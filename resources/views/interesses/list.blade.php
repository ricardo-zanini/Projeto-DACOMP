@extends('templates.base')
@section('title', 'Interesses')

@section('content')
    <h1>MEUS INTERESSES</h1>
    <div class="interesses-container">
        @if ($interesses->isEmpty())
            <p>Você ainda não tem interesses.</p>
        @else
            <div class="grid-container">
                @foreach ($interesses as $interesse)
                    <div class="interesse-card">
                        <label><strong>{{ $interesse->produtoEstoque->produto->nome ?? 'Produto não encontrado' }}</strong> - {{ $interesse->produtoEstoque->tamanho->tamanho }} - {{ $interesse->produtoEstoque->cor->cor }}</label>
                        <form action="{{ route('interesses.cancel', $interesse) }}" method="POST">
                            @csrf
                            <button class="button cancel">Cancelar</button>
                        </form>
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
    .interesses-container{
        display: flex; 
        flex-direction: column; 
        justify-content: center; 
        align-items:center;
    }
    .grid-container{
        display: grid;
        grid-template-rows: repeat(auto-fit, minmax(0px, 1fr));
        gap: 1rem;
        padding: 1rem 2rem;
        width: 100%;
    }
    .interesse-card{
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        align-items: center;
        padding: 0.6rem 1rem 0.6rem 1rem;
        border: 1px solid #ccc;
        border-radius: 8px;
        background-color: white;
    }
    .button{
        display: inline-block;
        padding: .5rem 1rem;
        border-radius: 6px;
        text-decoration: none;
        text-align: center;
        color: #fff;
        border-radius: 999px;
        border: none;
    }
    .cancel{
        background: #dc3545;
    }
</style>
@endpush