<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/painel/lib/includes.php");

    if($_POST['AppUsuario']) $_SESSION['AppUsuario'] = $_POST['AppUsuario'];

?><style>
    .bg_home{
        position:absolute;
        width:100%;
        height:100%;
        background-image:url("svg/fundo_home.svg");
        background-size:cover;
        background-color:#EAF3F0;
        opacity:0.05;
        display: flex;
        overflow:none;
    }

</style>
<div class="bg_home"></div>
<script>
    $(function(){
        Carregando();
        $.ajax({
                url:"src/home/home.php",
                success:function(dados){
                    $(".ms_corpo").html(dados);
                }
            });
    })
</script>
