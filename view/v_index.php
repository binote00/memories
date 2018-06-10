<?php
/**
 *
 * User: Binote
 * Date: 09-11-17
 * Time: 10:08
 */
?>
<h1>Bienvenue sur le site Memories</h1>
<?php
$alerts .= Output::ShowAdvert('<p>Ce site a pour but d\'offrir aux utilisateurs un espace où ils pourront consigner leur vécu ou leurs souvenirs sous différentes formes (texte, image, vidéo, données, fichiers, etc...) sans que ce contenu ne doive être visible ou partagé avec qui que ce soit, et sans qu\'aucune publicité, annonce ou contenu extérieur ne vienne se mêler à leur contenu privé.</p>
<p>Ce site est actuellement en développement.<br>Vous pouvez l\'utiliser à des fins de test en veillant à signaler tout bug via ce <a href="?view=bug">formulaire</a></p>', 'info', true);
if(!isset($_SESSION['id'])){
    include_once __DIR__.'/../form/f_login.php';
    $content.='<p><a href="?view=register" class="btn btn-danger">'.TXT_SIGNIN.'</a></p>';
    $content.='<p><a href="index.php?view=password_recover">Mot de passe oublié</a></p>';
}