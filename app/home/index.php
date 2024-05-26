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
    .foto{
        cursor:pointer;
        border:solid 1px #eee;
        border-radius:7px;
        min-height:120px;
    }
    .foto:hover{
        border:solid 1px #ccc;
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
            
            // Lista todos os arquivos e diretórios
            $n = scandir($path);
            // Filtra a lista para remover os diretórios '.' e '..'
            $n = array_diff($n, array('.', '..'));
            // Retorna a quantidade de arquivos
            $n = count($n);


            $p=0;
            while($arquivo = $diretorio -> read()){
                if(is_file($path.$arquivo) and $p < 6){

                    if($n == 1){
                        $c = 12;
                    }elseif($n == 2){
                        $c = 6;
                    }else{
                        $c = 4;
                    }

                    if($p == 5){
        ?>
            <div class="col-<?=$c?>">
                <h1>+ <?=($n - 5)?></h1>
            </div>
        <?php
                    }else{
        ?>
            <div class="col-<?=$c?>">
                <div class="m-3">
                    <img 
                        src="<?=$localPainel?>src/volume/products/<?="{$d->id}/{$arquivo}"?>" 
                        class="img-fluid foto" 
                        registo="<?=$d->id?>" 
                        imagem="<?=$arquivo?>"
                    >
                </div>
            </div>
        <?php
                    }
                $p++;
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