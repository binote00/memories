<?php
/**
 * Created by PhpStorm.
 * User: Binote
 * Date: 24-11-17
 * Time: 09:13
 */

/**
 * Class People : DB Table
 */
class People
{
    private $id;
    private $first_name;
    private $last_name;
    private $nickname;
    private $birth_date;
    private $email;
    private $photo;
    private $status;
    private $user_id;

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
    public function getNickname()
    {
        return $this->nickname;
    }

    /**
     * @param mixed $nickname
     */
    public function setNickname($nickname)
    {
        $this->nickname = $nickname;
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
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * @param mixed $photo
     */
    public function setPhoto($photo)
    {
        $this->photo = $photo;
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
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @param mixed $user_id
     */
    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }

    /**
     * @param array|mixed $vars
     * @param int $photo
     * @return bool|int
     */
    public function addPeople($vars, $photo=0)
    {
        $return = false;
        if(is_array($vars)){
            if (isset($vars['birth_date']) && !empty($vars['birth_date'])) {
                $date = DateTime::createFromFormat('Y-m-d', $vars['birth_date']);
                $birth_date = $date->format('Y-m-d');
            } else {
                $birth_date = null;
            }
            $dbh = DB::connect();
            $result = $dbh->prepare("INSERT INTO people (first_name, last_name, nickname, birth_date, email, photo, user_id) VALUES (:first_name, :last_name, :nickname, :birth_date, :email, :photo, :user_id)");
            $result->bindParam(':first_name', $vars['first_name'],2);
            $result->bindParam(':last_name', $vars['last_name'],2);
            $result->bindParam(':nickname', $vars['nickname'], 2);
            $result->bindParam(':birth_date', $birth_date,2);
            $result->bindParam(':email', $vars['email'], 2);
            $result->bindParam(':photo', $photo, 1);
            $result->bindParam(':user_id', $vars['user_id'], 1);
            $result->execute();
            $return = $result->rowCount();
            /*$result = DBManager::setData('people', ['first_name', 'last_name', 'nickname', 'email', 'photo', 'user_id'],
                [$vars['first_name'], $vars['last_name'], $vars['nickname'], $vars['email'], $photo, $vars['user_id'],]);
            $return = $result->rowCount();*/
        }
        return $return;
    }

    /**
     * @param array $vars
     * @param int $photo
     * @return bool|mixed
     */
    public function modPeople($vars, $photo=0)
    {
        $return = false;
        if(is_array($vars) && $vars['id']){
            $dbh = DB::connect();
            $result = $dbh->prepare("UPDATE people SET first_name=:first_name, last_name=:last_name, nickname=:nickname, birth_date=:birth_date, email=:email, photo=:photo WHERE id=:id");
            $result->bindParam(':first_name', $vars['first_name'],2);
            $result->bindParam(':last_name', $vars['last_name'],2);
            $result->bindParam(':nickname', $vars['nickname'], 2);
            $result->bindParam(':birth_date', $vars['birth_date'],2);
            $result->bindParam(':email', $vars['email'], 2);
            $result->bindParam(':photo', $photo, 1);
            $result->bindParam(':id', $vars['id'], 1);
            $result->execute();
            $return = $result->rowCount();
            /*$return = DBManager::setData('people', ['first_name', 'last_name', 'nickname', 'email', 'photo'],
                [$vars['first_name'], $vars['last_name'], $vars['nickname'], $vars['email'], $photo], 'id', $vars['id']);*/
            if ($return && $vars['event_id']) {
                DBManager::setData('event_link', ['event_id', 'data_type', 'data_id'], [$vars['event_id'], 4, $vars['id']]);
            }
        }
        return $return;
    }

    /**
     * @param mixed $id
     */
    public function getPeople($id)
    {
        if($id){
            $result = DBManager::getData('people', ['id', 'first_name', 'last_name', 'nickname', 'email', 'photo'], 'id', $id);
            $this->setFirstName($result->first_name);
            $this->setLastName($result->last_name);
            $this->setNickname($result->nickname);
            $this->setEmail($result->email);
            $this->setPhoto($result->photo);
        }
    }

    /**
     * @return mixed
     */
    public function viewProfile()
    {
        $form = new Form();

        return $form->CreateForm('./app/a_people_add.php', 'POST', 'Profil de la personne', true)
            ->AddInput('first_name', 'Prénom', 'text', $this->first_name, $this->first_name, true)
            ->AddInput('last_name', 'Nom', 'text', $this->last_name, $this->last_name, true)
            ->AddInput('nickname', 'Surnom', 'text', $this->nickname)
            ->AddInput('birth_date', 'Date de Naissance', 'date', $this->birth_date)
            ->AddInput('email', 'Email', 'email', $this->email)
            ->AddInput('img', 'Photo', 'file', $this->photo)
            ->AddInput('title', '', 'hidden', 'people-'.$this->id)
            ->AddInput('user_id', '', 'hidden', $_SESSION['id'])
            ->EndForm('Valider');
    }

    /**
     * @param int $user
     * @return bool|string
     */
    public function viewPeople($user)
    {
        $content = false;
        if($user){
            $results = DBManager::getData('people', ['id', 'first_name', 'last_name', 'nickname', 'birth_date', 'email', 'photo', 'status', 'user_id'], 'user_id', $user, 'id', 'ASC', 20, 'CLASS');
            if($results){
                $tbody='';
                $footer = '';
                foreach($results as $data){
                    $photo = '';
                    $title = $data->first_name.' '.$data->last_name;
                    if($data->photo){
                        $photo_id = DBManager::getData('image', 'link', 'id', $data->photo);
                        $photo = Output::ShowImage($photo_id[0][0], $title, 'users/'.$user.'/', 'img-people d-block mx-auto', 0);
                        $photo_modal = Output::ShowImage($photo_id[0][0], $title, 'users/'.$user.'/', 'img-fluid mx-auto d-block', 50);
                    }
                    $form = new Form();
                    $body = $photo_modal;
                    $body .= $form->CreateForm('./app/a_people_mod.php', 'POST', 'Profil de la personne', true)
                        ->AddInput('first_name', 'Prénom', 'text', $data->first_name, $data->first_name, true)
                        ->AddInput('last_name', 'Nom', 'text', $data->last_name, $data->last_name, true)
                        ->AddInput('nickname', 'Surnom', 'text', $data->nickname)
                        ->AddInput('birth_date', 'Date de Naissance', 'date', $data->birth_date)
                        ->AddInput('email', 'Email', 'email', $data->email)
                        ->AddInput('img', 'Photo', 'file', $data->photo)
                        ->AddInput('photo', '', 'hidden', $data->photo)
                        ->AddInput('id', '', 'hidden', $data->id)
                        ->EndForm('Valider');
                    //$detail = Output::btnModalJS('modal-people', 'Détail', $title, addslashes($body), 'footer');
                    /*$detail = '<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-people"
                    data-body="<form method=\"POST\"><input type=\"text\" id=\"first_name\" value="Patrick"><input type=\"text\" id=\"user_id\" value="1"></form></button>';*/
                    $footer .= Output::viewModal('ppl-modal-'.$data->id, $title, $body);
                    $detail = Output::btnModal('ppl-modal-'.$data->id,'+');
                    if (isset($data->birth_date) && !empty($data->birth_date)) {
                        $date = DateTime::createFromFormat('Y-m-d', $data->birth_date);
                        $birth_date = $date->format('d-m-Y');
                    } else {
                        $birth_date = '';
                    }

                    $tbody.='<tr><td>'.$detail.'</td><td>'.$data->first_name.'</td><td>'.$data->last_name.'</td><td>'.$data->nickname.'</td><td>'.$birth_date.'</td><td><a href="mailto:'.$data->email.'">'.$data->email.'</a></td><td>'.$photo.'</td></tr>';
                }
                $content = Output::TableHead(['Détail', 'Prénom', 'Nom', 'Surnom', 'Naissance', 'Email', 'Photo'], $tbody, 'Personnes <button type="button" class="btn btn-primary" data-toggle="collapse" href="#f-people-add-collapse">+</button>', 'people').$footer; //.Output::viewModalJS('modal-people', 'lg');
            }
        }
        return $content;
    }

}