<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Fonte cursiva -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playwrite+RO:wght@100..400&display=swap" rel="stylesheet">
    <!-- Fonte forma -->
    <link href="https://fonts.googleapis.com/css2?family=Cal+Sans&display=swap" rel="stylesheet">
    <!-- Fonte Leitura -->
    <link href="https://fonts.googleapis.com/css2?family=Tinos:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">

    <title>@yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <style>
      *{
        color:#292929;
      }
      .footer{
        background-color: #292929;
        display:flex;
        flex-direction:column;
        min-width: 100vw;
        height:200px;
        align-items:center;
        justify-content:space-between;
        position:relative;
        overflow: hidden;
      }
      .patternFooter{
        position:absolute;
        max-width: 350px;
        bottom:-50px;
        right:-50px;
        transform: rotate(180deg)
      }
      .containerConteudoFooter{
        width: 100%;
        max-width: 1200px;
        padding: 30px 20px 10px 20px;
        display: flex;
        gap: 30px;
      }
      .footerLogoDacomp{
        width:150px;
      }
      .footerRedesSociais{
        display:flex;
        justify-content:space-between;
        flex-direction: column;
      }
      .footerRedesSociaisIcon{
        width:40px;
      }
      .footerRedesSociaisText{
        font-family: "Cal Sans", sans-serif;
        color:#f0f0f0;
        display:flex;
        align-items:center;
        justify-content:center;
      }
      .footerRedesSociaisContainerIcons{
        display:flex;
        align-items:center;
        gap:10px;
      }
      .footerRights{
        width: 100%;
        max-width: 1200px;
        padding: 10px 20px;
        color:#545454;
        font-family: "Cal Sans", sans-serif;
        font-size:0.8rem;
        
      }


      .navbar{
        height:60px;
        width:100%;
        z-index:100;
        top:0;
        background-color: #e0e0e0;
        position:fixed;
      }

      @media (max-width: 800px) {
        .patternFooter{
          display:none;
        }
        .navbar{
          position:absolute;
        }
      }


    </style>
    @stack('styles')
</head>
  <body>
    <div class="navbar">
         
    </div>  

    <div class="conteudo">
          @yield('content')
    </div>

    <div class="footer">
      <div class="containerConteudoFooter">
        <img class="footerLogoDacomp" src="../images/DACOMP-logo.svg" alt="Pattern" />
        <div class="footerRedesSociais">
          <div class="footerRedesSociaisText">Nos siga nas redes</div>
          <div class="footerRedesSociaisContainerIcons">
            <a target="blank" href="https://www.facebook.com/p/DACOMP-UFRGS-100063671467028/"><img class="footerRedesSociaisIcon" src="../images/facebook.svg" alt="facebook"/></a>
            <a target="blank" href="https://www.instagram.com/dacomp.ufrgs/"><img class="footerRedesSociaisIcon" src="../images/instagram.svg" alt="Instagram"/></a>
            <a target="blank" href="https://x.com/ufrgsdacomp"><img class="footerRedesSociaisIcon" src="../images/X.svg" alt="X"/></a>
          </div>
        </div>
      </div>
      <div class="footerRights">DACOMP - Diretório Acadêmico de Computação da UFRGS. Todos os direitos reservados.</div>
      <img class="patternFooter" src="../images/curvePattern2.svg" alt="Pattern" />
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
    @stack('scripts')
  </body>
</html>