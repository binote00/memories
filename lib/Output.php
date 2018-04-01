<?php
/**
 * Created by PhpStorm.
 * User: Binote
 * Date: 10-11-17
 * Time: 13:35
 */

/**
 * Mise en forme de l'affichage
 */
Trait Output
{
    /**
     * Texte au pluriel si la valeur numérique associée est supérieure à 1
     *
     * @param string $text
     * @param integer $qty
     * @param string $end
     * @return string
     */
    public static function Plural($text, $qty, $end = 's')
    {
        if ($qty > 1) {
            $text .= $end;
        }
        return $text;
    }

    /**
     * Texte en infobulle
     *
     * @param string $link
     * @param string $text
     * @return string
     */
    public static function Popup($link, $text)
    {
        return '<a href="#" class="popup">' . $link . '<span>' . $text . '</span></a>';
    }

    /**
     * Texte en alerte
     *
     * @param string $alert
     * @param string $type
     */
    public static function ShowAlert($alert, $type = 'success')
    {
        $_SESSION['alert'] = '<div class="alert alert-' . $type . '">' . $alert . '</div>';
    }

    /**
     * Texte en alerte désactivable
     *
     * @param string $alert
     * @param string $type
     * @param bool $dismiss
     * @return string
     */
    public static function ShowAdvert($alert, $type = 'success', $dismiss = false)
    {
        if ($dismiss) {
            return '<div class="alert alert-' . $type . ' alert-dismissible fade show" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
              ' . $alert . '
            </div>';
        } else {
            return '<div class="alert alert-' . $type . '">' . $alert . '</div>';
        }
    }

    /**
     * Texte en alerte des tâches de Dev à réaliser
     *
     * @param array|string $alert
     * @param string $type
     * @param bool $dismiss
     * @return string
     */
    public static function ShowToDo($alert, $type = 'warning', $dismiss = false)
    {
        if (is_array($alert)) {
            $alert_txt = '<b>TODO</b><ul>';
            foreach ($alert as $data) {
                $alert_txt .= '<li>' . $data . '</li>';
            }
            $alert_txt .= '</ul>';
        } else {
            $alert_txt = $alert;
        }
        if ($dismiss) {
            return '<div class="alert alert-' . $type . ' alert-dismissible fade show" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
              ' . $alert_txt . '
            </div>';
        } else {
            return '<div class="alert alert-' . $type . '">' . $alert_txt . '</div>';
        }
    }

    /**
     * @param string $src
     * @param string $alt
     * @param string $sub
     * @param int $scale
     * @return string
     */
    public static function ShowImage($src, $alt, $sub = '', $scale = 100)
    {
        return '<img src="img/' . $sub . $src . '" alt="' . $alt . '" class="img-fluid mx-auto d-block" width="' . $scale . '%">';
    }

    /**
     * Générateur de table dynamique avec arrays de données et de titres de colonnes
     *
     * @param array|mixed $data
     * @param array|mixed $cols
     * @param string $title
     * @return string
     */
    public static function Table($data, $cols, $title = '')
    {
        $thead = '';
        $tbody = '';
        if (is_array($cols)) {
            foreach ($cols as $th) {
                $thead .= '<th>' . $th . '</th>';
            }
        } else {
            $thead = '<th>' . $cols . '</th>';
        }
        if (is_array($data)) {
            foreach ($data as $sub) {
                $tbody .= '<tr>';
                foreach ($sub as $key => $value) {
                    if (is_int($key)) {
                        $tbody .= '<td>' . $value . '</td>';
                    }
                }
                $tbody .= '</tr>';
            }
        } else {
            $tbody .= '<tr><td>' . $data . '</td></tr>';
        }
        return '<h2>' . $title . '</h2><table class="table table-responsive table-striped"><thead class="thead-inverse"><tr>' . $thead . '</tr></thead><tbody>' . $tbody . '</tbody></table>';
    }

    /**
     * Générateur de table dynamique avec tbody
     *
     * @param array|string $heads
     * @param string $tbody
     * @param string $title
     * @return string
     */
    public static function TableHead($heads, $tbody, $title = '')
    {
        $thead = '';
        if (is_array($heads)) {
            foreach ($heads as $th) {
                $thead .= '<th>' . $th . '</th>';
            }
        } else {
            $thead = '<th>' . $heads . '</th>';
        }
        return '<h2>' . $title . '</h2><table class="table table-responsive table-striped"><thead class="thead-inverse"><tr>' . $thead . '</tr></thead><tbody>' . $tbody . '</tbody></table>';
    }

    /**
     * Bouton Modal bootstrap
     *
     * @param string $target_id
     * @param string $btn_text
     * @param string $btn_class
     * @return string
     */
    public static function btnModal($target_id, $btn_text, $btn_class = 'primary')
    {
        return '<button type="button" class="btn btn-' . $btn_class . '" data-toggle="modal" data-target="#' . $target_id . '">' . $btn_text . '</button>';
    }

    /**
     * Bouton Modal avec contenu du modal généré en JavaScript
     *
     * @param string $target_id
     * @param string $btn_text
     * @param string $modal_title
     * @param string $modal_body
     * @param string $modal_footer
     * @param string $btn_class
     * @return string
     */
    public static function btnModalJS($target_id, $btn_text, $modal_title, $modal_body, $modal_footer = '', $btn_class = 'primary')
    {
        return '<button type="button" class="btn btn-' . $btn_class . '" data-toggle="modal" data-target="#' . $target_id . '" 
        data-title="' . $modal_title . '" data-body="' . $modal_body . '" data-footer="' . $modal_footer . '">' . $btn_text . '</button>';
    }

    /**
     * Générateur de Modal avec contenu généré en Javascript
     *
     * @param string $modal_id
     * @param string $modal_size
     * @return string
     */
    public static function viewModalJS($modal_id, $modal_size = '')
    {
        if ($modal_size == 'lg') {
            $modal_size = ' modal-lg';
        }
        return '<div class="modal modal-js fade" tabindex="-1" id="' . $modal_id . '">
          <div class="modal-dialog' . $modal_size . '">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">               
              </div>
              <div class="modal-footer">            
              </div>
            </div>
          </div>
        </div>';
    }

    /**
     * Générateur de Modal bootstrap
     *
     * @param string $modal_id
     * @param string $modal_title
     * @param string $modal_body
     * @param string $modal_footer
     * @param string $modal_size
     * @return string
     */
    public static function viewModal($modal_id, $modal_title, $modal_body, $modal_footer = '', $modal_size = '')
    {
        if ($modal_size == 'lg') {
            $modal_size = ' modal-lg';
        }
        return '<div class="modal fade" tabindex="-1" id="' . $modal_id . '">
          <div class="modal-dialog' . $modal_size . '">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">' . $modal_title . '</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                ' . $modal_body . '
              </div>
              <div class="modal-footer">
                ' . $modal_footer . '
              </div>
            </div>
          </div>
        </div>';
    }

    /**
     * Générateur de card bootstrap pour l'affichage des images de la DB
     *
     * @param int $user
     * @param int $id
     * @param int $type
     * @param string $mod_script
     * @param mixed $data
     * @param string $label
     * @param string $img
     * @param string $text
     * @param bool $chk_data_del
     * @return string
     */
    public static function viewCard($user, $id, $type, $mod_script, $data, $label, $img = '', $text = '', $chk_data_del = false)
    {
        //            ->AddSelect('tag_id', 'Tag', 'tag', ['id','tag_name'], 'tag_name', 'id', 'user_id', $user, 'tag_name', 'ASC', true)
        /*$query = "SELECT DISTINCT t.id,t.tag_name FROM tag as t
        LEFT JOIN tag_link as tl ON t.id=tl.tag_id AND tl.data_type=2
        LEFT JOIN image as i ON i.id=tl.data_id
        WHERE user_id=$user AND t.id NOT IN (SELECT tag_id FROM tag_link WHERE data_type=2 AND data_id=$id)";
        $dbh = DB::connect();
        $result = $dbh->prepare($query);
        $result->execute();*/

        $o_user = new User();
        $result = $o_user->getTagsByType($user, $type, $id);

        $form = new Form();

        if ($type == DATA_TYPE_IMAGE) {
            if ($chk_data_del) {
                $form_del = '' . $form->CreateForm('./app/a_image_restore.php', 'POST', '')
                        ->AddInput('id', '', 'hidden', $id)
                        ->AddInput('user_id', '', 'hidden', $user)
                        ->EndForm('fa fa-undo fa-2x', 'primary');
                $img_popup = 'Cette image a été supprimée. Si vous voulez la récupérer, veuillez cliquer sur <i class="fa fa-undo"></i>';
                $bg_class = ' bg-del';
            } else {
                $form_txt = $form->CreateForm($mod_script, 'POST', '')
                    ->AddInput('title', $label, 'text', $data)
                    ->AddSelectData('tag_id', '#Tag', $result, 'tag_name', 'id', true)
                    ->AddInput('id', '', 'hidden', $id)
                    ->AddInput('user_id', '', 'hidden', $user)
                    ->EndForm('Modifier', 'primary');
                $form_del = '' . $form->CreateForm('./app/a_image_del.php', 'POST', '')
                        ->AddInput('id', '', 'hidden', $id)
                        ->AddInput('user_id', '', 'hidden', $user)
                        ->EndForm('fa fa-trash-o fa-2x', 'danger');
                list($width, $height) = getimagesize("img/" . $img);
                if ($width > $height) {
                    $img_popup = '<img src="img/' . $img . '" class="mx-auto d-block img-popup-l">';
                } else {
                    $img_popup = '<img src="img/' . $img . '" class="img-fluid mx-auto d-block img-popup-h">';
                }
                $btn_edit = '<div class="col-6 d-flex justify-content-center align-items-center"><i class="fa fa-pencil-square-o fa-2x text-primary" data-toggle="collapse" data-target="#f-image-mod-collapse-' . $id . '"></i></div>';
            }
            $top_card = '
                    <div class="' . $bg_class . '" style="padding: 5px;">
                        <a href="#" class="popup-light">
                            <img src="img/' . $img . '" alt="' . $data . '" class="img-fluid mx-auto d-block img-card" style="max-height: 200px;">
                            <span>' . $img_popup . '</span>
                        </a>          
                    </div>';
        }

        return '<div class="card col-xs-12 col-md-6 col-lg-4">
                    ' . $top_card . '
                    <div class="card-block' . $bg_class . '">
                        <h4 class="card-title"></h4>
                        <p class="card-text">' . $text . '</p>    
                        <div class="row">
                            ' . $btn_edit . '
                            <div class="col-6 d-flex justify-content-center align-items-center">' . $form_del . '</div>
                        </div>
                    </div>
                    <div class="card-footer collapse" id="f-image-mod-collapse-' . $id . '">
                    ' . $form_txt . '
                    </div>
                </div>';
    }

    /**
     * @param $data
     * @return string
     */
    public static function viewTimelineData($data)
    {
        $emotion_q = DBManager::getData('emotion', 'em_name', 'id', $data->getEmotion(), '', '', '', 'OBJECT');
        $event_type_q = DBManager::getData('events_type', 'event_name', 'id', $data->getEventType(), '', '', '', 'OBJECT');

        return '<div class="timeline__item">
                    <div class="timeline__content">
                        <h2>'.$data->time.'</h2>
                        <h2>'.ucfirst($event_type_q->event_name).'</h2><p>' . $emotion_q->em_name .'</p>
                    </div>
                </div>';
    }
}


