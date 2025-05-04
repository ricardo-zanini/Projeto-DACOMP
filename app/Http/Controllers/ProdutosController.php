<?php

namespace App\Http\Controllers;

class ProdutosController extends Controller
{
    public function search()
    {
        return view('produtos.search');
    }
}