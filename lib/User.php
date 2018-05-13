<?php
/**
 * Created by PhpStorm.
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
                    $date = DateTime::createFromFormat('Y-m-d', $vars['birth_date']);
                    $birth_date = $date->format('Y-m-d');
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
                    $text = $this->listTagsFromElement(5, $data, $dbh);
                    if (!$event_type) {
                        $event_type_q = DBManager::getData('events_type', 'event_name', 'id', $data->getEventType(), '', '', '', 'OBJECT');
                        $event_type_txt = $event_type_q->event_name;
                    }
                    $emotion_q = DBManager::getData('emotion', 'em_name', 'id', $data->getEmotion(), '', '', '', 'OBJECT');
                    $emotion_txt = $emotion_q->em_name;
                    $text .= $this->AddTagOnElement($user, $data->getId(), './app/a_event_tag_add.php', 0, $text);
                    $tbody .= '<tr><td class="event-time">' . $data->getMoment() . Event::updateEventDate($data->getId(), './app/a_event_date.php', $data->getMoment()) . '</td>
                        <td>' . $data->getTitle() . '</td>
                        <td>' . $event_type_txt . $this->AddCatOnElement($data->getId(), './app/a_event_type.php', $event_type_txt) . '</td>
                        <td>' . $emotion_txt . $this->AddEmotionOnElement($data->getId(), './app/a_event_emo.php', $emotion_txt) . '</td>
                        <td>' . $data->getNote() . $this->AddNoteOnElement($data->getId(), './app/a_event_note.php', $data->getNote()) . '</td><td>' . $text . '</td></tr>';
                }
                $content = Output::TableHead(['Date', 'Titre', 'Catégorie', 'Emotion', 'Note', 'Tags'], $tbody, 'Evènements <button type="button" class="btn btn-primary" data-toggle="collapse" href="#f-event-add-collapse">+</button>');
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
                    }
                    $text = $this->listTagsFromElement(1, $data, $dbh);
                    $text .= $this->AddTagOnElement($user, $data->getId(), './app/a_message_tag_add.php', $tags, $text);
                    $tbody .= '<tr><td>' . $data->getMoment() . '<br><span class="text-hide">' . $data->getId() . '</span>
                        <button type="button" class="btn-modif btn btn-sm btn-danger">Modifier</button>
                        </td>
                        <td><div class="ck-inline" contenteditable="true">' . $data->getMessage() . '</div></td><td>' . $text . '</td>
                        <td>' . $emotion_txt . $this->AddEmotionOnElement($data->getId(), './app/a_message_emo.php') . '</td>
                        <td>' . $data->getNote() . $this->AddNoteOnElement($data->getId(), './app/a_message_note.php') . '</td>
                        <td>texte à ajouter' . $this->AddEventOnElement($data->getId(), './app/a_message_event.php') . '</td>
                        </tr>';
                }
                $content = Output::TableHead(['Date', 'Message', 'Tags', 'Emotion', 'Note', 'Event'], $tbody, 'Messages <button type="button" class="btn btn-primary" data-toggle="collapse" href="#f-message-add-collapse">+</button>');
            }
        }
        return $content;
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
                        $tbody .= '<tr><td>' . Output::ShowImage($data->getLink(), $data->getTitle(), 'users/' . $user . '/') . '</td><td>' . $data->getTitle() . '</td></tr>';
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
        LEFT JOIN tag_link as tl ON t.id=tl.tag_id AND tl.data_type=$type
        LEFT JOIN image as i ON i.id=tl.data_id
        WHERE user_id=$user AND t.id NOT IN (SELECT tag_id FROM tag_link WHERE data_type=$type AND data_id=$id)";
        $dbh = DB::connect();
        $result = $dbh->prepare($query);
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
        $return = false;
        if (!$tags) {
            $tags = DBManager::getData('tag', 'id', 'user_id', $user, '', '', '', 'COUNT');
        }
        if ($tags) {
            if ($text) $return = '<hr>';
            $form = new Form();
            $return .= $form->CreateForm($action, 'POST', '')
                ->AddSelect('tag_id', '', 'tag', ['id', 'tag_name'], 'tag_name', 'id', 'user_id', $user, 'tag_name', 'ASC')
                ->AddInput('id', '', 'hidden', $element_id)
                ->EndForm('Ajouter', 'primary');
        } else {
            $return = Output::btnModal('modal-add-btn', '+', 'primary');
        }
        return $return;
    }

    /**
     * @param int $id
     * @param string $action
     * @param string $text
     * @return bool|string
     */
    private function AddEmotionOnElement($id, $action, $text = '')
    {
        $return = false;
        if ($text) $return = '<hr>';
        $form = new Form();
        $return .= $form->CreateForm($action, 'POST', '')
            ->AddSelect('emotion', '', 'emotion', ['id', 'em_name'], 'em_name', 'id', '', '', 'em_name', 'ASC')
            ->AddInput('id', '', 'hidden', $id)
            ->EndForm('Modifier', 'primary');
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
            ->EndForm('Modifier', 'primary');
        return $return;
    }

    /**
     * @param int $id
     * @param string $action
     * @param string $text
     * @return bool|string
     */
    private function AddNoteOnElement($id, $action, $text = '')
    {
        $return = false;
        if ($text) $return = '<hr>';
        $form = new Form();
        $return .= $form->CreateForm($action, 'POST', '')
            ->AddSelectNumber('note', '', 1, 10)
            ->AddInput('id', '', 'hidden', $id)
            ->EndForm('Noter', 'primary');
        return $return;
    }

    /**
     * @param int $id
     * @param string $action
     * @param string $text
     * @return bool|string
     */
    private function AddEventOnElement($id, $action, $text = '')
    {
        $return = false;
        if ($text) $return = '<hr>';
        $form = new Form();
        $return .= $form->CreateForm($action, 'POST', '')
            ->AddSelect('event_id', 'Evénement', 'event', ['id', 'moment', 'title'], ['moment', 'title'], 'id', 'user_id', $_SESSION['id'], 'moment', 'DESC')
            ->AddInput('id', '', 'hidden', $id)
            ->EndForm('Modifier', 'primary');
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
                    $content = '<div class="row">' . $content . '</div>';
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
                $result = $dbh->query($query);
                if ($result) {
                    $tbody = '';
                    while ($data = $result->fetchObject()) {
                        $text = $this->listTagsFromElement(1, $data, $dbh, false);
                        if ($text) $text .= '<hr>';
                        $form = new Form();
                        $text .= $form->CreateForm('./app/a_message_tag_add.php', 'POST', '')
                            ->AddSelect('tag_id', '', 'tag', ['id', 'tag_name'], 'tag_name', 'id', 'user_id', $user, 'tag_name', 'ASC')
                            ->AddInput('id', '', 'hidden', $data->id)
                            ->EndForm('Ajouter', 'primary');
                        $tbody .= '<tr><td>' . $data->moment . '<br><span class="text-hide">' . $data->id . '</span>
                        <button type="button" class="btn btn-sm btn-danger btn-modif">Modifier</button>
                        </td>
                        <td><div class="ck-inline" contenteditable="true">' . $data->message . '</div></td><td>' . $text . '</td><td>' . $data->note . $this->AddNoteOnElement($data->id, './app/a_message_note.php') . '</td></tr>';
                    }
                    $content = Output::TableHead(['Date', 'Message', 'Tags', 'Note'], $tbody, 'Messages');
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
                    ->AddSelect('tag_id', 'Nouveau Tag', 'tag', ['id', 'tag_name'], 'tag_name', 'id', 'user_id', $user, 'tag_name', 'ASC')
                    ->AddInput('id', '', 'hidden', $data[0])
                    ->EndForm('Modifier', 'primary');
                $tbody .= '<tr>
                            <td>' . $data[1] . '</td>
                            <td>' . Output::Popup($tag_nbr . ' ' . Output::Plural('référence', $tag_nbr), $help_txt) . '</td>
                            <td><form><button type="button" class="btn btn-primary" data-toggle="collapse" data-target="#clp-tag-tr-' . $data[0] . '"><i class="fa fa-exchange"></i></button></form><div class="collapse" id="clp-tag-tr-' . $data[0] . '">' . $form_tr . '</div></td>
                        </tr>';
            } else {
                $form_delete = $form->CreateForm('./app/a_tag_del.php', 'POST', '')
                    ->AddInput('id', '', 'hidden', $data[0])
                    ->EndForm('fa fa-trash-o', 'danger');
                $tbody .= '<tr><td>' . $data[1] . '</td><td>' . $form_delete . '</td><td>' . Output::Popup('<form><button type="button" class="btn btn-danger"><i class="fa fa-ban"></i></button></form>', $help_txt2) . '</td></tr>';
            }
        }
        $btn_add = Output::btnModal('modal-add-btn', '+', 'primary');
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
            $results = DBManager::getData('event', ['id', DBManager::SQLDateFormat('moment', 'BIRTH', 'time'), 'title', 'moment', 'note', 'emotion', 'event_type'], 'user_id', $user, 'moment', 'DESC', 20, 'CLASS');
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