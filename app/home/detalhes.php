<?php
    $app = true;
    include("{$_SERVER['DOCUMENT_ROOT']}/painel/lib/includes.php");
?>
<style>



</style>

    
<?php
    $query = "select a.*, (select id from favorite where product = a.id and customer = '{$_SESSION['idUnico']}') as `like` from products a where a.id = '{$_POST['registro']}'";
    $query = "select a.*, (select id from favorite where product = a.id and customer = (select id from customers where device = '{$_SESSION['idUnico']}')) as opclike from products a";
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
                    <i 
                        opc<?=$d->id?> 
                        codigo="<?=$d->id?>" 
                        favorito="<?=(($d->opclike)?:$d->id)?>" 
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



<script>

$(function(){
    Carregando('none');


})

	

</script>