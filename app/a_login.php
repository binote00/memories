<?php
/**
 * Created by PhpStorm.
 * User: Binote
 * Date: 10-11-17
 * Time: 13:26
 */

require_once '../inc/actions.inc.php';

if(isset($_POST['login'])){
    $dbh = DB::connect();
    $result = $dbh->prepare("SELECT id,login,pwd,level FROM user WHERE login=:login");
    $result->bindParam('login', $_POST['login']);
    $result->execute();
    $data = $result->fetchObject();
    if(is_object($data)){
        $id = $data->id;
        $login = $data->login;
        $pwd = $data->pwd;
        $level = $data->level;
        if(password_verify($_POST['pwd'], $pwd)){
            $_SESSION['id'] = $id;
            $_SESSION['level'] = $level;
            Output::ShowAlert(TXT_WELCOME.' '.$login);
        }else{
            Output::ShowAlert(TXT_ERROR,'danger');
        }
    }else{
        Output::ShowAlert(TXT_LOGIN_ERROR,'danger');
    }
}
header('Location: ../index.php?view=default');