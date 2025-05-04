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
    .barraBusca{
        position:absolute;
        justify-content: flex-end;
        align-items: center;
        flex-direction: column;
        width:100%;
        top:120px;
        height:45px;
        padding-left:10px;
        padding-right:10px;
    }
    .home_corpo{
        position: absolute;
        top:170px;
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
    .banner{
        margin:0;
        padding:0;
        width:100%;
    }
    .foto{
        cursor:pointer;
        border:solid 1px #eee;
        border-radius:7px;
        height:100%;
        width:100%;
    }
    .foto:hover{
        border:solid 1px #ccc;
    }
    .acao{
        cursor:pointer;
        font-size:14px;
    }
    i[favorito]:hover{
        font-size:16px;
    }

</style>
<div class="barra_topo">
    <h2>Promoções</h2>
</div>

<div class="barraBusca">
    <div class="input-group mb-3">
        <input type="text" class="form-control" placeholder="Recipient's username" aria-label="Recipient's username" aria-describedby="button-addon2">
        <button class="btn btn-outline-secondary" type="button" id="button-addon2"><i class="fa-solid fa-magnifying-glass"></i></button>
    </div>
</div>

<div class="home_corpo"></div>
<div class="home_rodape"></div>

<script>

$(function(){

    $.ajax({
        url:"home/lista.php",
        success:function(dados){
            $(".home_corpo").html(dados);
        }
    });


})

	

</script>