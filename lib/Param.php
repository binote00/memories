<?php
/**
 * Created by PhpStorm.
 * User: JF
 * Date: 05-04-18
 * Time: 09:06
 */

class Param
{
    private $id;
    private $param_name;
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
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getParamName()
    {
        return $this->param_name;
    }

    /**
     * @param mixed $param_name
     */
    public function setParamName($param_name): void
    {
        $this->param_name = $param_name;
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
     * @param string $name
     * @return int
     */
    public function getParamId($name)
    {
        $return = DBManager::getData('param', 'id', 'param_name', $name);
        return $return[0][0];
    }

    /**
     * @param int $user_id
     * @param array $vars
     * @return bool|int
     */
    public function modParam($user_id, $vars)
    {
        $return = false;
        if ($user_id and is_array($vars)) {
            $param_id = $this->getParamId(strtoupper($vars['param_id']));
            $query = "INSERT INTO users_param (user_id,param_id,param_value) VALUES (:user_id,:param_id,:param_value) ON DUPLICATE KEY UPDATE param_value=:param_value";
            $dbh = DB::connect();
            $result = $dbh->prepare($query);
            $result->bindParam('user_id', $user_id, 1);
            $result->bindParam('param_id', $param_id, 1);
            $result->bindParam('param_value', $vars['param_value'], 1);
            $result->execute();
            $return = $result->rowCount();
        }
        return $return;
    }
}