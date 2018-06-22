<?php
/**
 *
 * User: Binote
 * Date: 30-11-17
 * Time: 14:45
 */

if ($_SESSION) {
    if ($_SESSION['id']) {
        $form = new Form();
        $user = new User();
        $user->getUser($_SESSION['id']);

        $content = $form->CreateForm('./app/a_images_add.php', 'POST', 'Images', true)
            ->AddInput('img[]', 'Ajouter', 'file', '', '', '', 'required multiple')
            ->AddSelect('tag', 'Tag', 'tag', ['id','tag_name'], 'tag_name', 'id', 'user_id', $_SESSION['id'], 'tag_name', 'ASC', true)
            ->AddInput('user_id', '', 'hidden', $_SESSION['id'])
            ->EndForm('Valider');
    } else {
        header('Location: index.php');
    }
} else {
    header('Location: index.php');
}