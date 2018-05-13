<?php
/**
 * Created by PhpStorm.
 * User: Binote
 * Date: 16-11-17
 * Time: 13:12
 */

/**
 * Class Message : DB Table
 */
class Message
{

    private $id;
    private $user_id;
    private $event_type;
    private $moment;
    private $message;
    private $emotion;
    private $note;


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
     * @return mixed
     */
    public function getEventType()
    {
        return $this->event_type;
    }

    /**
     * @param mixed $event_type
     */
    public function setEventType($event_type)
    {
        $this->event_type = $event_type;
    }

    /**
     * @return mixed
     */
    public function getMoment()
    {
        return $this->moment;
    }

    /**
     * @param mixed $moment
     */
    public function setMoment($moment)
    {
        $this->moment = $moment;
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param mixed $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * @return mixed
     */
    public function getEmotion()
    {
        return $this->emotion;
    }

    /**
     * @param mixed $emotion
     */
    public function setEmotion($emotion): void
    {
        $this->emotion = $emotion;
    }

    /**
     * @return mixed
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * @param mixed $note
     */
    public function setNote($note): void
    {
        $this->note = $note;
    }

    /**
     * @param mixed $event
     */
    public function getMessageInfos($event)
    {
        if($event){
            $result = DBManager::getData('Message', ['id', 'user_id', 'event_type', 'moment'], 'id', $event);
            if($result){
                $this->setId($result[0]['id']);
                $this->setUserId($result[0]['user_id']);
                $this->setEventType($result[0]['event_type']);
                $this->setMoment($result[0]['moment']);
            }
        }
    }

    /**
     * @param array|mixed $vars
     * @return bool|int
     */
    public function setMessageInfos($vars)
    {
        $return = false;
        if(is_array($vars)){
            $dbh = DB::connect();
            if($vars['user_id'] && $vars['event_type'] && $vars['message']){
                $result = $dbh->prepare("INSERT INTO message (user_id, event_type, moment, message, emotion, note) VALUES (:user_id, :event_type, NOW(), :message, :emotion, :note)");
                $result->bindParam(':user_id', $vars['user_id'],1);
                $result->bindParam(':event_type', $vars['event_type'],1);
                $result->bindParam(':message', $vars['message'], 2);
                $result->bindParam(':emotion', $vars['emotion'], 1);
                $result->bindParam(':note', $vars['note'], 1);
                $result->execute();
                $return = $result->rowCount();
                $data_id = $dbh->lastInsertId();
            }
            if($vars['tag'] && $data_id){
                $result2 = $dbh->prepare("INSERT INTO tag_link (tag_id, data_type, data_id) VALUES (:tag_id, 1, :data_id)");
                $result2->bindParam(':tag_id', $vars['tag'],1);
                $result2->bindParam(':data_id', $data_id,1);
                $result2->execute();
                $tag_ok = $result2->rowCount();
                if(!$tag_ok){
                    $return = false;
                }
            }
            /*$result = DBManager::setData('events', ['user_id', 'event_type', 'moment'],
                [$vars['user_id'], $vars['event_type'], 'NOW()']);*/
        }
        return $return;
    }

    /**
     * @param int $id
     * @param int $tag_id
     * @return int
     */
    public function setMessageTag($id, $tag_id)
    {
        $dbh = DB::connect();
        $result2 = $dbh->prepare("INSERT INTO tag_link (tag_id, data_type, data_id) VALUES (:tag_id, 1, :data_id)");
        $result2->bindParam(':tag_id', $tag_id,1);
        $result2->bindParam(':data_id', $id,1);
        $result2->execute();
        return $result2->rowCount();
    }

    /**
     * @param array $vars
     * @return mixed
     */
    public function updateMessage($vars)
    {
        if(is_array($vars)){
            return DBManager::setData('message', 'message', $vars['message'],'id', $vars['id']);
        }
    }

    /**
     * @param int $id
     * @param int $note
     * @return mixed
     */
    public function updateMessageNote($id, $note)
    {
        return DBManager::setData('message', 'note', $note,'id', $id);
    }

    /**
     * @param int $id
     * @param int $eventid
     * @return mixed
     */
    public function updateMessageEvent($id, $eventid)
    {
        $return = false;
        if ($id && $eventid) {
            $return = DBManager::setData('event_link', ['event_id', 'data_type', 'data_id'], [$eventid, 1, $id]);
        }
        return $return;
    }


}