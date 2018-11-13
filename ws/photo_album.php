<?php
/**
 * Webservice Photo Album
 * User: JF
 * Date: 05-04-18
 * Time: 13:43
 */

if (isset($_GET['id']) && isset($_GET['tag'])) {
    require_once '../inc/actions.inc.php';
    if ($_GET['id'] > 0 && $_GET['tag'] > 0) {
        $user = new User();
        $user->getUser($_GET['id']);
        $tags = $user->getTags($user->getId());
        if (!in_array_r($_GET['tag'], $tags)) {
            echo 'PARAM NOT VALID-';
        } else {
            $data = $user->getImagesFromUserByTag($user->getId(), $_GET['tag'], 50, true);
        }
        //Output
        header('Content-type: application/json');
        echo json_encode(['data' => $data]);
    } else {
        echo 'PARAM NOT VALID';
    }
} else {
    echo 'PARAM MISSING';
}

function in_array_r($needle, $haystack, $strict = false)
{
    foreach ($haystack as $item) {
        if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && in_array_r($needle, $item, $strict))) {
            return true;
        }
    }
    return false;
}
