<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/painel/lib/includes.php");

    // for($i=0;$i<10;$i++){
        $query = "select a.*,
                         c.name as training_name,
                         c.training_description as training_description,
                         b.name as company_name,
                         b.logo,
                         (select id from treinee_admission where trainee = '{$_SESSION['AppUsuario']}' and training = a.training and treining_period = a.id and del != '1') as sign_up,
                         (select status from treinee_admission where trainee = '{$_SESSION['AppUsuario']}' and training = a.training and treining_period = a.id and del != '1') as status
                from treining_period a
                left join company b on a.company = b.id
                left join company_training c on a.training = c.id
                where a.id = '{$_POST['id']}'";
        $result = mysqli_query($con, $query);
        $i=0;
        $d = mysqli_fetch_object($result);
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


        if($_POST['action'] == 'sign_up'){
            $q = "insert into treinee_admission set
                                                company = '{$d->company}',
                                                training = '{$d->training}',
                                                trainee = '{$_SESSION['AppUsuario']}',
                                                treining_period = '{$d->id}',
                                                initial_date = '{$d->initial_date}',
                                                final_date = '{$d->final_date}',
                                                cost = '{$d->cost}'
                ";
            mysqli_query($con, $q);
            exit();
        }

?>
<style>
    .Titulo<?=$md5?>{
        margin-<?=(($_SESSION['lng'] == 'ar')?'right':'left')?>:60px;
    }

    .card-body {
        padding:1px;
        margin:0;
        font-size:11px;
    }

</style>
<div style="position:fixed; z-index:10; left:0; top:0; height:60px; background:#d8f2fe; width:100%; padding:10px; padding-top:15px;">
    <h4 class="Titulo<?=$md5?>"><?=$Dic['Training details']?></h4>
</div>
<div class="card m-2" <?=(($color_status)?"style=\"border:solid 2px {$color_status};\"":false)?>>
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
                }else{
                ?>
                <span class="text-bg-primary rounded p-1 sign_up" style="margin-<?=(($_SESSION['lng'] == 'ar')?'right':'left')?>:5px;">
                    <i class="fa-solid fa-user-plus"></i> <?=$Dic['sign up']?>
                </span>
                <?php
                }
                if($d->status == 'registered'){
                ?>
                <span class="text-bg-danger rounded p-1" style="margin-<?=(($_SESSION['lng'] == 'ar')?'right':'left')?>:5px;">
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
        <!--
            <?php
                if($d->sign_up){
                ?>
                <button class="btn btn-success d-flex justify-content-between w-100" style="font-size:12px;">
                    <i class="fa-solid fa-sack-dollar"></i>
                    <span><?=$Dic['LE']?> <?=number_format($d->cost,2,'.',false)?> <?=$Dic['Cost']?></span>
                    <span><i class="fa-regular fa-thumbs-up"></i></span>
                </button>
                <?php
                }else{
                ?>
                <button class="btn btn-primary d-flex justify-content-between w-100 sign_up" style="font-size:12px;">
                    <i class="fa-solid fa-sack-dollar"></i>
                    <span><?=$Dic['LE']?> <?=number_format($d->cost,2,'.',false)?> <?=$Dic['Cost']?></span>
                    <span><i class="fa-solid fa-right-to-bracket"></i></span>
                </button>
                <?php
                }
                ?>
        </p> -->
    </div>
</div>

<script>
    $(function(){
        $(".sign_up").off('click').on('click', function(){
            AppUsusario = window.localStorage.getItem('AppUsusario');
            if(AppUsuario == 'undefined' || AppUsuario == null) AppUsuario = '';

            if(!AppUsuario){
                $.ajax({
                    url:`components/ms_popup.php`,
                    type:"POST",
                    data:{
                        local:'src/home/login.php',
                    },
                    success:function(dados){
                        $(".ms_corpo").append(dados);
                    }
                });
                return;
            }else{

                $.confirm({
                    content:'<?=$Dic['Confirm your subscription?']?>',
                    title:false,
                    buttons:{
                        '<?=$Dic['Yes']?>':function(){

                            Carregando();
                            $.ajax({
                                url:`src/company/training.php`,
                                type:"POST",
                                data:{
                                    action:'sign_up',
                                    id:'<?=$d->id?>'
                                },
                                success:function(dados){
                                    $.ajax({
                                        url:`components/ms_popup_100.php`,
                                        type:"POST",
                                        data:{
                                            local:`src/company/training.php`,
                                            id:'<?=$d->id?>'
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

                                }
                            });

                        },
                        '<?=$Dic['No']?>':function(){

                        }
                    }
                });



            }

        })
    })
</script>