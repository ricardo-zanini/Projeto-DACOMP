<?php

namespace App\Http\Controllers;


use App\Models\Produto;
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
        $produtos = Produto::all(); // Busca todos os produtos
        return view('produtos.list', ['produtos' => $produtos]);
    }
    public function create()
    {
        if(Auth::user()->gestor == true){
            return view('produtos.create');

        }else{
            return view('usuarios.login');
        }
    }
}