<?php
/**
 * User: JF
 * Date: 17-06-18
 * Time: 12:34
 */

if (isset($user) && is_object($user)) {
    $content .= $form->CreateForm('./app/a_options.php', 'POST', 'Couleur de base de l\'application')
        ->AddColors()
        ->AddInput('id', '', 'hidden', $user->getId())
        ->EndForm('Modifier', 'danger');
}
