<?php

namespace App\Http\Controllers;


use App\Models\Usuario;
use App\Models\TiposUsuario;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class UsuariosController extends Controller
{

    // Envia para a criação de Usuários
    public function create()
    {
        $tipos = TiposUsuario::all(); // Busca todos os tipos
        return view('usuarios.create', ['tipos' => $tipos]);
    }

    // Insert do Usuário no banco, de acordo com colunas na tabela usuario
    public function insert(Request $form)
    {
        // Validação de dados do formulario
        $form->validate([
            'cartao_UFRGS' => ['nullable', 'min:6', 'max:8', 'unique:usuarios'],
            'nome' => ['required', 'max:100'],
            'email' => ['required', 'email', 'max:100', 'unique:usuarios'],
            'password' => ['required','confirmed', 'min:8', 'max:100'],
            'password_confirmation' => ['required'],
            'telefone' => ['required', 'min:8'],
            'tipo_usuario_id' => ['required']
        ]);
        
        // Preenche estrutura de dados com dados do formulario 
        $usuario = new Usuario();
        $usuario->cartao_UFRGS = $form->cartao_UFRGS;
        $usuario->nome = $form->nome;
        $usuario->email = $form->email;
        $usuario->password = Hash::make($form->password);
        $usuario->telefone = $form->telefone;
        $usuario->gestor = false;
        $usuario->tipo_usuario_id = $form->tipo_usuario_id;

        // Salva no banco
        $usuario->save();
        // Evento de registro de usuário
        event(new Registered($usuario));
        $usuario = Usuario::where('email', $usuario->email)->first();
        // Cria sessão para o usuário
        Auth::login($usuario);

        return response()->json([
            'status' => 200,
            'message' => 'Cadastro efetuado com sucesso!',
            'redirect_url' => route('home')
        ]);
    }

    // Ações de login
    public function login(Request $form)
    {
        // Está enviando o formulário
        if ($form->isMethod('POST'))
        {
            $credenciais = $form->validate([
                'email' => ['required'],
                'password' => ['required', 'min:8', 'max:100'],
            ]);
               
            // Tenta o login
            if (Auth::attempt($credenciais)) {
                session()->regenerate();
                return redirect('/');
            }
            else {
                // Login deu errado (usuário ou senha inválidos)
                return redirect()->route('login')->with('erro', 'Usuário ou senha inválidos.');
            }
        }

        return view('usuarios.login');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    public function edit()
    {
        $tipos = TiposUsuario::all(); // Busca todos os tipos
        return view('usuarios.edit', ['usuario' => Auth::user(), 'tipos' => $tipos]);
    }
    public function update(Request $form)
    {
        // Validação de dados do formulario
        $form->validate([
            'cartao_UFRGS' => ['nullable', 'min:6', 'max:8', Rule::unique('usuarios', 'cartao_UFRGS')->ignore($form->cartao_UFRGS, 'cartao_UFRGS')],
            'nome' => ['required', 'max:100'],
            'email' => ['required', 'email', Rule::unique('usuarios', 'email')->ignore($form->email, 'email')],
            'telefone' => ['required', 'min:8'],
            'tipo_usuario_id' => ['required']
        ]);

        $usuario = Auth::user();
        $usuario->cartao_UFRGS = $form->cartao_UFRGS;
        $usuario->nome = $form->nome;
        $usuario->email = $form->email;
        $usuario->telefone = $form->telefone;
        $usuario->tipo_usuario_id = $form->tipo_usuario_id;

        $usuario->save();

        return true;
    }

    public function alterar_senha()
    {
        return view('usuarios.editSenha', ['usuario' => Auth::user()]);
    }
    public function update_senha(Request $form)
    {
        
        try {
            if (!Hash::check($form->old_password, Auth::user()->password)) {
                throw new Exception();
            }
        }
        catch (Exception $exception) {
            return response()->json([
                'status' => 422,
                'errors' => ['old_password' => ['Senha atual incorreta.']]
            ], 422);
        }
        
        $form->validate([
            'password' => ['required', 'confirmed', 'min:8', 'max:100'],
            'password_confirmation' => ['required']
        ]);

        $usuario = Auth::user();

        $usuario->password = Hash::make($form->password);
        $usuario->save();

        return response()->json([
            'status' => 200,
            'message' => 'Produto criado com sucesso!',
            'redirect_url' => route('produtos.list')
        ]);
    }
}