<?php
/**
 *
 * User: JF
 * Date: 17-01-18
 * Time: 14:49
 */

if(isset($_SESSION['id'])) {
    $modal_body = Output::ShowAdvert(TXT_UPLOAD_ERROR.'<br>'.TXT_IMAGE_MAX_SIZE.' 2Mo','danger');
    if ($modal_body) {
        $content .= Output::viewModal('modal-alert-img-size', TXT_IMAGE_ADD_FAIL, $modal_body, '');
    }
}
