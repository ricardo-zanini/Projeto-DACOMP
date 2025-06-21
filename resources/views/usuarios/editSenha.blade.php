@extends('templates.base')
@section('title', 'Alterar Senha')

@section('content')
    <h1>ALTERAR SENHA</h1>
    <div class="conteudoCadastro">
        <form method="post" action="{{ route('senha.update') }}" id="editar-senha-form">
            @csrf
            @method('PUT')

            <div class="form-floating">
                <input type="password" class="form-control middle_input" id="old_password" placeholder="old_password" name="old_password" minlength="8" maxlength="100" required>
                <div class="form-text text-end me-1 text-danger old_password_error"></div>
                <label for="old_password">Senha atual</label>
            </div>

            <div class="form-floating">
                <input type="password" class="form-control middle_input" id="password" placeholder="password" name="password" minlength="8" maxlength="100" required>
                <div class="form-text text-end me-1 text-danger password_error"></div>
                <label for="password">Nova senha</label>
            </div>

            <div class="form-floating">
                <input type="password" class="form-control last-input" id="password_confirmation" placeholder="Confirmar password" name="password_confirmation" minlength="8" maxlength="100" required>
                <div class="form-text text-end me-1 text-danger password_confirmation_error"></div>
                <label for="password_confirmation">Confirmar nova senha</label>
            </div>

            <button class="buttonSubmitForm" type="submit">Salvar nova senha</button>
            
            <div class="alerta_sucesso hidden"> Senha alterada com sucesso! </div>
            <div class="alerta_erro hidden"> Ocorreu um erro </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function(){
            $('#editar-senha-form').on("submit", function(e){
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
                        
                        $(".alerta_sucesso").addClass("hidden")
                        $(".alerta_erro").addClass("hidden")
                    },
                    success: function() {
                        $(".alerta_sucesso").removeClass("hidden")
                        $(".alerta_erro").addClass("hidden")
                        $(".form-floating").addClass("hidden")
                        $(".buttonSubmitForm").addClass("hidden")
                    },
                    error: function(err) {
                        if (err.status == 422) {
                            $.each(err.responseJSON.errors, function (i, error) {
                                $('.'+i+'_error').text(error[0]);
                                $(document).find('[name="'+i+'"]').addClass('is-invalid');
                            });
                        }
                        $(".alerta_sucesso").addClass("hidden")
                        $(".alerta_erro").removeClass("hidden")
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