<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/painel/lib/includes.php");
?>
<div style="position:absolute; left:0; right:0; height:auto;">
    <div class="col">
        <div class="p-2">
            <h4>Filtro de Treinamentos</h4>
            <p style="font-size:12px; color:#a1a1a1">Informe nos campos abaixo o tipo de filtro para localizar os treinamentos do seu perfil.</p>

            <div class="form-floating mb-3">
                <select SearchFild name="category" class="form-control" id="category">
                    <option value="" >:: <?=$Dic['Category']?> ::</option>
                    <?php
                    $q = "select * from categories where status = '1' order by category";
                    $r = mysqli_query($con, $q);
                    while($s = mysqli_fetch_object($r)){
                    ?>
                    <option value="<?=$s->id?>" <?=(($s->id == $d->category)?'selected':false)?>><?=$s->category?></option>
                    <?php
                    }
                    ?>
                </select>
                <label for="category"><?=$Dic['Category']?></label>
            </div>

            <div class="form-floating mb-3">
                <select SearchFild name="company" class="form-control" id="company">
                    <option value="" >:: <?=$Dic['Company']?> ::</option>
                    <?php
                    $q = "select * from company /*where status = '1'*/ order by name";
                    $r = mysqli_query($con, $q);
                    while($s = mysqli_fetch_object($r)){
                    ?>
                    <option value="<?=$s->id?>" <?=(($s->id == $d->company)?'selected':false)?>><?=$s->name?></option>
                    <?php
                    }
                    ?>
                </select>
                <label for="company"><?=$Dic['Company']?></label>
            </div>


            <button type="button" class="btn btn-secondary SendKey w-100 mb-3">Filtrar</button>
        </div>

    </div>
</div>

<script>
    $(function(){

    })
</script>