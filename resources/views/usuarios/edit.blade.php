@extends('templates.base')
@section('title', 'Alterar Dados')

@section('content')
    <h1>ALTERAR DADOS</h1>
    <div class="conteudoCadastro">
        <form method="post" action="{{ route('perfil.update') }}" id="editar-perfil-form">
            @csrf
            @method('PUT')
            <div class="form-floating">
                <input value="{{$usuario->nome}}" type="text" class="form-control first_input" id="nome" placeholder="Nome de usuário" name="nome" maxlength="100" required>
                <div class="form-text text-end me-1 text-danger nome_error"></div>
                <label for="nome">Nome</label>
            </div>

            <div class="form-floating">
                <input value="{{$usuario->cartao_UFRGS}}" type="text" class="form-control first_input" id="cartao_UFRGS" placeholder="Cartão UFRGS" name="cartao_UFRGS" minlength="6" maxlength="8">
                <div class="form-text text-end me-1 text-danger cartao_UFRGS_error"></div>
                <label for="cartao_UFRGS">Cartão UFRGS</label>
            </div>

            <div class="form-floating">
                <input value="{{$usuario->email}}" type="email" class="form-control middle_input" id="email" placeholder="Endereço de email" name="email" maxlength="100" required>
                <div class="form-text text-end me-1 text-danger email_error"></div>
                <label for="email">Endereço de email</label>
            </div>

            <div class="form-floating">
                <input value="{{$usuario->telefone}}" type="text" class="form-control first_input" id="telefone" placeholder="Telefone" name="telefone" minlength="8" required>
                <div class="form-text text-end me-1 text-danger telefone_error"></div>
                <label for="telefone">Telefone</label>
            </div>

            <select name="tipo_usuario_id" class="form-control" required>
                <option value="-1">Selecione o tipo de Usuário</option>
                @foreach ($tipos as $tipo)
                    <option @if($usuario->tipo_usuario_id == $tipo->tipo_usuario_id) selected @endif value="{{ $tipo->tipo_usuario_id }}">{{ $tipo->tipo }}</option>
                @endforeach
            </select>
            <div class="form-text text-end me-1 text-danger tipo_usuario_id_error"></div>

            <button class="buttonSubmitForm" type="submit">Salvar Alterações</button>
            
            <div class="alerta_sucesso hidden"> Dados salvos com sucesso! </div>
            <div class="alerta_erro hidden"> Ocorreu um erro </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function(){
            $('#editar-perfil-form').on("submit", function(e){
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
                    success: function(r) {
                        $(".alerta_sucesso").removeClass("hidden")
                        $(".alerta_erro").addClass("hidden")
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