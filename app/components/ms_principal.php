<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/painel/lib/includes.php");
?>
<style>
    .alerta{
        position:fixed;
        width:0;
        height:0;
        left:0;
        top:0;
        z-index:10;
    }

    .topo{
        position:fixed;
        width:120%;
        height:65px;
        background:#2c93c3;
        border-top-left-radius: 0;
        border-top-right-radius: 0;
        border-bottom-right-radius: 100%;
        border-bottom-left-radius: 100%;
        border-bottom:1px solid rgb(79,198,254, 0.3);
        left:-10%;
        top:0;
        z-index:2;
    }

    .rodape{
        position:fixed;
        width:100%;
        height:65px;
        background:rgb(44,147,192, 0.1);
        border-bottom:1px solid rgb(79,198,254, 0.3);
        left:0;
        bottom:0;
    }
    .rodape .row .col{
        color:#075595;
        text-align:center;
        font-size:20px;
        margin-top:10px;
    }
    .rodape .row .col p{
        font-size:10px;
        text-align:center;
        color:#075595;
        padding:0;
        margin:0;
        cursor:pointer;
    }

    .categorias_home{
        position:fixed;
        top:60px;
        padding-top:5px;
        padding-bottom:5px;
        width:100%;
        height:125px;
        background:#7895fd;
    }

    .pagina{
        position:fixed;
        top:0px;
        padding-top:65px;
        bottom:65px;
        width:100%;
        background:#fff;
        z-index:1;
    }

    .paginaCenter{
        position:fixed;
        top:0px;
        top:200px;
        bottom:65px;
        width:100%;
        background:rgb(44,147,192, 0.1);
        z-index:4;
        overflow:auto;
    }
    .pagina div[dados]{
        position:fixed;
        top:195px;
        bottom:65px;
        left:5px;
        right:5px;
        overflow:auto;
        background:#d8e0eb; /*f5ebdc*/
        border-top-left-radius:25px;
        border-top-right-radius:25px;
        padding:10px;
    }

    .categoria_combo{
        position:relative;
        width:100%;
        margin-bottom:15px;

    }

    .ListaLojas{
        position:fixed;
        top:0;
        left:0;
        right:0;
        bottom:0;
        background-color:#fff;
        z-index:999;
        display:none;
    }

    .MensagemAddProduto2 {
        position: fixed;
        left: 50%;
        margin-left:-100px;
        bottom: 80px;
        background-color: rgb(75, 192, 192, 1);
        color: #fff;
        text-align: center;
        font-weight: bold;
        border-color:rgb(75, 192, 192, 1);
        border-radius: 5px;
        padding: 5px;
        width: 200px;
        z-index: 3;
        display: none;
    }

    .MensagemAddProduto2 span {
        position: absolute;
        left:50%;
        margin-left:-10px;
        font-size: 30px;
        top: 10px;
        color: rgb(75, 192, 192, 1);
    }
    .BannersCompany{
        /* background:url('img/company_background.png?xy');
        background-size:100%;
        background-repeat:no-repeat; */
        background-color:#fff;
        height:155px;
    }

    .card-body-limit4 {
        padding:1px;
        margin:0;
        display: -webkit-box;
        -webkit-line-clamp: 4;
        overflow: hidden;
        -webkit-box-orient: vertical;
        font-size:11px;
    }
    .card-background{
        background-image:url('img/background_card.png?k');
        background-color:#fff;
        background-size:auto 100%;
        background-position:<?=(($_SESSION['lng'] == 'ar')?'left':'right')?> top;
        background-repeat:no-repeat;
    }
</style>

<!-- Informativo de pedidos ativos -->

<div class="topo"></div>

<div class="pagina">
        <div class="BannersCompany" style="margin-top:-15px;">
            <?php
                // for($i=0;$i<10;$i++){
                    $query = "select * from company /*order by rand()*/ limit 22";
                    $result = mysqli_query($con, $query);
                    $i=0;
                    while($d = mysqli_fetch_object($result)){
                        $i++;
            ?>
            <div
                class="d-flex justify-content-between align-items-end"
                style="height:150px;"
            >
                <div class="col-3 d-flex flex-column justify-content-center align-items-center" style="color:#fff; background-color:#30407f; height:100%; background-image:url(img/banner_bg_training.png); background-size:contain; background-repeat:no-repeat;">
                    <b style="font-size:30px;"> 45</b>
                    <span style="font-size:10px;">Alunos</span>
                    <div style="width:60%; height:40px; position:relative;">
                        <div style="position:absolute; bottom:0; left:0; width:33%; height:10%; background-color:#e88016; float:left;"></div>
                        <div style="position:absolute; bottom:0; left:33%; width:33%; height:45%; background-color:#76b42d; float:left; border:solid 1px #fff; border-bottom:0;"></div>
                        <div style="position:absolute; bottom:0; left:66%; width:33%; height:80%; background-color:#2886c7; float:left;"></div>
                    </div>
                </div>
                <div class="col-6 d-flex justify-content-center flex-column align-items-center">
                    <?php
                    if(is_file("../../painel/src/volume/{$d->id}/{$d->logo}")){
                    ?>
                    <img src="<?=$localPainel?>src/volume/<?=$d->id?>/<?=$d->logo?>" style="height:50px;" />
                    <?php
                    }else{
                    ?>
                    <i class="fa-regular fa-image" style="font-size:40px; color:#eee;"></i>
                    <?php
                    }
                    ?>
                    <h6 style="text-align:center; color:#075595;"><?=$d->name?></h6>
                </div>
                <div class="col-3 d-flex flex-column justify-content-center align-items-center" style="color:#fff; background-color:#00a8ec; height:100%; background-image:url(img/banner_bg_company.png); background-size:contain; background-repeat:no-repeat;">
                    <b style="font-size:30px;">12</b>
                    <span style="font-size:10px;">Treinamentos</span>
                    <div style="width:60%; height:40px; position:relative;">
                        <div style="position:absolute; bottom:0; left:0; width:33%; height:10%; background-color:#e88016; float:left;"></div>
                        <div style="position:absolute; bottom:0; left:33%; width:33%; height:45%; background-color:#76b42d; float:left; border:solid 1px #fff; border-bottom:0;"></div>
                        <div style="position:absolute; bottom:0; left:66%; width:33%; height:80%; background-color:#2886c7; float:left;"></div>
                    </div>
                </div>
            </div>
            <?php
                }
            ?>
        </div>

        <div class="paginaCenter">

            <?php
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
                            where a.status = '1'
                            order by c.registration_date desc";
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

            <div class="card card-background m-2"
                <?=(($color_status)?"style=\"border:solid 2px {$color_status};\"":false)?>
            >
                <div class="OpenTraining" id="<?=$d->id?>">
                    <div class="row g-0">
                        <div class="col">
                            <h6 class="card-title" style="color:#054f8c; padding:2px; margin:0;">
                                <?=$d->training_name?>
                                <!-- <small style="color:#a1a1a1"><?=$d->company_name?></small> -->
                            </h6>
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
                        <div class="card-body-limit4">
                            <b><?=$d->company_name?></b><br><?=$d->training_description?>
                        </div>
                        </div>
                    </div>
                    <div class="row g-0">
                        <div class="col">
                            <div class="text-body-secondary w-100 p-2" style="color:#054f8c; font-size:12px;">
                                <i class="fa fa-calendar"></i> <?=$Dic['Date']?>: <?=dataBr($d->initial_date)?> - <?=dataBr($d->final_date)?><br>
                                <i class="fa fa-users"></i> <?=$d->trainings?> <?=$Dic['Trained Opportunity']?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row g-0">
                    <div class="col">
                        <div class="w-100 p-2" style="color:#054f8c; font-size:12px; text-align:<?=(($_SESSION['lng'] == 'ar')?'left':'right')?>;">
                            <span class="bg-success p-1 text-dark bg-opacity-25 rounded">
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
            </div>

            <?php
                }
            ?>

        </div>

</div>


<div class="rodape"></div>

<script>
    $(function(){

        Carregando('none');


		$('.BannersCompany').slick({
			slidesToShow: 1,
			slidesToScroll: 1,
			dots: false,
			centerMode: false,
			focusOnSelect: true,
			autoplay: true,
  			autoplaySpeed: 5000,
            <?=(($_SESSION['lng'] == 'ar')?'rtl: true,':false)?>
		});

        $.ajax({
            url:"components/ms_topo.php",
            success:function(dados){
                $(".topo").html(dados);
            }
        });

        $.ajax({
            url:"components/ms_rodape.php",
            success:function(dados){
                $(".rodape").html(dados);
            }
        });

        $("div[acao<?=$md5?>]").off('click').on('click',function(){

            // AppPedido = window.localStorage.getItem('AppPedido');
            // AppCliente = window.localStorage.getItem('AppCliente');

            janela = $(this).attr('janela');
            local = $(this).attr('local');

                Carregando();
                $.ajax({
                    url:`components/${janela}.php`,
                    type:"POST",
                    data:{
                        local,
                    },
                    success:function(dados){
                        $(".ms_corpo").append(dados);
                    }
                });

        })


        $(".OpenTraining").off('click').on('click', function(){
            id = $(this).attr('id');
            Carregando();
            $.ajax({
                url:`components/ms_popup_100.php`,
                type:"POST",
                data:{
                    local:'src/company/training.php',
                    id,
                },
                success:function(dados){
                    $(".ms_corpo").append(dados);
                    Carregando('none');
                }
            });
        })

    })

</script>