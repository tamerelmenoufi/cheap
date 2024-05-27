<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/painel/lib/includes.php");

    if($_POST['idUnico']){
        $_SESSION['idUnico'] = $_POST['idUnico'];
    }

    if($_POST['acao'] == 'atualizar'){
        mysqli_query($con, "update clientes set {$_POST['campo']} = '".addslashes($_POST['valor'])."' where codigo = '{$_POST['codigo']}'");
        $retorno = [
            'status' => 'success',
            'idUnico' => $_SESSION['idUnico'],
        ];
        echo json_encode($retorno);
        exit();
    }

    if($_POST['telefone']){
        $telefone = str_replace(['-',' ','(',')'],false,trim($_POST['telefone']));
        if(strlen($telefone) != 11){
            echo 'erro';
            exit();
        }else{
            $q = "SELECT * from clientes WHERE telefone = '{$_POST['telefone']}'";
            $c = mysqli_fetch_object(mysqli_query($con, $q));
            if($c->codigo){
            }else{
                mysqli_query($con, "INSERT INTO clientes set telefone = '{$_POST['telefone']}'");
            }
        }
    }


?>

<div class="row g-0 p-2">
    <div class="card p-2">
        <h4 class="w-100 text-center">DADOS PESSOAIS</h4>
        <div class="mb-1">
            <label for="nome" class="form-label">Nome Completo</label>
            <input type="text" class="form-control formDados" autocomplete="off" value="<?=$d->nome?>" id="nome">
        </div>
        <div class="mb-1">
            <label for="cpf" class="form-label">CPF</label>
            <input type="text" class="form-control formDados" autocomplete="off" value="<?=$d->cpf?>" id="cpf">
        </div>
        <div class="mb-1">
            <label class="form-label">Telefone</label>
            <div class="form-control is-valid" ><?=$d->telefone?></div>
        </div>
        <div>
            <label for="email" class="form-label">E-mail</label>
            <input type="email" class="form-control formDados" autocomplete="off" value="<?=$d->email?>" id="email">
        </div>        
    </div>
</div>


<script>
    $(function(){

        $(".desconectar").css("display","block");

        $("#cpf").mask("999.999.999-99");

        ExecutaAtualizacao = (campo, valor)=>{
            $.ajax({
                url:"usuarios/dados.php",
                type:"POST",
                dataType:"JSON",
                data:{
                    campo,
                    valor,
                    codigo:'<?=$d->codigo?>',
                    acao:'atualizar'
                },
                success:function(dados){
                    console.log(dados)
                }
            })            
        }

        $(".formDados").keydown(function(){
            $(this).addClass("is-invalid")
            $(this).removeClass("is-valid")
        })

        $(".formDados").blur(function(){
            campo = $(this).attr("id");
            valor = $(this).val();
            console.log(campo)
            console.log(valor)
            if(campo == 'nome'){
                ExecutaAtualizacao(campo, valor);
                $(this).removeClass("is-invalid")
                $(this).addClass("is-valid")
            }else if(campo == 'cpf'){
                if(valor.length == 14){
                    ExecutaAtualizacao(campo, valor);
                    $(this).removeClass("is-invalid")
                    $(this).addClass("is-valid")
                }
            }else if(campo == 'email'){
                ExecutaAtualizacao(campo, valor);
                $(this).removeClass("is-invalid")
                $(this).addClass("is-valid")
            }
        })


        idUnico = localStorage.getItem("idUnico");

        $.ajax({
            url:"enderecos/lista_enderecos.php",
            type:"POST",
            data:{
                idUnico
            },
            success:function(dados){
                $(".dados_enderecos").html(dados);
            }
        })  

    })
</script>