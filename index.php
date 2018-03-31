<?php
/**
 * Created by PhpStorm.
 * User: JF
 * Date: 22-10-17
 * Time: 12:42
 */
require_once 'inc/index.inc.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="JF Binote">
    <title>Memories</title>
    <link rel="stylesheet" href="./css/jquery-ui.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons">
    <link rel="stylesheet"
          href="https://unpkg.com/bootstrap-material-design@4.0.0-beta.4/dist/css/bootstrap-material-design.min.css"
          integrity="sha384-R80DC0KVBO4GSTw+wZ5x2zn2pu4POSErBkf8/fSFhPXHxvHJydT0CSgAP2Yo2r4I" crossorigin="anonymous">
    <!--<link href="./css/bootstrap.min.css" rel="stylesheet">-->
    <link rel="stylesheet" type="text/css"
          href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.16/af-2.2.2/b-1.5.1/b-colvis-1.5.1/b-flash-1.5.1/b-html5-1.5.1/b-print-1.5.1/cr-1.4.1/fc-3.2.4/fh-3.1.3/kt-2.3.2/r-2.2.1/rg-1.0.2/rr-1.2.3/sc-1.4.3/sl-1.2.4/datatables.min.css"/>
    <!--<link href="./css/datatables.min.css" rel="stylesheet">-->
    <link href="./css/font-awesome.min.css" rel="stylesheet">
    <link href="./css/main.css" rel="stylesheet">
    <script src="./ckeditor/ckeditor.js"></script>
</head>
<body>
<header>
    <?php require_once 'inc/nav.inc.php'; ?>
</header>
<div class="container header-wrap">
    <span class="text-hide" id="sess-id"><?php if (isset($_SESSION['id'])) echo $_SESSION['id']; ?></span>
    <?php if ($view) require_once 'view/v_' . $view . '.php'; ?>
    <div id="alerts"><?= $alerts ?></div>
    <div id="content"><?= $content ?></div>
</div>
<!--<footer class="text-center text-success fixed-bottom">&copy;JF-2017 <p><?php //var_dump($_SESSION);?></p></footer>-->
<script src="./js/jquery-3.2.1.min.js"></script>
<script src="./js/jquery-ui.min.js"></script>
<script src="https://unpkg.com/popper.js@1.12.6/dist/umd/popper.js"
        integrity="sha384-fA23ZRQ3G/J53mElWqVJEGJzU0sTs+SvzG8fXVWP+kJQ1lwFAOkcUOysnlKJC33U"
        crossorigin="anonymous"></script>
<script src="./js/tether.min.js"></script>
<script src="https://unpkg.com/bootstrap-material-design@4.0.0-beta.4/dist/js/bootstrap-material-design.js"
        integrity="sha384-3xciOSDAlaXneEmyOo0ME/2grfpqzhhTcM4cE32Ce9+8DW/04AGoTACzQpphYGYe"
        crossorigin="anonymous"></script>
<!--<script>$(document).ready(function() { $('body').bootstrapMaterialDesign(); });</script>-->
<!--<script src="./js/bootstrap.min.js"></script>
<script src="./js/datatables.min.js"></script>-->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
<script type="text/javascript"
        src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.16/af-2.2.2/b-1.5.1/b-colvis-1.5.1/b-flash-1.5.1/b-html5-1.5.1/b-print-1.5.1/cr-1.4.1/fc-3.2.4/fh-3.1.3/kt-2.3.2/r-2.2.1/rg-1.0.2/rr-1.2.3/sc-1.4.3/sl-1.2.4/datatables.min.js"></script>
<script src="./js/ajax.js"></script>
<script>
    CKEDITOR.replace('ckeditor');
    var elements = CKEDITOR.document.find('.ck-inline'),
        i = 0,
        element;
    while ((element = elements.getItem(i++))) {
        CKEDITOR.inline(element);
    }
</script>
</body>
</html>


