<p style="color:black;">Caro {{$dados['nome']}},</p>
<p style="color:black;">Seu pedido de número {{$dados['compra_id']}} está disponível para retirada no DACOMP</p>
<p style="color:black;">Não esqueça de apresentar seu código na hora da retirada</p>
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
<p style="color:black;">Agradecemos sua compra!</p>
