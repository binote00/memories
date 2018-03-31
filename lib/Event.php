<?php
/**
 * Created by PhpStorm.
 * User: Binote
 * Date: 08-12-17
 * Time: 10:32
 */

/**
 * Class Event : DB Table
 */
class Event
{
    private $id;
    private $user_id;
    private $event_type;
    private $moment;
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
    public function setId($id): void
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
    public function setUserId($user_id): void
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
    public function setEventType($event_type): void
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
    public function setMoment($moment): void
    {
        $this->moment = $moment;
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
     * @param array $vars
     * @return bool|mixed
     */
    public function addEvent($vars)
    {
        $return = false;
        if(is_array($vars)){
            $return = DBManager::setData('event', ['user_id', 'event_type', 'moment', 'emotion', 'note'], [$vars['user_id'], $vars['event_type'], $vars['moment'], $vars['emotion'], $vars['note']]);
        }
        return $return;
    }

    /**
     * @param int $id
     * @param int $tag_id
     * @return int
     */
    public function setEventTag($id, $tag_id)
    {
        $dbh = DB::connect();
        $result2 = $dbh->prepare("INSERT INTO tag_link (tag_id, data_type, data_id) VALUES (:tag_id, 5, :data_id)");
        $result2->bindParam(':tag_id', $tag_id,1);
        $result2->bindParam(':data_id', $id,1);
        $result2->execute();
        return $result2->rowCount();
    }

    /**
     * @param int $id
     * @param array|string $vars
     * @param mixed $values
     * @return mixed
     */
    public function updateEvent($id, $vars, $values)
    {
        return DBManager::setData('event', $vars, $values,'id', $id);
    }

    /**
     * @param int $id
     * @param string $action
     * @param string $text
     * @return bool|string
     */
    public static function updateEventDate($id, $action, $text = '')
    {
        $return = false;
        if ($text) $return = '<hr>';
        $form = new Form();
        $return .= $form->CreateForm($action, 'POST', '')
            ->AddInput('moment', '', 'date', '', '', '', 'required')
            ->AddInput('id', '', 'hidden', $id)
            ->EndForm('Modifier', 'primary');
        return $return;
    }
}