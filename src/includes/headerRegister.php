<?php
session_start();
require_once "../../API/functions.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teste Tecnico</title>
    <link rel="icon" href="https://upload.wikimedia.org/wikipedia/commons/thumb/2/27/PHP-logo.svg/1200px-PHP-logo.svg.png">
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" type="text/javascript"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"
        integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script type="text/javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
    <script src="../js/scripts.js"></script>

    <div class="alert-box alert-box-success">
        <div class="container">
            <button class="btn btn-light" onclick="closeAlertBox()">
                Continuar
            </button>
            <a href="" class="btn-link" style="display: none;">
                <button class="btn btn-light">
                    Continuar
                </button>
            </a>
            <div class="row">
                <div class="my-auto mx-auto text-center">
                    <div class="swal2-icon swal2-success swal2-animate-success-icon" style="display: flex;">
                        <div class="swal2-success-circular-line-left" style="background-color: rgb(255, 255, 255);"></div>
                        <span class="swal2-success-line-tip"></span>
                        <span class="swal2-success-line-long"></span>
                        <div class="swal2-success-ring"></div> 
                        <div class="swal2-success-fix" style="background-color: rgb(255, 255, 255);"></div>
                        <div class="swal2-success-circular-line-right" style="background-color: rgb(255, 255, 255);"></div>
                    </div>
                    <p class="msg"></p>
                </div>
            </div>
        </div>
    </div>
    
</head>

<body>
