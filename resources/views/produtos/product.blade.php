@extends('templates.base')
@section('title', 'Produto')

@section('content')
    <h1>COMPRAR</h1>
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    <div class="container">
        <div class="product-container">
            <img class="img" src="@if ($produto->imagem == null) {{asset('icons/no_image.svg')}} @else {{asset('images/' . $produto->imagem)}} @endif" alt="{{ $produto->produto_id }}" />
            <div class="product-info">
                <div class="link-container">
                    <a href="{{ route('produtos.list') }}" class="link">Produtos</a>
                    <p>&nbsp;&gt;&nbsp;{{ $tipo_produto->tipo }}</p>
                </div>
                <p class="product-name">{{ $produto->nome }}</p>
                <p id="product-value" class="product-value" data-valor="{{ $produto->valor_unidade }}">R$ {{ number_format($produto->valor_unidade, 2, ',', '.') }}</p>
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

                <form id="produto-form" method="POST" style="display:none;">
                    @csrf
                    <input type="hidden" name="produto_estoque_id" id="form-produto_estoque_id">
                    <input type="hidden" name="quantidade" id="form-quantidade">
                    <input type="hidden" name="valor_unidade" id="form-valor_unidade">
                </form>

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
        const valorUnidade = parseFloat(document.getElementById('product-value').dataset.valor);

        const form = document.getElementById('produto-form');
        const formProdutoEstoqueId = document.getElementById('form-produto_estoque_id');
        const formQuantidade = document.getElementById('form-quantidade');
        const formValor = document.getElementById('form-valor_unidade');

        function update() {
            const tamanho = parseInt(tamanhoSelect.value);
            const cor = parseInt(corSelect.value);

            const match = estoques.find(e => e.tamanho_id === tamanho && e.cor_id === cor);
            const unidades = match?.unidades ?? 0;
            const prontaEntrega = match?.prontaEntrega ?? 'Não';
            const produto_estoque_id = match?.produto_estoque_id ?? 0;

            entregaLabel.textContent = prontaEntrega ? 'Sim' : 'Não';

            unidadesSelect.innerHTML = '';
            if (unidades > 0) {
                for (let i = 1; i <= unidades; i++) {
                    const opt = new Option(`Quantidade: ${i}`, i);
                    unidadesSelect.appendChild(opt);
                }

                comprarButton.textContent = 'Adicionar ao carrinho';
                comprarButton.onclick = () => {
                    formProdutoEstoqueId.value = produto_estoque_id;
                    formQuantidade.value = unidadesSelect.value;
                    formValor.value = valorUnidade;
                    form.action = '{{ route('compras.gravar') }}';
                    form.submit();
                };
            } else {
                unidadesSelect.innerHTML = '';
                unidadesSelect.appendChild(new Option('Indisponível', 0));

                comprarButton.textContent = 'Me avise quando estiver disponível';
                comprarButton.onclick = () => {
                    // Implementar
                };
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
        color: #2e96d5; 
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
    .alert {
        padding: 1rem;
        border-radius: 5px;
        font-weight: bold;
    }
    .alert-success {
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
        margin: 1rem 1rem 1rem 1rem;
    }
    .alert-danger {
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
        margin: 1rem 1rem 1rem 1rem;
    }
</style>
@endpush