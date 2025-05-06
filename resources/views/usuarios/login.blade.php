@extends('templates.base')
@section('title', 'Login')

@section('content')

    <h1>LOGIN</h1>
    <div class="conteudoCadastro">
    <form method="post" action="{{ route('login') }}">
        @csrf

        <div class="form-floating">
            <input type="email" class="form-control middle_input" id="email" placeholder="Endereço de email" name="email" maxlength="100" required>
            <label for="email">Endereço de email</label>
        </div>

        <div class="form-floating">
            <input type="password" class="form-control middle_input" id="password" placeholder="password" name="password" minlength="8" maxlength="100" required>
            <label for="password">Senha</label>
        </div>

        @if (session('erro'))
        
        <!-- Erro -->
        <div class="alert alert-danger">{{ session('erro') }}</div>

        @endif

        <button class="buttonSubmitForm" type="submit">Entrar</button>

        <div class="mb-3" style="margin-top: 1rem">
            <a href="{{ route('usuarios.inserir') }}" class="cadastrarse">Ainda não está cadastrado? Cadastre-se agora!</a>
        </div>
    </form>
    </div>
@endsection

@push('styles')
<style>
    form{
        max-width:1200px;
        width:100%;
    }
    .conteudoCadastro{
        display:flex;
        justify-content:center;
        padding-bottom:50px;
    }
    .form-floating{
        margin-bottom:20px;
    }
    .buttonSubmitForm{
        font-family: "Cal Sans", sans-serif;
        border:none;
        padding:10px;
        background-color: #292929;
        color: #f0f0f0;
        border-radius:5px;
        width:100%;
    }
    .cadastrarse{
        color: #2e96d5;
        text-decoration:none;
        font-family: "Cal Sans", sans-serif;
    }
    h1{
        font-family: "Cal Sans", sans-serif;
        text-align:center;
        padding-top:30px;
        margin:30px 0px;
    }
</style>
@endpush