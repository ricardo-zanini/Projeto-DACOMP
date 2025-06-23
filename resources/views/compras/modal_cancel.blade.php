<div id="cancel-modal" class="cancel-modal" style="display:none;">
    <div class="cancel-box">
        <span id="close-cancel" class="close-btn">&times;</span>
        <h5 style="font-weight: bold;margin-top:20px;">SOLICITAR CANCELAMENTO</h5>
        <p class="aviso">
            Se você realmente deseja cancelar o pedido, forneça sua chave pix para que seu reembolso possa ser avaliado. O resultado da avaliação será enviado por email.
        </p>
        <form class="container_cancelamento" method="post" action="{{ route('compras.cancel') }}">
            @csrf
            <input id="input_cancel" type="hidden" name="compra_id" value=""/>

            <div class="mb-3">
                <label for="chave" class="form-label">Chave Pix</label>
                <input type="text" class="form-control first_input" id="chave" placeholder="Chave Pix" name="chave" maxlength="100" required>
            </div>

            <div class="mb-3">
                <label for="chave" class="form-label">Confirme a Chave Pix</label>
                <input type="text" class="form-control first_input" id="chave" placeholder="Chave Pix" name="chave_confirmation" maxlength="100" required>
            </div>

            <div class="mb-3">
                <label for="motivacao" class="form-label">Motivação</label>
                <textarea name="motivacao" class="form-control" maxlength="200" placeholder="Escreva aqui a motivação do seu pedido de reembolso" id="motivacao" rows="3"></textarea>
            </div>
            <div class="container_botoes_cancelamento">
                <button type="submit" id="cancelar">Enviar</button>
                <button type="button" id="cancelar_cancelamento">Cancelar</button>
            </div>
        </form>

        <div class="alerta_sucesso hidden"> Solicitação Enviada!</div>
        <div class="alerta_erro hidden"> Ocorreu um erro </div>
    </div>
</div>

@push('styles')
    <style>
        .aviso{
            text-align:justify;
            margin-top:20px;
        }
        .cancel-modal{
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 9999;
        }
        .cancel-box{
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
        .container_botoes_cancelamento{
            display:flex;
            align-items:center;
            justify-content:space-between;
        }
        .container_botoes_cancelamento > button{
            padding:10px 20px;
            border-radius:200px;
            font-weight:bold;
            border:none;
            color:white;
            cursor:pointer;
        }
        #cancelar{
            background-color:#e04a4a;
        }
        #cancelar_cancelamento{
            background-color:#292929;
        }
    </style>
@endpush