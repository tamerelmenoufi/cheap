<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/painel/lib/includes.php");
?>
<style>
    .topoImg{
        /* position:absolute; */
        height:45px;
        /* margin-left:calc(15px + 10%);
        margin-top:5px; */
        /* transform: rotate(-10deg); */
        z-index:2;
    }
    .nameLogo{
        color:#fff; /*#075595;*/
        font-size:20px;
        margin-left:5px;
        margin-top:12px;
    }

</style>
<div class="row">
    <div class="col-4">
        <div class="w-100 d-flex flex-column justify-content-center align-items-center language"
            janela="ms_popup"
            local="src/conf/language.php"
            style="height:55px;">
            <i class="fa-solid fa-language" style="font-size:22px; color:#fff; padding:0; margin:0;"></i>
            <div style="font-size:10px; color:#fff;"><?=(($_SESSION['lng'] == 'ar')?'عربي':'English')?></div>
        </div>
    </div>
    <div class="col-4">
        <div class="d-flex justify-content-center align-items-center" style="height:65px;">
            <img class="topoImg" src="img/logo2.png?xxx" />
            <!-- <h1 class="nameLogo">TCV</h1> -->
        </div>
        <!-- <h1 class="topoImg">TCV</h1> -->
    </div>
    <div class="col-4">
        <?php
        if($_SESSION['AppUsuario']){
        ?>
        <div class="d-flex justify-content-center align-items-center exitApp" style="height:65px; color:#fff;">
            <div><i class="fa-solid fa-arrow-right-to-bracket <?=(($_SESSION['lng'] == 'ar')?'fa-rotate-180':false)?>"></i> <span style="font-size:10px;"><?=$Dic['Exit']?></span></div>
        </div>
        <?php
        }
        ?>
    </div>
</div>

<script>

    $(function(){

        $(".language").off('click').on('click',function(){

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

        $(".exitApp").click(function(){


            $.confirm({
                content:'Deseja realmente sair?',
                title:false,
                buttons:{
                    '<?=$Dic['Yes']?>':function(){
                        Carregando();
                        window.localStorage.removeItem('AppUsuario');
                        $.ajax({
                            url:`src/conf/sessao.php`,
                            type:"POST",
                            data:{
                                exit:1,
                            },
                            success:function(dados){
                                window.location.href='./';
                            }
                        });
                    },
                    '<?=$Dic['No']?>':function(){

                    }
                }
            });

        });

    })
</script>