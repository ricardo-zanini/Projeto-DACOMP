@extends('templates.base')
@section('title', 'Pedidos')

@section('content')
    <h1>MEUS PEDIDOS</h1>
    <div class="pedidos-container">
        @if ($compras->isEmpty())
            <p>Você ainda não tem pedidos.</p>
        @else
            <div class="grid-container">
                @foreach ($compras as $status => $comprasPorStatus)
                    <div class="status-section">
                        <h2>{{ strtoupper($status) }}</h2>
                        <div class="pedido-list">
                            @forelse ($comprasPorStatus as $compra)
                                <div class="pedido-card">
                                    <div class="info">
                                        <p style="font-weight: bold;">Pedido #{{ $compra->compra_id }}</p>
                                        <p>{{ $compra->horario->format('d-m-y') }}</p>
                                    </div>
                                    <div class="itens-container">
                                        @foreach ($compra->produtosCompras as $item)
                                            <div class="item-wrapper">
                                                <div class="info">
                                                    <p class="item-name">{{ $item->produtoEstoque->produto->nome ?? 'Produto não encontrado' }} ({{ $item->quantidade }})</p>
                                                    <p>R$ {{ number_format($item->valor_unidade, 2, ',', '.') }}</p>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="info total">
                                        <label>Total ({{ $compra->quantidade_total }})</label>
                                        <label>R$ {{ number_format($compra->total, 2, ',', '.') }}</label>
                                    </div>
                                    @if ($compra->status_id == 1)
                                        <div class="acoes">
                                            <a href="{{ route('compras.show') }}" class="button edit">Editar</a>
                                            <form action="{{ route('compras.cancel', $compra) }}" method="POST">
                                                @csrf
                                                <button class="button cancel">Cancelar</button>
                                            </form>
                                            <a href="{{ route('compras.pagamento', $compra) }}" class="button pay">Pagar</a>
                                        </div>
                                    @elseif ($compra->status_id == 2)
                                        <div class="acoes">
                                            @if (!$compra->solicitacao_cancelamento_id)
                                            <button compra_id="{{$compra->compra_id}}"class="button cancel">Cancelar</button>
                                            @else
                                            <div class="cancelamento_solicitado">Cancelamento Solicitado</diiv>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
        @include('compras.modal_cancel')
    </div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // ================= Modal de Deleção =================
    $(document).on('click', '.cancel', function(){
        const compraId = $(this).attr('compra_id');
        $('#input_cancel').val(compraId);
        openModal('#cancel-modal')
    });

    $('#close-cancel').on('click', () => closeModal('#cancel-modal'));
    $('#cancelar_cancelamento').on('click', () => closeModal('#cancel-modal'));
    $('.button.cancel').on('click', () => openModal('#cancel-modal'));

    $('.container_cancelamento').on("submit", function(e){
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
                $(".container_cancelamento").addClass("hidden")
                setTimeout(function() {
                    closeModal('#delete-modal');
                    setTimeout(function() {
                            $(".alerta_sucesso").addClass("hidden");
                            $(".container_cancelamento").removeClass("hidden")
                    }, 400);
                }, 2000);
            },
            error: function(err) {
                if (err.status == 422) {
                    $.each(err.responseJSON.errors, function (i, error) {
                        $('.'+i+'_error').text(error[0]);
                        $(document).find('[name="'+i+'"]').addClass('is-invalid');
                    });
                }else if(err.status == 409){
                    $('.alerta_erro').text(err.responseJSON.message)
                }
              
                {{-- console.log("Erro:")
                console.log(err) --}}
                console.log(err)
                $(".alerta_sucesso").addClass("hidden")
                $(".alerta_erro").removeClass("hidden")
            }
        });
    })

    function openModal(element) {
        $(element).hide().fadeIn()
    }

    function closeModal(element) {
        $(element).fadeOut();
    }
</script>
@endpush

@push('styles')
<style>
    h1{
        font-family: "Cal Sans", sans-serif;
        text-align: center;
        padding: 50px 0px;
    }
    h2 {
        font-family: "Cal Sans", sans-serif;
        margin-bottom: 1rem;
        font-size: 1.2rem;
        border-bottom: 1px solid #ccc;
        padding-bottom: 0.5rem;
    }
    .pedidos-container{
        display: flex; 
        flex-direction: column; 
        justify-content: center; 
        align-items:center;
    }
    .grid-container {
        display: grid;
        grid-template-rows: repeat(auto-fit, minmax(0px, 1fr));
        gap: 2rem;
        padding: 1rem 2rem;
        width: 100%;
    }
    .status-section {
        border-radius: 8px;
        padding: 1rem;
    }
    .pedido-list {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }
    .pedido-card {
        padding: 1rem;
        background-color: white;
        border: 1px solid #ccc;
        border-radius: 8px;
    }
    .info{
        display: flex; 
        flex-direction: row; 
        justify-content: space-between;
    }
    .itens-container{
        display: flex; 
        flex-direction: column;
    }
    .acoes{
        border-top: 1px solid #ccc;
        margin-top: 1rem;
        padding-top: 1rem;
        display: flex;
        gap: .75rem;
        justify-content: flex-end;
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
    .edit{
        background:#2e96d5;
    }
    .pay{
        background:#292929;
    }
    .cancel{
        background: #dc3545;
    }
</style>
@endpush