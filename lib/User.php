<?php
/**
 *
 * User: JF
 * Date: 04-11-17
 * Time: 06:21
 */

/**
 * Class User : DB Table
 */
class User
{
    private $id;
    private $first_name;
    private $last_name;
    private $birth_date;
    private $login;
    private $pwd;
    private $email;
    private $con_date;
    private $ip;
    private $status;
    private $level;
    private $alerts;

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
    public function getFirstName()
    {
        return $this->first_name;
    }

    /**
     * @param mixed $first_name
     */
    public function setFirstName($first_name)
    {
        $this->first_name = $first_name;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->last_name;
    }

    /**
     * @param mixed $last_name
     */
    public function setLastName($last_name)
    {
        $this->last_name = $last_name;
    }

    /**
     * @return mixed
     */
    public function getBirthDate()
    {
        return $this->birth_date;
    }

    /**
     * @param mixed $birth_date
     */
    public function setBirthDate($birth_date)
    {
        $this->birth_date = $birth_date;
    }

    /**
     * @return mixed
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * @param mixed $login
     */
    public function setLogin($login)
    {
        $this->login = $login;
    }

    /**
     * @return mixed
     */
    public function getPwd()
    {
        return $this->pwd;
    }

    /**
     * @param mixed $pwd
     */
    public function setPwd($pwd)
    {
        $this->pwd = $pwd;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getConDate()
    {
        return $this->con_date;
    }

    /**
     * @param mixed $con_date
     */
    public function setConDate($con_date)
    {
        $this->con_date = $con_date;
    }

    /**
     * @return mixed
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * @param mixed $ip
     */
    public function setIp($ip)
    {
        $this->ip = $ip;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return mixed
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * @param mixed $level
     */
    public function setLevel($level)
    {
        $this->level = $level;
    }

    /**
     * @return mixed
     */
    public function getAlerts()
    {
        return $this->alerts;
    }

    /**
     * @param mixed $alerts
     */
    public function setAlerts($alerts)
    {
        $this->alerts = $alerts;
    }

    /**
     * @param string $password
     * @return bool
     * @throws Exception
     */
    private function validatePassword($password)
    {
        if (mb_strlen($password) > 256) {
            throw new Exception('PARAM_NOT_VALID|mot de passe trop grand');
        }
        $ucase = preg_match('@[A-Z]@', $password);
        $lcase = preg_match('@[a-z]@', $password);
        $number = preg_match('@[0-9]@', $password);
        $special = preg_match('@[^\w]@', $password);
        if (($ucase + $lcase + $number + $special) < 4 || strlen($password) < 8) {
            return false;
        }
        return true;
    }

    /**
     * @param $vars
     * @throws Exception
     */
    public function addUser($vars)
    {
        if (is_array($vars)) {
            $dbh = DB::connect();
            $result = $dbh->prepare("SELECT COUNT(*) FROM user WHERE email=:email OR login=:login");
            $result->bindParam('email', $vars['email']);
            $result->bindParam('login', $vars['login']);
            $result->execute();
            $data = $result->fetchAll();
            if ($data[0][0]) {
                Output::ShowAlert('Un compte avec cet identifiant ou cette adresse email existe déjà!', 'danger');
            } else {
                if (!$this->validatePassword($vars['pwd'])) {
                    Output::ShowAlert('Mot de passe invalide !<br>Le mot de passe doit comporter au minimum 8 caractères et posséder 3 des 4 caractéristiques suivantes : une lettre minuscule, une lettre majuscule, un chiffre, un caractère spécial', 'danger');
                } else {
                    $pwd = password_hash($vars['pwd'], PASSWORD_DEFAULT);
                    if (isset($vars['birth_date']) && !empty($vars['birth_date'])) {
                        $date = DateTime::createFromFormat('Y-m-d', $vars['birth_date']);
                        $birth_date = $date->format('Y-m-d');
                    } else {
                        $birth_date = '';
                    }
                    $result = $dbh->prepare("INSERT INTO user (first_name, last_name, birth_date, login, pwd, email, con_date, ip) 
                    VALUES (:first_name, :last_name, :birth_date, :login, :pwd, :email, NOW(), :ip)");
                    $result->bindParam(':first_name', $vars['first_name'], 2);
                    $result->bindParam(':last_name', $vars['last_name'], 2);
                    $result->bindParam(':birth_date', $birth_date, 2);
                    $result->bindParam(':login', $vars['login'], 2);
                    $result->bindParam(':pwd', $pwd, 2);
                    $result->bindParam(':email', $vars['email'], 2);
                    $result->bindParam(':ip', $_SERVER['REMOTE_ADDR'], 2);
                    $result->execute();
                    session_unset();
                    session_destroy();
                    session_start();
                    if ($result->rowCount()) {
                        $this->setId($dbh->lastInsertId());
                        $_SESSION['id'] = $this->id;
                        Output::ShowAlert('Utilisateur enregistré avec succès!');
                    } else {
                        Output::ShowAlert('Erreur!', 'danger');
                    }
                }
            }
        }
    }

    /**
     * @param int $user
     */
    public function getUser($user)
    {
        if ($user) {
            $result = DBManager::getData('user', ['id', 'first_name', 'last_name', 'birth_date', 'login', 'pwd', 'email'], 'id', $user, '', '', '', 'OBJECT');
            $this->setFirstName($result->first_name);
            $this->setLastName($result->last_name);
            $this->setBirthDate($result->birth_date);
            $this->setLogin($result->login);
            $this->setPwd($result->pwd);
            $this->setEmail($result->email);
            $this->setId($result->id);
        }
    }

    /**
     * @param int $user
     * @param array $vars
     * @return bool
     */
    public function updateUser($user, $vars)
    {
        $return = false;
        if ($user and is_array($vars)) {
            /*if($vars['pwd']){
                $query = "UPDATE user SET first_name=:first_name, last_name=:last_name, pwd=:pwd, email=:email, ip=:ip WHERE id=:id";
            }else{*/
            $query = "UPDATE user SET first_name=:first_name, last_name=:last_name, email=:email, ip=:ip WHERE id=:id";
            //}
            $dbh = DB::connect();
            $result = $dbh->prepare($query);
            $result->bindParam('id', $user, 1);
            $result->bindParam('first_name', $vars['first_name'], 2);
            $result->bindParam('last_name', $vars['last_name'], 2);
            $result->bindParam('email', $vars['email'], 2);
            $result->bindParam('ip', $_SERVER['REMOTE_ADDR'], 2);
            /*if($vars['pwd'])
                $result->bindParam('pwd', password_hash($vars['pwd'], PASSWORD_DEFAULT), 2);*/
            $result->execute();
            $return = $result->rowCount();
        }
        return $return;
    }

    /**
     * @param int $user
     * @return bool|mixed
     */
    public function deleteUser($user)
    {
        $return = false;
        if ($user) {
            $return = DBManager::setData('user', 'status', '1', 'id', $user);
        }
        return $return;
    }

    /**
     * @param mixed $user
     * @param integer $event_type
     * @return bool|string
     */
    public function getEventsFromUser($user, $event_type = 0)
    {
        $content = false;
        if ($user) {
            if ($event_type) {
                $results = DBManager::getData('event', ['id', DBManager::SQLDateFormat('moment', 'BIRTH'), 'title', 'note', 'emotion', 'event_type'], ['user_id', 'event_type'], [$user, $event_type], 'moment', 'DESC', 20, 'CLASS');
                $event_type_q = DBManager::getData('events_type', 'event_name', 'id', $event_type, '', '', '', 'OBJECT');
                $event_type_txt = $event_type_q->event_name;
            } else {
                $event_type_txt = '';
                $results = DBManager::getData('event', ['id', DBManager::SQLDateFormat('moment', 'BIRTH'), 'title', 'note', 'emotion', 'event_type'], 'user_id', $user, 'moment', 'DESC', 20, 'CLASS');
            }
            if ($results) {
                $tbody = '';
                $dbh = DB::connect();
                foreach ($results as $data) {
                    $tag_txt = $this->listTagsFromElement(5, $data, $dbh);
                    if (!$tag_txt) {
                        $tag_txt = '<i>&lt;Aucun Tag&gt;</i>';
                    }
                    if (!$event_type) {
                        $event_type_q = DBManager::getData('events_type', 'event_name', 'id', $data->getEventType(), '', '', '', 'OBJECT');
                        $event_type_txt = ucfirst($event_type_q->event_name);
                    }
                    $emotion_q = DBManager::getData('emotion', 'em_name', 'id', $data->getEmotion(), '', '', '', 'OBJECT');
                    $emotion_txt = $emotion_q->em_name;
                    if (!$emotion_txt) {
                        $emotion_txt = '<i>&lt;Aucune Emotion&gt;</i>';
                    }
                    $title_txt = $data->getTitle();
                    if (!$title_txt) {
                        $title_txt = '<i>&lt;Titre manquant&gt;</i>';
                    }
                    $note_txt = $data->getNote();
                    if (!$note_txt) {
                        $note_txt = '<i>&lt;Note manquante&gt;</i>';
                    } else {
                        $note_txt .= '/10';
                    }
                    $tbody .= '<tr>
                        <td class="event-time">
                            <div class="row">
                                <div class="col-md-8">' . $data->getMoment() . '</div>
                                <div class="col-md-2">
                                    <form><button type="button" class="btn btn-primary-1" data-toggle="collapse" data-target="#clp-event-time-mod-' . $data->getId() . '"><i class="fa fa-pencil-square-o color-primary-1"></i></button></form>
                                </div>
                            </div>
                            <div class="collapse" id="clp-event-time-mod-' . $data->getId() . '">' . Event::updateEventDate($data->getId(), './app/a_event_date.php', $data->getMoment()) . '</div>
                        </td>
                        <td>
                            <div class="row">
                                <div class="col-md-8">' . $title_txt . '</div>
                                <div class="col-md-2">
                                    <form><button type="button" class="btn btn-primary-1" data-toggle="collapse" data-target="#clp-event-title-mod-' . $data->getId() . '"><i class="fa fa-pencil-square-o color-primary-1"></i></button></form>
                                </div>
                            </div>
                            <div class="collapse" id="clp-event-title-mod-' . $data->getId() . '">' . Event::updateEventTitle($data->getId(), './app/a_event_title.php') . '</div>
                        </td>
                        <td>
                            <div class="row">
                                <div class="col-md-8">' . $event_type_txt . '</div>
                                <div class="col-md-2">
                                    <form><button type="button" class="btn btn-primary-1" data-toggle="collapse" data-target="#clp-event-type-mod-' . $data->getId() . '"><i class="fa fa-pencil-square-o color-primary-1"></i></button></form>
                                </div>
                            </div>
                            <div class="collapse" id="clp-event-type-mod-' . $data->getId() . '">' . $this->AddCatOnElement($data->getId(), './app/a_event_type.php', $event_type_txt) . '</div>
                        </td>
                        <td>
                            <div class="row">
                                <div class="col-md-8">' . $emotion_txt . '</div>
                                <div class="col-md-2">
                                    <form><button type="button" class="btn btn-primary-1" data-toggle="collapse" data-target="#clp-event-emo-mod-' . $data->getId() . '"><i class="fa fa-pencil-square-o color-primary-1"></i></button></form>
                                </div>
                            </div>
                            <div class="collapse" id="clp-event-emo-mod-' . $data->getId() . '">' . $this->AddEmotionOnElement($data->getId(), './app/a_event_emo.php') . '</div>
                        </td>
                        <td>
                            <div class="row">
                                <div class="col-md-8">' . $note_txt . '</div>
                                <div class="col-md-2">
                                    <form><button type="button" class="btn btn-primary-1" data-toggle="collapse" data-target="#clp-event-note-mod-' . $data->getId() . '"><i class="fa fa-pencil-square-o color-primary-1"></i></button></form>
                                </div>
                            </div>
                            <div class="collapse" id="clp-event-note-mod-' . $data->getId() . '">' . $this->AddNoteOnElement($data->getId(), './app/a_event_note.php') . '</div>
                        </td>
                        <td>
                            <div class="row">
                                <div class="col-md-8">' . $tag_txt . '</div>
                                <div class="col-md-2">
                                    <form><button type="button" class="btn btn-lg btn-primary-1" data-toggle="collapse" data-target="#clp-event-tag-mod-' . $data->getId() . '">+</button></form>
                                </div>
                            </div>
                            <div class="collapse" id="clp-event-tag-mod-' . $data->getId() . '">' . $this->AddTagOnElement($user, $data->getId(), './app/a_event_tag_add.php', 0, $tag_txt) . '</div>
                        </td>
                    </tr>';
                }
                $content = Output::TableHead(['Date', 'Titre', 'Catégorie', 'Emotion', 'Intensité', 'Tags'], $tbody, 'Evénements <button type="button" class="btn btn-primary-1 btn-lg" data-toggle="collapse" href="#f-event-add-collapse">+</button>');
            }
        }
        return $content;
    }

    /**
     * @param mixed $user
     * @param integer $event_type
     * @return bool|string
     */
    public function getMessagesFromUser($user, $event_type)
    {
        $content = false;
        if ($user and $event_type) {
            $results = DBManager::getData('message', ['id', DBManager::SQLDateFormat('moment'), 'message', 'emotion', 'note'], ['user_id', 'event_type'], [$user, $event_type], 'moment', 'DESC', 10, 'CLASS');
            if ($results) {
                $tags = DBManager::getData('tag', 'id', 'user_id', $user, '', '', '', 'COUNT');
                $tbody = '';
                $dbh = DB::connect();
                foreach ($results as $data) {
                    if ($data->getEmotion()) {
                        $emotion_q = DBManager::getData('emotion', 'em_name', 'id', $data->getEmotion(), '', '', '', 'OBJECT');
                        $emotion_txt = $emotion_q->em_name;
                    } else {
                        $emotion_txt = '<i>&lt;Aucune Emotion&gt;</i>';
                    }
                    $event_txt = $data->getMessageEvent($data->id);
                    $note_txt = $data->getNote();
                    if (!$note_txt) {
                        $note_txt = '<i>&lt;Note manquante&gt;</i>';
                    } else {
                        $note_txt .= '/10';
                    }
                    $tag_txt = $this->listTagsFromElement(1, $data, $dbh);
                    if (!$tag_txt) {
                        $tag_txt = '<i>&lt;Aucun Tag&gt;</i>';
                    }
                    $tbody .= '<tr><td>' . $data->getMoment() . '<br><span class="text-hide">' . $data->getId() . '</span>
                        <button type="button" class="btn-modif btn btn-sm btn-danger">Modifier</button></td>
                        <td class="td-ck"><div class="ck-inline ck-inline-min" contenteditable="true">' . $data->getMessage() . '</div></td>
                        <td>
                            ' . $tag_txt . '
                            <form><button type="button" class="btn btn-lg btn-primary-1" data-toggle="collapse" data-target="#clp-msg-tag-mod-' . $data->getId() . '">+</button></form>
                            <div class="collapse" id="clp-msg-tag-mod-' . $data->getId() . '">' . $this->AddTagOnElement($user, $data->getId(), './app/a_message_tag_add.php', $tags, $tag_txt) . '</div>
                        </td>
                        <td>
                            ' . $emotion_txt . '
                            <form><button type="button" class="btn btn-primary-1" data-toggle="collapse" data-target="#clp-msg-emo-mod-' . $data->getId() . '"><i class="fa fa-pencil-square-o color-primary-1"></i></button></form>
                            <div class="collapse" id="clp-msg-emo-mod-' . $data->getId() . '">' . $this->AddEmotionOnElement($data->getId(), './app/a_message_emo.php') . '</div>
                        </td>
                        <td>
                            ' . $note_txt . '
                            <form><button type="button" class="btn btn-primary-1" data-toggle="collapse" data-target="#clp-msg-note-mod-' . $data->getId() . '"><i class="fa fa-pencil-square-o color-primary-1"></i></button></form>
                            <div class="collapse" id="clp-msg-note-mod-' . $data->getId() . '">' . $this->AddNoteOnElement($data->getId(), './app/a_message_note.php') . '</div>
                        </td>
                        <td>
                            ' . $event_txt . '
                            <form><button type="button" class="btn btn-primary-1" data-toggle="collapse" data-target="#clp-msg-event-mod-' . $data->getId() . '"><i class="fa fa-pencil-square-o color-primary-1"></i></button></form>
                            <div class="collapse" id="clp-msg-event-mod-' . $data->getId() . '">' . $this->AddEventOnElement($data->getId(), './app/a_message_event.php') . '</div>
                        </td>
                        </tr>';
                }
                $content = Output::TableHead(['Date', 'Message', 'Tags', 'Emotion', 'Intensité', 'Event'], $tbody, 'Messages <button type="button" class="btn btn-primary-1 btn-lg" data-toggle="collapse" href="#f-message-add-collapse">+</button>');
            }
        }
        return $content;
    }

    /**
     * @param int $user
     * @return mixed
     */
    public function getImageListFromUser($user)
    {
        $return = '';
        $results = DBManager::getData('image', ['id', 'link', 'title', 'status'], ['uploader', 'status'], [$user, '0'], 'title', 'ASC', '', 'CLASS');
        foreach ($results as $data) {
            $return .= Output::ShowImage($data->getLink(), $data->getTitle(), 'users/' . $user . '/', '', '25');
        }
        return $return;

//        return DBManager::getData('image', ['id', 'link', 'title', 'status'], ['uploader', 'status'], [$user, '0'], 'title', 'ASC', '', 'CLASS');
    }

    /**
     * @param mixed $user
     * @param string $show
     * @param array|int $limit
     * @param bool $chk_img_del
     * @return bool|string
     */
    public function getImagesFromUser($user, $show = 'table', $limit = 50, $chk_img_del = false)
    {
        $content = false;
        if ($user) {
            if ($chk_img_del) {
                $where_fields = 'uploader';
                $where_values = $user;
            } else {
                $where_fields = ['uploader', 'status'];
                $where_values = [$user, '0'];
            }
            if ($limit != 50) {
                $offset_max = DBManager::getData('image', 'id', $where_fields, $where_values, '', '', '', 'COUNT');
                $actual = 1;
                $_SESSION['offset_max'] = ceil($offset_max / CARDS_PER_PAGE);
                if (isset($_SESSION['offset'])) {
                    $actual = intval($_SESSION['offset']);
                }
                if ($actual > $_SESSION['offset_max']) $actual = $_SESSION['offset_max'];
                $offset = ($actual - 1) * CARDS_PER_PAGE;
                $limit = [$offset, CARDS_PER_PAGE];
            }
            $results = DBManager::getData('image', ['id', 'link', 'title', 'status'], $where_fields, $where_values, 'title', 'ASC', $limit, 'CLASS');
            if ($results) {
                if ($show == 'table') {
                    //$content = Output::Table($results, ['Image','Titre'], 'Images');
                    $tbody = '';
                    foreach ($results as $data) {
                        $tbody .= '<tr><td>' . Output::ShowImage($data->getLink(), $data->getTitle(), 'users/' . $user . '/', '', '20') . '</td><td>' . $data->getTitle() . '</td></tr>';
                    }
                    $content = Output::TableHead(['Image', 'Titre'], $tbody, 'Images');
                } elseif ($show == 'card') {
                    //$events = DBManager::getData('event', ['id', DBManager::SQLDateFormat('moment', 'BIRTH'), 'note', 'emotion', 'event_type'], 'user_id', $user, 'moment', 'DESC', '','OBJECT');
                    $content = '<div class="row">';
                    $dbh = DB::connect();
                    foreach ($results as $data) {
                        $text = $this->listTagsFromElement(2, $data, $dbh);
                        /*$result = $dbh->prepare("SELECT tag_name FROM tag as t,tag_link as tl WHERE t.id=tl.tag_id AND tl.data_type=2 AND tl.data_id=".$data->getId());
                        $result->execute();
                        while($data_tag = $result->fetchObject()){
                            $text .= '#'.$data_tag->tag_name.' ';
                        }*/
                        $data_img = [
                            'id' => $data->getId(),
                            'img_link' => 'users/' . $user . '/' . $data->getLink(),
                            'card_text' => $text,
                            'mod_script' => './app/a_image_mod.php',
                            'user_id' => $user,
                            'title' => $data->getTitle(),
                            'title_label' => 'Titre',
                            'type' => 2,
                            //'events' => $events
                        ];
                        $content .= Output::viewCard($data_img, $data->getStatus());
                    }
                    $content .= '</div>';
                }
            }
        }
        return $content;
    }

    /**
     * @param int $user
     * @param int $type
     * @param int $id
     * @return PDOStatement
     */
    public function getTagsByType($user, $type, $id)
    {
        $query = "SELECT DISTINCT t.id,t.tag_name FROM tag as t
        LEFT JOIN tag_link as tl ON t.id=tl.tag_id AND tl.data_type=:typeid
        LEFT JOIN image as i ON i.id=tl.data_id
        WHERE user_id=:userid AND t.id NOT IN (SELECT tag_id FROM tag_link WHERE data_type=$type AND data_id=:dataid)
        ORDER BY t.tag_name";
        $dbh = DB::connect();
        $result = $dbh->prepare($query);
        $result->bindParam('typeid', $type, 1);
        $result->bindParam('userid', $user, 1);
        $result->bindParam('dataid', $id, 1);
        $result->execute();
        return $result;
    }

    /**
     * @param integer $user
     * @param integer $element_id
     * @param string $action
     * @param integer $tags
     * @param string $text
     * @return bool|string
     */
    public function AddTagOnElement($user, $element_id, $action, $tags = 0, $text = '')
    {
        if (!$tags) {
            $tags = DBManager::getData('tag', 'id', 'user_id', $user, '', '', '', 'COUNT');
        }
        if ($tags) {
            $return = '<hr>';
            $form = new Form();
            $return .= $form->CreateForm($action, 'POST', '')
                ->AddSelect('tag_id', '', 'tag', ['id', 'tag_name'], 'tag_name', 'id', 'user_id', $user, 'tag_name', 'ASC')
                ->AddInput('id', '', 'hidden', $element_id)
                ->EndForm('Ajouter', 'primary-1');
        } else {
            $return = Output::btnModal('modal-add-btn', '+', 'primary-1');
        }
        return $return;
    }

    /**
     * @param int $id
     * @param string $action
     * @return bool|string
     */
    private function AddEmotionOnElement($id, $action)
    {
        $return = '<hr>';
        $form = new Form();
        $return .= $form->CreateForm($action, 'POST', '')
            ->AddSelect('emotion', '', 'emotion', ['id', 'em_name'], 'em_name', 'id', '', '', 'em_name', 'ASC')
            ->AddInput('id', '', 'hidden', $id)
            ->EndForm('Modifier', 'primary-1');
        return $return;
    }

    /**
     * @param int $id
     * @param string $action
     * @param string $text
     * @return bool|string
     */
    private function AddCatOnElement($id, $action, $text = '')
    {
        $return = false;
        if ($text) $return = '<hr>';
        $form = new Form();
        $return .= $form->CreateForm($action, 'POST', '')
            ->AddSelect('event_type', '', 'events_type', ['id', 'event_name'], 'event_name', 'id', '', '', 'event_name', 'ASC')
            ->AddInput('id', '', 'hidden', $id)
            ->EndForm('Modifier', 'primary-1');
        return $return;
    }

    /**
     * @param int $id
     * @param string $action
     * @return bool|string
     */
    private function AddNoteOnElement($id, $action)
    {
        $return = '<hr>';
        $form = new Form();
        $return .= $form->CreateForm($action, 'POST', '')
            ->AddSelectNumber('note', '', 1, 10)
            ->AddInput('id', '', 'hidden', $id)
            ->EndForm('Noter', 'primary-1');
        return $return;
    }

    /**
     * @param int $id
     * @param string $action
     * @return bool|string
     */
    private function AddEventOnElement($id, $action)
    {
        $return = '<hr>';
        $form = new Form();
        $return .= $form->CreateForm($action, 'POST', '')
            ->AddSelect('event_id', '', 'event', ['id', DBManager::SQLDateFormat('moment', 'BIRTH'), 'title'], [' : ', 'moment', 'title'], 'id', 'user_id', $_SESSION['id'], 'title', 'DESC')
            ->AddInput('id', '', 'hidden', $id)
            ->EndForm('Modifier', 'primary-1');
        return $return;
    }

    /**
     * @param int $data_type
     * @param object $data
     * @param object $dbh
     * @param bool $object
     * @return string
     */
    public function listTagsFromElement($data_type, $data, $dbh, $object = true)
    {
        if ($object) {
            $id = $data->getId();
        } else {
            $id = $data->id;
        }
        $text = '';
        $redirect = getRedirect($data_type);
        $result = $dbh->prepare("SELECT tl.id,tag_name FROM tag AS t,tag_link AS tl WHERE t.id=tl.tag_id AND tl.data_type=:data_type AND tl.data_id=:data_id");
        $result->bindParam(':data_type', $data_type, 1);
        $result->bindParam(':data_id', $id, 1);
        $result->execute();
        while ($data_tag = $result->fetchObject()) {
            $text .= '<div class="mem-tag-border">
                        <span class="hide-tag-id text-hide">' . $data_tag->id . '</span>
                        <span class="hide-redirect text-hide">' . $redirect . '</span>
                        <button type="button" class="btn btn-sm btn-danger tag-del" title="Supprimer le Tag #' . $data_tag->tag_name . ' pour cet élément"><i class="fa fa-trash-o"></i></button>
                        <span class="mem-tag">#' . $data_tag->tag_name . '</span>
                        <button type="button" class="btn btn-sm btn-danger tag-cancel" title="Annuler"><i class="fa fa-ban"></i></button>
                      </div>';
        }
        return $text;
    }

    /**
     * @param int $user
     * @param string $tag
     * @param int $limit
     * @return bool|string
     */
    public function getImagesFromUserByTag($user, $tag, $limit = 12)
    {
        $content = false;
        if ($user && $tag) {
            $tag_ok = DBManager::getData('tag', 'id', ['tag_name', 'user_id'], [$tag, $user], '', '', '', 'OBJECT');
            $tag = $tag_ok->id;
            if ($tag) {
                if ($limit != 50) {
                    $offset_max = DBManager::getData('image', ['id', 'link', 'title'], ['uploader', 'status'], [$user, '0'], '', '', '', 'COUNT');
                    $actual = 1;
                    $_SESSION['offset_max'] = ceil($offset_max / CARDS_PER_PAGE);
                    if (isset($_SESSION['offset'])) {
                        $actual = intval($_SESSION['offset']);
                    }
                    if ($actual > $_SESSION['offset_max']) $actual = $_SESSION['offset_max'];
                    $offset = ($actual - 1) * CARDS_PER_PAGE;
                    $limit = [$offset, CARDS_PER_PAGE];
                }
                $query = "SELECT i.id,i.link,i.title FROM image AS i
                    LEFT JOIN tag_link AS tl ON tl.data_id=i.id AND tl.data_type=2
                    WHERE tag_id=" . $tag . " AND uploader=" . $user . " ORDER BY i.id ASC";
                $dbh = DB::connect();
                $result = $dbh->query($query);
                while ($data = $result->fetchObject()) {
                    $data_img = [
                        'id' => $data->id,
                        'img_link' => 'users/' . $user . '/' . $data->link,
                        'card_text' => '',
                        'mod_script' => './app/a_image_mod.php',
                        'user_id' => $user,
                        'title' => $data->title,
                        'title_label' => 'Titre',
                        'type' => 2,
                    ];
                    $content .= Output::viewCard($data_img);
                }
                if ($content) {
                    $content = '<h2 class="h2-bl">' . TXT_IMAGE . '</h2><div class="row">' . $content . '</div>';
                }
            }
        }
        return $content;
    }

    /**
     * @param int $user
     * @param string $tag
     * @return bool|string
     */
    public function getMessagesFromUserByTag($user, $tag)
    {
        $content = false;
        if ($user && $tag) {
            $tag_ok = DBManager::getData('tag', 'id', ['tag_name', 'user_id'], [$tag, $user], '', '', '', 'OBJECT');
            $tag = $tag_ok->id;
            if ($tag) {
                $query = "SELECT m.id,m.message,m.moment FROM message AS m
                LEFT JOIN tag_link AS tl ON tl.data_id=m.id AND tl.data_type=1
                WHERE tl.tag_id=" . $tag . " AND m.user_id=" . $user . " ORDER BY m.id ASC";
                $dbh = DB::connect();
                $res = $dbh->query($query);
                if ($res) {
                    $tags = DBManager::getData('tag', 'id', 'user_id', $user, '', '', '', 'COUNT');
                    $tbody = '';
                    $result = $res->fetchAll(PDO::FETCH_CLASS, 'Message');
                    foreach ($result as $data) {
                        if ($data->getEmotion()) {
                            $emotion_q = DBManager::getData('emotion', 'em_name', 'id', $data->getEmotion(), '', '', '', 'OBJECT');
                            $emotion_txt = $emotion_q->em_name;
                        } else {
                            $emotion_txt = '<i>&lt;Aucune Emotion&gt;</i>';
                        }
                        $event_txt = $data->getMessageEvent($data->id);
                        $note_txt = $data->getNote();
                        if (!$note_txt) {
                            $note_txt = '<i>&lt;Note manquante&gt;</i>';
                        } else {
                            $note_txt .= '/10';
                        }
                        $tag_txt = $this->listTagsFromElement(1, $data, $dbh);
                        if (!$tag_txt) {
                            $tag_txt = '<i>&lt;Aucun Tag&gt;</i>';
                        }
                        $tbody .= '<tr><td>' . $data->getMoment() . '<br><span class="text-hide">' . $data->getId() . '</span>
                        <button type="button" class="btn-modif btn btn-sm btn-danger">Modifier</button></td>
                        <td class="td-ck"><div class="ck-inline ck-inline-min" contenteditable="true">' . $data->getMessage() . '</div></td>
                        <td>
                            ' . $tag_txt . '
                            <form><button type="button" class="btn btn-lg btn-primary-1" data-toggle="collapse" data-target="#clp-msg-tag-mod-' . $data->getId() . '">+</button></form>
                            <div class="collapse" id="clp-msg-tag-mod-' . $data->getId() . '">' . $this->AddTagOnElement($user, $data->getId(), './app/a_message_tag_add.php', $tags, $tag_txt) . '</div>
                        </td>
                        <td>
                            ' . $emotion_txt . '
                            <form><button type="button" class="btn btn-primary-1" data-toggle="collapse" data-target="#clp-msg-emo-mod-' . $data->getId() . '"><i class="fa fa-pencil-square-o color-primary-1"></i></button></form>
                            <div class="collapse" id="clp-msg-emo-mod-' . $data->getId() . '">' . $this->AddEmotionOnElement($data->getId(), './app/a_message_emo.php') . '</div>
                        </td>
                        <td>
                            ' . $note_txt . '
                            <form><button type="button" class="btn btn-primary-1" data-toggle="collapse" data-target="#clp-msg-note-mod-' . $data->getId() . '"><i class="fa fa-pencil-square-o color-primary-1"></i></button></form>
                            <div class="collapse" id="clp-msg-note-mod-' . $data->getId() . '">' . $this->AddNoteOnElement($data->getId(), './app/a_message_note.php') . '</div>
                        </td>
                        <td>
                            ' . $event_txt . '
                            <form><button type="button" class="btn btn-primary-1" data-toggle="collapse" data-target="#clp-msg-event-mod-' . $data->getId() . '"><i class="fa fa-pencil-square-o color-primary-1"></i></button></form>
                            <div class="collapse" id="clp-msg-event-mod-' . $data->getId() . '">' . $this->AddEventOnElement($data->getId(), './app/a_message_event.php') . '</div>
                        </td>
                        </tr>';
                    }
                    if ($tbody) {
                        $content = Output::TableHead([TXT_DATE, TXT_MESSAGE, TXT_TAG, TXT_EMOTION, TXT_INTENSITY, TXT_EVENT], $tbody, Output::Plural(TXT_MESSAGE, 2));
                    } else {
                        $content = '<h2 class="h2-bl">' . TXT_MESSAGE . '</h2>' . Output::ShowAdvert(TXT_TAG_NO_MESSAGE, 'info');
                    }
                }
            }
        }
        return $content;
    }

    /**
     * @param int $user
     * @param int $tag
     * @param int $event_type
     * @return bool|string
     */
    public function getEventsFromUserByTag($user, $tag, $event_type = 0)
    {
        $content = false;
        if ($user && $tag) {
            $tag_ok = DBManager::getData('tag', 'id', ['tag_name', 'user_id'], [$tag, $user], '', '', '', 'OBJECT');
            $tag = $tag_ok->id;
            if ($tag) {
                $query = "SELECT m.* FROM event AS m
                LEFT JOIN tag_link AS tl ON tl.data_id=m.id AND tl.data_type=5
                WHERE tl.tag_id=" . $tag . " AND m.user_id=" . $user . " ORDER BY m.id ASC";
                $dbh = DB::connect();
                $res = $dbh->query($query);
                if ($res) {
                    $tbody = '';
                    $result = $res->fetchAll(PDO::FETCH_CLASS, 'Event');
                    foreach ($result as $data) {
                        $tag_txt = $this->listTagsFromElement(5, $data, $dbh);
                        if (!$tag_txt) {
                            $tag_txt = '<i>&lt;Aucun Tag&gt;</i>';
                        }
                        if (!$event_type) {
                            $event_type_q = DBManager::getData('events_type', 'event_name', 'id', $data->getEventType(), '', '', '', 'OBJECT');
                            $event_type_txt = ucfirst($event_type_q->event_name);
                        }
                        $emotion_q = DBManager::getData('emotion', 'em_name', 'id', $data->getEmotion(), '', '', '', 'OBJECT');
                        $emotion_txt = $emotion_q->em_name;
                        if (!$emotion_txt) {
                            $emotion_txt = '<i>&lt;Aucune Emotion&gt;</i>';
                        }
                        $title_txt = $data->getTitle();
                        if (!$title_txt) {
                            $title_txt = '<i>&lt;Titre manquant&gt;</i>';
                        }
                        $note_txt = $data->getNote();
                        if (!$note_txt) {
                            $note_txt = '<i>&lt;Note manquante&gt;</i>';
                        } else {
                            $note_txt .= '/10';
                        }
                        $tbody .= '<tr>
                            <td class="event-time">
                                <div class="row">
                                    <div class="col-md-8">' . $data->getMoment() . '</div>
                                    <div class="col-md-2">
                                        <form><button type="button" class="btn btn-primary-1" data-toggle="collapse" data-target="#clp-event-time-mod-' . $data->getId() . '"><i class="fa fa-pencil-square-o color-primary-1"></i></button></form>
                                    </div>
                                </div>
                                <div class="collapse" id="clp-event-time-mod-' . $data->getId() . '">' . Event::updateEventDate($data->getId(), './app/a_event_date.php', $data->getMoment()) . '</div>
                            </td>
                            <td>
                                <div class="row">
                                    <div class="col-md-8">' . $title_txt . '</div>
                                    <div class="col-md-2">
                                        <form><button type="button" class="btn btn-primary-1" data-toggle="collapse" data-target="#clp-event-title-mod-' . $data->getId() . '"><i class="fa fa-pencil-square-o color-primary-1"></i></button></form>
                                    </div>
                                </div>
                                <div class="collapse" id="clp-event-title-mod-' . $data->getId() . '">' . Event::updateEventTitle($data->getId(), './app/a_event_title.php') . '</div>
                            </td>
                            <td>
                                <div class="row">
                                    <div class="col-md-8">' . $event_type_txt . '</div>
                                    <div class="col-md-2">
                                        <form><button type="button" class="btn btn-primary-1" data-toggle="collapse" data-target="#clp-event-type-mod-' . $data->getId() . '"><i class="fa fa-pencil-square-o color-primary-1"></i></button></form>
                                    </div>
                                </div>
                                <div class="collapse" id="clp-event-type-mod-' . $data->getId() . '">' . $this->AddCatOnElement($data->getId(), './app/a_event_type.php', $event_type_txt) . '</div>
                            </td>
                            <td>
                                <div class="row">
                                    <div class="col-md-8">' . $emotion_txt . '</div>
                                    <div class="col-md-2">
                                        <form><button type="button" class="btn btn-primary-1" data-toggle="collapse" data-target="#clp-event-emo-mod-' . $data->getId() . '"><i class="fa fa-pencil-square-o color-primary-1"></i></button></form>
                                    </div>
                                </div>
                                <div class="collapse" id="clp-event-emo-mod-' . $data->getId() . '">' . $this->AddEmotionOnElement($data->getId(), './app/a_event_emo.php') . '</div>
                            </td>
                            <td>
                                <div class="row">
                                    <div class="col-md-8">' . $note_txt . '</div>
                                    <div class="col-md-2">
                                        <form><button type="button" class="btn btn-primary-1" data-toggle="collapse" data-target="#clp-event-note-mod-' . $data->getId() . '"><i class="fa fa-pencil-square-o color-primary-1"></i></button></form>
                                    </div>
                                </div>
                                <div class="collapse" id="clp-event-note-mod-' . $data->getId() . '">' . $this->AddNoteOnElement($data->getId(), './app/a_event_note.php') . '</div>
                            </td>
                            <td>
                                <div class="row">
                                    <div class="col-md-8">' . $tag_txt . '</div>
                                    <div class="col-md-2">
                                        <form><button type="button" class="btn btn-lg btn-primary-1" data-toggle="collapse" data-target="#clp-event-tag-mod-' . $data->getId() . '">+</button></form>
                                    </div>
                                </div>
                                <div class="collapse" id="clp-event-tag-mod-' . $data->getId() . '">' . $this->AddTagOnElement($user, $data->getId(), './app/a_event_tag_add.php', 0, $tag_txt) . '</div>
                            </td>
                        </tr>';
                    }
                    if ($tbody) {
                        $content = Output::TableHead([TXT_DATE, TXT_TITLE, TXT_CATEGORY, TXT_EMOTION, TXT_INTENSITY, TXT_TAG], $tbody, Output::Plural(TXT_EVENT, 2));
                    } else {
                        $content = '<h2 class="h2-bl">' . TXT_EVENT . '</h2>' . Output::ShowAdvert(TXT_TAG_NO_EVENT, 'info');
                    }
                }
            }
        }
        return $content;
    }

    /**
     * @param int $user
     * @return mixed
     */
    public function getTags($user)
    {
        return DBManager::getData('tag', ['id', 'tag_name'], 'user_id', $user, 'tag_name', 'ASC');
    }

    /**
     * @param int $user
     * @return string
     */
    public function viewTags($user)
    {
        $tags = DBManager::getData('tag', ['id', 'tag_name'], 'user_id', $user);
        //return Output::Table($tags, 'Tag', 'Tags');
        $tbody = '';
        $help_txt = 'Vous ne pouvez pas supprimer de Tag associé à une ou plusieurs données. Veuillez transférer vos données vers un autre Tag afin de pouvoir le supprimer.';
        $help_txt2 = 'Vous ne pouvez transférer que des données associés à un Tag';
        foreach ($tags as $data) {
            $tag = new Tag();
            $tag_nbr = $tag->getTagLinks($data[0]);
            $form = new Form();
            if ($tag_nbr) {
                $form_tr = $form->CreateForm('./app/a_tag_tr.php', 'POST', '')
                    ->AddSelect('tag_id', 'Vers ce Tag', 'tag', ['id', 'tag_name'], 'tag_name', 'id', 'user_id', $user, 'tag_name', 'ASC')
                    ->AddInput('id', '', 'hidden', $data[0])
                    ->EndForm('Transférer', 'primary-1');
                $form_mod = $form->CreateForm('./app/a_tag_mod.php', 'POST', '')
                    ->AddInput('tag_name', '', 'text', $data[1])
                    ->AddInput('id', '', 'hidden', $data[0])
                    ->AddInput('user_id', '', 'hidden', $user)
                    ->EndForm('Modifier', 'primary-1');
                $tbody .= '<tr>
                            <td class="tag-editable">
                            <div class="row">
                                <div class="col-md-6">' . $data[1] . '</div>
                                <div class="col-md-6"><form><button type="button" class="btn btn-primary-1" data-toggle="collapse" data-target="#clp-tag-mod-' . $data[0] . '"><i class="fa fa-pencil-square-o color-primary-1"></i></button></form><div class="collapse" id="clp-tag-mod-' . $data[0] . '">' . $form_mod . '</div></div>
                            </div>
                            </td>
                            <td>' . Output::Popup($tag_nbr . ' ' . Output::Plural('référence', $tag_nbr), $help_txt) . '</td>
                            <td><form><button type="button" class="btn btn-primary-1" data-toggle="collapse" data-target="#clp-tag-tr-' . $data[0] . '"><i class="fa fa-exchange color-primary-1"></i></button></form><div class="collapse" id="clp-tag-tr-' . $data[0] . '">' . $form_tr . '</div></td>
                        </tr>';
            } else {
                $form_delete = $form->CreateForm('./app/a_tag_del.php', 'POST', '')
                    ->AddInput('id', '', 'hidden', $data[0])
                    ->EndForm('fa fa-trash-o', 'danger');
                $tbody .= '<tr><td>' . $data[1] . '</td><td>' . $form_delete . '</td><td>' . Output::Popup('<form><button type="button" class="btn btn-danger"><i class="fa fa-ban"></i></button></form>', $help_txt2) . '</td></tr>';
            }
        }
        $btn_add = Output::btnModal('modal-add-btn', '+', 'primary-1');
        return Output::TableHead(['Nom du Tag', 'Références', 'Transférer'], $tbody, 'Tags ' . $btn_add);
    }

    /**
     * @param int $length
     * @return string
     * @throws Exception
     */
    public function genPwd($length = 20)
    {
        $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        $str = '';
        $max = strlen($chars) - 1;
        for ($i = 0; $i < $length; $i++) {
            $str .= $chars[random_int(0, $max)];
        }
        return $str;
    }

    /**
     * @param $user
     * @return array
     */
    public function getTimelineEventsFromUser($user)
    {
        $events = '';
        $modal = '';
        if ($user) {
            $results = DBManager::getData('event', ['id', DBManager::SQLDateFormat('moment', 'BIRTH', 'time'), 'title', 'moment', 'note', 'emotion', 'event_type'], 'user_id', $user, 'moment', 'ASC', 20, 'CLASS');
            if ($results) {
                foreach ($results as $data) {
                    $event = Output::viewTimelineData($data);
                    $events .= $event[0];
                    $modal .= $event[1];
                }
            }
        }
        return [$events, $modal];
    }
}