<?php
    $app = true;
    include("{$_SERVER['DOCUMENT_ROOT']}/painel/lib/includes.php");


    if($_POST['idUnico']){
        $_SESSION['idUnico'] = $_POST['idUnico'];
    }

    if($_POST['acao'] == 'regular'){
        $query = "insert into favorite set product = '{$_POST['favorite']}', customer = (select id from customers where device = '{$_SESSION['idUnico']}')";
        mysqli_query($con, $query);
        echo 'solid';
        exit();
    }

    if($_POST['acao'] == 'solid'){
        $query = "delete from favorite where product = '{$_POST['favorite']}' and customer = (select id from customers where device = '{$_SESSION['idUnico']}')";
        mysqli_query($con, $query);
        echo 'regular';
        exit();
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
        position:flex;
        justify-content: flex-end;
        align-items: center;
        flex-direction: column;
        width:100%;
        top:120px;
        height:30px;
        border:solid 1px red;
    }
    .home_corpo{
        position: absolute;
        top:135px;
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
<div class="home_corpo">
    

<div class="barraBusca">

</div>


<?php
    $query = "select a.*, (select id from favorite where product = a.id and customer = (select id from customers where device = '{$_SESSION['idUnico']}')) as opclike from products a";
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
                <div 
                    class="foto"
                    registro="<?=$d->id?>"
                    imagem=""                    
                >
                    <div 
                        class="d-flex justify-content-center align-items-center" 
                        style="height:100%; border-radius:5px; background-color:#eee"
                    >
                        <h1>+ <?=($n - 5)?></h1>
                    </div>
                </div>
            </div>
        <?php
                    }else{
        ?>
            <div class="col-<?=$c?>">
                <div class="mb-1">
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
                <i 
                    opc<?=$d->id?> 
                    codigo="<?=$d->id?>" 
                    favorito="<?=$d->id?>" 
                    class="fa-<?=(($d->opclike)?'solid':'regular')?> fa-heart acao text-danger"
                    acao = <?=(($d->opclike)?'solid':'regular')?>
                ></i>
                <i url="<?=$d->url?>" class="fa-solid fa-arrow-up-right-from-square acao"></i>
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

    $(document).off('click').on("click", "i[favorito]", function(){
        favorite = $(this).attr("favorito");
        codigo = $(this).attr("codigo");
        idUnico = localStorage.getItem("idUnico");
        acao = $(this).attr("acao");
        $.ajax({
            url:`home/index.php`,
            type:"POST",
            data:{
                favorite,
                idUnico,
                acao
                // imagem
            },
            success:function(dados){
                $(`i[opc${codigo}]`).removeClass(`fa-${acao}`);
                $(`i[opc${codigo}]`).addClass(`fa-${dados}`);
                $(`i[opc${codigo}]`).attr("acao", dados);
            }
        });        
    })

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