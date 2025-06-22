<?php

namespace App\Http\Controllers;

use App\Models\Compras;
use App\Models\ProdutosCompras;
use App\Models\ComprasStatus;
use App\Models\ProdutosEstoques;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ComprasController extends Controller
{
    public function list() 
    {
        if (!Auth::check()) {
            return redirect()->route('usuarios.login');
        }
        
        $usuario = Auth::user();

        $compras = Compras::where('usuario_id', $usuario->usuario_id)
            ->with('status')
            ->get()
            ->groupBy('status.status');

        return view('compras.orders', compact('compras'));
    }

    public function show()
    {
        if (!Auth::check()) {
            return redirect()->route('usuarios.login');
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

    public function createOrder($usuario)
    {
        $compra = new Compras();
        $compra->usuario_id = $usuario->usuario_id;
        $compra->status_id = 1;
        $compra->total = 0;
        $compra->save();

        return $compra;
    }

    public function getOpenOrder($usuario)
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
            return redirect()->route('usuarios.login');
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
            return redirect()->route('usuarios.login');
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
            return redirect()->route('usuarios.login');
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
            return redirect()->route('usuarios.login');
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
            Compras::where('compra_id', $compra->compra_id)->update([
                'status_id' => 2
            ]);
            return view('compras.pagamento');
        }
    }

    public function cancel(Compras $compra)
    {
        if(Auth::user()->usuario_id == $compra->usuario_id){
            foreach ($compra->produtosCompras as $item) {
                $estoque = ProdutosEstoques::find($item->produto_estoque_id);
                if ($estoque) {
                    $estoque->unidades += $item->quantidade;
                    $estoque->save();
                }
            }

            Compras::where('compra_id', $compra->compra_id)->update([
                'status_id' => 4
            ]);

            return back()->with('success', 'Pedido cancelado.');
        }
    }
}