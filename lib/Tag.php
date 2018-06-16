<?php
/**
 *
 * User: JF
 * Date: 02-12-17
 * Time: 12:53
 */

/**
 * Class Tag : DB Table
 */
class Tag
{
    private $id;
    private $tag_name;
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
    public function getTagName()
    {
        return $this->tag_name;
    }

    /**
     * @param mixed $tag_name
     */
    public function setTagName($tag_name)
    {
        $this->tag_name = $tag_name;
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
     * @param $vars
     * @return mixed
     */
    public function addTag($vars)
    {
        $return = false;
        if (is_array($vars) && isset($vars['user_id']) && isset($vars['tag_name'])) {
            $dbh = DB::connect();
            $result = $dbh->prepare("SELECT COUNT(*) FROM tag WHERE user_id=:user_id AND tag_name=:tag_name");
            $result->bindParam('user_id', $vars['user_id'], 1);
            $result->bindParam('tag_name', $vars['tag_name'], 2);
            $result->execute();
            $data = $result->fetchAll();
            if ($data[0][0]) {
                $return = false;
            } else {
                $result = $dbh->prepare("INSERT INTO tag (tag_name, user_id) VALUES (:tag_name, :user_id)");
                $result->bindParam(':tag_name', $vars['tag_name'], 2);
                $result->bindParam(':user_id', $vars['user_id'], 1);
                $result->execute();
                if ($result->rowCount()) {
                    $this->setId($dbh->lastInsertId());
                    $return = $this->id;
                }
            }
        }
        return $return;
    }

    public function modTag($vars)
    {
        $return = false;
        if (is_array($vars) && isset($vars['user_id']) && isset($vars['tag_name']) && isset($vars['id'])) {
            $dbh = DB::connect();
            $result = $dbh->prepare("SELECT COUNT(*) FROM tag WHERE user_id=:user_id AND tag_name=:tag_name");
            $result->bindParam('user_id', $vars['user_id'], 1);
            $result->bindParam('tag_name', $vars['tag_name'], 2);
            $result->execute();
            $data = $result->fetchAll();
            if ($data[0][0]) {
                $return = false;
            } else {
                $return = DBManager::setData('tag', 'tag_name', $vars['tag_name'], 'id', $vars['id']);
            }
        }
        return $return;
    }

    /**
     * @param integer $id
     * @return bool
     */
    public function delTag($id)
    {
        $dbh = DB::connect();
        $result = $dbh->prepare("DELETE FROM tag WHERE id=:id");
        $result->bindParam('id', $id, 1);
        $result->execute();
        $return = $result->rowCount();
        return $return;
    }

    /**
     * @param int $id
     * @return int
     */
    public function delTagLink($id)
    {
        $dbh = DB::connect();
        $result = $dbh->prepare("DELETE FROM tag_link WHERE id=:id");
        $result->bindParam('id', $id, 1);
        $result->execute();
        $return = $result->rowCount();
        return $return;
    }

    /**
     * @param integer $id
     * @return mixed
     */
    public function getTagLinks($id)
    {
        return DBManager::getData('tag_link', ['id', 'tag_id'], 'tag_id', $id, '', '', '', 'COUNT');
    }

    /**
     * @param int $tag_id
     * @param int $new_tag_id
     * @return mixed
     */
    public function TransferTag($tag_id, $new_tag_id)
    {
        return DBManager::setData('tag_link', 'tag_id', $new_tag_id, 'tag_id', $tag_id);
    }
}