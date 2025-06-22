@extends('templates.base')
@section('title', 'Relatórios Interesses')

@section('content')
    <h1>RELATÓRIO DE INTERESSES</h1>
    <div class="container">
        @if (empty($agrupado))
            <p>Você ainda não tem relatórios de interesse.</p>
        @else
            <div class="grid-container">
                @foreach ($agrupado as $tipo => $produtos)
                    <h2>{{ mb_strtoupper($tipo, 'UTF-8') }}</h2>
                    @foreach ($produtos as $produtoNome => $variacoes)
                        <div class="produto-card">
                            <h3>{{ $produtoNome }}</h3>
                            <div class="info-grid">
                                <p><strong>Tamanho</strong></p>
                                <p><strong>Cor</strong></p>
                                <p><strong>Interessados (UFRGS)</strong></p>
                                <p><strong>Interessados (Externos)</strong></p>
                                <p><strong>Total</strong></p>
                            </div>
                            <div class="produto-grid">
                                @foreach ($variacoes as $variacao)
                                    <div class="variacao-card">
                                        <p>{{ $variacao['tamanho'] }}</p>
                                        <p>{{ $variacao['cor'] }}</p>
                                        <p>{{ $variacao['com_cartao'] }}</p>
                                        <p>{{ $variacao['sem_cartao'] }}</p>
                                        <p>{{ $variacao['total'] }}</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
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
    h2 {
        font-family: "Cal Sans", sans-serif;
        margin-bottom: 1rem;
        font-size: 1.2rem;
        border-bottom: 1px solid #ccc;
        padding-bottom: 0.5rem;
    }
    h3 {
        font-family: "Cal Sans", sans-serif;
        margin-bottom: 1rem;
        font-size: 1.2rem;
        justify-self: center;
    }
    .container{
        display: flex;
        flex-direction: column;
        align-items: center;
        margin-bottom: 2rem;
        justify-content: center;
        align-items: center;
    }
    .grid-container{
        background-color: #f9f9f9;
        border: 1px solid #ccc;
        border-radius: 8px;
        padding: 1rem;
        width: 100%;
    }
    .tipo-grid {
        margin: 2rem 0;
        padding: 1rem;
        background-color: #f9f9f9;
        border-radius: 8px;
    }
    .produto-card {
        margin: 1rem 0;
        padding: 1rem;
        background-color: #ffffff;
        border: 1px solid #ccc;
        border-radius: 8px;
    }
    .info-grid,
    .produto-grid {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 0;
        text-align: center;
    }
    .info-grid p {
        font-weight: bold;
        padding: 0.5rem 0;
        border-bottom: 1px solid #ccc;
    }
    .variacao-card {
        display: contents;
    }
    .produto-grid p {
        padding: 0.5rem 0;
    }
    .produto-grid p:last-child {
        border-bottom: none;
    }
</style>
@endpush