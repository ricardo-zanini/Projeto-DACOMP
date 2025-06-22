@extends('templates.base')
@section('title', 'Relatórios')

@section('content')
    <h1>RELATÓRIOS</h1>
    <div class="grid-container">
        <div class="relatorio-container">
            <a  class="button title" href="{{ route('pedidos.relatorios') }}">PEDIDOS</a>
        </div>
        <div class="relatorio-container">
            <a  class="button title" href="{{ route('interesses.relatorios') }}">INTERESSES</a>
        </div>
    </div>
@endsection

@push('styles')
<style>
    h1 {
        font-family: "Cal Sans", sans-serif;
        text-align: center;
        padding: 50px 0px;
    }
    .grid-container {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 2rem;
        max-width: 40rem;
        margin: 0 auto;
        padding: 1rem;
    }
    .relatorio-container {
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 1rem;
        border-radius: 999px;
        background-color: #292929;
        text-align: center;
    }
    .title{
        font-family: "Cal Sans", sans-serif;
        font-size: 1.3rem;
        text-decoration: none;
        color: white;
    }
</style>
@endpush