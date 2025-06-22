<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class RelatoriosController extends Controller
{
    public function list()
    {
        return view('relatorios.relatorios');
    }
}