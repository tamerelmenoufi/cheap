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
        min-height:80px;
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
    <div class="card m-3 mb-0">
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
                <div class="m-3 foto"  style="height:100%;">
                    <div 
                        class="d-flex justify-content-center align-items-center" 
                        style="height:100%; border-radius:5px; background-color:#eee"
                        registro=""
                        imagem=""
                    >
                        <h1>+ <?=($n - 5)?></h1>
                    </div>
                </div>
            </div>
        <?php
                    }else{
        ?>
            <div class="col-<?=$c?>">
                <div class="m-3">
                    <img 
                        src="<?=$localPainel?>src/volume/products/<?="{$d->id}/{$arquivo}"?>" 
                        class="img-fluid foto" 
                        registro="<?=$d->id?>" 
                        imagem="ancora-<?=md5($arquivo)?>"
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
    <div class="card-body mt-0">
        <p class="card-text"><?=$d->description?></p>
        <div class="alert alert-secondary p-2" role="alert">
            <div class="d-flex justify-content-between align-items-center">
                <small class="text-body-secondary" style="font-size:12px; color:#a1a1a1;"><?=dataBr($d->end_date)?></small>
                <i class="fa-regular fa-heart"></i>
                <i class="fa-solid fa-arrow-up-right-from-square"></i>
            </div>
        </div>
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

    // $.ajax({
    //     url:"home/banner.php",
    //     success:function(dados){
    //         $(".banner").html(dados);
    //     }
    // });

    $(".foto").click(function(){

        registro = $(this).attr("registro");
        imagem = $(this).attr("imagem");
        Carregando();
        $.ajax({
            url:`home/detalhes.php#${imagem}`,
            type:"POST",
            data:{
                registro,
                // imagem
            },
            success:function(dados){
                $(".popupPalco").html(dados);
                $(".popupArea").css("display","flex");
            }
        });
    })


})

	

</script>