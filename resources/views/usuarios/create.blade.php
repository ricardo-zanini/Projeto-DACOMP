@extends('templates.base')
@section('title', 'Cadastrar-se')

@section('content')

    <div class="conteudoCadastro">
    <form method="post" action="{{ route('usuarios.gravar') }}">

        @csrf
        
        <div class="form-floating">
            <input type="text" class="form-control first_input" id="nome" placeholder="Nome de usuário" name="nome" maxlength="100" required>
            <label for="nome">Nome</label>
        </div>

        <div class="form-floating">
            <input type="text" class="form-control first_input" id="cartao_UFRGS" placeholder="Cartão UFRGS" name="cartao_UFRGS" minlength="6" maxlength="6" required>
            <label for="cartao_UFRGS">Cartão UFRGS</label>
        </div>

        <div class="form-floating">
            <input type="email" class="form-control middle_input" id="email" placeholder="Endereço de email" name="email" maxlength="100" required>
            <label for="email">Endereço de email</label>
        </div>

        <div class="form-floating">
            <input type="text" class="form-control first_input" id="telefone" placeholder="Telefone" name="telefone" minlength="8" required>
            <label for="telefone">Telefone</label>
        </div>

        <div class="form-floating">
            <input type="text" class="form-control first_input" id="tipo_usuario_id" placeholder="tipo_usuario_id" name="tipo_usuario_id" minlength="1" maxlength="1" required>
            <label for="tipo_usuario_id">tipo_usuario_id</label>
        </div>

        <div class="form-floating">
            <input type="password" class="form-control middle_input" id="senha" placeholder="Senha" name="senha" minlength="8" maxlength="20" required>
            <label for="senha">Senha</label>
        </div>

        <div class="form-floating">
            <input type="password" class="form-control last-input" id="senha_confirmation" placeholder="Confirmar senha" name="senha_confirmation" minlength="8" maxlength="20" required>
            <label for="senha_confirmation">Confirmar senha</label>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">{{ $errors->first() }}</div>
        @endif

        <button class="buttonSubmitForm" type="submit">Cadastrar-se</button>

        <div class="mb-3" style="margin-top: 1rem">
            <a href="{{ route('login') }}" class="jaPossuiConta">Já tem uma conta? Logue agora mesmo!</a>
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
        margin-top:70px;
        justify-content:center;
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
    .jaPossuiConta{
        color: #2e96d5;
        text-decoration:none;
        font-family: "Cal Sans", sans-serif;
    }
</style>
@endpush