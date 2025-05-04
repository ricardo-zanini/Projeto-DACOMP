@extends('templates.base')
@section('title', 'DACOMP')

@section('content')
    <div class="containerTitulo">
        <img class="patternTitulo" src="../images/curvePattern.svg" alt="Pattern" />
        <img class="patternTitulo" src="../images/curvePattern.svg" alt="Pattern" />
        <div><h1>DA<span>COMP</span></h1></div>
        <h3>Personalizados</h3>
    </div>
    <div class="containerProdutos">
        <div class="containerProdutosTitulo">
            <img class="titleIcon" src="../images/shoppingCart.svg" alt="Shopping cart icon" />
            <h4>Nossos Produtos</h4>
        </div>
        <div class="containerTextoProdutos">
            <div class="sobreProdutos1">
                <p>
                O DACOMP da UFRGS realiza a venda de produtos personalizados do curso de Ciência e Engenharia de Computação, fortalecendo a identidade estudantil. Entre os itens disponíveis estão camisetas, moletons, canecas e adesivos, todos com design voltado à comunidade acadêmica. A renda obtida auxilia em eventos, melhorias no espaço do diretório e apoio a iniciativas estudantis. As vendas são feitas em feiras, bancas e por encomenda online, promovendo integração entre os alunos e incentivando o orgulho de fazer parte do curso.
                </p>
            </div>
            <div class="sobreProdutos2">
                <p>
                Além de apoiar financeiramente o diretório, adquirir os produtos é uma forma de demonstrar pertencimento e fortalecer o vínculo com o curso. Clique aqui para conhecer a loja virtual do DACOMP, e contribua para o desenvolvimento da nossa comunidade estudantil!
                </p>
                <button type="button" class="button">Conheça nossos produtos</button>
            </div>
        </div>
    </div>
    <div class="containerSobreNos">
        <div class="containerSobreNosTitulo">
            <img class="titleIcon" src="../images/book.svg" alt="Book icon" />
            <h4>Sobre Nós</h4>
        </div>
        <div class="containerSobreNosTexto">
            <p>
            O DACOMP (Diretório Acadêmico de Computação) é a entidade representativa dos estudantes de cursos ligados à computação no Instituto de Informática (INF) da UFRGS, como Ciência da Computação e Engenharia de Computação. Ele atua como ponte entre o corpo discente e a universidade, defendendo os interesses dos alunos em questões acadêmicas, administrativas e políticas, além de ser um espaço de apoio, acolhimento e integração da comunidade estudantil.
            </p><p>
            Além da representação política, o DACOMP organiza atividades culturais, técnicas e sociais que promovem o engajamento entre os alunos. Isso inclui recepções aos calouros, palestras, minicursos, eventos esportivos, hackathons e semanas acadêmicas. Essas ações contribuem para um ambiente mais dinâmico, onde os estudantes têm oportunidade de crescer pessoal e profissionalmente, além de fortalecerem os laços com colegas e professores.
            </p><p>
            O diretório também realiza ações práticas no dia a dia estudantil, como a venda de produtos personalizados (camisetas, canecas, etc.), manutenção de espaços físicos compartilhados e apoio a grupos de estudo e projetos. A participação ativa dos estudantes é incentivada, tornando o DACOMP uma organização viva, construída por e para os alunos, refletindo os valores e as necessidades de quem faz parte do INF da UFRGS.
            </p>
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
        min-width: 100vw;
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
        width:100vw;
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
    }
    .sobreProdutos2{
        display:flex;
        flex-direction:column;
        justify-content:space-between;
    }
    .button{
        font-family: "Cal Sans", sans-serif;
        border:none;
        padding:10px;
        margin-top:20px;
        background-color: #f0f0f0;
        border-radius:500px;
        width:100%;
    }

    .containerSobreNos{
        width:100vw;
        display:flex;
        flex-direction:column;
        align-items:center;
        background-color:#f0f0f0;
        margin-bottom:20px;
    }
    .containerSobreNosTitulo{
        width: 100%;
        max-width: 1200px;
        padding: 30px 20px 10px 20px;
        display:flex;
        align-items:center;
    }
    .containerSobreNosTitulo > h4{
        font-family: "Cal Sans", sans-serif;
        margin:0;
    }
    .containerSobreNosTexto{
        display:flex;
        justify-content:center;
        margin-bottom:50px;
        max-width:1200px;
        padding: 0px 20px;
        gap:20px;
    }
    .containerSobreNosTexto > p{
        text-align:justify;
        font-family: "Tinos", serif;
        font-style: normal;
        font-weight: 400;
        margin-bottom:0;
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

    @media (max-width: 1000px) {
        .containerSobreNosTexto {
            flex-direction:column;
        }

    }
</style>
@endpush