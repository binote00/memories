<?php
/**
 *
 * User: Binote
 * Date: 16-11-17
 * Time: 13:10
 */

if($_SESSION){
    if($_SESSION['id']) {
        $form = new Form();
        $content .= $form->CreateForm('./app/a_message_add.php', 'POST', TXT_MESSAGE_ADD)
            ->AddCKEditor('message', 10, 50, '', TXT_WRITE_HERE, true)
            ->AddSelect('emotion', TXT_EMOTION, 'emotion', ['id', 'em_name'], 'em_name', 'id', '', '', 'em_name', 'ASC')
            ->AddSelectNumber('note', TXT_NOTE, 0, 10)
            ->AddSelect('tag', 'Tag', 'tag', ['id','tag_name'], 'tag_name', 'id', 'user_id', $_SESSION['id'], 'tag_name', 'ASC', true)
            ->AddInput('event_type', '', 'hidden', DATA_TYPE_MESSAGE)
            ->AddInput('user_id', '', 'hidden', $_SESSION['id'])
            ->EndForm(TXT_CONFIRM);
    }
}