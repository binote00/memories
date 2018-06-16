<?php
/**
 *
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
    public $title;
    private $moment;
    private $emotion;
    private $note;
    public $time;

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
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title): void
    {
        $this->title = $title;
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
        if (is_array($vars)) {
            $return = DBManager::setData('event', ['user_id', 'event_type', 'title', 'moment', 'emotion', 'note'], [$vars['user_id'], $vars['event_type'], $vars['title'], $vars['moment'], $vars['emotion'], $vars['note']]);
        }
        if ($return && $vars['tag']) {
            $return = DBManager::setData('tag_link', ['tag_id', 'data_type', 'data_id'], [$vars['tag'], DATA_TYPE_EVENT, $return]);
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
        return DBManager::setData('tag_link', ['tag_id', 'data_type', 'data_id'], [$tag_id, 5, $id]);
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

    /**
     * @param int $id
     * @param string $action
     * @return bool|string
     */
    public static function updateEventTitle($id, $action)
    {
        $return = '<hr>';
        $form = new Form();
        $return .= $form->CreateForm($action, 'POST', '')
            ->AddInput('title', '', 'text', '', '', '', 'required')
            ->AddInput('id', '', 'hidden', $id)
            ->EndForm('Modifier', 'primary');
        return $return;
    }
}