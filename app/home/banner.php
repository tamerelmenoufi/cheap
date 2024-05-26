<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/painel/lib/includes.php");
?>
<style>
    .slider{
        position:relative;
        background:#fff;
        width:100%;        
    }
    .slider-for{
        position:relative;
        width:100%;
    }
    .slider-for img{
        margin:0;
        padding:0;
        width:100%;
        height:auto;
    }
    .barra_banner{
        position: absolute;
        margin-top:-36px;
        height:30px;
        width:100%;
    }
    .barra_banner div{
        background-color:#fff;
        width:100%;
    } 
</style>

<div class="slider">
    <div class="slider-for">

        <?php
        // $query = "select * from produtos where promocao = '1' and situacao = '1' and deletado != '1'";
        // $result = mysqli_query($con, $query);
        // while($d = mysqli_fetch_object($result)){
        for($i=0;$i<5;$i++){
        ?>
        <div style="position:relative; background:orange;">
            <img src="http://cheappanel.mohatron.com/src/volume/products/1/a55f6be79878b5e34ef5aaf3a9b80fa4.png" style="width:100%; position:relative;" />
        </div>
        <?php
        }
        ?>

    </div>

</div>



<script>

$(function(){

    $('.slider-for').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: false,
        fade: true,
        autoplay: true,
        autoplaySpeed: 5000,
    });

})

	

</script>