@extends('templates.base')
@section('title', 'Interesses')

@section('content')
    <h1>SOBRE NÓS</h1>
    <div class="containerSobreNos">
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
    h1{
        font-family: "Cal Sans", sans-serif;
        text-align:center;
        padding: 50px 0px;
    }
    .containerSobreNos{
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
        line-height:2rem;
    }
    @media (max-width: 1000px) {
        .containerSobreNosTexto {
            flex-direction:column;
        }
    }
</style>
@endpush