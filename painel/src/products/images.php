<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/painel/lib/includes.php");

    if ($_POST['action'] == 'saveImage') {

        $md52 = md5($md5.$_POST['name'].$_POST['type'].$_POST['base64']);

        if(!is_dir("../volume")) mkdir("../volume");
        if(!is_dir("../volume/products")) mkdir("../volume/products");
        if(!is_dir("../volume/products/{$_POST['id']}")) mkdir("../volume/products/{$_POST['id']}");

        list($x, $img) = explode(';base64,', $_POST['base64']);
        $img = base64_decode($img);
        $pos = strripos($_POST['name'], '.');
        $ext = substr($_POST['name'], $pos, strlen($_POST['name']));

        file_put_contents("../volume/products/{$_POST['id']}/{$md52}{$ext}", $img);

    }

?>
        <div class="row mb-3">
            <?php
                $path = "../volume/products/{$_POST['id']}/";
                if(is_dir($path)){
                $diretorio = dir($path);
                while($arquivo = $diretorio -> read()){
                    if(is_file($path.$arquivo)){
            ?>
                <div class="col-md-4">
                    <img src="src/volume/products/<?="{$_POST['id']}/{$arquivo}"?>" class="img-fluid m-3">
                </div>
            <?php
                    }
                }
                $diretorio -> close();
                }
            ?>
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
                                        console.log(type)
                                        console.log(name)
                                        if(base64 && type && name){
                                            Carregando();
                                            $.ajax({
                                                url:"src/products/images.php",
                                                type:"POST",
                                                data:{
                                                    id:'<?=$_POST['id']?>',
                                                    base64,
                                                    type,
                                                    name,
                                                    action:'saveImage'
                                                },
                                                success:function(dados){
                                                    console.log(dados)

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