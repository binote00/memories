<?php
/**
 *
 * User: Binote
 * Date: 20-11-17
 * Time: 11:39
 */

require_once '../inc/actions.inc.php';

/*$user = new User();
echo $user->getEventsFromUser($_SESSION['id'], $_GET['event_type']);*/
if($_SESSION && $_GET['event_type']){
    if($_SESSION['id']) {
        $form_add = '';
        $form = new Form();
        if(isset($_GET['event_type'])){
            if($_GET['event_type'] == DATA_TYPE_MESSAGE){
                $form_add = $form->CreateForm('./app/a_message_add.php', 'POST', 'Ajouter un message')
                    ->AddCKEditor('message', 10, 50, '', 'Ecrivez votre message ici', true)
                    ->AddInput('event_type', '', 'hidden', DATA_TYPE_MESSAGE)
                    ->AddInput('user_id', '', 'hidden', $_SESSION['id'])
                    ->EndForm('Valider');
            }elseif($_GET['event_type'] == DATA_TYPE_IMAGE){
                $form_add = $form->CreateForm('./app/a_image_add.php', 'POST', 'Ajouter une image', true)
                    ->AddInput('title', 'Légende de l\'image')
                    ->AddInput('img[]', 'Image', 'file')
                    ->AddInput('event_type', '', 'hidden', DATA_TYPE_IMAGE)
                    ->AddInput('user_id', '', 'hidden', $_SESSION['id'])
                    ->EndForm('Valider');
            }elseif($_GET['event_type'] == DATA_TYPE_PEOPLE){
                $form_add = $form->CreateForm('./app/a_people_add.php', 'POST', 'Ajouter une personne', true)
                    ->AddInput('first_name', 'Prénom', 'text', '', '', true)
                    ->AddInput('last_name', 'Nom', 'text', '', '', true)
                    ->AddInput('nickname', 'Surnom')
                    ->AddInput('birth_date', 'Date de Naissance', 'date')
                    ->AddInput('email', 'Email', 'email')
                    ->AddInput('img', 'Photo', 'file')
                    ->AddInput('title', '', 'hidden', '')
                    ->AddInput('user_id', '', 'hidden', $_SESSION['id'])
                    ->EndForm('Valider');
            }
        }
        echo $form_add;
    }
}