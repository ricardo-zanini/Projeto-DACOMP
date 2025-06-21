@extends('templates.base')
@section('title', 'Cadastrar Produto')

@section('content')
    <h1>CADASTRO DE PRODUTO</h1>
    <div class="conteudoCadastro">
    <form method="post" enctype="multipart/form-data" action="{{ route('produtos.gravar') }}">

        @csrf
        
        <div class="form-floating">
            <input type="text" class="form-control first_input" id="nome" placeholder="Nome do Produto" name="nome" maxlength="100" required>
            <label for="nome">Nome do Produto</label>
        </div>

        <select name="tipo_produto_id" class="form-control" required>
            <option value="">Selecione o Tipo de Produto</option>
            @foreach ($tipos as $tipo)
                <option value="{{ $tipo->tipo_produto_id }}">{{ $tipo->tipo }}</option>
            @endforeach
        </select>

        <div id="valorContainer" class="form-floating">
            <input type="text" class="form-control first_input" id="valor_unidade" placeholder="Valor" name="valor_unidade" maxlength="100" required>
            <div id="simboloReal"><span>R$</span></div>
            <label for="valor">Valor</label>
        </div>

        <div class="mb-3">
            <input type="file" class="form-control" id="imagem" name="imagem" accept="image/*">
        </div>

        <h5>VARIAÇÕES</h5>

        <div id="container_info_estoque">
            <div id="info_estoque_variacoes">

            </div>
            <input style="display:none" value="0" type="text" name="numero_variacoes" class="numero_variacoes">

            <div id="container_estoque_acao">
                <div class="adicionar" onclick="adiciona_variacao()">
                    <img src="../icons/plusIcon.svg" alt="" />
                    <span>Adicionar<span>
                </div>
                <div class="remover" onclick="remove_variacao()">
                    <img src="../icons/minusIcon.svg" alt="" />
                    <span>Remover</span>
                </div>
            </div>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">{{ $errors->first() }}</div>
        @endif

        <button class="buttonSubmitForm" type="submit">Cadastrar</button>

        <div class="alerta_sucesso hidden"> Dados salvos com sucesso! </div>
        <div class="alerta_erro hidden"> Ocorreu um erro </div>

    </form>
    </div>
@endsection

@push('scripts')
<script>

    function adiciona_variacao(){
        const elementosX = document.querySelectorAll('.container_interno_variacao');
        const numero_atual = elementosX.length;

        $('#info_estoque_variacoes').append(`
            <div class="container_interno_variacao variacao_${numero_atual}">  
                <h5 class="variacao_titulo">Variação ${numero_atual}</h5>
                <select name="tamanho_id_${numero_atual}" class="form-control class_tamanho" required>
                    <option value="">Selecionar tamanho</option>
                    @foreach ($tamanhos as $tamanho)
                        <option value="{{ $tamanho->tamanho_id }}">{{ $tamanho->tamanho }}</option>
                    @endforeach
                </select>

                <select name="cor_id_${numero_atual}" class="form-control class_cor" required>
                    <option value="">Selecionar cor</option>
                    @foreach ($cores as $cor)
                        <option value="{{ $cor->cor_id }}">{{ $cor->cor }}</option>
                    @endforeach
                </select>

                <div class="form-floating class_unidades">
                    <input type="text" class="form-control first_input" id="unidades" placeholder="Unidades do Produto" name="unidades_${numero_atual}" maxlength="100" required>
                    <label for="unidades">Unidades do Produto</label>
                </div>
                
                <div class="container_checks">
                    <div class="form-check">
                        <input class="form-check-input" name="disponivel_${numero_atual}" type="checkbox" value="" id="defaultCheck1" checked>
                        <label class="form-check-label" for="defaultCheck1">
                            Disponível
                        </label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" name="pronta_entrega_${numero_atual}" type="checkbox" value="" id="defaultCheck1">
                        <label class="form-check-label" for="defaultCheck1">
                            Pronta-Entrega
                        </label>
                    </div>
                </div>
            </div>
        `);

        input_variacoes = document.querySelectorAll(".numero_variacoes")[0]
        input_variacoes.value = parseInt(input_variacoes.value) + 1;
    }
    function remove_variacao(){
        const elementos = document.querySelectorAll('.container_interno_variacao');
        if (elementos.length > 1) {
            elementos[elementos.length - 1].remove();
            input_variacoes = document.querySelectorAll(".numero_variacoes")[0]
            input_variacoes.value = parseInt(input_variacoes.value) - 1
        }
    }
    adiciona_variacao();

    const campo = document.getElementById('valor_unidade');

    campo.addEventListener('input', function () {
      // Remove tudo que não for dígito ou ponto
      let valor = campo.value.replace(/[^0-9,]/g, '');

      // Garante que só haja um ponto decimal
      const partes = valor.split(',');
      if (partes.length > 2) {
        valor = partes[0] + ',' + partes.slice(1).join('');
      }

      // Atualiza o valor no campo
      campo.value = valor;
    });

    campo.addEventListener('blur', function () {
      // Ao sair do campo, formata para 2 casas decimais
      let valor = parseFloat(campo.value.replace(/\,/g, '.'));
      if (!isNaN(valor)) {
        campo.value = valor.toFixed(2).replace(/\./g, ',');
      } else {
        campo.value = '';
      }
    });

    $(document).ready(function(){
            $('form').on("submit", function(e){
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
                        $(document).find('.border-danger').removeClass('is-invalid');
                        
                        $(".alerta_sucesso").addClass("hidden")
                        $(".alerta_erro").addClass("hidden")
                    },
                    success: function() {
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
                        console.log("Erro:")
                        console.log(err)
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
        padding: 20px;
        border: solid 1px #dee2e6;
        border-radius: 0.375rem;
        background-color: white;
    }
    h5{
        font-weight: bolder;
        margin: 20px 0px;
    }

    .container_checks{
        display:flex;
        flex-direction: row;
        gap: 20px;
        margin-bottom:20px;
    }

    .container_interno_variacao:not(.variacao_0) > .variacao_titulo{
        padding-top:20px;
        border-top:solid 1px #dee2e6;
    }
    #container_info_estoque{
        display:flex;
        flex-direction:column;
        width:100%;
        padding:20px;
        border-radius: 0.375rem;
        border: solid 1px #dee2e6;
        background-color:#ffffff;
        margin-bottom:20px;
    }
    #container_estoque_acao{
        display: flex;
        align-items: center;
        padding-top:20px;
        border-top: solid 1px #dee2e6;
        justify-content:space-between;
    }
    #container_estoque_acao > div{
        display: flex;
        align-items:center;
        gap: 5px;
        cursor:pointer;
        transition:0.2s;
    }
    #container_estoque_acao > div:hover{
        scale:1.02;
    }


    #container_estoque_acao > div > img{
        width:25px;
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
    h1{
        font-family: "Cal Sans", sans-serif;
        text-align:center;
        padding:50px 0px;
    }
    #valorContainer > input{
        padding-left:72px;
    }
    #valorContainer > label{
        padding-left:72px;
    }
    #simboloReal{
        position: absolute;
        top: 1px;
        width: 60px;
        height: 56px;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        border-top-left-radius: 0.375rem;
        border-bottom-left-radius: 0.375rem;
        background-color: #f8f9fa;
        left: 1px;
        border-right: solid 1px #dee2e6;
    }
    #simboloReal > span{
        color: #292929;
    }
</style>
@endpush