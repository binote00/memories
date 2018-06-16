<?php
/**
 *
 * User: Binote
 * Date: 10-11-17
 * Time: 13:23
 */

if ($_SESSION) {
    if ($_SESSION['id']) {
        $form = new Form();
        $user = new User();
        $user->getUser($_SESSION['id']);
        $content .= $form->CreateForm('./app/a_profile_mod.php', 'POST', 'Profil utilisateur')
            ->AddInput('first_name', 'Prénom', 'text', $user->getFirstName())
            ->AddInput('last_name', 'Nom', 'text', $user->getLastName())
            ->AddInput('birth_date', 'Date de Naissance', 'date', $user->getBirthDate())
            ->AddInput('email', 'Email', 'email', $user->getEmail(), '', '', 'required')
            ->AddInput('login', 'Identifiant', 'text', $user->getLogin(), '', '', 'disabled')
            ->AddInput('pwd', 'Nouveau mot de passe', 'password', '', '', '', 'title="'.TXT_PASSWORD_CHECK.'" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^\w]).{8,}"')
            ->AddInput('id', '', 'hidden', $user->getId())
            ->EndForm('Modifier', 'danger');
    } else {
        header('Location: index.php');
    }
} else {
    header('Location: index.php');
}