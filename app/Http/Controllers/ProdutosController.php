<?php

namespace App\Http\Controllers;


use App\Models\Produtos;
use App\Models\ProdutosEstoques;
use App\Models\TiposProdutos;
use App\Models\Tamanhos;
use App\Models\Cores;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProdutosController extends Controller
{
    public function list()
    {
        $produtos = Produtos::all()->where('excluido', false) ; // Busca todos os produtos
        $tipos_produtos = TiposProdutos::all();
        $tamanhos = Tamanhos::all();
        $cores = Cores::all();
        return view('produtos.products', compact('produtos', 'tipos_produtos', 'tamanhos', 'cores'));
    }

    public function create()
    {
        if(Auth::user()->gestor == true){
            $tipos = TiposProdutos::all();
            $tamanhos = Tamanhos::all(); // Busca todos os tamanhos
            $cores = Cores::all(); // Busca todos os cores
            return view('produtos.create', ['tipos' => $tipos, 'tamanhos' => $tamanhos, "cores" => $cores]);
        }else{
            return view('usuarios.login');
        }
    }

    public function insert(Request $form)
    {
        if(Auth::user()->gestor == true){
            $form->merge([
                'valor_unidade' => str_replace(',', '.', $form->valor_unidade),
            ]);
            // Validação de dados de produto
            $form->validate([
                'nome' => ['required', 'max:100'],
                'tipo_produto_id' => ['required'],
                'valor_unidade' => ['required', 'numeric'],
                'numero_variacoes' => ['required', 'integer', 'min:1'],
                'imagem' => ['nullable','image']
            ]);

            for($i = 0; $i < (int) $form->numero_variacoes; $i++){
                $form->validate([
                    "tamanho_id_$i" => ['required', 'integer'],
                    "cor_id_$i" => ['required', 'integer'],
                    "unidades_$i" => ['required', 'integer'],
                ]);
            }
            
            $produto = new Produtos();
            $produto->nome = $form->nome;
            $produto->tipo_produto_id = $form->tipo_produto_id;
            $produto->valor_unidade = $form->valor_unidade;
            $produto->excluido = false;

            $imgPath = null;
            if($form->file('imagem')){
                $imgPath = $form->file('imagem')->store('', 'imagens');
            }
            $produto->imagem = $imgPath;
            
            $produto->save();

            for($i = 0; $i < (int) $form->numero_variacoes; $i++){
                $produtoEstoque = new ProdutosEstoques();

                $produtoEstoque->produto_id = $produto->produto_id;
                $produtoEstoque->tamanho_id = $form->input("tamanho_id_$i");
                $produtoEstoque->cor_id = $form->input("cor_id_$i");
                $produtoEstoque->disponivel = $form->has("disponivel_$i") ? true : false;
                $produtoEstoque->prontaEntrega = $form->has("pronta_entrega_$i") ? true : false;
                $produtoEstoque->unidades = (int) $form->input("unidades_$i");
                $produtoEstoque->excluido = false;

                $produtoEstoque->save();
            }

            return response()->json([
                'status' => 200,
                'message' => 'Produto criado com sucesso!',
                'redirect_url' => route('produtos.list')
            ]);
        }else{
            return false;
        }
    }

    public function search(Request $form)
    {
        $form->validate([
            'input' => ['nullable'],
            'tipo_produto_id' => ['nullable'],
            'tamanho_id' => ['nullable'],
            'cor_id' => ['nullable']
        ]);

        $produtos = Produtos::query()
            ->where('excluido', false) 
            ->when($form->filled('tipo_produto_id') && !$form->filled('tamanho_id') && !$form->filled('cor_id'), fn ($q) =>
                $q->where('tipo_produto_id', $form->tipo_produto_id)
            )
            ->when($form->filled('tamanho_id') && !$form->filled('tipo_produto_id') && !$form->filled('cor_id'), function ($q) use ($form) {
                $q->whereHas('estoque', fn ($estoque) =>
                    $estoque->where('tamanho_id', $form->tamanho_id));
            })
            ->when($form->filled('cor_id') && !$form->filled('tipo_produto_id') && !$form->filled('tamanho_id'), function ($q) use ($form) {
                $q->whereHas('estoque', fn ($estoque) =>
                    $estoque->where('cor_id', $form->cor_id));
            })
            ->when($form->filled('input'), fn ($q) =>
            $q->where('nome', 'like', '%' . $form->input . '%'))
            ->distinct()
            ->get();

        $tipos_produtos = TiposProdutos::all();
        $tamanhos = Tamanhos::all();
        $cores = Cores::all();

        if ($form->ajax()) {
            return view('produtos.list', compact('produtos'));
        }

        return view('produtos.products', compact('produtos', 'tipos_produtos', 'tamanhos', 'cores'));
    }

    public function show($id)
    {
        $produto = Produtos::with('estoque.cor', 'estoque.tamanho')->findOrFail($id);
        $tipo_produto = TiposProdutos::findOrFail($produto->tipo_produto_id);

        $estoques = $produto->estoque->map(fn ($e) => [
            'tamanho_id'    => $e->tamanho_id,
            'cor_id'        => $e->cor_id,
            'prontaEntrega' => $e->prontaEntrega,
            'unidades'      => $e->unidades,
            'produto_estoque_id' => $e->produto_estoque_id,
            'disponivel' => $e->disponivel,
        ]);

        return view('produtos.product', compact(
            'produto',
            'estoques',
            'tipo_produto'
        ));
    }

    public function edit($produto_id){
        if(Auth::user()->gestor == true){
            $produto = Produtos::findOrFail($produto_id);
            $produtos_estoques = ProdutosEstoques::where('produto_id', $produto_id)->get();

            $tipos = TiposProdutos::all();
            $tamanhos = Tamanhos::all();
            $cores = Cores::all();

            return view('produtos.edit', compact(
                'produto',
                'produtos_estoques',
                'tipos',
                'tamanhos',
                'cores'
            ));
        }else{
            return redirect()->route('home');
        }
    }

    public function update($produto_id, Request $form){
        if(Auth::user()->gestor == true){
            //===============================================================
            // Seta o produto antigo e suas variações como "excluido -> True"
            //===============================================================
            Produtos::where('produto_id', $produto_id)->update([
                'excluido' => True
            ]);
            ProdutosEstoques::where('produto_id', $produto_id)->update([
                'excluido' => True
            ]);
            //=======================================
            // Regitra novo Produto e suas variações
            //=======================================
            $form->merge([
                'valor_unidade' => str_replace(',', '.', $form->valor_unidade),
            ]);

            $form->validate([
                'nome' => ['required', 'max:100'],
                'tipo_produto_id' => ['required'],
                'valor_unidade' => ['required', 'numeric'],
                'numero_variacoes' => ['required', 'integer', 'min:1'],
                'imagem' => ['nullable','image']
            ]);

            for($i = 0; $i < (int) $form->numero_variacoes; $i++){
                $form->validate([
                    "tamanho_id_$i" => ['required', 'integer'],
                    "cor_id_$i" => ['required', 'integer'],
                    "unidades_$i" => ['required', 'integer'],
                ]);
            }
            
            $produto = new Produtos();
            $produto->nome = $form->nome;
            $produto->tipo_produto_id = $form->tipo_produto_id;
            $produto->valor_unidade = $form->valor_unidade;
            $produto->excluido = 0;

            $imgPath = null;
            if($form->file('imagem')){
                $imgPath = $form->file('imagem')->store('', 'imagens');
            }else{
                $imgPath = $form->old_image_name;
            }
            $produto->imagem = $imgPath;
            
            $produto->save();

            for($i = 0; $i < (int) $form->numero_variacoes; $i++){
                $produtoEstoque = new ProdutosEstoques();

                $produtoEstoque->produto_id = $produto->produto_id;
                $produtoEstoque->tamanho_id = $form->input("tamanho_id_$i");
                $produtoEstoque->cor_id = $form->input("cor_id_$i");
                $produtoEstoque->disponivel = $form->has("disponivel_$i") ? true : false;
                $produtoEstoque->prontaEntrega = $form->has("pronta_entrega_$i") ? true : false;
                $produtoEstoque->unidades = (int) $form->input("unidades_$i");
                $produtoEstoque->excluido = false;
                
                $produtoEstoque->save();
            }

            return true;
        }else{
            return false;
        }
    }

    public function delete(Request $form){
        if(Auth::user()->gestor == true){
            $form->validate([
                'produto_id' => ['required', 'integer']
            ]);

            Produtos::where('produto_id', $form->produto_id)->update([
                'excluido' => True
            ]);

            ProdutosEstoques::where('produto_id', $form->produto_id)->update([
                'excluido' => True
            ]);

            return true;
        }else{
            return false;
        }
    }

    public function demonstrarInteresse(Request $request, ProdutosEstoques $estoque){
        if ($estoque->disponivel != 0) {
            return back()->withErrors('Este item ainda está disponível em estoque.');
        }
        $estoque->interessados()
                ->syncWithoutDetaching([$request->user()->usuario_id]);

        return back()->with('success', 'Seu interesse foi registrado!');
    }
   
    public function relatorios(){
        $tipos_produtos = TiposProdutos::all();
        $tamanhos = Tamanhos::all();
        $cores = Cores::all();
        return view('produtos.relatorios', compact(
            'tipos_produtos',
            'tamanhos',
            'cores'
        ));
    }
}
