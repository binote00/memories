<?php
/**
 *
 * User: JF
 * Date: 22-10-17
 * Time: 11:15
 */

/**
 * Générateur de requêtes
 */
trait DBManager
{
    use DB;

    /**
     * Générateur de champs de requête SELECT ou WHERE
     *
     * @param array|string $fields
     * @param string $concat [, dans le cas d'un select ou d'un update; AND, OR, etc... dans le cas d'un WHERE]
     * @param string $addtxt [suffixe pour chaque élément de la requête, par exemple un =:toto pour chaque champs du where dans une requête préparée]
     * @param bool|int $addnbr [si le suffixe doit être indicé]
     * @return bool|string
     */
    private static function getSelectFields($fields, $concat, $addtxt = '', $addnbr = false)
    {
        $return = false;
        if (is_array($fields)) {
            $nbr = 0;
            $addtxtfinal = $addtxt;
            foreach ($fields as $field) {
                if ($addnbr) {
                    $addtxtfinal = $addtxt . $nbr;
                }
                if ($nbr > 0) {
                    if ($field == 'NOW()') {
                        $return .= $concat . $field . '=NOW()';
                    } else {
                        $return .= $concat . $field . $addtxtfinal;
                    }
                } else {
                    $return .= $field . $addtxtfinal;
                }
                $nbr++;
            }
        } else {
            $return = $fields . $addtxt;
        }
        return $return;
    }

    /**
     * Générateur de champs de requête INSERT
     *
     * @param array|string $fields
     * @return bool|string
     */
    private static function getInsertFields($fields)
    {
        $return = false;
        $values = false;
        if (is_array($fields)) {
            foreach ($fields as $field) {
                $return .= ',' . $field;
                if ($field == 'NOW()') {
                    $values .= ',NOW()';
                } else {
                    $values .= ',?';
                }
            }
            $return = '(' . substr($return, 1) . ') VALUES (' . substr($values, 1) . ')';
        } else {
            $return = $fields . '=' . $values;
        }
        return $return;
    }

    /**
     * Générateur de bindParam
     *
     * @param PDOStatement $result
     * @param array|string $params
     * @param bool $update
     */
    private static function bindParams($result, $params, $update = false)
    {
        $tag = ':field';
        if ($update) {
            $tag = ':data';
        }
        if (is_array($params)) {
            $nbr = 0;
            foreach ($params as &$param) {
                if ($param != 'NOW()') {
                    $result->bindParam($tag . $nbr, $param, 2);
                }
                $nbr++;
            }
        } else {
            $result->bindParam($tag, $params, 2);
        }
    }

    /**
     * @param string $table
     * @param array|string $selectField
     * @param string $order
     * @param string $orderBy
     * @param mixed $limit
     * @param string $fetch [object or array or multi]
     * @return array|int|mixed
     */
    public static function getAllData($table, $selectField, $order = '', $orderBy = 'DESC', $limit = '', $fetch = 'ALL')
    {
        if ($order) {
            $order = ' ORDER BY ' . $order . ' ' . $orderBy;
        }
        if (is_array($limit)) {
            if ($limit[0] < 0) $limit[0] = 0;
            $order .= ' LIMIT ' . $limit[0] . ', ' . $limit[1];
        } elseif ($limit) {
            $order .= ' LIMIT ' . $limit;
        }
        $dbh = DB::connect();
        $selectFields = self::getSelectFields($selectField, ',');
        $query = "SELECT $selectFields FROM $table " . $order;
        $result = $dbh->query($query);
        if ($fetch == 'OBJECT') {
            $data = $result->fetchObject();
        } elseif ($fetch == 'CLASS') {
            $data = $result->fetchAll(PDO::FETCH_CLASS, ucfirst($table));
        } elseif ($fetch == 'COUNT') {
            $data = $result->rowCount();
        } else {
            $data = $result->fetchAll();
        }
        return $data;
    }

    /**
     * Générateur de résultat [SELECT FROM WHERE]
     *
     * @param string $table
     * @param array|string $selectField
     * @param array|string $whereField
     * @param array|mixed $whereValue
     * @param string $order
     * @param string $orderBy
     * @param mixed $limit
     * @param string $fetch [object or array or multi]
     * @return mixed
     */
    public static function getData($table, $selectField, $whereField, $whereValue, $order = '', $orderBy = 'DESC', $limit = '', $fetch = 'ALL')
    {
        $whereFields = '';
        if ($order) {
            $order = ' ORDER BY ' . $order . ' ' . $orderBy;
        }
        if (is_array($limit)) {
            if ($limit[0] < 0) $limit[0] = 0;
            $order .= ' LIMIT ' . $limit[0] . ', ' . $limit[1];
        } elseif ($limit) {
            $order .= ' LIMIT ' . $limit;
        }
        $dbh = DB::connect();
        $selectFields = self::getSelectFields($selectField, ',');
        if ($whereField and $whereValue) {
            $whereFields = "WHERE " . self::getSelectFields($whereField, ' AND ', '=:field', true);
        }
        $query = "SELECT $selectFields FROM $table " . $whereFields . $order;
        //echo '[GETDATA-QUERY]'.$query.' / '.$whereValue.' /';
        $result = $dbh->prepare($query);
        if ($whereValue) {
            self::bindParams($result, $whereValue);
        }
        $result->execute();
        if ($fetch == 'OBJECT') {
            $data = $result->fetchObject();
        } elseif ($fetch == 'CLASS') {
            $data = $result->fetchAll(PDO::FETCH_CLASS, ucfirst($table));
        } elseif ($fetch == 'COUNT') {
            $data = $result->rowCount();
        } else {
            $data = $result->fetchAll();
        }
        return $data;
    }

    /**
     * Générateur de résultat [SELECT FROM WHERE]
     *
     * @param string $table
     * @param array|string $selectField
     * @param array|string $whereField
     * @param array|mixed $whereValue
     * @param string $order
     * @param string $orderBy
     * @param mixed $limit
     * @return mixed
     */
    public static function getDatas($table, $selectField, $whereField, $whereValue, $order = '', $orderBy = 'DESC', $limit = '')
    {
        $whereFields = '';
        if ($order) {
            $order = ' ORDER BY ' . $order . ' ' . $orderBy;
        }
        if (is_array($limit)) {
            if ($limit[0] < 0) $limit[0] = 0;
            $order .= ' LIMIT ' . $limit[0] . ', ' . $limit[1];
        } elseif ($limit) {
            $order .= ' LIMIT ' . $limit;
        }
        $dbh = DB::connect();
        $selectFields = self::getSelectFields($selectField, ',');
        if ($whereField and $whereValue) {
            $whereFields = "WHERE " . self::getSelectFields($whereField, ' AND ', '=:field', true);
        }
        $query = "SELECT $selectFields FROM $table " . $whereFields . $order;
        //echo $query;
        $result = $dbh->prepare($query);
        if ($whereValue) {
            self::bindParams($result, $whereValue);
        }
        $result->execute();
        return $result;
    }

    /**
     * Générateur de Mise à jour [UPDATE SET WHERE OR INSERT INTO]
     *
     * @param string $table
     * @param array|string $setField
     * @param array|string $values
     * @param array|string $whereField
     * @param array|mixed $whereValue
     * @return mixed
     */
    public static function setData($table, $setField, $values, $whereField = '', $whereValue = '')
    {
        $dbh = DB::connect();
        if ($whereField and $whereValue) {
            $setFields = self::getSelectFields($setField, $values, '=:data');
            $whereFields = self::getSelectFields($whereField, ' AND ', '=:field', true);
            $query = "UPDATE $table SET $setFields WHERE $whereFields";
            /*mail(LOG_EMAIL, 'MEMORIES : SET DATA', $query);
            echo $query;*/
            $result = $dbh->prepare($query);
            self::bindParams($result, $whereValue);
            self::bindParams($result, $values, true);
            $result->execute();
            $return = $result->rowCount();
        } else {
            $exist = self::getData($table, 'id', $setField, $values, '', 'DESC', '', 'COUNT');
            if (!$exist) {
                $setFields = self::getInsertFields($setField);
                $query = "INSERT INTO " . $table . $setFields;
                //echo $query;
                $result = $dbh->prepare($query);
                $result->execute($values);
                $return = $dbh->lastInsertId();
            } else {
                $return = false;
            }
        }
        return $return;
    }

    /**
     * Convertisseur de date SQL
     *
     * @param string $date
     * @param string $mode
     * @param string $alias
     * @return string
     */
    public static function SQLDateFormat($date, $mode = 'LOG', $alias = '')
    {
        if (!$alias) {
            $alias = $date;
        }
        if ($mode == 'BIRTH') {
            return 'DATE_FORMAT(' . $date . ',\'%d-%m-%Y\') AS ' . $alias;
        } elseif ($mode == 'LOG') {
            return 'DATE_FORMAT(' . $date . ',\'%d-%m %H:%i\') AS ' . $alias;
        }
    }
}