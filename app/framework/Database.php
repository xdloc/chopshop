<?php
declare(strict_types=1);

namespace App\Framework;

use PDO;

/**
 * Trait Database
 * @package App\Framework
 */
trait Database
{
    /**
     * @return PDO
     */
    private function connect()
    {
        $string = "mysql:hostname=".DB_HOST.";dbname=".DB_NAME;
        return new PDO($string, DB_USER, DB_PASS);
    }

    /**
     * @param $query
     * @param  array  $data
     * @return array|bool
     */
    public function query($query, $data = [])
    {

        $con = $this->connect();
        $stm = $con->prepare($query);

        $check = $stm->execute($data);
        if ($check) {
            $result = $stm->fetchAll(PDO::FETCH_OBJ);
            if (is_array($result) && count($result)) {
                return $result;
            }
        }

        return false;
    }

    /**
     * @param $query
     * @param  array  $data
     * @return bool|mixed
     */
    public function getRow($query, $data = [])
    {

        $con = $this->connect();
        $stm = $con->prepare($query);

        $check = $stm->execute($data);
        if ($check) {
            $result = $stm->fetchAll(PDO::FETCH_OBJ);
            if (is_array($result) && count($result)) {
                return $result[0];
            }
        }

        return false;
    }

}


