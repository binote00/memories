<?php
/**
 *
 * User: Binote
 * Date: 10-11-17
 * Time: 09:55
 */

$form = new Form();

$content = $form->CreateForm('./app/a_register.php', 'POST', TXT_SIGNIN)
    ->AddInput('first_name', 'Prénom')
    ->AddInput('last_name', 'Nom')
    ->AddInput('birth_date', 'Date de Naissance', 'date')
    ->AddInput('email', 'Email', 'email', '', '', '', 'required')
    ->AddInput('login', 'Identifiant', 'text', '', '', '', 'required')
    ->AddInput('pwd', 'Mot de passe', 'password', '', '', '', 'required title="' . TXT_PASSWORD_CHECK . '" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^\w]).{8,}"')
    ->AddInput('pwd2', 'Confirmation du mot de passe', 'password', '', '', '', 'required title="' . TXT_PASSWORD_CHECK . '" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^\w]).{8,}"')
    ->EndForm('Valider');