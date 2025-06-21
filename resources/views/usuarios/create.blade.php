@extends('templates.base')
@section('title', 'Cadastrar-se')

@section('content')
    <h1>CADASTRO</h1>
    <div class="conteudoCadastro">
    <form method="post" action="{{ route('usuarios.gravar') }}" id="cadastrar-usuario-form">

        @csrf
        
        <div class="form-floating">
            <input type="text" class="form-control first_input" id="nome" placeholder="Nome de usuário" name="nome" maxlength="100" required>
            <div class="form-text text-end me-1 text-danger text-danger nome_error"></div>
            <label for="nome">Nome</label>
        </div>

        <div class="form-floating">
            <input type="text" class="form-control first_input" id="cartao_UFRGS" placeholder="Cartão UFRGS" name="cartao_UFRGS" minlength="6" maxlength="8">
            <div class="form-text text-end me-1 text-danger text-danger cartao_UFRGS_error"></div>
            <label for="cartao_UFRGS">Cartão UFRGS</label>
        </div>

        <div class="form-floating">
            <input type="email" class="form-control middle_input" id="email" placeholder="Endereço de email" name="email" maxlength="100" required>
            <div class="form-text text-end me-1 text-danger text-danger email_error"></div>
            <label for="email">Endereço de email</label>
        </div>

        <div class="form-floating">
            <input type="text" class="form-control first_input" id="telefone" placeholder="Telefone" name="telefone" minlength="8" required>
            <div class="form-text text-end me-1 text-danger telefone_error"></div>
            <label for="telefone">Telefone</label>
        </div>

        <select name="tipo_usuario_id" class="form-control" required>
            <option value="">Selecione o tipo de Usuário</option>
            @foreach ($tipos as $tipo)
                <option value="{{ $tipo->tipo_usuario_id }}">{{ $tipo->tipo }}</option>
            @endforeach
        </select>
        <div class="form-text text-end me-1 text-danger tipo_usuario_id_error"></div>


        <div class="form-floating">
            <input type="password" class="form-control middle_input" id="password" placeholder="password" name="password" minlength="8" maxlength="100" required>
            <div class="form-text text-end me-1 text-danger password_error"></div>
            <label for="password">Senha</label>
        </div>

        <div class="form-floating">
            <input type="password" class="form-control last-input" id="password_confirmation" placeholder="Confirmar password" name="password_confirmation" minlength="8" maxlength="100" required>
            <div class="form-text text-end me-1 text-danger password_confirmation_error"></div>
            <label for="password_confirmation">Confirmar senha</label>
        </div>

        <button class="buttonSubmitForm" type="submit">Cadastrar-se</button>

        <div class="mb-3" style="margin-top: 1rem">
            <a href="{{ route('login') }}" class="jaPossuiConta">Já tem uma conta? Logue agora mesmo!</a>
        </div>
    </form>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function(){
            $('#cadastrar-usuario-form').on("submit", function(e){
                e.preventDefault();
                var action = $(this).attr('action');
                $.ajax({
                    url: action,
                    method: $(this).attr('method'),
                    data: new FormData(this),
                    processData: false,
                    dataType: 'json',
                    contentType: false,
                    beforeSend: function() {
                        $(document).find('.text-danger').text('');
                        $(document).find('.is-invalid').removeClass('is-invalid');
                    },
                    success: function(r) {
                        if (r.status = 200)
                        {
                            window.location.href = r.redirect_url;
                        }
                    },
                    error: function(err) {
                        if (err.status == 422) {
                            $.each(err.responseJSON.errors, function (i, error) {
                                $('.'+i+'_error').text(error[0]);
                                $(document).find('[name="'+i+'"]').addClass('is-invalid');
                            });
                        }
                        else if (err.status = 200)
                        {
                            window.location.href = err.redirect_url;
                        }
                    }
                });
            })
        })
    </script>
@endpush

@push('styles')
<style>
    form{
        max-width:1000px;
        width:100%;
    }
    .conteudoCadastro{
        display:flex;
        padding: 0px 20px;
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