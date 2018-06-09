<?php
/**
 * Created by PhpStorm.
 * User: Binote
 * Date: 13-05-18
 * Time: 18:32
 */

$form = new Form();

$content .= $form->CreateForm('./app/a_account_disable.php', 'POST', TXT_ACCOUNT_DISABLE)
    ->EndForm('DESACTIVER', 'danger');