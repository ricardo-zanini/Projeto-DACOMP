@extends('templates.base')
@section('title', 'Entrega')

@section('content')
    <h1>Pedido #{{$pedido->compra_id}}</h1>
    <div class="container">
        <div class="infos">
            <p><strong>Cliente</strong> {{$pedido->usuario->nome}}</p>
            <p><strong>Total</strong> R$ {{ number_format($pedido->total, 2, ',', '.') }}</p>
        </div>

        <div class="grid-header">
            <p><strong>Produto</strong></p>
            <p><strong>Quantidade</strong></p>
            <p><strong>Tamanho</strong></p>
            <p><strong>Cor</strong></p>
        </div>
        @foreach ($pedido->produtosCompras as $item)
            <div class="grid-item">
                <p>{{ $item->produtoEstoque->produto->nome ?? 'Produto' }}</p>
                <p>{{ $item->quantidade }}</p>
                <p>{{ $item->produtoEstoque->tamanho->tamanho ?? '-' }}</p>
                <p>{{ $item->produtoEstoque->cor->cor ?? '-' }}</p>
            </div>
        @endforeach

        <div class="button-container">
            <form method="POST" action="">
                @csrf
                <button class="button" type="submit">Liberar para Retirada</button>
            </form>
        </div>
    </div>
@endsection

@push('styles')
<style>
    h1{
        font-family: "Cal Sans", sans-serif;
        text-align:center;
        padding: 50px 0px;
    }
    .container {
        max-width: 800px;
        margin: 0 auto;
        padding: 2rem;
        border: 1px solid #ccc;
        border-radius: 10px;
        background-color: #ffffff;
        margin-bottom: 2rem;
    }
    .grid-header, .grid-item {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1rem;
        padding: 0.75rem 1rem;
        align-items: center;
        text-align: center;
    }
    .grid-header {
        background-color: white;
        font-weight: bold;
        border-bottom: 1px solid #ccc;
        border-top-left-radius: 6px;
        border-top-right-radius: 6px;
    }
    .grid-item:nth-child(even) {
        background-color: white;
        justify-content: center;
    }
    .infos {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        margin-bottom: 1rem;
        gap: 0.5rem;
    }
    .button-container {
        text-align: center;
        margin-top: 2rem;
    }
    .button {
        font-family: "Cal Sans", sans-serif;
        display: inline-block;
        padding: .6rem 1rem;
        border-radius: 6px;
        text-align: center;
        border-radius: 999px;
        border: none;
        background-color: #2e96d5;
        color: white;
    }
</style>
@endpush