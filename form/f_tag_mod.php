<?php
/**
 * User: JF
 * Date: 16-06-18
 * Time: 07:52
 */

if (isset($data[0]) && isset($form)) {
    $form_delete = $form->CreateForm('./app/a_tag_mod.php', 'POST', '')
        ->AddInput('id', '', 'hidden', $data[0])
        ->EndForm('fa fa-trash-o', 'danger');
}