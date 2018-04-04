<?php
/**
 * Created by PhpStorm.
 * User: Binote
 * Date: 20-11-17
 * Time: 13:55
 */

/**
 * Class Image : DB Table
 */
class Image
{

    private $id;
    private $uploader;
    private $title;
    private $link;
    private $status;
    private $tag_name;

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
    public function getUploader()
    {
        return $this->uploader;
    }

    /**
     * @param mixed $uploader
     */
    public function setUploader($uploader)
    {
        $this->uploader = $uploader;
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
    public function setTitle($title)
    {
        $this->title = $title;
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
    public function getLink()
    {
        return $this->link;
    }

    /**
     * @param mixed $link
     */
    public function setLink($link)
    {
        $this->link = $link;
    }

    /**
     * @param array|mixed $vars
     * @param array|mixed $files
     * @return bool|int
     */
    public function addImage($vars, $files)
    {
        $return = false;
        $move = false;
        if (is_array($vars) && is_array($files)) {
            if (is_dir('../img/users/' . $vars['user_id']) == false) {
                mkdir('../img/users/' . $vars['user_id'], 0700);
            }
            if ($files['img']['type'] == 'image/png' || $files['img']['type'] == 'image/jpg' || $files['img']['type'] == 'image/jpeg') {
                $basename = basename($files['img']['name']);
                $move = move_uploaded_file($files['img']['tmp_name'], '../img/users/' . $vars['user_id'] . '/' . $basename);
            }
            if ($move) {
                $dbh = DB::connect();
                $result2 = $dbh->prepare("INSERT INTO image (uploader, link, title) VALUES (:uploader, :link, :title)");
                $result2->bindParam(':uploader', $vars['user_id'], 1);
                $result2->bindParam(':link', $basename, 2);
                $result2->bindParam(':title', trim($vars['title']), 2);
                $result2->execute();
                $return = $dbh->lastInsertId();
            }
        }
        return $return;
    }

    /**
     * @param array|mixed $vars
     * @param array|mixed $files
     * @return bool|int
     */
    public function addImages($vars, $files)
    {
        $return = false;
        if (is_array($vars) && is_array($files)) {
            $files_ok = 0;
            $values_query = '';
            if (is_dir('../img/users/' . $vars['user_id']) == false) {
                mkdir('../img/users/' . $vars['user_id'], 0700);
            }
            if (is_array($files['img'])) {
                foreach ($files['img']['error'] as $key => $error) {
                    if ($error == UPLOAD_ERR_OK) {
                        if ($files['img']['size'][$key] <= IMG_MAX_SIZE) {
                            if ($files['img']['type'][$key] == 'image/png' || $files['img']['type'][$key] == 'image/jpg' || $files['img']['type'][$key] == 'image/jpeg') {
                                $basename = basename($files['img']['name'][$key]);
                                $move = move_uploaded_file($files['img']['tmp_name'][$key], '../img/users/' . $vars['user_id'] . '/' . $basename);
                                if ($move) {
                                    if ($files_ok) {
                                        $values_query .= ", ";
                                    }
                                    $values_query .= "('" . $vars['user_id'] . "','" . $basename . "', '')";
                                    $files_ok++;
                                }
                            }
                        }
                    }
                }
            } else {
                var_dump($files);
            }
            if ($values_query) {
                $dbh = DB::connect();
                $query = "INSERT INTO image (uploader, link, title) VALUES " . $values_query;
                echo $query;
                $result = $dbh->query($query);
                $return = $result->rowCount();
            }
        }
        return $return;
    }

    /**
     * @param array|mixed $vars
     * @return bool|int
     */
    public function modImage($vars)
    {
        $return = false;
        if (is_array($vars)) {
            if ($vars['title']) {
                $return = DBManager::setData('image', 'title', $vars['title'], 'id', $vars['id']);
            }
            if ($vars['tag_id']) {
                $return = DBManager::setData('tag_link', ['tag_id', 'data_type', 'data_id'], [$vars['tag_id'], 2, $vars['id']]);
            }
            if ($vars['event_id']) {
                $return = DBManager::setData('event_link', ['event_id', 'data_type', 'data_id'], [$vars['event_id'], 2, $vars['id']]);
            }
        }
        return $return;
    }

    /**
     * @param array|mixed $vars
     * @return bool|int
     */
    public function delImage($vars)
    {
        $return = false;
        if (is_array($vars)) {
            $return = DBManager::setData('image', 'status', 1, 'id', $vars['id']);
        }
        return $return;
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function restoreImage($id)
    {
        return DBManager::setData('image', 'status', 0, 'id', $id);
    }
}