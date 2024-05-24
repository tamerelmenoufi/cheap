<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/painel/lib/includes.php");

    if ($_POST['action'] == 'saveImage') {

        $md52 = md5($md5.$_POST['name'].$_POST['type'].$_POST['base64']);

        if(!is_dir("../volume")) mkdir("../volume");
        if(!is_dir("../volume/produtos")) mkdir("../volume/produtos");

        list($x, $icon) = explode(';base64,', $data['icon-base']);
        $icon = base64_decode($icon);
        $pos = strripos($data['icon-name'], '.');
        $ext = substr($data['icon-name'], $pos, strlen($data['icon-name']));

        $atual = $data['icon-atual'];

        unset($data['icon-base']);
        unset($data['icon-type']);
        unset($data['icon-name']);
        unset($data['icon-atual']);

        if (file_put_contents("../volume/produtos/{$md52}{$ext}", $icon)) {
            $attr[] = "icon = '{$md52}{$ext}'";
            if ($atual) {
                unlink("../volume/produtos/{$atual}");
            }
        }

    }

?>

        <div class="row">
            <div class="col">
                
                <input type="hidden" id="id" value="<?=$_POST['id']?>" />
            </div>
        </div>


    <script>
        $(function(){
            Carregando('none');

            if (window.File && window.FileList && window.FileReader) {

                $('input[type="file"]').change(function () {

                    if ($(this).val()) {
                        var files = $(this).prop("files");
                        for (var i = 0; i < files.length; i++) {
                            (function (file) {
                                var fileReader = new FileReader();
                                fileReader.onload = function (f) {

                                    var img = new Image();
                                    img.src = f.target.result;
                                    img.onload = function () {
                                        // CREATE A CANVAS ELEMENT AND ASSIGN THE IMAGES TO IT.
                                        var canvas = document.createElement("canvas");
                                        var value = 50;
                                        // RESIZE THE IMAGES ONE BY ONE.
                                        w = img.width;
                                        h = img.height;
                                        if(w > 800){
                                            img.width = 800 //(800 * 100)/img.width // (img.width * value) / 100
                                            img.height = (800 * h / w) //(img.height/100)*img.width // (img.height * value) / 100
                                        }
                                        var ctx = canvas.getContext("2d");
                                        ctx.clearRect(0, 0, canvas.width, canvas.height);
                                        canvas.width = img.width;
                                        canvas.height = img.height;
                                        ctx.drawImage(img, 0, 0, img.width, img.height);

                                        var base64 = canvas.toDataURL(file.type); //f.target.result;
                                        var type = file.type;
                                        var name = file.name;
                                        if(bases64 && type && name){
                                            Carregando();
                                            $.ajax({
                                                url:"src/advertisers/images.php",
                                                type:"POST",
                                                data:{
                                                    base64,
                                                    type,
                                                    name,
                                                    action:'saveImage'
                                                },
                                                success:function(dados){
                                                    $("#divImages").html(dados);
                                                }
                                            });
                                        }

                                    }
                                };
                                fileReader.readAsDataURL(file);
                            })(files[i]);
                        }
                }
                });
            } else {
                alert('Nao suporta HTML5');
            }

        })
    </script>