<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/painel/lib/includes.php");


    if($_POST['action'] == 'delete'){
        $query = "update treinee_admission set del = '1', justify_del = '{$_POST['justify']}' where id = '{$_POST['id']}'";
        mysqli_query($con, $query);
        // exit();
    }

?>

<style>
    .Titulo<?=$md5?>{
        margin-<?=(($_SESSION['lng'] == 'ar')?'right':'left')?>:60px;
    }
</style>

<div style="position:fixed; z-index:10; left:0; top:0; height:60px; background:#d8f2fe; width:100%; padding:10px; padding-top:15px;">
    <h4 class="Titulo<?=$md5?>"><?=$Dic['My trainings']?></h4>
</div>


<?php
    $query = "select
                        a.*,
                        c.name as training_name,
                        c.training_description as training_description,
                        b.name as company_name,
                        b.logo
                        from treinee_admission a
                        left join company b on a.company = b.id
                        left join company_training c on a.training = c.id
            where a.trainee = '{$_SESSION['AppUsuario']}' and del != '1'";
    $result = mysqli_query($con, $query);
    $i=0;
    while($d = mysqli_fetch_object($result)){
        $i++;
        switch($d->status){
            case 'registered':{
                $color_status = '#054f8b';
                break;
            }
            case 'approved':{
                $color_status = '#85b344';
                break;
            }
            case 'denied':{
                $color_status = '#ee1d23';
                break;
            }
            default:{
                $color_status = false;
                break;
            }
        }
?>
<style>
    .card-body {
        padding:1px;
        margin:0;
        font-size:11px;
    }
</style>
<div class="card m-2" <?=(($color_status)?"style=\"border:solid 2px {$color_status};\"":false)?>>
    <div class="row g-0">
        <div class="col">
            <div class="card-body">
                <h6 class="card-title" style="color:#054f8c; padding:2px; margin:0;">
                    <?=$d->training_name?>
                </h6>
            </div>
        </div>
    </div>
    <div class="row g-0">
        <div class="col-2 text-center">
        <?php
        if(is_file("../../painel/src/volume/{$d->id}/{$d->logo}")){
        ?>
        <img src="<?=$localPainel?>src/volume/<?=$d->id?>/<?=$d->logo?>" class="img-fluid rounded-start w-100" />
        <?php
        }else{
        ?>
        <i class="fa-regular fa-image" style="font-size:50px; color:#eee;"></i>
        <?php
        }
        ?>
        </div>
        <div class="col-10">
        <div class="card-body">
            <b><?=$d->company_name?></b>
            <div class="d-flex justify-content-between card-text p-2" style="color:#054f8c; font-size:12px;">
                <small class="w-100">
                    <div class="w-100">
                        <i class="fa fa-calendar"></i> <?=$Dic['Date']?>: <?=dataBr($d->initial_date)?> - <?=dataBr($d->final_date)?><br>
                        <i class="fa fa-users"></i> <?=$d->trainings?> <?=$Dic['Trained Opportunity']?>
                    </div>
                </small>
            </div>
        </div>
        </div>
    </div>

    <div class="card-body">
    <div class="row g-0">
            <div class="col">
            <div class="w-100 p-2" style="color:#054f8c; font-size:12px; text-align:<?=(($_SESSION['lng'] == 'ar')?'left':'right')?>;">
                <span class="bg-success p-1 text-dark bg-opacity-25 rounded" style="margin-<?=(($_SESSION['lng'] == 'ar')?'right':'left')?>:5px;">
                    <i class="fa-solid fa-sack-dollar"></i> <?=$Dic['LE']?> <?=number_format($d->cost,2,'.',false)?> <?=$Dic['Cost']?>
                </span>
                <?php
                if($d->status){
                ?>
                <span class="rounded p-1" style="margin-<?=(($_SESSION['lng'] == 'ar')?'right':'left')?>:5px; background-color:<?=$color_status?>; color:#fff;">
                    <i class="fa-solid fa-face-flushed"></i>
                    <?=$Dic[$d->status]?>
                </span>
                <?php
                }
                if($d->status == 'registered'){
                ?>
                <span class="text-bg-danger rounded p-1 del" codId="<?=$d->id?>" style="margin-<?=(($_SESSION['lng'] == 'ar')?'right':'left')?>:5px;">
                    <i class="fa-solid fa-trash"></i>
                    <?=$Dic['Cancel']?>
                </span>
                <?php
                }
                ?>
            </div>
            </div>
        </div>
        <p class="card-text p-2" style="text-align:justify"><?=$d->training_description?></p>
    </div>
</div>

<?php
    }
?>

<script>
    $(function(){

        $("span.del").off('click').on('click',function(){
            id = $(this).attr('codId');

            $.confirm({
                title:false,
                content:'<?=$Dic['']?>'
            });
            return;
            $.ajax({
                url:`components/ms_popup_100.php`,
                type:"POST",
                data:{
                    local:`src/trainee/my_training.php`,
                    id,
                    action:'delete'
                },
                success:function(dados){
                    PageClose();
                    $(".ms_corpo").append(dados);
                    Carregando('none');
                    $.alert({
                        content:'<?=$Dic['Confirmed enrollment!']?>',
                        title:false,
                        buttons:{
                            '<?=$Dic['ok']?>':function(){

                            }
                        }
                    });
                }
            });


        })
    })
</script>