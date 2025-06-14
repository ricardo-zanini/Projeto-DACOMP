<?php

namespace App\Http\Controllers;


use App\Models\Produtos;
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
        $produtos = Produtos::all(); // Busca todos os produtos
        $tipos_produtos = TiposProdutos::all();
        $tamanhos = Tamanhos::all();
        $cores = Cores::all();
        return view('produtos.products', compact('produtos', 'tipos_produtos', 'tamanhos', 'cores'));
    }

    public function create()
    {
        if(Auth::user()->gestor == true){
            return view('produtos.create');

        }else{
            return view('usuarios.login');
        }
    }

    public function search(Request $form)
    {
        $form->validate([
            'input' => ['nullable'],
            'tipo_produto_id' => ['nullable']
        ]);

        $produtos = Produtos::query()
        ->when($form->filled('tipo_produto_id'), function ($q) use ($form) {
            $q->where('tipo_produto_id', $form->tipo_produto_id);
        })
        ->when($form->filled('input'), function ($q) use ($form) {
            $q->where('nome', 'like', '%' . $form->input . '%');
        })->get();

        $tipos_produtos = TiposProdutos::all();
        $tamanhos = Tamanhos::all();
        $cores = Cores::all();

        if ($form->ajax()) {
            return view('produtos.list', compact('produtos'));
        }

        return view('produtos.products', compact('produtos', 'tipos_produtos', 'tamanhos', 'cores'));
    }
}