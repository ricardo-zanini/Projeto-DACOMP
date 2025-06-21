<div id="delete-modal" class="delete-modal" style="display:none;">
    <div class="delete-box">
        <span id="close-delete" class="close-btn">&times;</span>
        <h5 style="font-weight: bold;">EXCLUIR PRODUTO</h5>
        <p>
            Você realmente deseja excluir esse produto e suas variações?
        </p>
        <p class="subtexto">
            (Excluir o produto não apagará registros de compras)
        <p>
        <form class="container_botoes_delecao"method="post" action="{{ route('produtos.delete') }}">
            @csrf
            <input style="display:none" id="input_delete" type="text" name="produto_id" value=""/>
            <button type="submit" id="deletar_delecao">Deletar</button>
            <button id="cancelar_delecao">Cancelar</button>
        </form>

        <div class="alerta_sucesso hidden"> Produto Excluído </div>
        <div class="alerta_erro hidden"> Ocorreu um erro </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function(){
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
                },
                error: function(err) {
                    if (err.status == 422) {
                        $.each(err.responseJSON.errors, function (i, error) {
                            $('.'+i+'_error').text(error[0]);
                            $(document).find('[name="'+i+'"]').addClass('is-invalid');
                        });
                    }
                    console.log("Erro:")
                    console.log(err)
                    $(".alerta_sucesso").addClass("hidden")
                    $(".alerta_erro").removeClass("hidden")
                }
            });
        })
    })
</script>
@endpush

@push('styles')
    <style>
    .delete-modal{
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 9999;
    }
    .delete-box{
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
    .container_botoes_delecao{
        display:flex;
        align-items:center;
        justify-content:space-between;
    }
    .container_botoes_delecao > button{
        padding:10px 20px;
        border-radius:200px;
        font-weight:bold;
        border:none;
        color:white;
        cursor:pointer;
    }
    #cancelar_delecao{
        background-color:#292929;
    }
    #deletar_delecao{
        background-color:#e04a4a;
    }
    .subtexto{
        color:#d0d0d0;
        padding-bottom:10px;
    }
    </style>
@endpush