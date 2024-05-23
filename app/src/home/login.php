<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/painel/lib/includes.php");
?>
<div style="position:absolute; left:0; right:0; height:auto;">
    <div class="col">
        <div class="p-2">
            <h4><?=$Dic['Access']?></h4>
            <p style="font-size:12px; color:#a1a1a1"><?=$Dic['Enter your WhatsApp number in your registration so that we can send you your access credential.']?></p>
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="LoginPhone" inputmode="numeric" placeholder="<?=$Dic['Enter your phone number']?>">
                <label for="LoginPhone"><?=$Dic['Enter your phone number']?></label>
            </div>
            <button type="button" class="btn btn-secondary SendKey w-100 mb-3"><?=$Dic['Send Key']?></button>
            <button type="button" class="btn btn-link w-100 newRegister"><?=$Dic['Make new registration']?></button>
        </div>
    </div>
</div>
<img src="img/lock-open-solid.svg?x" style="position:absolute; bottom:0; left:-20px; width:150px; color:#eee; opacity:0.1; transform: rotate(-45deg);" />

<!-- </div> -->

<script>
    $(function(){
        $("#LoginPhone").mask("299999999999");

        $(".newRegister").click(function(){
            Carregando();
            $.ajax({
                url:`components/ms_popup_100.php`,
                type:"POST",
                data:{
                    local:'src/trainee/form.php',
                },
                success:function(dados){
                    PageClose();
                    $(".ms_corpo").append(dados);
                }
            });
        });

        $(".SendKey").off('click').on('click',function(){
            phone = $("#LoginPhone").val();

            if(!phone){
                $.alert({
                    content:'<?=$Dic['Please enter the phone number!']?>',
                    title:false,
                    buttons:{
                        '<?=$Dic['ok']?>':function(){

                        }
                    }
                });
                return;
            }

            Carregando();

            $.ajax({
                url:`src/home/key.php`,
                type:"POST",
                data:{
                    phone,
                    send:0,
                },
                success:function(dados){
                    if(dados == 'error'){
                        Carregando('none');
                        $.alert({
                            content:'<?=$Dic['An error occurred, the number entered is not in our records.']?>',
                            title:false,
                            buttons:{
                                '<?=$Dic['ok']?>':function(){

                                }
                            }
                        });
                    }else{
                        $.ajax({
                            url:`components/ms_popup.php`,
                            type:"POST",
                            data:{
                                local:'src/home/key.php',
                                phone,
                                send:1,
                            },
                            success:function(dados){
                                Carregando('none');
                                PageClose();
                                $(".ms_corpo").append(dados);
                            }
                        });
                    }
                }
            })


        });
    })
</script>