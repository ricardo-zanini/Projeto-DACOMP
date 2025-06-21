@extends('templates.base')
@section('title', 'Carrinho')

@section('content')
    <h1>CARRINHO</h1>
    <div class="container">
        @if ($compras->isEmpty())
            <p>Seu carrinho está vazio.</p>
        @else
            <div class="list-container">
                @foreach ($compras as $compra)
                    <div class="list-item">
                        <div class="info">
                            <p>#{{ $compra->compra_id }} - {{ $compra->status->status }}</p>
                            <p>{{ $compra->horario->format('d-m-y') }}</p>
                        </div>
                        <div class="itens-container">
                            @foreach ($compra->produtosCompras as $item)
                                <div class="item-wrapper">
                                    <div class="info">
                                        <p class="item-name">{{ $item->produtoEstoque->produto->nome ?? 'Produto não encontrado' }}</p>
                                        <p>R$ {{ number_format($item->valor_unidade, 2, ',', '.') }}</p>
                                    </div>
                                    <div class="counter">
                                        @if ($item->quantidade === 1)
                                            <form action="{{ route('compras.delete', [$compra, $item]) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="icon-button">
                                                    <img class="icon" src="{{asset('/icons/trash.svg')}}" alt="Remover">
                                                </button>
                                            </form>
                                        @else
                                            <form action="{{ route('compras.remove', [$compra, $item]) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="icon-button">
                                                    <img class="icon" src="{{asset('/icons/minus-wo-border.svg')}}" alt="Remover">
                                                </button>
                                            </form>
                                        @endif
                                        <p>{{ $item->quantidade }}</p>
                                        <form action="{{ route('compras.add', [$compra, $item]) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="icon-button">
                                                <img class="icon" src="{{asset('/icons/plus-wo-border.svg')}}" alt="Adicionar" />
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="info total">
                            <p >Total ({{ $compra->quantidade_total }})</p>
                            <p>R$ {{ $compra->total }}</p>
                        </div>
                        <button class="button">Pagar</button>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection

@push('styles')
<style>
    h1{
        font-family: "Cal Sans", sans-serif;
        text-align:center;
        padding: 50px 0px;
    }
    .container{
        display: flex;
        flex-direction: column;
        align-items: center;
        margin-bottom: 2rem;
        justify-content: center;
        align-items: center;
    }
    .list-container{
        display: grid;
        grid-template-rows: 100%;
        margin: auto;
    }
    .list-item{
        display: flex;
        flex-direction: column;
        border-radius: 8px;
        padding: 2rem;
        width: 100%;
        border: solid 1px #dee2e6;
        background-color: white;
    }
    .itens-container{
        display: flex; 
        flex-direction: column;
    }
    .itens-container > .item-wrapper:not(:last-child) {
        border-bottom: 1px solid #dee2e6;
        margin-bottom: 0.5rem;
    }
    .counter{
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-radius: 8px;
        width: 10rem;
        border: 1px solid #dee2e6;
        margin-bottom: 1rem;
        padding: 0.6rem 1rem 0.6rem 1rem;
    }
    .counter p {
        margin: 0rem;
        line-height: 1rem;
        padding: 0px;
    }
    .icon {
        height: 1rem;
        width: 1rem;
        padding: 0px;
    }
    .button{
        font-family: "Cal Sans", sans-serif;
        border: none;
        padding: 10px;
        background-color: #292929;
        border-radius: 500px;
        width: 25rem;
        color: #ffffff;
    }
    .icon-button{
        background-color: white;
        border: none;
    }
    .info{
        display: flex; 
        flex-direction: row; 
        justify-content: space-between;
    }
    .item-name{
        font-weight: bold;
    }
    .total{
        border-top: 1px solid #dee2e6;
        padding-top: 1rem;
    }
</style>
@endpush