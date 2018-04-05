<?php
/**
 * Created by PhpStorm.
 * User: JF
 * Date: 05-04-18
 * Time: 08:43
 */

if ($_SESSION) {
    if ($_SESSION['id']) {
        $form = new Form();
        $user = new User();
        $param = new Param();
        $user->getUser($_SESSION['id']);
        $cards_per_page_value = $param->getParamValue($user->getId(), 1);
        $event_auto_tag_value = $param->getParamValue($user->getId(), 3);
        $content = $form->CreateForm('./app/a_options.php', 'POST', 'Paramètres utilisateur')
            ->AddSelectNumber('cards_per_page', 'Images par page', 1, 21, $cards_per_page_value)
            ->AddCheckbox('event_auto_tag', ['1' => TXT_EVENT_AUTO_TAG], $event_auto_tag_value)
            ->AddInput('id', '', 'hidden', $user->getId())
            ->EndForm('Modifier', 'danger');
    } else {
        header('Location: index.php?view=login');
    }
} else {
    header('Location: index.php?view=login');
}