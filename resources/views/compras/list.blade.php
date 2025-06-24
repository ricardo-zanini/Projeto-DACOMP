<div id="container_overflow">
    <div id="container_pedidos">
    @foreach($pedidos as $pedido)
        <div id="compra_{{$pedido->compra_id}}" class="container_pedido" id="pedido_${pedido.compra_id}">
            <div class="cabecalhos">
                <div>Horário</div>
                <div>Cliente</div>
                <div>Status do pedido</div>
                <div>Total</div>
                <div></div>
            </div>
            <div class="dados">
                <div class="horario_compra">{{ \Carbon\Carbon::parse($pedido->horario)->format('d/m/Y H:i')}}</div>
                <div class="usuario_compra">{{$pedido->nome}}</div>
                <div class="status_compra">{{$pedido->status}}</div>
                <div class="total_compra">R${{number_format($pedido->total, 2, ',', '.')}}</div>
                <div class="acao_compra">
                    @if($pedido->status_id == 2)
                        <button class="botaoTransicao">
                            Pronto para Entrega
                        </button>
                    @endif
                </div>
            </div>
        </div>
    @endforeach
    </div>
</div>

@push('styles')
    <style>
        .acao_compra > button{
            padding:10px 20px;
            border-radius:200px;
            font-weight:bold;
            border:none;
            color:white;
            cursor:pointer;
            background-color:#292929;
        }
         .cabecalhos, .dados{
            display:flex;
            flex-direction:row;
        }
        .cabecalhos > div, .dados > div{
            width:20%;
            height:40px;
            display:flex;
            align-items:center;
            justify-content:center;
           
        }
        .cabecalhos > div{
            font-weight:bold;
        }
        .container_pedido{
            padding:10px 0px;
        }
        .container_pedido:first-of-type{
            padding-top:20px;
            border-top-left-radius:0.375rem;
            border-top-right-radius:0.375rem;
        }
        .container_pedido:last-of-type{
            padding-bottom:20px;
            border-bottom-left-radius:0.375rem;
            border-bottom-right-radius:0.375rem;
        }
        .container_pedido:nth-child(odd){
            background-color:#efefef;
        }

        #container_pedidos{
            background-color: #ffffff;
            border: 1px solid #ccc;
            border-radius: 0.375rem;
            /* padding:1rem 0; */
            width: 100%;
            display:flex;
            flex-direction:column;
            min-width:1200px;
        }
        #container_overflow{
            overflow-x:scroll;
        }
    </style>
@endpush