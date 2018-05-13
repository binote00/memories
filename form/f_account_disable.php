<?php
/**
 * Created by PhpStorm.
 * User: Binote
 * Date: 13-05-18
 * Time: 18:32
 */

$form = new Form();

$content .= $form->CreateForm('./app/a_account_disable.php', 'POST', 'Désactiver son compte')
    ->EndForm('DESACTIVER', 'danger');