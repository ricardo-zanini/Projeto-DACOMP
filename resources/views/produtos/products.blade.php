@extends('templates.base')
@section('title', 'Produtos')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <h1>PRODUTOS</h1>
    <div class="container">
        <form id="search-form" method="GET">
            <div class="search-container">
                <div class="icon-container">
                    <i class="fa fa-search search-icon"></i>
                    <input id="search" class="search-bar" type="search" name="input" placeholder="Pesquisar" />
                </div>
                <div class="filter-container">
                    <img id="open-filter" class="filter-icon" src="../icons/filters.svg" alt="Filtros" />
                </div>
                <!-- Se usuário do tipo gestor, permitir adição de Produtos -->
                @if(Auth::user() && Auth::user()->gestor)
                    <a href="{{ route('produtos.create') }}" class="botao_novo_prod">Novo Produto</a>
                @endif
            </div>
            @include('produtos.filter')
        </form>
        @include('produtos.list', ['produtos' => $produtos])
    </div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(function() {
        $('#open-filter').on('click', () => openFilter());
        $('#close-filter').on('click', () => closeFilter());
        $('#modal-tipo').on('change', () => filterAndSearch('tipo'));
        $('#modal-tamanho').on('change', () => filterAndSearch('tamanho'));
        $('#modal-cor').on('change', () => filterAndSearch('cor'));
        $('#search-form').on('submit', function (e) {
            e.preventDefault();
            search();
        });

        function search() {
            $.ajax({
                url: "{{ route('produtos.search') }}",
                method: "GET",
                data: {
                    input: $('#search').val(),
                    tipo_produto_id: $('#modal-tipo').val(),
                    tamanho_id: $('#modal-tamanho').val(),
                    cor_id: $('#modal-cor').val()
                },
                success: data => $('#products-list').html(data),
                error:   () => alert('Erro ao buscar produtos.')
            });
        }

        function reset(except) {
            if (except !== 'tipo')    $('#modal-tipo').val('');
            if (except !== 'tamanho') $('#modal-tamanho').val('');
            if (except !== 'cor')     $('#modal-cor').val('');
        }

        function openFilter() {
            $('#filter-modal').fadeIn();
        }

        function closeFilter() {
            $('#filter-modal').fadeOut();
        }

        function filterAndSearch(except) {
            reset(except); 
            closeFilter();
            search();
        }
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
        .search-container{
            display: flex;
            width: 100%;
            max-width: 64rem;
            margin: 0 auto;
            align-items: center;
            gap: 1rem;
        }
        .search-bar{
            width: 100%;
            padding: 0.6rem 0.6rem 0.6rem 3rem;
            border-radius: 999px;
            border: none;
            background-color: #f9f9f9;
            box-sizing: border-box;
            border: solid 1px #dee2e6;
            height:48px;
        }
        .icon-container{
            width: 100%;
        }
        .icon-container i{
            position: absolute;
        }
        .search-icon{
            padding: 0.85rem 0rem 0.85rem 1rem;
            min-width: 40px;
            pointer-events: none;         
        }
        .label{
            font-size: 17px;
        }
        .container{
            display: flex;
            flex-direction: column;
            margin-bottom: 2rem;
            gap: 2.625rem;
        }
        form{
            display: flex;
            flex-direction: row;
            justify-content: center;
            align-items: center;
        }
        .form-control{
            width: 10rem;
        }
        .filter-container{
            display: flex;
            background-color: #292929;
            border-radius: 100%;
            padding: 0.4rem 0.4rem 0.4rem 0.4rem;
            cursor: pointer;
        }
        .filter-container:hover{
            background-color: #2e96d5;
        }
        .filter-icon{
            width: 2rem;
        }
        .botao_novo_prod{
            height:48px;
            width:150px;
            text-decoration:none;
            display:flex;
            align-items:center;
            justify-content:center;
            background-color: #292929;
            color:white;
            border-radius:0.375rem;
            cursor:pointer;
        }
</style>
@endpush