<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/painel/lib/includes.php");

    if($_POST['exit']) $_SESSION = [];

    if($_POST['AppUsuario']) $_SESSION['AppUsuario'] = $_POST['AppUsuario'];


?>