<?php

namespace App\Http\Controllers;

use App\Models\UsuariosInteresses;
use App\Models\PedidosEstoques;
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

class InteressesController extends Controller
{
    public function list() 
    {
        if (!Auth::check()) {
            return redirect()->route('usuarios.login');
        }

        $usuario = Auth::user();
        $interesses = UsuariosInteresses::with('produtoEstoque.produto', 'produtoEstoque.tamanho', 'produtoEstoque.cor')
            ->where('usuario_id', $usuario->usuario_id)
            ->get();

        return view('interesses.list', compact('interesses'));
    }

    public function insert(Request $request) 
    {
        $produto_estoque_id = $request->input('produto_estoque_id');

        if (!Auth::check()) {
            return redirect()->route('usuarios.login');
        }

        if ($produto_estoque_id != 0) {
            $usuario = Auth::user();
            
            $existe = UsuariosInteresses::where('usuario_id', $usuario->usuario_id)
                ->where('produto_estoque_id', $produto_estoque_id)
                ->exists();

            if ($existe) {
                return back()->with('error', 'Você já demonstrou interesse por esse produto.');
            }

            $usuario_interesse = new UsuariosInteresses();
            $usuario_interesse->usuario_id = $usuario->usuario_id;
            $usuario_interesse->produto_estoque_id = $produto_estoque_id;
            $usuario_interesse->save();
        }

        return back()->with('success', 'Seu interesse por esse produto foi registrado.');
    }

    public function cancel(UsuariosInteresses $interesse)
    {
        if (!Auth::check()) {
            return redirect()->route('usuarios.login');
        }

        $interesse->delete();

        return back()->with('success', 'Seu interesse por esse produto foi removido.');
    }

    public function relatorios()
    {
        if (!Auth::check()) {
            return redirect()->route('usuarios.login');
        }

        $usuario = Auth::user();

        if ($usuario->gestor === 0) {
            throw new Exception('Operação não permitida.');
        }

        $interesses = UsuariosInteresses::with([
            'usuario',
            'produtoEstoque.produto.tipoProduto',
            'produtoEstoque.tamanho',
            'produtoEstoque.cor'
        ])->get();

        $agrupado = [];

        foreach ($interesses as $interesse) {
            $tipo   = $interesse->produtoEstoque->produto->tipoProduto->tipo;
            $nome   = $interesse->produtoEstoque->produto->nome;
            $tam    = $interesse->produtoEstoque->tamanho->tamanho;
            $cor    = $interesse->produtoEstoque->cor->cor;
            $key    = "$tam|$cor";

            if (!isset($agrupado[$tipo][$nome][$key])) {
                $agrupado[$tipo][$nome][$key] = [
                    'tamanho'     => $tam,
                    'cor'         => $cor,
                    'com_cartao'  => 0,
                    'sem_cartao'  => 0,
                    'total'       => 0,
                ];
            }

            if ($interesse->usuario && $interesse->usuario->cartao_UFRGS) {
                $agrupado[$tipo][$nome][$key]['com_cartao']++;
            } else {
                $agrupado[$tipo][$nome][$key]['sem_cartao']++;
            }
            $agrupado[$tipo][$nome][$key]['total']++;
        }

        return view('interesses.relatorios', compact('agrupado'));
    }
}