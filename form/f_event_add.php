<?php
/**
 * Created by PhpStorm.
 * User: Binote
 * Date: 30-11-17
 * Time: 11:53
 */

if($_SESSION){
    if($_SESSION['id']) {
        $form = new Form();
        $content .= $form->CreateForm('./app/a_event_add.php', 'POST', 'Ajouter un évènement')
            ->AddInput('moment', 'Date', 'date', '', '', '', 'required')
            ->AddSelect('event_type', 'Catégorie', 'events_type', ['id', 'event_name'], 'event_name', 'id', '', '', 'event_name', 'ASC', false, true)
            ->AddSelect('emotion', 'Emotion', 'emotion', ['id', 'em_name'], 'em_name', 'id', '', '', 'em_name', 'ASC')
            ->AddSelectNumber('note', 'Evaluation', 0, 10)
            ->AddSelect('tag', 'Tag', 'tag', ['id','tag_name'], 'tag_name', 'id', 'user_id', $_SESSION['id'], 'tag_name', 'ASC', true)
            ->AddInput('user_id', '', 'hidden', $_SESSION['id'])
            ->EndForm('Valider');
    }
}