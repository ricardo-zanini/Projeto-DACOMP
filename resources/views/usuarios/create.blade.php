@extends('templates.base')
@section('title', 'Cadastrar-se')

@section('content')
    <h1>CADASTRO</h1>
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

        <select name="tipo_usuario_id" class="form-control">
            <option value="">Selecione o tipo de Usuário</option>
            @foreach ($tipos as $tipo)
                <option value="{{ $tipo->tipo_usuario_id }}">{{ $tipo->tipo }}</option>
            @endforeach
        </select>


        <div class="form-floating">
            <input type="password" class="form-control middle_input" id="password" placeholder="password" name="password" minlength="8" maxlength="100" required>
            <label for="password">Senha</label>
        </div>

        <div class="form-floating">
            <input type="password" class="form-control last-input" id="password_confirmation" placeholder="Confirmar password" name="password_confirmation" minlength="8" maxlength="100" required>
            <label for="password_confirmation">Confirmar senha</label>
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
        max-width:1000px;
        width:100%;
    }
    .conteudoCadastro{
        display:flex;
        padding-bottom:50px;
        justify-content:center;
    }
    .form-floating, select{
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
    h1{
        font-family: "Cal Sans", sans-serif;
        text-align:center;
        padding:50px 0px;
    }
</style>
@endpush