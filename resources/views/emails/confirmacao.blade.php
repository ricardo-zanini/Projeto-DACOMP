<h1 style="color:black;">Obrigado pela sua compra {{$dados['nome']}}!</h1>
<p style="color:black;"> Apresente cada código para retirada de cada um de seus produtos quando estiverem prontos para retirada</p>
<div style="color:black;border:solid 1px #ccc;margin-bottom:20px;padding:10px;border-radius:8px;width:fit-content;">
    <div style="display:flex;flex-direction:row;border:solid 1px #ccc;border-radius:8px;padding:10px;padding-right:0px;width:fit-content;gap:10px;">
        @foreach (str_split($dados['item']->codigo_compra) as $caracter)
            <div style="
                margin-right:10px;
                color:black;
                display:flex;
                align-items:center;
                justify-content:center;
                width:20px;font-size:20px;
                border:solid 1px #ccc;
                border-radius:8px;
                padding:10px;
            "><b style="margin:auto;color:#2e96d5">{{ $caracter }}</b></div>
        @endforeach
    </div>
</div>
