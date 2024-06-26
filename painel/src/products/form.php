<?php
        include("{$_SERVER['DOCUMENT_ROOT']}/painel/lib/includes.php");



    if($_POST['action'] == 'save'){

        $data = $_POST;
        $attr = [];

        unset($data['id']);
        unset($data['action']);

        foreach ($data as $name => $value) {
            $attr[] = "{$name} = '" . addslashes($value) . "'";
        }

        $attr = implode(', ', $attr);

        if($_POST['id']){
            $query = "update products set {$attr} where id = '{$_POST['id']}'";
            mysqli_query($con, $query);
            $id = $_POST['id'];
        }else{
            $query = "insert into products set register_date = NOW(), {$attr}";
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


    $query = "select * from products where id = '{$_POST['id']}'";
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
    <h4 class="Titulo<?=$md5?>"><?=$Dic['products']?></h4>
    <form id="form-<?= $md5 ?>">
        <div class="row">
            <div class="col">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="name" name="name" placeholder="<?=$Dic['Full Name']?>" value="<?=$d->name?>">
                    <label for="nome"><?=$Dic['Name']?>*</label>
                </div>

                <div class="form-floating mb-3">
                    <select name="category" class="form-control" id="category">
                        <?php
                        $q = "select * from categories where status = '1' order by category";
                        $r = mysqli_query($con, $q);
                        while($s = mysqli_fetch_object($r)){
                        ?>
                        <option value="<?=$s->id?>" <?=(($d->category == $s->id)?'selected':false)?>><?=$s->category?></option>
                        <?php
                        }
                        ?>
                    </select>
                    <label for="category"><?=$Dic['Category']?></label>
                </div>

                <div class="form-floating mb-3">
                    <textarea class="form-control" id="description" name="description" placeholder="<?=$Dic['Description']?>" style="height:150px;"><?=$d->description?></textarea>
                    <label for="description"><?=$Dic['Description']?>*</label>
                </div>
                <?php
                if($d->id){
                ?>
                <input type="file" class="form-control" placeholder="Icon">
                <div class="form-text mb-3"><?=$Dic['Select an image to include in the gallery']?></div>
                <div id="divImages"></div>
                <?php
                }
                ?>
                <div class="form-floating mb-3">
                    <input type="datetime-local" name="start_date" id="start_date" class="form-control" placeholder="<?=$Dic['Start Date']?>" value="<?=($d->start_date)?>">
                    <label for="start_date"><?=$Dic['Start Date']?>*</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="datetime-local" name="end_date" id="end_date" class="form-control" placeholder="<?=$Dic['End Date']?>" value="<?=($d->end_date)?>">
                    <label for="end_date"><?=$Dic['End Date']?>*</label>
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

            $.ajax({
                url:"src/products/images.php",
                type:"POST",
                data:{
                    id:'<?=$_POST['id']?>'
                },
                success:function(dados){
                    $("#divImages").html(dados);
                }
            });


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
                    url:"src/products/form.php",
                    type:"POST",
                    typeData:"JSON",
                    mimeType: 'multipart/form-data',
                    data: filds,
                    success:function(dados){
                        console.log(dados);
                        // if(dados.status){
                            $.ajax({
                                url:"src/products/index.php",
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