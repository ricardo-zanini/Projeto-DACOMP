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


            <!-- ==================== MODAL ==================== -->
            <div id="filter-modal" class="filter-modal" style="display:none;">
                <div class="filter-box">
                    <span id="close-filter" class="close-btn">&times;</span>
                    <label style="font-weight: bold;">FILTRAR POR</label>

                    <form id="filter-form">
                        <label for="modal-tipo">Categoria</label>
                        <select id="modal-tipo" name="tipo_produto_id" class="form-control">
                            <option value="">Todas</option>
                            @foreach ($tipos_produtos as $tipo)
                                <option value="{{ $tipo->tipo_produto_id }}">{{ $tipo->tipo }}</option>
                            @endforeach
                        </select>

                        <label for="modal-tamanho">Tamanho</label>
                        <select id="modal-tamanho" name="tamanho_id" class="form-control">
                            <option value="">Todos</option>
                            @foreach ($tamanhos as $tamanho)
                                <option value="{{ $tamanho->tamanho_id }}">{{ $tamanho->tamanho }}</option>
                            @endforeach
                        </select>

                        <label for="modal-cor">Cor</label>
                        <select id="modal-cor" name="cor_id" class="form-control">
                            <option value="">Todas</option>
                            @foreach ($cores as $cor)
                                <option value="{{ $cor->cor_id }}">{{ $cor->cor }}</option>
                            @endforeach
                        </select>
                    </form>
                </div>
            </div>
        </form>
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
            $.ajax({
                url: "{{ route('pedidos.relatorios') }}",
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


        console.log({{$pedidos}});
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




    /* ========================================== */
    /* ============== Estilo Modal ============== */
    /* ========================================== */

    .filter-modal{
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 9999;
    }
    .filter-box{
        background: white;
        padding: 30px;
        border-radius: 10px;
        width: 90%;
        max-width: 400px;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        box-shadow: 0 5px 15px rgba(0,0,0,0.3);
    }
    .close-btn{
        position: absolute;
        top: 10px;
        right: 15px;
        font-size: 24px;
        cursor: pointer;
    }
    .filter-box label{
        margin-top: 10px;
        display: block;
    }
    .filter-box select{
        width: 100%;
        padding: 6px;
        border-radius: 5px;
        border: 1px solid #ccc;
    }
</style>
@endpush