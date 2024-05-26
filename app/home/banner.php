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
    .slider-for div img{
        margin:0;
        padding:0;
        width:100%;
        height:auto;
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
        <div style="position:relative; background:orange; padding:0; margin:0">
            <img src="http://cheappanel.mohatron.com/src/volume/products/1/a55f6be79878b5e34ef5aaf3a9b80fa4.png" style="width:100%; border:solid 1px green; position:relative;" />
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