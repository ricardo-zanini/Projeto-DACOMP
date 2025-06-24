@extends('templates.base')
@section('title', 'DACOMP')

@section('content')
    <div class="containerTitulo">
        <img class="patternTitulo" src="../icons/curvePattern.svg" alt="Pattern" />
        <img class="patternTitulo" src="../icons/curvePattern.svg" alt="Pattern" />
        <div><h1>DA<span>COMP</span></h1></div>
        <h3>Personalizados</h3>
        <button onclick="window.location='{{ route('produtos.list') }}'" type="button" class="button">Conheça nossos produtos</button>
    </div>
    <div class="containerProdutos">
        <div class="containerProdutosTitulo">
            <img class="titleIcon" src="../icons/shoppingCart.svg" alt="Shopping cart icon" />
            <h4>Nossos Produtos</h4>
        </div>
        <div class="containerTextoProdutos">
            <div class="sobreProdutos1">
                <p>
                O DACOMP da UFRGS realiza a venda de produtos personalizados do curso de Ciência e Engenharia de Computação, fortalecendo a identidade estudantil. Entre os itens disponíveis estão camisetas, moletons, canecas e adesivos, todos com design voltado à comunidade acadêmica. A renda obtida auxilia em eventos, melhorias no espaço do diretório e apoio a iniciativas estudantis.
                </p>
            </div>
            <div class="sobreProdutos2">
                <p>
                As vendas são feitas em feiras, bancas e por encomenda online, promovendo integração entre os alunos e incentivando o orgulho de fazer parte do curso. Além de apoiar financeiramente o diretório, adquirir os produtos é uma forma de demonstrar pertencimento e fortalecer o vínculo com o curso. Clique aqui para conhecer a loja virtual do DACOMP, e contribua para o desenvolvimento da nossa comunidade estudantil!
                </p>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
    .containerTitulo{
        display:flex;
        flex-direction:column;
        background-color:#f0f0f0;
        margin-top:60px;
        height:400px;
        align-items:center;
        justify-content:center;
        overflow: hidden;
        position: relative;
    }
    .containerTitulo > div{
        position:relative;
        width:340px;
    }
    .containerTitulo > div > h1{
        font-family: "Cal Sans", sans-serif;
        font-size: 5rem;
    }
    .containerTitulo > div > h1 > span{
        font-family: "Cal Sans", sans-serif;
        position:absolute;
        bottom: -5px;
        left: 110px;
    }
    .containerTitulo > h3{
        font-family: "Playwrite RO", cursive;
    }
    .patternTitulo{
        position:absolute;
        max-width: 350px;
    }
    .patternTitulo:nth-of-type(1){
        top:-50px;
        left:-50px;
    }
    .patternTitulo:nth-of-type(2){
        bottom:-50px;
        right:-50px;
        transform: rotate(180deg)
    }

    .containerProdutos{
        display:flex;
        flex-direction:column;
        align-items:center;
    }
    .containerProdutosTitulo{
        width: 100%;
        max-width: 1200px;
        padding: 30px 20px 10px 20px;
        display:flex;
        align-items:center;
    }
    .containerProdutosTitulo > h4{
        font-family: "Cal Sans", sans-serif;
        margin:0;
    }
    .titleIcon{
        width:1.3rem;
        margin-right:10px;

    }
    .containerTextoProdutos{
        display:flex;
        justify-content:center;
        margin-bottom:50px;
        max-width:1200px;
        padding: 0px 20px;
        gap:20px;
    }
    .containerTextoProdutos > div{
        width:50%;
    }
    .containerTextoProdutos > div > p{
        font-family: "Tinos", serif;
        text-align: justify;
        font-style: normal;
        font-weight: 400;
        margin-bottom:0;
        line-height:2rem;
    }
    .sobreProdutos2{
        display:flex;
        flex-direction:column;
    }
    .button{
        font-family: "Cal Sans", sans-serif;
        border:none;
        padding:10px;
        margin-top:2rem;
        background-color: #2e96d5;
        border-radius:500px;
        width:20rem;
        color: white;
    }

    @media (max-width: 600px) {
        .containerTextoProdutos {
            flex-direction:column;
        }
        .containerTextoProdutos > div{
            width:100%;
        }
        .patternTitulo{
            opacity:0.3;
        }
    }
</style>
@endpush