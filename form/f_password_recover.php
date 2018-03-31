<?php
/**
 * Created by PhpStorm.
 * User: Binote
 * Date: 22-01-18
 * Time: 16:14
 */

$form = new Form();

$content = $form->CreateForm('./app/a_password_recover.php','POST', TXT_PWD_RECOVER)
    ->AddInput('email', 'Email', 'text', 'email', '', '', 'required')
    ->EndForm('Valider');