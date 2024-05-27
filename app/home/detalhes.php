<?php
    $app = true;
    include("{$_SERVER['DOCUMENT_ROOT']}/painel/lib/includes.php");
?>
<style>



</style>

    
<?php
    $query = "select * from products where id = '{$_POST['registro']}'";
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
            <div class="col-12" id=ancora-<?=$arquivo?>>
                <div class="m-3">
                    <img 
                        src="<?=$localPainel?>src/volume/products/<?="{$d->id}/{$arquivo}"?>" 
                        class="img-fluid" 
                    >
                </div>
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
        <div class="d-flex flex-content-right flex-item-center">
            <p class="card-text"><?=$d->description?></p>
            <i class="fa fa-users ms-3"></i>
            <i class="fa fa-user ms-3"></i>
        </div>
        
        <p class="card-text"><small class="text-body-secondary"><?=dataBr($d->end_date)?></small></p>
    </div>
    </div>    
<?php
    }
?>



<script>

$(function(){
    Carregando('none');


})

	

</script>