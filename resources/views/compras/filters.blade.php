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


@push('styles')
    <style>
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
    #filter-form{
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items:start;
    }
    </style>
@endpush