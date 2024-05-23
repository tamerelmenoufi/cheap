<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/painel/lib/includes.php");
?>

<div class="row">
    <div class="col acao" componente="ms_popup_100" local="src/trainee/form.php"><i class="fa-solid fa-user-graduate"></i><p><?=$Dic['My cadastre']?></p></div>
    <div class="col acao" componente="ms_popup" local="src/company/filter.php"><i class="fa-solid fa-magnifying-glass"></i><p><?=$Dic['Search']?></p></div>
    <div class="col acao" componente="ms_popup_100" local="src/trainee/my_training.php"><i class="fa-regular fa-id-badge"></i><p><?=$Dic['My trainings']?></p></div>
</div>
<script>
    ///////////////
    $(function(){

        $(".acao").off('click').on('click',function(){

            janela = $(this).attr('componente');
            local = $(this).attr('local');

            // AppPedido = window.localStorage.getItem('AppPedido');
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

            }

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


    })
</script>