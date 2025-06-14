@extends('templates.base')
@section('title', 'Produtos')

@section('content')

    <div class="containerGeral">
        <div class="containerWidth">
             @if(Auth::user() && Auth::user()->gestor)
                <!-- Se usuário do tipo gestor, permitir adição de Produtos -->
                <a href="{{ route('produtos.create') }}" class="novoProduto">Novo Produto</a>
            @endif
            <div class="containerProdutos">
                @foreach ($produtos as $produto)
                    <div>{{$produto->nome}}</div>
                @endforeach
            </div>
        </div>
    </div>
@endsection

@push('scripts')

@endpush

@push('styles')
<style>
    .containerGeral{
        display:flex;
        padding: 0px 20px;
        padding-bottom:50px;
        justify-content:center;
    }
    .containerWidth{
        max-width:1000px;
        width:100%;
    }
</style>
@endpush