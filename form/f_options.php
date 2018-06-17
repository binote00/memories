<?php
/**
 *
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
        $user_lang_value = $param->getParamValue($user->getId(), 2);
        $app_color_value = $param->getParamValue($user->getId(), 5);
        if ($event_auto_tag_value) {
            $event_auto_tag_default_value = 0;
            $event_auto_tag_value = 0;
        } else {
            $event_auto_tag_default_value = 1;
        }
        $content = $form->CreateForm('./app/a_options.php', 'POST', 'Paramètres utilisateur')
            ->AddSelectArray('user_lang', 'Langue de l\'application', [0 => 'Français', 1 => 'English', 2 => 'Nederlands'], '', 'disabled')
//            ->AddSelect('app_color', 'Couleur de base de l\'application', 'theme_color', ['id', 'hex', 'css', 'name'], 'name', 'id', '', '', 'name')
//            ->AddInput('app_color', 'Couleur de base de l\'application', 'color', $app_color_value, '', '', 'disabled')
            ->AddSelectNumber('cards_per_page', 'Images par page', 1, 21, $cards_per_page_value)
            ->AddCheckbox('event_auto_tag', [$event_auto_tag_default_value => TXT_EVENT_AUTO_TAG], false, $event_auto_tag_value)
            ->AddInput('id', '', 'hidden', $user->getId())
            ->AddInput('cards_per_page_ori', '', 'hidden', $cards_per_page_value)
            ->AddInput('event_auto_tag_ori', '', 'hidden', $event_auto_tag_value)
            ->EndForm('Modifier', 'danger');
        include_once 'f_theme_color.php';
    } else {
        header('Location: index.php?view=login');
    }
} else {
    header('Location: index.php?view=login');
}