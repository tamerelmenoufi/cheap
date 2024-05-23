<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/painel/lib/includes.php");


    $query = "select * from trainee where phone = '{$_POST['phone']}'";
    $result = mysqli_query($con, $query);
    $d = mysqli_fetch_object($result);
    if(!$d->id){
        echo 'error';
        exit();
    }else if($_POST['send']){
        $token = false;
        for($i=0;$i<6;$i++){
            $token = $token . rand(0,9);
        }
        $_SESSION['token'] = $token;

        EnviarWappNovo($d->phone, $Dic['TCV Inform: Your payment activation code is: '].$_SESSION['token'], true);
    }else{
        exit();
    }

?>
<div style="position:absolute; left:0; right:0; height:auto;">
    <div class="col">
        <div class="p-2">
            <h4><?=$Dic['Entry key']?></h4>
            <p style="font-size:12px; color:#a1a1a1"><?=$Dic['Enter the access key sent to your WhatsApp.']?></p>
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="LoginKey" inputmode="numeric" placeholder="<?=$Dic['Enter the key']?>">
                <label for="LoginKey"><?=$Dic['Enter the key']?></label>
            </div>
            <button type="button" class="btn btn-secondary ConfirmKey w-100 mb-3"><?=$Dic['Access']?></button>
        </div>
    </div>
</div>
<img src="img/key-solid.svg?x" style="position:absolute; bottom:0; left:0px; width:150px; color:#eee; opacity:0.1; " />

<script>
    $(function(){
        $("#LoginKey").mask("999999");

        $(".ConfirmKey").off('click').on('click',function(){

            token = $("#LoginKey").val();

            if('<?=$_SESSION['token']?>' != token){
                if(!token){
                    $.alert({
                        content:'<?=$Dic['It is mandatory to inform the access key!']?>',
                        title:false,
                        buttons:{
                            '<?=$Dic['ok']?>':function(){

                            }
                        }
                    });
                }else{
                    $.alert({
                        content:'<?=$Dic['The entered key does not match!']?>',
                        title:false,
                        buttons:{
                            '<?=$Dic['ok']?>':function(){

                            }
                        }
                    });
                }
                return;
            }
            Carregando();
            // AppUsuario = window.localStorage.getItem('<?=$d->id?>');
            window.localStorage.setItem('AppUsuario','<?=$d->id?>');
            PageClose();
            window.location.href='./';

        });


    })
</script>