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
                <div class="filter-container botaoTransicao">
                    <img id="open-filter" class="filter-icon" src="../icons/filters.svg" alt="Filtros" />
                </div>
                <!-- Se usuário do tipo gestor, permitir adição de Produtos -->
                @if(Auth::user() && Auth::user()->gestor)
                    <a href="{{ route('produtos.create') }}" class="botao_novo_prod botaoTransicao">Novo Produto</a>
                @endif
            </div>
            @include('produtos.filter')
            @include('produtos.delete')
        </form>
        @include('produtos.list', ['produtos' => $produtos])
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
        $(document).on('click', '.open-delete', function(){
            const produtoId = $(this).attr('produto_id');
            $('#input_delete').val(produtoId);
            openModal('#delete-modal')
        });
        $('#close-delete').on('click', () => closeModal('#delete-modal'));
        $('#cancelar_delecao').on('click', () => closeModal('#delete-modal'));

        $('.container_botoes_delecao').on("submit", function(e){
            e.preventDefault();
            var action = $(this).attr('action');
            $.ajax({
                url: action,
                method: $(this).attr('method'),
                data: new FormData(this),
                processData: false,
                dataType: 'json',
                contentType: false,
                beforeSend: function() {
                    $(document).find('.text-danger').text('');
                    $(document).find('.border-danger').removeClass('is-invalid');
                    
                    $(".alerta_sucesso").addClass("hidden")
                    $(".alerta_erro").addClass("hidden")
                },
                success: function() {
                    $(".alerta_sucesso").removeClass("hidden")
                    $(".alerta_erro").addClass("hidden")
                    $(".container_botoes_delecao").addClass("hidden")
                    search()
                    setTimeout(function() {
                        closeModal('#delete-modal');
                        setTimeout(function() {
                                $(".alerta_sucesso").addClass("hidden");
                                $(".container_botoes_delecao").removeClass("hidden")
                        }, 400);
                    }, 2000);
                },
                error: function(err) {
                    if (err.status == 422) {
                        $.each(err.responseJSON.errors, function (i, error) {
                            $('.'+i+'_error').text(error[0]);
                            $(document).find('[name="'+i+'"]').addClass('is-invalid');
                        });
                    }
                    {{-- console.log("Erro:")
                    console.log(err) --}}
                    $(".alerta_sucesso").addClass("hidden")
                    $(".alerta_erro").removeClass("hidden")
                }
            });
        })
        
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

        function resetFilter(except) {
            if (except !== 'tipo')    $('#modal-tipo').val('');
            if (except !== 'tamanho') $('#modal-tamanho').val('');
            if (except !== 'cor')     $('#modal-cor').val('');
        }

        function openModal(element) {
            $(element).hide().fadeIn()
        }

        function closeModal(element) {
            $(element).fadeOut();
        }

        function filterAndSearch(except) {
            resetFilter(except); 
            closeModal('#filter-modal');
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
        .botao_novo_prod{
            height:48px;
            width:180px;
            text-decoration:none;
            display:flex;
            align-items:center;
            justify-content:center;
            background-color: #292929;
            color:white;
            border-radius:500px;
            cursor:pointer;
            font-weight:bold;
        }
</style>
@endpush