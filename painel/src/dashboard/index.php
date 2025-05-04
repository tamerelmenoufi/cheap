<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/painel/lib/includes.php");

?>


<div class="row g-0">
    <div class="col-md-3">
        <div class="alert alert-success text-center m-2" role="alert">
            <small><?=$Dic['CompanyX']?></small>
            <h1><?=$d->company?></h1>
        </div>
    </div>
    <div class="col-md-3">
        <div class="alert alert-danger text-center m-2" role="alert">
            <small><?=$Dic['TrainingX']?></small>
            <h1><?=$d->training?></h1>
        </div>
    </div>
    <div class="col-md-3">
        <div class="alert alert-warning text-center m-2" role="alert">
            <small><?=$Dic['TraineesX']?></small>
            <h1><?=$d->trainee?></h1>
        </div>
    </div>
    <div class="col-md-3">
        <div class="alert alert-info text-center m-2" role="alert">
            <small><?=$Dic['AdmissionX']?></small>
            <h1><?=$d->admission?></h1>
        </div>
    </div>
</div>


<div class="row g-0">
    <div class="col-md-6 p-2">
        <div class="card p-3">
            <h3><?=$Dic['Registered TrainingX']?></h3>
            
        </div>
    </div>
    <div class="col-md-6 p-2">
        <div class="card p-3">
            <h3><?=$Dic['Registered TraineeX']?></h3>
            
        </div>
    </div>
</div>


<script>
    $(function(){

        Carregando('none');


    })
</script>