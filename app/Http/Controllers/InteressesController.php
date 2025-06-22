<?php

namespace App\Http\Controllers;

use App\Models\UsuariosInteresses;
use App\Models\PedidosEstoques;

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

    public function cancel(UsuariosInteresses $interesse)
    {
        if (!Auth::check()) {
            return redirect()->route('usuarios.login');
        }

        $interesse->delete();

        return back()->with('success', 'Seu interesse por esse produto foi removido.');
    }
}