<?php
/**
 * Created by PhpStorm.
 * User: Binote
 * Date: 22-01-18
 * Time: 16:17
 */

require_once '../inc/actions.inc.php';

if(isset($_POST['email'])){

    $email_valid = DBManager::getData('user', 'id', 'email', $_POST['email'], '', '', '', 'COUNT');

    if($email_valid){
        $user = new User();
        $pass = $user->genPwd();
        $crypted_pass = password_hash($pass,PASSWORD_DEFAULT);

        $ok = DBManager::setData('user', 'pwd', $crypted_pass, 'email', $_POST['email']);

        $msg="Bonjour, \n Ce message provient du site Memories suite a une demande de nouveau mot de passe. \n Votre nouveau mot de passe est : ".$pass." \n Si vous n\'êtes pas à l'origine de cette demande, veuillez contacter les administrateurs du site.";
        mail($_POST['email'],'Memories: Mot de passe oublié', $msg);
    }
    if($ok){
        Output::ShowAlert(TXT_PWD_NEW_SEND_DONE, 'success');
    }else{
        Output::ShowAlert(TXT_PWD_NEW_SEND_FAIL, 'danger');
    }
}
header('Location: ../index.php?view=default');