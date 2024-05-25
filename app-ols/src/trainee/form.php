<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/painel/lib/includes.php");


    if($_POST['action'] == 'save'){

        $data = $_POST;
        $attr = [];

        unset($data['id']);
        unset($data['action']);

        $base64Image = [];
        $nameImage = [];
        $typeImage = [];
        $atualImage = [];

        foreach ($data as $name => $value) {

            $verify = explode("-",$name);
            if($verify[0] == 'image'){
                if($verify[2] == 'base64_image'){
                    $base64Image[$verify[1]] = $value;
                }else if($verify[2] == 'name_image' and $value){
                    $ext = substr($value,strripos($value, '.'),strlen($value));
                    $nameImage[$verify[1]] = md5($value.$verify[1].date("YmdHis")).$ext;
                    $attr[] = "{$verify[1]} = '" . $nameImage[$verify[1]] . "'";
                }else if($verify[2] == 'atual_image' and $base64Image[$verify[1]] and $nameImage[$verify[1]] and $value){
                    $atualImage[$verify[1]] = $value;
                }
            }else{
                $attr[] = "{$name} = '" . addslashes($value) . "'";
            }
        }

        $attr = implode(', ', $attr);

        if($_POST['id']){
            $query = "update trainee set {$attr} where id = '{$_POST['id']}'";
            $exec = mysqli_query($con, $query);
            $id = $_POST['id'];
        }else{
            $query = "insert into trainee set registration_date = NOW(), {$attr}";
            $exec = mysqli_query($con, $query);
            $id = mysqli_insert_id($con);
        }

        if($exec and $base64Image){
            $local = "../../../painel/src/volume/trainings/{$id}";
            if(!is_dir("../../../painel/src/volume/trainings")) mkdir("../../../painel/src/volume/trainings");
            if(!is_dir($local)) mkdir($local);
            foreach($base64Image as $ind => $img){
                $img = explode("base64,", $img);
                file_put_contents("{$local}/{$nameImage[$ind]}", base64_decode($img[1]));
                if(is_file("{$local}/{$atualImage[$ind]}")) unlink("{$local}/{$atualImage[$ind]}");
            }
        }

        $return = [
            'status' => true,
            'id' => $id." - ".$query
        ];

        echo json_encode($return);

        exit();
    }


    $query = "select * from trainee where id = '{$_SESSION['AppUsuario']}'";
    $result = mysqli_query($con, $query);
    $d = mysqli_fetch_object($result);

?>
<style>
    .btn-secondary, .btn-secondary:hover{
        background:#075595;
    }
    .Titulo<?=$md5?>{
        margin-<?=(($_SESSION['lng'] == 'ar')?'right':'left')?>:60px;
    }
</style>

<div style="position:fixed; z-index:10; left:0; top:0; height:60px; background:#d8f2fe; width:100%; padding:10px; padding-top:15px;">
    <h4 class="Titulo<?=$md5?>"><?=$Dic['Trainee Registration']?></h4>
</div>
<div style="position:relative; width:100%;" class="p-3">
    <form id="form-<?= $md5 ?>">
        <div class="row">
            <div class="col" style="margin-bottom:50px;">
                <div class="form-floating mb-3">
                    <select name="faculty" id="faculty" class="form-control" placeholder="Coordenator">
                        <option value="">::<?=$Dic['Select Faculity']?>::</option>
                        <?php
                            $q = "select * from faculties order by faculty";
                            $r = mysqli_query($con, $q);
                            while($s = mysqli_fetch_object($r)){
                        ?>
                        <option value="<?=$s->id?>" <?=(($d->faculty == $s->id)?'selected':false)?>><?=$s->faculty?></option>
                        <?php
                            }
                        ?>
                    </select>
                    <label for="faculty"><?=$Dic['Faculity']?></label>
                </div>
                <div class="input-group mb-3">
                    <?php
                    if($d->photo){
                    ?>
                    <div class="imageView"><div><i class="fa-solid fa-trash"></i></div><object data="<?=$localPainel?>src/volume/trainings/<?=$d->id?>/<?=$d->photo?>" style="max-width:100%;"></object></div>
                    <?php
                    }
                    ?>
                    <div class="form-floating" style="width:calc(100% - 50px);">
                        <input type="text" name="name" id="name" class="form-control form-text-group-adapt" placeholder="<?=$Dic['Name']?>" aria-label="<?=$Dic['Name']?>" value="<?=$d->name?>">
                        <label for="name"><?=$Dic['Name']?>*</label>
                    </div>
                    <button class="btn btn-secondary btn-group-adapt" type="button" id="button-addon2">
                        <input type="file" class="attachment" target="photo" accept="image/*,application/pdf" >
                        <input attachment type="hidden" id="photo" base64_image="" name_image="" type_image="" atual_image="<?=$d->photo?>">
                        <i class="fa-solid fa-camera"></i>
                    </button>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" name="address" id="address" class="form-control" placeholder="<?=$Dic['Adress']?>" value="<?=$d->address?>">
                    <label for="address"><?=$Dic['Adress']?>*</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" name="date_birth" id="date_birth" class="form-control" placeholder="<?=$Dic['Birthday']?>" value="<?=$d->date_birth?>">
                    <label for="date_birth"><?=$Dic['Birthday']?>*</label>
                </div>
                <div class="form-floating mb-3">
                    <select name="gender" class="form-control" id="gender">
                        <option value="m" <?=(($d->gender == 'm')?'selected':false)?>><?=$Dic['Masculine']?></option>
                        <option value="f" <?=(($d->gender == 'f')?'selected':false)?>><?=$Dic['Female']?></option>
                    </select>
                    <label for="gender"><?=$Dic['Gender']?></label>
                </div>
                <div class="input-group mb-3">
                    <?php
                    if($d->identity_attachment){
                    ?>
                    <div class="imageView"><div><i class="fa-solid fa-trash"></i></div><object data="<?=$localPainel?>src/volume/trainings/<?=$d->id?>/<?=$d->identity_attachment?>" style="max-width:100%;"></object></div>
                    <?php
                    }
                    ?>
                    <div class="form-floating" style="width:calc(100% - 50px);">
                        <input type="text" name="identity" id="identity" class="form-control form-text-group-adapt" placeholder="<?=$Dic['Identity']?>" aria-label="<?=$Dic['Identity']?>" value="<?=$d->identity?>">
                        <label for="identity"><?=$Dic['Identity']?>*</label>
                    </div>
                    <button class="btn btn-secondary btn-group-adapt" type="button" id="button-addon2">
                        <input type="file" class="attachment" target="identity_attachment" accept="image/*,application/pdf">
                        <input attachment type="hidden" id="identity_attachment" base64_image="" name_image="" type_image="" atual_image="<?=$d->identity_attachment?>">
                        <i class="fa-solid fa-camera"></i>
                    </button>
                </div>
                <div class="input-group mb-3">
                    <?php
                    if($d->college_statement_attachment){
                    ?>
                    <div class="imageView"><div><i class="fa-solid fa-trash"></i></div><object data="<?=$localPainel?>src/volume/trainings/<?=$d->id?>/<?=$d->college_statement_attachment?>" style="max-width:100%;"></object></div>
                    <?php
                    }
                    ?>
                    <div class="form-floating" style="width:calc(100% - 50px);">
                        <input type="text" name="college_statement" id="college_statement" class="form-control form-text-group-adapt" placeholder="<?=$Dic['College Statement']?>" aria-label="<?=$Dic['College Statement']?>" value="<?=$d->college_statement?>">
                        <label for="college_statement"><?=$Dic['College Statement']?>*</label>
                    </div>
                    <button class="btn btn-secondary btn-group-adapt" type="button" id="button-addon2">
                        <input type="file" class="attachment" target="college_statement_attachment" accept="image/*,application/pdf">
                        <input attachment type="hidden" id="college_statement_attachment" base64_image="" name_image="" type_image="" atual_image="<?=$d->college_statement_attachment?>">
                        <i class="fa-solid fa-camera"></i>
                    </button>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" name="phone" id="phone" class="form-control" inputmode="numeric" placeholder="<?=$Dic['Phone']?>" value="<?=$d->phone?>" <?=(($_SESSION['AppUsuario'])?'readonly':false)?>>
                    <label for="phone"><?=$Dic['Phone']?>*</label>
                </div>
            </div>
        </div>
        <div style="position:fixed; z-index:10; left:0; bottom:0; height:60px; background:#d8f2fe; width:100%; padding:10px;">
            <div class="row">
                <div class="col">
                    <button type="submit" class="btn btn-success w-100"><i class="fa-regular fa-floppy-disk"></i> <?=$Dic['Save']?></button>
                </div>
                <div class="col">
                    <button cancel type="button" class="btn btn-danger w-100"><i class="fa-solid fa-arrow-rotate-left"></i> <?=$Dic['Cancel']?></button>
                </div>
            </div>
        </div>
        <input type="hidden" id="id" value="<?=$_SESSION['AppUsuario']?>" />
    </form>
</div>


<script>

$(function(){

    Carregando('none');
    $("#identity").mask("9 999999 99 99999");
    $("#phone").mask("299999999999");

    if (window.File && window.FileList && window.FileReader) {

        $('input[type="file"]').change(function () {
            target = $(this).attr("target");
            if ($(this).val()) {
                var files = $(this).prop("files");
                for (var i = 0; i < files.length; i++) {
                    (function (file) {
                        var fileReader = new FileReader();
                        fileReader.onload = function (f) {

                            var type = file.type;
                            var name = file.name;

                            // console.log(type.indexOf("image"))


                            if(type.indexOf("image") == -1){

                                var Base64 = f.target.result;

                                $(`#${target}`).attr("base64_image", Base64);
                                $(`#${target}`).attr("type_image", type);
                                $(`#${target}`).attr("name_image", name);
                                $(`#${target}`).parent("button").parent("div").children(".imageView").remove();
                                $(`#${target}`).parent("button").parent("div").prepend(`<div class="imageView"><div><i class="fa-solid fa-trash"></i></div><object data="${Base64}" style="max-width:100%;"></object></div>`);


                            }else{

                                //////////////////////////////////////////////////////////////////

                                var img = new Image();
                                img.src = f.target.result;

                                img.onload = function () {

                                    // CREATE A CANVAS ELEMENT AND ASSIGN THE IMAGES TO IT.
                                    var canvas = document.createElement("canvas");

                                    var value = 50;

                                    // RESIZE THE IMAGES ONE BY ONE.
                                    w = img.width;
                                    h = img.height;
                                    img.width = 800 //(800 * 100)/img.width // (img.width * value) / 100
                                    img.height = (800 * h / w) //(img.height/100)*img.width // (img.height * value) / 100

                                    var ctx = canvas.getContext("2d");
                                    ctx.clearRect(0, 0, canvas.width, canvas.height);
                                    canvas.width = img.width;
                                    canvas.height = img.height;
                                    ctx.drawImage(img, 0, 0, img.width, img.height);

                                    // $('.Foto').append(img);      // SHOW THE IMAGES OF THE BROWSER.
                                    // console.log(canvas.toDataURL(file.type));

                                    ///////

                                    var Base64 = canvas.toDataURL(file.type); //f.target.result;





                                    $(`#${target}`).attr("base64_image", Base64);
                                    $(`#${target}`).attr("type_image", type);
                                    $(`#${target}`).attr("name_image", name);
                                    $(`#${target}`).parent("button").parent("div").children(".imageView").remove();
                                    $(`#${target}`).parent("button").parent("div").prepend(`<div class="imageView"><div><i class="fa-solid fa-trash"></i></div><object data="${Base64}" style="max-width:100%;"></object></div>`);


                                    //////

                                }

                                //////////////////////////////////////////////////////////////////
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

    $('#form-<?=$md5?>').submit(function (e) {

        e.preventDefault();

        var id = $('#id').val();
        var filds = $(this).serializeArray();

        if (id) {
            filds.push({name: 'id', value: id})
        }

        filds.push({name: 'action', value: 'save'})

        $("input[attachment]").each(function(){
            base64_image = $(this).attr("base64_image");
            name_image = $(this).attr("name_image");
            type_image = $(this).attr("type_image");
            atual_image = $(this).attr("atual_image");
            id = $(this).attr("id");
            if(base64_image){
                filds.push({name: `image-${id}-base64_image`, value:base64_image });
                filds.push({name: `image-${id}-name_image`, value:name_image });
                filds.push({name: `image-${id}-type_image`, value:type_image });
                filds.push({name: `image-${id}-atual_image`, value:atual_image });
            }
        })

        id = $("#id").val();
        faculty = $("#faculty").val();
        name = $("#name").val();
        address = $("#address").val();
        date_birth = $("#date_birth").val();
        gender = $("#gender").val();
        identity = $("#identity").val();
        college_statement = $("#college_statement").val();
        phone = $("#phone").val();
        photo = $("#photo").attr("base64_image");
        photo_atual = $("#photo").attr("atual_image");
        identity_attachment = $("#identity_attachment").attr("base64_image");
        identity_attachment_atual = $("#identity_attachment").attr("atual_image");
        college_statement_attachment = $("#college_statement_attachment").attr("base64_image");
        college_statement_attachment_atual = $("#college_statement_attachment").attr("atual_image");


        // console.log(`faculty - ${faculty}`);
        // console.log(`name - ${name}`);
        // console.log(`address - ${address}`);
        // console.log(`date_birth - ${date_birth}`);
        // console.log(`gender - ${gender}`);
        // console.log(`identity - ${identity}`);
        // console.log(`college_statement - ${college_statement}`);
        // console.log(`phone - ${phone}`);
        // console.log(`photo - ${photo}`);
        // console.log(`photo_atual - ${photo_atual}`);
        // console.log(`identity_attachment - ${identity_attachment}`);
        // console.log(`identity_attachment_atual - ${identity_attachment_atual}`);
        // console.log(`college_statement_attachment - ${college_statement_attachment}`);
        // console.log(`college_statement_attachment_atual - ${college_statement_attachment_atual}`);


        if(
            !faculty ||
            !name ||
            !address ||
            !date_birth ||
            !gender ||
            !identity ||
            !college_statement ||
            !phone ||
            (!photo && !photo_atual) ||
            (!identity_attachment && !identity_attachment_atual) ||
            (!college_statement_attachment && !college_statement_attachment_atual)
        ){
            $.alert({
                content:'<?=$Dic['To register, filling out all fields of the form is mandatory!']?>',
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
            url:"src/trainee/form.php",
            type:"POST",
            typeData:"JSON",
            mimeType: 'multipart/form-data',
            data: filds,
            success:function(dados){
                $.alert({
                    content:'<?=$Dic['Your registration was successful!']?>',
                    title:false,
                    buttons:{
                        '<?=$Dic['ok']?>':function(){

                        }
                    }
                });
                if(!id){

                    $.ajax({
                        url:`components/ms_popup.php`,
                        type:"POST",
                        data:{
                            local:'src/home/login.php',
                        },
                        success:function(dados){
                            PageClose();
                            Carregando('none');
                            $(".ms_corpo").append(dados);
                        }
                    });

                }else{
                    Carregando('none');
                }

            },
            error:function(erro){

                // $.alert('Ocorreu um erro!' + erro.toString());
                //dados de teste
            }
        });

    });

    $("button[cancel]").click(function(){
        PageClose();
    })
})
</script>