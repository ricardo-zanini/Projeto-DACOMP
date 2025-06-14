@extends('templates.base')
@section('title', 'Cadastrar Produto')

@section('content')
    <h1>CADASTRO DE PRODUTO</h1>
    <div class="conteudoCadastro">
    <form method="post" action="{{ route('usuarios.gravar') }}">

        @csrf
        
        <div class="form-floating">
            <input type="text" class="form-control first_input" id="nome" placeholder="Nome do Produto" name="nome" maxlength="100" required>
            <label for="nome">Nome do Produto</label>
        </div>

        <div id="valorContainer" class="form-floating">
            <input type="text" class="form-control first_input" id="valor" placeholder="Valor" name="valor" maxlength="100" required>
            <div id="simboloReal"><span>R$</span></div>
            <label for="valor">Valor</label>
        </div>

        <div class="mb-3">
            <input type="file" class="form-control" id="arquivo" name="arquivo" required>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">{{ $errors->first() }}</div>
        @endif

        <button class="buttonSubmitForm" type="submit">Cadastrar</button>
    </form>
    </div>
@endsection

@push('scripts')
<script>
    const campo = document.getElementById('valor');

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