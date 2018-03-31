<?php
/**
 * Created by PhpStorm.
 * User: Binote
 * Date: 16-11-17
 * Time: 13:10
 */
if($_SESSION){
    if($_SESSION['id']) {
        //$result = $user->getTags($_SESSION['id'], 1, $id);

        $form = new Form();
        $content .= $form->CreateForm('./app/a_message_add.php', 'POST', 'Ajouter un message')
            ->AddCKEditor('message', 10, 50, '', 'Ecrivez votre message ici', true)
            ->AddSelect('emotion', 'Emotion', 'emotion', ['id', 'em_name'], 'em_name', 'id', '', '', 'em_name', 'ASC')
            ->AddSelectNumber('note', 'Evaluation', 0, 10)
            ->AddSelect('tag', 'Tag', 'tag', ['id','tag_name'], 'tag_name', 'id', 'user_id', $_SESSION['id'], 'tag_name', 'ASC', true)
            ->AddInput('event_type', '', 'hidden', DATA_TYPE_MESSAGE)
            ->AddInput('user_id', '', 'hidden', $_SESSION['id'])
            ->EndForm('Valider');
    }
}