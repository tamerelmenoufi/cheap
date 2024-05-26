<?php
    $app = true;
    include("{$_SERVER['DOCUMENT_ROOT']}/painel/lib/includes.php");
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
    .banner{
        margin:0;
        padding:0;
        width:100%;
    }
</style>
<div class="barra_topo"></div>
<div class="home_corpo">
    

<?php
    $query = "select * from products ";
    $result = mysqli_query($con, $query);
    while($d = mysqli_fetch_object($result)){
?>
    <div class="card m-3 nb-0">
    <div class="card-body">
        <h5 class="card-title"><?=$d->name?></h5>
    </div>

    <div class="row mb-3">
        <?php
            $path = "{$_SERVER['DOCUMENT_ROOT']}/painel/src/volume/products/{$d->id}/";
            if(is_dir($path)){
            $diretorio = dir($path);
            while($arquivo = $diretorio -> read()){
                if(is_file($path.$arquivo)){
        ?>
            <div class="col-4">
                <img src="src/volume/products/<?="{$_POST['id']}/{$arquivo}"?>" class="img-fluid m-3">
            </div>
        <?php
                }
            }
            $diretorio -> close();
            }
        ?>
    </div>

    <!-- <img src="http://cheappanel.mohatron.com/src/volume/products/1/a55f6be79878b5e34ef5aaf3a9b80fa4.png" class="card-img-bottom" alt="..."> -->
    <div class="card-body">
        <p class="card-text"><?=$d->description?></p>
        <p class="card-text"><small class="text-body-secondary"><?=dataBr($d->end_date)?></small></p>
    </div>
    </div>    
<?php
    }
?>

</div>
<div class="home_rodape"></div>

<script>

$(function(){


    idUnico = localStorage.getItem("idUnico");
    codUsr = localStorage.getItem("codUsr");

    
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
            codUsr
        },  
        success:function(dados){
            $(".barra_topo").append(dados);
        }
    });

    // $.ajax({
    //     url:"home/banner.php",
    //     success:function(dados){
    //         $(".banner").html(dados);
    //     }
    // });


})

	

</script>