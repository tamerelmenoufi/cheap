<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/painel/lib/includes.php");
?>
<style>
    .ms_popup_fundo<?=$md5?>{
        position:fixed;
        left:0px;
        bottom:0;
        width:100%;
        height:100%;
        background:#000;
        opacity: 0.4;
        z-index: 100;
    }
    .ms_popup<?=$md5?>{
        position:fixed;
        left:0px;
        bottom:0;
        width:100%;
        height:70%;
        padding-top:40px;
        border-top-left-radius:25px;
        border-top-right-radius:25px;
        background:#d8f2fe;
        z-index: 101;
        overflow:auto;

    }
    .ms_popup_close<?=$md5?>{
        position:fixed;
        bottom:calc(70% - 30px);
        left:50%;
        margin-left:-30px;
        padding:3px;
        font-size:30px;
        text-align:center;
        color:#fc1a1a;
        width:60px;
        height:60px;
        border-radius:100%;
        background:#d8f2fe;
        border:solid 3px #fff;
        z-index:110;
        font-weight:bold;
    }

</style>

<div class="ms_popup_fundo<?=$md5?>"></div>
<div
    class="ms_popup<?=$md5?> wow animate__fadeInUp"
    data-wow-duration="0.5s"
    data-wow-delay="0s"
>
</div>
<close chave="<?=$md5?>"></close>
<div class="ms_popup_close<?=$md5?>"><i class="fa fa-close"></i></div>
<script>



    FecharPopUp<?=$md5?> = () => {
        $(".ms_popup_fundo<?=$md5?>, .ms_popup<?=$md5?>, .ms_popup_close<?=$md5?>").remove();
    }

    $(function(){

        Carregando('none');

        $(".ms_popup_fundo<?=$md5?>, .ms_popup_close<?=$md5?>").off('click').on('click',function(){
            FecharPopUp<?=$md5?>();
        });



        <?php
        if($_POST['local']){

            $Dados = json_encode($_POST).';';
            echo "Dados{$md5} = ".(($Dados)?:"'';\n\n");
        ?>
        Carregando();

        $.ajax({
            url:"<?=$_POST['local']?>",
            type:"POST",
            data:{
                Dados:<?="Dados{$md5}"?>,
            <?php
            //*
            foreach($_POST as $ind => $val){
                if($ind != 'local'){
                    echo  "             {$ind}:'{$val}',\n";
                }
            }
            //*/
                ?>
            },
            success:function(dados){
                $(".ms_popup<?=$md5?>").append(dados);
                Carregando('none');
            },
            error:function(){
                $.alert("Ocorreu um erro no carregamento da página!");
                Carregando('none');
            }
        });
        <?php
        }
        ?>


        $(".ms_popup_fundo<?=$md5?>").draggable({

            containment: ".ms_corpo",
            //cursor: "move",
            helper: "clone",
            scroll: false,

            start: function () {
                $(".ms_popup_fundo<?=$md5?>, .ms_popup_close<?=$md5?>").click();
                //console.log('start');
            },

        });


    })
</script>