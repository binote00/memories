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
//require_once './inc/text.inc.php';
$txt_intro = '';
$intro_nbr = TXT_INTRO_NBR + 1;
for ($i=1; $i < $intro_nbr; $i++) {
    $var = 'txt_intro_'.$i;
    $txt_intro .= '<li>'.$$var.'</li>';
}

$alerts .= Output::ShowAdvert('<p>'.TXT_INTRO.'</p><ul>'.$txt_intro.'</ul>', 'info', true);
if(!isset($_SESSION['id'])){
    include_once __DIR__.'/../form/f_login.php';
    $content.='<p><a href="?view=register" class="btn btn-danger">'.TXT_SIGNIN.'</a></p>';
    $content.='<p><a href="index.php?view=password_recover">Mot de passe oublié</a></p>';
}