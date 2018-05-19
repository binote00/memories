<?php
/**
 * Created by PhpStorm.
 * User: Binote
 * Date: 09-11-17
 * Time: 10:25
 */

/**
 * Générateur de Formulaire HTML dynamique
 */
class Form
{
    private $id;
    private $output;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getOutput()
    {
        return $this->output;
    }

    /**
     * @param mixed $output
     */
    public function setOutput($output): void
    {
        $this->output = $output;
    }

    /**
     * Création de formulaire HTML générique avec classes Bootstrap : Première méthode obligatoire
     *
     * @param string $action
     * @param string $method
     * @param string $title
     * @param bool $enc_type
     * @return object $this
     */
    public function CreateForm($action, $method = 'GET', $title = '', $enc_type = false)
    {
        $this->setId(uniqid());
        $enc_txt = '';
        if ($enc_type) {
            $enc_txt = ' enctype="multipart/form-data"';
        }
        if ($title) {
            $title = '<h2>' . $title . '</h2>';
        }
        $this->output = $title . '<form action="' . $action . '" method="' . $method . '"' . $enc_txt . '>';
        return $this;
    }

    /**
     * Création de formulaire HTML générique avec classes Bootstrap : Méthode finale obligatoire
     *
     * @param string $btnValue
     * @param string $btnClass
     * @return string
     */
    public function EndForm($btnValue, $btnClass = 'primary')
    {
        //Font-Awesome button
        if (substr($btnValue, 0, 2) == 'fa') {
            $this->output .= '<button type="submit" class="btn btn-' . $btnClass . '"><i class="' . $btnValue . '"></i></button></form>';
        } else {
            $this->output .= '<input type="submit" class="btn btn-' . $btnClass . '" value="' . $btnValue . '"></form>';
        }
        return $this->output;
    }

    /**
     * Création de formulaire HTML générique avec classes Bootstrap : Ajout d'un input
     *
     * @param string $name
     * @param string $label
     * @param string $type [text | hidden | email | password | date | file]
     * @param string $value
     * @param string $placeholder
     * @param string $class
     * @param string $attr
     * @return object $this
     */
    public function AddInput($name, $label, $type = 'text', $value = '', $placeholder = '', $class = '', $attr = '')
    {
        $return = false;
        if ($type != 'hidden') {
            $return = '<label for="' . $name . '">' . $label . '</label>';
        }
        if ($value && $type != 'password') {
            $value = ' value="' . $value . '"';
        } else {
            $value = '';
        }
        if ($placeholder && $type != 'password') {
            $placeholder = ' placeholder="' . $placeholder . '"';
        }
        if ($class) {
            $class = ' ' . $class;
        }
        if ($attr) {
            $attr = ' ' . $attr;
        }
        $return .= '<input type="' . $type . '" class="form-control' . $class . '" name="' . $name . '" id="' . $this->getId() . '-' . $name . '"' . $placeholder . $value . $attr . '>';
        $this->output .= $return;
        return $this;
    }

    /**
     * @param int $user
     * @param int $photo
     * @return $this
     */
    public function AddInputPhoto($user, $photo)
    {
//        $user = new User;
//        $photolist = $user->getImageListFromUser($_SESSION['user']);
        if (isset($user) && is_int($user)) {
            $this->AddSelect('photolist', 'Images existantes', 'image', ['id', 'link', 'title', 'status'], ['title', 'link'], 'id', ['uploader', 'status'], [$user, '0'], 'ASC', 'title');
        }
        $this->AddInput('img', 'Photo', 'file', $photo);
        $this->AddInput('photo', '', 'hidden', $photo);
        return $this;
    }

    /**
     * Création de formulaire HTML générique avec classes Bootstrap : Ajout d'un textarea compatible CKEditor
     *
     * @param string $name
     * @param int $rows
     * @param int $cols
     * @param string $value
     * @param string $placeholder
     * @param bool $required
     * @return object $this
     */
    public function AddCKEditor($name, $rows = 10, $cols = 80, $value = '', $placeholder = '', $required = true)
    {
        if ($required) {
            $required = ' required';
        }
        $return = '<textarea name="' . $name . '" id="ckeditor" rows="' . $rows . '" cols="' . $cols . '" placeholder="' . $placeholder . '"' . $required . '>' . $value . '</textarea>';
        $this->output .= $return;
        return $this;
    }

    /**
     * Création de formulaire HTML générique avec classes Bootstrap : Ajout d'un select depuis une table de la DB
     *
     * @param string $name
     * @param string $label
     * @param string $table
     * @param array $fields [example : id,name]
     * @param array|string $caption [example : name | concaténation si plusieurs éléments, séparés par le premier élément du tableau : [' : ', 'id', 'name'] Si le premier élément du tableau est 'OR', alors le caption prendra la première valeur non nulle du tableau à partir de l'index 1]
     * @param string $value [example : id]
     * @param array|string $whereField
     * @param array|mixed $whereValue
     * @param string $order [ASC, DESC]
     * @param string $orderBy
     * @param bool $add_btn [true si un input doit remplacer l'absence de select]
     * @param bool $default [true si la première valeur est la valeur par défaut]
     * @return $this
     */
    public function AddSelect($name, $label, $table, $fields, $caption, $value, $whereField, $whereValue, $order, $orderBy = 'ASC', $add_btn = false, $default = false)
    {
        if ($default) {
            $default_txt = '';
        } else {
            $default_txt = '<option value="">Choisissez...</option>';
        }
        $options = false;
        $btn_add = '';
        $result = DBManager::getDatas($table, $fields, $whereField, $whereValue, $order, $orderBy);
        while ($data = $result->fetchObject()) {
            $caption_txt = '';
            if (is_array($caption)) {
                $caption_link = '';
                foreach ($caption as $key => $val) {
                    if ($key > 0) {
                        if ($caption[0] == 'OR') {
                            if (!empty($data->$val)) {
                                $caption_txt = $data->$val;
                                break;
                            }
                        } else {
                            $caption_txt .= $caption_link.$data->$val;
                            $caption_link = $caption[0];
                        }
                    }
                }
            } else {
                $caption_txt = $data->$caption;
            }
            $options .= '<option value="' . $data->$value . '">' . $caption_txt . '</option>';
        }
        if ($add_btn) {
            $btn_add = Output::btnModal('modal-add-btn', '+', 'primary');
        }
        if ($options) {
            $this->output .= '<label for="' . $name . '">' . $label . '</label>' . $btn_add . '<select name="' . $name . '" id="' . $this->getId() . '-' . $name . '" class="form-control">' . $default_txt . $options . '</select>';
        }
        return $this;
    }

    /**
     * Création de formulaire HTML générique avec classes Bootstrap : Ajout d'un select depuis une ressource PDO
     *
     * @param string $name
     * @param string $label
     * @param PDOStatement $result
     * @param string $caption
     * @param string $value
     * @param bool $add_btn
     * @param bool $default
     * @return $this
     */
    public function AddSelectData($name, $label, $result, $caption, $value, $add_btn = false, $default = false)
    {
        if ($default) {
            $default_txt = '';
        } else {
            $default_txt = '<option value="">Choisissez...</option>';
        }
        $options = false;
        $btn_add = '';
        while ($data = $result->fetchObject()) {
            $options .= '<option value="' . $data->$value . '">' . $data->$caption . '</option>';
        }
        if ($add_btn) {
            $btn_add = Output::btnModal('modal-add-btn', '+', 'primary');
        }
        if ($options) {
            $this->output .= '<label for="' . $name . '">' . $label . '</label>' . $btn_add . '<select name="' . $name . '" id="' . $this->getId() . '-' . $name . '" class="form-control">' . $default_txt . $options . '</select>';
        }
        return $this;
    }

    /**
     * Création de formulaire HTML générique avec classes Bootstrap : Ajout d'un select numérique
     *
     * @param string $name
     * @param string $label
     * @param integer $start
     * @param integer $end
     * @param integer|bool $selected
     * @return $this
     */
    public function AddSelectNumber($name, $label, $start, $end, $selected = false)
    {
        if ($selected) {
            if ($selected > $end && $selected < $start) {
                $selected = $start;
            }
        }
        $options = false;
        for ($i = $start; $i <= $end; $i++) {
            if ($selected == $i) {
                $options .= '<option value="' . $i . '" selected>' . $i . '</option>';
            } else {
                $options .= '<option value="' . $i . '">' . $i . '</option>';
            }
        }
        $this->output .= '<label for="' . $name . '">' . $label . '</label><select name="' . $name . '" id="' . $this->getId() . '-' . $name . '" class="form-control">' . $options . '</select>';
        return $this;
    }

    /**
     * Création de formulaire HTML générique avec classes Bootstrap : Ajout d'un ou plusieurs checkbox
     *
     * @param string $name
     * @param array $values [associative array where key = value and value = label]
     * @param bool $inline
     * @param integer|bool $checked
     * @return $this
     */
    public function AddCheckbox($name, $values, $inline = false, $checked = false)
    {
        if ($inline) {
            $inline_class = ' form-check-inline';
        }
        $checkboxes = false;
        foreach ($values as $key => $value) {
            if ($checked == $key) {
                $checkboxes .= '<div class="form-check'.$inline_class.'"><label class="form-check-label"><input class="form-check-input" type="checkbox" name="' . $name . '" value="' . $key . '" checked>' . $value . '</label></div>';
            } else {
                $checkboxes .= '<div class="form-check'.$inline_class.'"><label class="form-check-label"><input class="form-check-input" type="checkbox" name="' . $name . '" value="' . $key . '">' . $value . '</label></div>';
            }
        }
        $this->output .= $checkboxes;
        return $this;
    }
}
