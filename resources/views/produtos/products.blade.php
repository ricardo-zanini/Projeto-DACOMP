@extends('templates.base')
@section('title', 'Produtos')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <h1>PRODUTOS</h1>
    <div class="container">
        <form id="search-form" method="GET">
            <div class="search-container">
                <input id="search" class="search-bar" type="search" name="input" placeholder="Pesquisar" />
                <i class="fa fa-search search-icon"></i>
            </div>
            <select id="tipo_produto_select" class="form-control" name="tipo_produto_id">
                <option value="">Categoria</option>
                @foreach ($tipos_produtos as $tipo)
                    <option value="{{ $tipo->tipo_produto_id }}">{{ $tipo->tipo }}</option>
                @endforeach
            </select>
            <select id="tamanho_select" class="form-control" name="tamanho_id">
                <option value="">Tamanho</option>
                @foreach ($tamanhos as $tamanho)
                    <option value="{{ $tamanho->tamanho_id }}">{{ $tamanho->tamanho }}</option>
                @endforeach
            </select>
            <select id="cor_select" class="form-control" name="cor_id">
                <option value="">Cor</option>
                @foreach ($cores as $cor)
                    <option value="{{ $cor->cor_id }}">{{ $cor->cor }}</option>
                @endforeach
            </select>
            <!-- Se usuário do tipo gestor, permitir adição de Produtos -->
            @if(Auth::user() && Auth::user()->gestor)
                <a href="{{ route('produtos.create') }}" class="novoProduto">Novo Produto</a>
            @endif
        </form>
        <div id="products-list" class="products-container">
            @include('produtos.list', ['produtos' => $produtos])
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        function buscar() {
            $.ajax({
                url: "{{ route('produtos.search') }}",
                method: "GET",
                data: {
                    input: $('#search').val(),
                    tipo_produto_id: $('#tipo_produto_select').val()
                },
                success: data => $('#products-list').html(data),
                error:   () => alert('Erro ao buscar produtos.')
            });
        }

        $('#search-form').on('submit', function (e) {
            e.preventDefault();
            buscar();
        });

        $('#tipo_produto_select').on('change', buscar);
    });
</script>
@endpush

@push('styles')
    <style>
        h1{
            font-family: "Cal Sans", sans-serif;
            text-align:center;
            padding: 50px 0px;
        }
        h2{
            font-size: 18px; 
            margin-bottom: 8px;
        }
        .search-container {
            position: relative;
            width: 100%;
            max-width: 64rem;
            margin: 0 auto;
        }
        .search-bar {
            width: 100%;
            padding: 0.6rem 1.2rem 0.6rem 2.5rem;
            border-radius: 999px;
            border: none;
            background-color: #f0f0f0;
            font-size: 1rem;
            font-family: "Cal Sans", sans-serif;
            box-sizing: border-box;
        }
        .search-icon {
            position: absolute;
            top: 50%;
            left: 1rem;
            transform: translateY(-50%);
            color: #999;
            font-size: 1rem;
        }
        .label{
            font-size: 17px;
        }
        .container{
            display: flex;
            flex-direction: column;
            margin-top: 2rem;
            margin-bottom: 2rem;
            gap: 2.625rem;
        }
        form{
            display: flex;
            flex-direction: row;
            gap: 1rem;
        }
        .form-control{
            width: 15rem;
        }
        .products-container{
            display: flex; 
            justify-content: center;
        }
</style>
@endpush