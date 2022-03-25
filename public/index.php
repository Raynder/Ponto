<?php
session_start();
include './../app/autoload.php';
include './../app/config.php';
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet"> -->
    <link href="<?= DIST ?>css/style.css" rel="stylesheet">


    <script defer src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script defer src="<?= DIST ?>js/jquery.mask.min.js"></script>
    <script defer src="<?= DIST ?>js/sweetAlert.js"></script>
    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script defer src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script defer src="<?= DIST ?>js/main.js"></script>

    <title><?= APP_NOME ?></title>
</head>

<body>

    <?php
    $rotas = new Rota();
    ?>


</body>

<script>
    function alerta(frase, status = '') {
        console.log(status);
        if (status == '') {
            swal.fire(frase);
        } else {
            Swal.fire(
                '',
                frase,
                status
            )
        }
    }
</script>



</html>