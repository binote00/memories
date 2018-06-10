<?php
/**
 *
 * User: JF
 * Date: 13-01-18
 * Time: 13:05
 */

if($_SESSION){
    if($_SESSION['id']){
        $form = new Form();
        $content = $form->CreateForm('./app/m_bug_add.php', 'POST', 'Signaler un bug')
            ->AddCKEditor('desc', 10, 50, '', 'Ecrivez ici une courte description du bug', 'required')
            ->AddInput('error', 'Message d\'erreur', 'text', '', 'Collez ici un éventuel message d\'erreur')
            ->AddInput('user_id', '', 'hidden', $_SESSION['id'])
            ->EndForm('Valider');
    }
}