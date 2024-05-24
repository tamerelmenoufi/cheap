<?php
        include("{$_SERVER['DOCUMENT_ROOT']}/painel/lib/includes.php");


    if($_POST['action'] == 'save'){

        $data = $_POST;
        $attr = [];

        unset($data['id']);
        unset($data['action']);
        unset($data['password']);

        foreach ($data as $name => $value) {
            $attr[] = "{$name} = '" . addslashes($value) . "'";
        }
        if($_POST['password']){
            $attr[] = "password = '" . md5($_POST['password']) . "'";
        }

        $attr = implode(', ', $attr);

        if($_POST['id']){
            $query = "update advertisers set {$attr} where id = '{$_POST['id']}'";
            mysqli_query($con, $query);
            $id = $_POST['id'];
        }else{
            $query = "insert into advertisers set register_date = NOW(), {$attr}";
            mysqli_query($con, $query);
            $id = mysqli_insert_id($con);
        }

        $return = [
            'status' => true,
            'id' => $id." - ".$query
        ];

        echo json_encode($return);

        exit();
    }


    $query = "select * from advertisers where id = '{$_POST['id']}'";
    $result = mysqli_query($con, $query);
    $d = mysqli_fetch_object($result);
?>
<style>
    .Titulo<?=$md5?>{
        position:absolute;
        left:60px;
        top:8px;
        z-index:0;
    }
</style>
<h4 class="Titulo<?=$md5?>"><?=$Dic['User Registration']?></h4>
    <form id="form-<?= $md5 ?>">
        <div class="row">
            <div class="col">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="name" name="name" placeholder="<?=$Dic['Full Name']?>" value="<?=$d->name?>">
                    <label for="nome"><?=$Dic['Name']?>*</label>
                </div>
                <div class="form-floating mb-3">
                    <select name="segment" class="form-control" id="segment">
                        <?php
                        $q = "select * from segments where status = '1' order by segment";
                        $r = mysqli_query($con, $q);
                        while($s = mysqli_fetch_object($r)){
                        ?>
                        <option value="<?=$s->id?>" <?=(($d->segment == $s->id)?'selected':false)?>><?=$s->segment?></option>
                        <?php
                        }
                        ?>
                    </select>
                    <label for="segment"><?=$Dic['Segment']?></label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" name="phone" id="phone" class="form-control" placeholder="<?=$Dic['Phone']?>" value="<?=$d->phone?>">
                    <label for="telefone"><?=$Dic['Phone']?>*</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" name="email" id="email" class="form-control" placeholder="<?=$Dic['E-mail']?>" value="<?=$d->email?>">
                    <label for="email"><?=$Dic['E-mail']?></label>
                </div>

                <div class="form-floating mb-3">
                    <input type="text" name="addres" id="addres" class="form-control" placeholder="<?=$Dic['Addres']?>" value="<?=$d->addres?>">
                    <label for="addres"><?=$Dic['Addres']?></label>
                </div>

                <div class="form-floating mb-3">
                    <input type="text" name="password" id="password" class="form-control" placeholder="Password" value="">
                    <label for="password"><?=$Dic['Password']?></label>
                </div>

                <div class="form-floating mb-3">
                    <select name="status" class="form-control" id="status">
                        <option value="1" <?=(($d->status == '1')?'selected':false)?>><?=$Dic['Allowed']?></option>
                        <option value="0" <?=(($d->status == '0')?'selected':false)?>><?=$Dic['Blocked']?></option>
                    </select>
                    <label for="email"><?=$Dic['Status']?></label>
                </div>

            </div>
        </div>

        <div class="row">
            <div class="col">
                <div style="display:flex; justify-content:end">
                    <button type="submit" class="btn btn-success btn-ms"><?=$Dic['Save']?></button>
                    <input type="hidden" id="id" value="<?=$_POST['id']?>" />
                </div>
            </div>
        </div>
    </form>

    <script>
        $(function(){
            Carregando('none');

            $("#identity").mask("9 999999 99 99999");
            $("#phone").mask("299999999999");

            $('#form-<?=$md5?>').submit(function (e) {

                e.preventDefault();

                var id = $('#id').val();
                var filds = $(this).serializeArray();

                if (id) {
                    filds.push({name: 'id', value: id})
                }

                filds.push({name: 'action', value: 'save'})

                Carregando();

                $.ajax({
                    url:"src/advertisers/form.php",
                    type:"POST",
                    typeData:"JSON",
                    mimeType: 'multipart/form-data',
                    data: filds,
                    success:function(dados){
                        console.log(dados);
                        // if(dados.status){
                            $.ajax({
                                url:"src/advertisers/index.php",
                                type:"POST",
                                success:function(dados){
                                    $("#pageHome").html(dados);
                                    let myOffCanvas = document.getElementById('offcanvasRight');
                                    let openedCanvas = bootstrap.Offcanvas.getInstance(myOffCanvas);
                                    openedCanvas.hide();
                                }
                            });
                        // }
                    },
                    error:function(erro){

                        // $.alert('Ocorreu um erro!' + erro.toString());
                        //dados de teste
                    }
                });

            });

        })
    </script>