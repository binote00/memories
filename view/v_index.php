<?php
/**
 *
 * User: Binote
 * Date: 09-11-17
 * Time: 10:08
 */

$txt_intro = '';
$intro_nbr = TXT_INTRO_NBR + 1;
for ($i = 1; $i < $intro_nbr; $i++) {
    $var = 'txt_intro_' . $i;
    $txt_intro .= '<li>' . $$var . '</li>';
}
$img_index = '<div class="img-index-lg">' . Output::ShowImage('memories.jpg', TXT_TITLE) . '</div>
                <div class="img-index-sx">' . Output::ShowImage('memories_sx.jpg', TXT_TITLE) . '</div>';

if (!isset($_SESSION['id'])) {
    $register = '<p><a href="?view=register" class="btn btn-primary">' . TXT_SIGNIN . '</a></p>';
    $recover = '<p><a href="index.php?view=password_recover" class="btn btn-primary">Mot de passe oublié</a></p>';
    include_once __DIR__ . '/../form/f_login.php';
    $alerts = '
    <div class="row">
        <div class="col-12 text-center color-primary-0">
            <h1>Bienvenue sur Memories</h1>
        </div>
    </div>
    <div class="row mb-5">
        <div class="col-md-5">
            <div class="card">
                <div class="card-block">
                    <p class="card-text">' . $content . '</p>    
                </div>
            </div>
        </div>
        <div class="col-md-7">
            <div class="card">
                <div class="card-block">
                    <div class="card-text color-primary-2"><p class="font-weight-bold" style="font-size: 1rem;">' . TXT_INTRO . '</p><ul>' . $txt_intro . '</ul></div>    
                </div>
            </div>    
            <div class="card">
                <div class="card-block">
                    <div class="row">
                        <div class="col-6">' . $register . '</div>
                        <div class="col-6">' . $recover . '</div>
                    </div>
                </div>
            </div>
        </div>
    </div>';
    $content = $img_index;
} else {
    $content = Output::ShowAdvert('<p>' . TXT_INTRO . '</p><ul>' . $txt_intro . '</ul>', 'info', true) . $img_index;
}