@extends('templates.base')
@section('title', 'Pagamento')

@section('content')
    <h1>PAGAMENTO</h1>
    <div class="container">
        <p>Seu pagamento foi processado com sucesso!</p>
        <p class="subtitle">Você será notificado por email com os códigos de retirada</p>
        <a href="{{ route('produtos.list') }}" class="button">Fazer outros pedidos</a>
    </div>
@endsection

@push('styles')
<style>
   h1{
        font-family: "Cal Sans", sans-serif;
        text-align:center;
        padding: 50px 0px;
    }
    .subtitle{
        color:#2e96d5;
    }
    .container{
        display: flex;
        flex-direction: column;
        align-items: center;
        margin-bottom: 2rem;
        justify-content: center;
        align-items: center;
    }
    .button{
        font-family: "Cal Sans", sans-serif;
        border: none;
        padding: 10px;
        background-color: #292929;
        border-radius: 500px;
        width: 25rem;
        color: #ffffff;
        text-align:center;
        text-decoration:none;
        cursor:pointer;
    }
    p:last-of-type{
        margin-bottom:50px;
    }
</style>
@endpush