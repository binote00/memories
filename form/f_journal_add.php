<?php
/**
 * Created by PhpStorm.
 * User: Binote
 * Date: 16-11-17
 * Time: 13:10
 */
if($_SESSION){
    if($_SESSION['id']) {
        $form = new Form();
        $form_add = '<h2>Ajouter un élément</h2>'.$form->AddSelect('event_type', 'Catégorie', 'data_type', ['id', 'data_name'], 'data_name', 'id', '', '', 'data_name','ASC')
                    ->getOutput();
    }
}
