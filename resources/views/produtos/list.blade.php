<div id="products-list" class="products-container">
    @if ($produtos->isEmpty())
        <p>Nenhum produto encontrado.</p>
    @else
        <div class="grid">
            @foreach ($produtos as $produto)
                <div class="card">
                    @if(Auth::user() && Auth::user()->gestor)
                        <div class="container_actions_card">
                            <a href="{{ route('produtos.edit', $produto->produto_id) }}" class="editar_produto">
                                <img class="editar_icone" src="../icons/edit.svg" alt="Editar" />
                            </a>
                            <a href="{{ route('produtos.edit', $produto->produto_id) }}" class="editar_produto">
                                <img class="remover_icone" src="../icons/close.svg" alt="Remover" />
                            </a>
                        </div>
                    @endif
                    <img class="img" src="@if ($produto->imagem == null) {{asset('images/no_image.svg')}} @else {{asset('images/' . $produto->imagem)}} @endif" alt="Imagem de {{ $produto->nome }}" />
                    <h2>{{ $produto->nome }}</h2>
                    <p>R$ {{ number_format($produto->valor_unidade, 2, ',', '.') }}</p>
                    @if((!Auth::user()) || (!Auth::user()->gestor))
                        <button onclick="window.location='{{ route('produtos.show', ['produto' => $produto->produto_id]) }}'" type="button" class="button botaoTransicao">Comprar</button>
                    @endif
                </div>
            @endforeach
        </div>
    @endif
</div>

@push('styles')
    <style>
        .products-container{
            display: flex; 
            justify-content: center;
        }
        .grid{
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            column-gap: 1.5rem;
            row-gap: 2rem;
            align-self: center;
            justify-content: center;
        }
        @media only screen and (max-width: 71rem){
            .grid{
                grid-template-columns: repeat(3, 1fr) !important;
            }
        }
        @media only screen and (max-width: 55rem){
            .grid{
                grid-template-columns: repeat(2, 1fr) !important;
            }
        }
        @media only screen and (max-width: 40rem){
            .grid{
                grid-template-columns: repeat(1, 1fr) !important;
            }
        }
        .card{
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            border-radius: 8px;
            padding: 16px;
            width: 16rem;
            box-shadow: 2px 2px 4px rgba(0,0,0,0.1);
            background-color: rgba(255, 255, 255,1);
            margin-right: auto;
            margin-left: auto;
        }
        .img{
            max-width: 12rem; 
            height: auto;
            align-self: center;
            margin-top: 1rem;
            margin-bottom: 1rem;
            border-radius: 8px;
            user-select: none;
        }
        .button{
            font-family: "Cal Sans", sans-serif;
            border: none;
            padding: 10px;
            background-color: #292929;
            color: #f0f0f0;
            border-radius: 500px;
            width: 100%;
        }
        .container_actions_card > a > img{
            width: 20px;
            transition:0.3s;
            user-select: none;
        }
        .container_actions_card > a > img:hover{
            scale: 1.1
        }
        .container_actions_card{
            display:flex;
            flex-direction:row;
            justify-content:space-between;
            height:10px;
        }

        .editar_icone{
            position:absolute;
            top:10px;
            left:10px;
        }
        .remover_icone{
            position:absolute;
            top:10px;
            right:10px;
        }
    </style>
@endpush