<?php
include("{$_SERVER['DOCUMENT_ROOT']}/painel/lib/includes.php");



$query = "select * from customers where device = '{$_SESSION['idUnico']}'";
$result = mysqli_query($con, $query);
$d = mysqli_fetch_object($result);

?>

<style>
    .topo{
        position:absolute;
        top:0;
        width:100%;
        background:transparent;
        height:100px;
        z-index:2;
    }
    .topo > .voltar{
        position:absolute;
        bottom:10px;
        left:15px;
        font-size:30px;
        color:#670600;
        cursor:pointer;
    }
    .topo > .dados{
        position:absolute;
        top:5px;
        left:10px;
        right:10px;
        font-size:14px;
        font-family:verdana;
        color:#670600;
        cursor:pointer;
        text-align:center;
    }

    
</style>
<div class="topo">
    <div class="dados"><?=$d->name?></div>
    <i class="voltar fa-solid fa-arrow-left"></i>
</div>
<script>
    $(function(){

        $(".voltar").click(function(){
            Carregando();
            $.ajax({
                url:"lib/voltar.php",
                dataType:"JSON",
                success:function(dados){
                    var data = $.parseJSON(dados.dt);
                    $.ajax({
                        url:dados.pg,
                        type:"POST",
                        data,
                        success:function(retorno){
                            $(`${dados.tg}`).html(retorno);
                            Carregando('none');
                        }
                    })
                }
              })
        })
        
    })
</script>