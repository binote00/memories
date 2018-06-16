<?php
/**
 * User: JF
 * Date: 16-06-18
 * Time: 07:52
 */

if (isset($data[0]) && isset($form) && isset($user)) {
    $form_tr = $form->CreateForm('./app/a_tag_tr.php', 'POST', '')
        ->AddSelect('tag_id', 'Nouveau Tag', 'tag', ['id', 'tag_name'], 'tag_name', 'id', 'user_id', $user, 'tag_name', 'ASC')
        ->AddInput('id', '', 'hidden', $data[0])
        ->EndForm('Modifier', 'primary');
}