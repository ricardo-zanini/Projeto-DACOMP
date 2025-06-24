<?php

namespace App\Http\Controllers;

use App\Models\SolicitacoesCancelamentos;
use App\Models\Compras;
use App\Models\ProdutosCompras;
use App\Models\ComprasStatus;
use App\Models\Produtos;
use App\Models\ProdutosEstoques;
use App\Models\TiposProdutos;
use App\Models\Tamanhos;
use App\Models\Cores;
use App\Models\Usuario;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

use App\Mail\ConfirmaCompra;
use Illuminate\Support\Facades\Mail;

class ComprasController extends Controller
{
    public function list()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        
        $usuario = Auth::user();

        $compras = Compras::query()
        ->where('usuario_id', $usuario->usuario_id)
        ->with('status')
        ->orderBy('status_id')
        ->get()
        ->groupBy('status.status');

        return view('compras.orders', compact('compras'));
    }

    public function show()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $usuario = Auth::user();

        $compras = Compras::with([
            'status',
            'produtosCompras.produtoEstoque.produto'
        ])
        ->where('usuario_id', $usuario->usuario_id)
        ->where('status_id', 1)
        ->get();
        
        return view('compras.cart', compact('compras'));
    }

    public function createOrder(Usuario $usuario)
    {
        $compra = new Compras();
        $compra->usuario_id = $usuario->usuario_id;
        $compra->status_id = 1;
        $compra->total = 0;
        $compra->save();

        return $compra;
    }

    public function getOpenOrder(Usuario $usuario)
    {
        $compra = Compras::where('usuario_id', $usuario->usuario_id)
            ->where('status_id', 1)
            ->first();

        if (!$compra) {
            return $this->createOrder($usuario);
        }

        return $compra;
    }

    public function insert(Request $request) 
    {
        $request->validate([
            'produto_estoque_id' => ['required', 'exists:produtos_estoques,produto_estoque_id'],
            'quantidade'         => ['required', 'integer', 'min:1'],
            'valor_unidade'      => ['required', 'numeric', 'min:0'],
        ]);
        
        $produto_estoque_id = $request->input('produto_estoque_id');
        $quantidade = $request->input('quantidade');
        $valor_unidade = $request->input('valor_unidade');

        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $usuario = Auth::user();
        $compra = $this->getOpenOrder($usuario);

        $produto_compra = ProdutosCompras::where('compra_id', $compra->compra_id)
            ->where('produto_estoque_id', $produto_estoque_id)
            ->first();

        if ($produto_compra) {
            $produto_compra->quantidade += $quantidade;
        } else {
            $produto_compra = new ProdutosCompras();
            $produto_compra->compra_id = $compra->compra_id;
            $produto_compra->produto_estoque_id = $produto_estoque_id;
            $produto_compra->quantidade = $quantidade;
            $produto_compra->valor_unidade = $valor_unidade;
        }

        $produto_compra->save();

        $compra->total += $quantidade * $valor_unidade;
        $compra->save();

        $produto_estoque = ProdutosEstoques::where('produto_estoque_id', $produto_estoque_id)->firstOrFail();
        $produto_estoque->unidades -= $quantidade;
        $produto_estoque->save();

        return back()->with('success', 'Produto adicionado ao carrinho.');
    }

    public function add(Compras $compra, ProdutosCompras $item)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $usuario = Auth::user();

        if ($usuario->usuario_id !== $compra->usuario_id) {
            throw new Exception('Operação não permitida.');
        }

        $estoque = ProdutosEstoques::findOrFail($item->produto_estoque_id);

        if ($estoque->unidades <= 0) {
            return back()->with('error', 'Estoque insuficiente.');
        }

        $item->quantidade += 1;
        $item->save();

        $compra->total += $item->valor_unidade;
        $compra->save();

        $estoque->unidades -= 1;
        $estoque->save();

        return back()->with('success', 'Produto atualizado com sucesso.');
    }

    public function remove(Compras $compra, ProdutosCompras $item)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $usuario = Auth::user();

        if ($usuario->usuario_id !== $compra->usuario_id) {
            throw new Exception('Operação não permitida.');
        }

        $estoque = ProdutosEstoques::findOrFail($item->produto_estoque_id);

        if ($estoque->unidades <= 0) {
            return back()->with('error', 'Estoque insuficiente.');
        }

        $item->quantidade -= 1;
        $item->save();

        $compra->total -= $item->valor_unidade;
        $compra->save();

        $estoque->unidades += 1;
        $estoque->save();

        return back()->with('success', 'Produto atualizado com sucesso.');
    }

    public function delete(Compras $compra, ProdutosCompras $item)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $usuario = Auth::user();

        if ($usuario->usuario_id !== $compra->usuario_id) {
            throw new Exception('Operação não permitida.');
        }

        $estoque = ProdutosEstoques::findOrFail($item->produto_estoque_id);

        $estoque->unidades += $item->quantidade;
        $estoque->save();

        $compra = $item->compra;
        $compra->total -= $item->valor_unidade * $item->quantidade;
        $compra->save();
        
        $item->delete();

        if ($compra->produtosCompras()->count() === 0) {
            $compra->delete();
        }

        return back()->with('success', 'Item removido do carrinho.');
    }

    public function pagamento(Compras $compra){
        if(Auth::user()->usuario_id == $compra->usuario_id){
            $item = Compras::where('compra_id', $compra->compra_id)->get();
            $item = $item->first();

            // Caso o usuario tente recarregar a página de pagamento estava gerando os codigos e enviando email novamente
            if(!is_null($item->codigo_compra)){
                return redirect()->route('home');
            }
            
            Compras::where('compra_id', $compra->compra_id)->update([
                'status_id' => 2
            ]);
            
            $caracteres = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
            
            $string_random = '';
            for($i = 0; $i < 9; $i++){
                $string_random .= $caracteres[random_int(0, strlen($caracteres) - 1)];
            }
            $item->codigo_compra = $string_random; // ou qualquer lógica que você queira
            $item->save();

            Mail::to(Auth::user()->email)->send(new ConfirmaCompra([
                'nome' => Auth::user()->nome,
                'item' => $item
            ]));    

            return view('compras.pagamento');
        }
    }
    
    public function relatorios(Request $form){
        if(Auth::user()->gestor == true){
            $form->validate([
                'input' => ['nullable'],
                'tipo_produto_id' => ['nullable'],
                'tamanho_id' => ['nullable'],
                'cor_id' => ['nullable']
            ]);

            $pedidos = Compras::query()
                ->select('compras.compra_id','compras.usuario_id','compras.horario','compras.status_id','compras.total','compras.codigo_compra', 'usuarios.nome', 'compras_status.status')
                ->leftJoin('produtos_compras', 'compras.compra_id', '=', 'produtos_compras.compra_id')
                ->leftJoin('produtos_estoques', 'produtos_estoques.produto_estoque_id', '=', 'produtos_compras.produto_estoque_id')
                ->leftJoin('produtos', 'produtos.produto_id', '=', 'produtos_estoques.produto_id')
                ->leftJoin('usuarios', 'usuarios.usuario_id', '=', 'compras.usuario_id')
                ->leftJoin('compras_status', 'compras_status.status_id', '=', 'compras.status_id')

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

                ->when($form->filled('input'), function ($q) use ($form) {
                    $q->where(function ($subQuery) use ($form) {
                    $subQuery
                        ->where('produtos.nome', 'like', '%' . $form->input . '%')
                        ->orWhere('usuarios.cartao_UFRGS', 'like', '%' . $form->input . '%')
                        ->orWhere('usuarios.nome', 'like', '%' . $form->input . '%')
                        ->orWhere('usuarios.email', 'like', '%' . $form->input . '%')
                        ->orWhere('usuarios.telefone', 'like', '%' . $form->input . '%');
                    });
                })
                ->groupBy('compras.compra_id','compras.usuario_id','compras.horario','compras.status_id','compras.total','compras.codigo_compra', 'usuarios.nome', 'compras_status.status')
                ->orderBy('compras.horario', 'desc')
                ->get();

            $tipos_produtos = TiposProdutos::all();
            $tamanhos = Tamanhos::all();
            $cores = Cores::all();

            if ($form->ajax()) {
                return view('compras.list', compact('pedidos'));
            }

            return view('compras.relatorios', compact('pedidos', 'tipos_produtos', 'tamanhos', 'cores'));
        }else{
             return redirect()->route('login');
        }
    }

    public function cancel(Request $form)
    {
        $form->validate([
            'compra_id' => ['required', 'integer'],
            'chave' => ['required'],
            'chave_confirmation' => ['required'],
            'motivacao' => ['required'],
        ]);

        $compra = Compras::where('compra_id', $form->compra_id)->first();

        if(Auth::user()->usuario_id == $compra->usuario_id){
            $solicitacoes_cancelamentos = New SolicitacoesCancelamentos();
            $solicitacoes_cancelamentos->cancelamento_status_id = 1;
            $solicitacoes_cancelamentos->motivacao = $form->motivacao;
            $solicitacoes_cancelamentos->chave_pix = $form->chave;
            $solicitacoes_cancelamentos->compra_id = $form->compra_id;
            $solicitacoes_cancelamentos->save();
            return true;
        }else{
            return false;
        }
    }

    public function cancelamentos(){
        if(Auth::user()->gestor == true){
            $pedidos = SolicitacoesCancelamentos::query()
            ->join('Compras', 'solicitacoes_cancelamentos.compra_id', '=', 'compras.compra_id')
            ->where('solicitacao_cancelamento_id', '=', 1)
            ->get();

            return view('compras.cancelamentos', compact('pedidos'));
        }else{
             return redirect()->route('login');
        }
    }

    public function pedidoRetirada(Compras $pedido)
    {
        if(Auth::user()->gestor == true) {
            $pedido = Compras::with('produtosCompras.produtoEstoque.produto', 'produtosCompras.produtoEstoque.tamanho', 'produtosCompras.produtoEstoque.cor')->findOrFail($pedido->compra_id);
            return view('compras.entrega', compact('pedido'));
        } else {
             return redirect()->route('login');
        }
    }
}