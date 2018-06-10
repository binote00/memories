<?php
/**
 *
 * User: Binote
 * Date: 10-11-17
 * Time: 13:27
 */

$form = new Form();

$content .= $form->CreateForm('./app/a_login.php','POST', 'Se connecter')
    ->AddInput('login', 'Identifiant', 'text', '', '', '', 'required')
    ->AddInput('pwd', 'Mot de passe', 'password', '', '', '', 'required')
    ->EndForm('Valider');