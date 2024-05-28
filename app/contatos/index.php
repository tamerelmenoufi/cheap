<?php
    $app = true;
    include("{$_SERVER['DOCUMENT_ROOT']}/painel/lib/includes.php");

    if($_POST['idUnico']){
        $_SESSION['idUnico'] = $_POST['idUnico'];
    }


?>
<style>
    .barra_topo{
        position:absolute;
        display: flex;
        justify-content: flex-end;
        align-items: center;
        flex-direction: column;
        top:0;
        width:100%;
        height:100px;
        background-color:#ffc63a;
        color:#670600;
        border-bottom-right-radius:40px;
        border-bottom-left-radius:40px;
        font-family:FlameBold;
    }


    .home_corpo{
        position: absolute;
        top:100px;
        bottom:80px;
        overflow:auto;
        background-color:#fff;
        width:100%;
    }

    .home_rodape{
        position: absolute;
        background-color:#fff;
        width:100%;
        bottom:0;
        height:80px;
    }


</style>

<div class="barra_topo">
    <h2>Contatos</h2>
</div>


<div class="home_corpo p-2">
    <div class="container">
        <div class="row mb-3">
            <div class="col">
                Para dúvidas, sugestões ou reclamações, entre em contato conosco utilizando um dos contatos a seguinte.
            </div>
        </div>
        <div class="row mb-1">
            <div class="col">
                <i class="fa-brands fa-whatsapp"></i> <a href="https://api.whatsapp.com/send?phone=5592986123301" target="_blank">+55 92 986123301</a>
            </div>
        </div>
        <div class="row mb-1">
            <div class="col">
                <i class="fa-solid fa-at"></i> <a href="mailto:atendimento@bkmanaus.com.br" target="_blank">atendimento@bkmanaus.com.br</a>
            </div>
        </div>
        <div class="row mb-1">
            <div class="col">
                <i class="fa-solid fa-house"></i> <a href="https://bkmanaus.com.br" target="_blank">https://bkmanaus.com.br</a>
            </div>
        </div>
        <div class="row mb-1">
            <div class="col">
                <span style="color:#a1a1a1">Aplicativo atende pedidos todos os dias das 11h às 23h.</span>
            </div>
        </div>
    </div>
</div>   
<div class="home_rodape"></div>

<script>

$(function(){

    idUnico = localStorage.getItem("idUnico");

    $.ajax({
        url:"rodape/rodape.php",
        success:function(dados){
            $(".home_rodape").html(dados);
        }
    });

    $.ajax({
        url:"topo/topo.php",
        type:"POST",
        data:{
            idUnico,
        },  
        success:function(dados){
            $(".barra_topo").append(dados);
        }
    });

})

</script>