@extends('templates.base')
@section('title', 'Produto')

@section('content')
    <h1>COMPRAR</h1>
    <div class="container">
        <div class="product-container">
            <img class="img" src="{{ '../images/produtos/' . $produto->imagem }}" alt="{{ $produto->produto_id }}" />
            <div class="product-info">
                <div class="link-container">
                    <a href="{{ route('produtos.list') }}" class="link">Produtos</a>
                    <p>&nbsp;&gt;&nbsp;{{ $tipo_produto->tipo }}</p>
                </div>
                <p class="product-name">{{ $produto->nome }}</p>
                <p class="product-value">R$ {{ number_format($produto->valor_unidade, 2, ',', '.') }}</p>
                <label>Disponível para pronta entrega</label>
                <p id="entrega-label" style="font-weight: bold;"></p>

                <label for="tamanho-select">Selecione a opção de Tamanho</label>
                <select id="tamanho-select" name="tamanho_produto_id" class="form-control select">
                    @foreach ($produto->estoque->pluck('tamanho')->unique('tamanho_id') as $tamanho)
                        <option value="{{ $tamanho->tamanho_id }}">{{ $tamanho->tamanho }}</option>
                    @endforeach
                </select>

                <label for="cor-select">Selecione a opção de Cor</label>
                <select id="cor-select" name="cor_produto_id" class="form-control select">
                    @foreach ($produto->estoque->pluck('cor')->unique('cor_id') as $cor)
                        <option value="{{ $cor->cor_id }}">{{ $cor->cor }}</option>
                    @endforeach
                </select>

                <label for="unidades-select">Em estoque</label>
                <select id="unidades-select" name="unidades_produto" class="form-control select">
                    <option value="0">Quantidade: 0</option>
                </select>

                <button id="comprar-button" type="button" class="button"></button>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const estoques = @json($estoques);

        const tamanhoSelect = document.querySelector('[name="tamanho_produto_id"]');
        const corSelect = document.querySelector('[name="cor_produto_id"]');
        const unidadesSelect = document.getElementById('unidades-select');
        const comprarButton = document.getElementById('comprar-button');
        const entregaLabel = document.getElementById('entrega-label');

        function update() {
            const tamanho = parseInt(tamanhoSelect.value);
            const cor = parseInt(corSelect.value);

            const match = estoques.find(e => e.tamanho_id === tamanho && e.cor_id === cor);
            const unidades = match ? match.unidades : 0;
            const prontaEntrega = match ? match.prontaEntrega : 'Não';

            unidadesSelect.innerHTML = '';
            if (unidades > 0) {
                for (let i = 1; i <= unidades; i++) {
                    const opt = document.createElement('option');
                    opt.value = i;
                    opt.textContent = `Quantidade: ${i}`;
                    unidadesSelect.appendChild(opt);
                }
                comprarButton.textContent = 'Adicionar ao carrinho';
                comprarButton.onclick = () => {
                    // Implementar
                };
            } else {
                const opt = document.createElement('option');
                opt.value = 0;
                opt.textContent = 'Indisponível';
                unidadesSelect.appendChild(opt);
                comprarButton.textContent = 'Me avise quando estiver disponível';
                comprarButton.onclick = () => {
                    // Implementar
                };
            }

            if (prontaEntrega) {
                entregaLabel.textContent = 'Sim';
            } else {
                entregaLabel.textContent = 'Não';
            }
        }

        tamanhoSelect.addEventListener('change', update);
        corSelect.addEventListener('change', update);

        update();
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
    .container{
        display: flex; 
        flex-direction: column;
        border: solid 1px #dee2e6;
        border-radius: 0.375rem;
        background-color: white;
        margin-bottom: 2rem;
        padding: 1rem;
        width: fit-content;
    }
    .link-container{
        display: flex; 
        flex-direction: row;
    }
    .link{
        color: #292929; 
        text-decoration:none;
    }
    .product-container{
        display: grid;
        grid-template-columns: 0.5fr 1fr;
        gap: 2rem;
        padding: 1rem;
        width: fit-content;
    }
    @media only screen and (max-width: 80rem){
        .product-container {
            grid-template-columns: 1fr;
            justify-items: center; 
        }
    }
    .icon-container {
        display: inline-block;
        line-height: 0;
        margin: 1rem;
        width: 1.5rem;
    }
    .back-icon {
        width: 1.5rem;
        height: auto;
        cursor: pointer;
        display: block;
    }
    .img{
        max-width: 23rem;
        height: auto;
        border-radius: 8px;
        object-fit: contain;
        border: solid 1px #dee2e6;
    }
    .product-info{
        display: flex;
        flex-direction: column;
        justify-content: flex-start;
        align-items: flex-start;
        width: fit-content;
    }
    .product-name{
        font-size: 2rem;
        font-weight: bold;
    }
    .product-value {
        font-size: 1.5rem;
    }
    .select{
        width: 30rem;
        margin-bottom: 1rem;
    }
    .button{
        font-family: "Cal Sans", sans-serif;
        border: none;
        padding: 10px;
        background-color: #2e96d5;
        border-radius: 500px;
        width: 30rem;
        color: #ffffff;
    }
</style>
@endpush