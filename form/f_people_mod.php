<?php
/**
 *
 * User: Binote
 * Date: 19-05-18
 * Time: 13:18
 */

if ($user && is_object($data) && $body) {
    $form = new Form();
    $body .= $form->CreateForm('./app/a_people_mod.php', 'POST', 'Profil de la personne', true)
        ->AddInput('first_name', 'Prénom', 'text', $data->first_name, $data->first_name, true)
        ->AddInput('last_name', 'Nom', 'text', $data->last_name, $data->last_name, true)
        ->AddInput('nickname', 'Surnom', 'text', $data->nickname)
        ->AddInput('birth_date', 'Date de Naissance', 'date', $data->birth_date)
        ->AddInput('email', 'Email', 'email', $data->email)
        ->AddSelect('photolist', 'Photo depuis votre collection d\'Images', 'image', ['id', 'link', 'title', 'status'], ['OR', 'title', 'link'], 'id', ['uploader', 'status'], [$user, '0'], 'title', 'ASC')
        ->AddInput('img', 'Photo importée depuis votre ordinateur', 'file')
        ->AddInput('photo', '', 'hidden', $data->photo)
        ->AddInput('id', '', 'hidden', $data->id)
        ->EndForm('Valider');
}
