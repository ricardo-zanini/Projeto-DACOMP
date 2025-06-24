@extends('templates.base')
@section('title', 'Relatório de Pedidos')

@section('content')
    <h1>RELATÓRIO DE PEDIDOS</h1>
    <div class="container">
    <!-- ==================== MENU FILTROS ==================== -->
        <form id="search-form" method="GET">
            <div class="search-container">
                <div class="icon-container">
                    <i class="fa fa-search search-icon"></i>
                    <input id="search" class="search-bar" type="search" name="input" placeholder="Pesquisar" />
                </div>
                <div class="filter-container botaoTransicao">
                    <img id="open-filter" class="filter-icon" src="../icons/filters.svg" alt="Filtros" />
                </div>
            </div>
        </form>
        @include('compras.filters')
        @include('compras.list', ['pedidos' => $pedidos])
    </div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(function() {
        // ================= Modal de Filtragem =================
        $('#open-filter').on('click', () => openModal('#filter-modal'));
        $('#close-filter').on('click', () => closeModal('#filter-modal'));
        $('#modal-tipo').on('change', () => filterAndSearch('tipo'));
        $('#modal-tamanho').on('change', () => filterAndSearch('tamanho'));
        $('#modal-cor').on('change', () => filterAndSearch('cor'));
        $('#search-form').on('submit', function (e) {e.preventDefault(); search();});
        $('#search').on('blur', function (e) {search();});

        // ================= Modal de Deleção =================
        $('.open-delete').on('click', function(){
            const produtoId = $(this).attr('produto_id');
            $('#input_delete').val(produtoId);
            console.log($('#input_delete').val())
            openModal('#delete-modal')
        });
        $('#close-delete').on('click', () => closeModal('#delete-modal'));
        $('#cancelar_delecao').on('click', () => closeModal('#delete-modal'));
        
        function search() {
            console.log('aaa')
            $.ajax({
                url: "{{ route('pedidos.relatorios') }}",
                method: "GET",
                data: {
                    input: $('#search').val(),
                    tipo_produto_id: $('#modal-tipo').val(),
                    tamanho_id: $('#modal-tamanho').val(),
                    cor_id: $('#modal-cor').val()
                },
                success: data => $('#container_pedidos').html(data),
                error:   () => alert('Erro ao buscar produtos.')
            });
        }

        function resetFilter(except) {
            if (except !== 'tipo')    $('#modal-tipo').val('');
            if (except !== 'tamanho') $('#modal-tamanho').val('');
            if (except !== 'cor')     $('#modal-cor').val('');
        }

        function openModal(element) {
            $(element).fadeIn();
        }

        function closeModal(element) {
            $(element).fadeOut();
        }

        function filterAndSearch(except) {
            resetFilter(except); 
            closeModal('#filter-modal');
            search();
        }

       
        // const container_append_pedidos = $("#container_pedidos")
        // const pedidos_json = @json($pedidos)

        // listagem_produtos(pedidos_json, container_append_pedidos);
        
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
        .filter-icon{
            width: 2rem;
            padding: 0.2rem;
            user-select: none;
        }
</style>
@endpush