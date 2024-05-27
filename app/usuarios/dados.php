<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/painel/lib/includes.php");

    if($_POST['idUnico']){
        $_SESSION['idUnico'] = $_POST['idUnico'];
    }

    if($_POST['acao'] == 'atualizar'){
        mysqli_query($con, "update customers set {$_POST['campo']} = '".addslashes($_POST['valor'])."' where id = '{$_POST['id']}'");
        $retorno = [
            'status' => 'success',
            'idUnico' => $_SESSION['idUnico'],
        ];
        echo json_encode($retorno);
        exit();
    }

    // if($_POST['telefone']){
    //     $telefone = str_replace(['-',' ','(',')'],false,trim($_POST['telefone']));
    //     if(strlen($telefone) != 11){
    //         echo 'erro';
    //         exit();
    //     }else{
    //         $q = "SELECT * from customers WHERE telefone = '{$_POST['telefone']}'";
    //         $c = mysqli_fetch_object(mysqli_query($con, $q));
    //         if($c->codigo){
    //         }else{
    //             mysqli_query($con, "INSERT INTO customers set telefone = '{$_POST['telefone']}'");
    //         }
    //     }
    // }

    $query = "select * from customers where device = '{$_SESSION['idUnico']}'";
    $result = mysqli_query($con, $query);
    $d = mysqli_fetch_object($result);


?>

<div class="row g-0 p-2">
    <div class="card p-2">
        <h4 class="w-100 text-center">DADOS PESSOAIS</h4>
        <div class="mb-1">
            <label for="name" class="form-label">Nome Completo</label>
            <input type="text" class="form-control formDados" autocomplete="off" value="<?=$d->name?>" id="name">
        </div>
        <div class="mb-1">
            <label for="phone" class="form-label">Phone</label>
            <input type="text" class="form-control formDados" autocomplete="off" value="<?=$d->phone?>" id="phone">
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

        ExecutaAtualizacao = (campo, valor)=>{
            $.ajax({
                url:"usuarios/dados.php",
                type:"POST",
                dataType:"JSON",
                data:{
                    campo,
                    valor,
                    id:'<?=$d->id?>',
                    acao:'atualizar'
                },
                success:function(dados){
                    console.log(dados)
                }
            })            
        }

        // $(".formDados").keydown(function(){
        //     $(this).addClass("is-invalid")
        //     $(this).removeClass("is-valid")
        // })

        $(".formDados").blur(function(){
            campo = $(this).attr("id");
            valor = $(this).val();
            console.log(campo)
            console.log(valor)
            if(campo == 'name'){
                ExecutaAtualizacao(campo, valor);
                $(this).removeClass("is-invalid")
                $(this).addClass("is-valid")
            }else if(campo == 'phone'){
                ExecutaAtualizacao(campo, valor);
                $(this).removeClass("is-invalid")
                $(this).addClass("is-valid")
            }else if(campo == 'email'){
                ExecutaAtualizacao(campo, valor);
                $(this).removeClass("is-invalid")
                $(this).addClass("is-valid")
            }
        })


        // idUnico = localStorage.getItem("idUnico");

        // $.ajax({
        //     url:"enderecos/lista_enderecos.php",
        //     type:"POST",
        //     data:{
        //         idUnico
        //     },
        //     success:function(dados){
        //         $(".dados_enderecos").html(dados);
        //     }
        // })  

    })
</script>