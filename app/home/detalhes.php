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

        <div class="card-body">
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



<script>

$(function(){
    Carregando('none');


})

	

</script>