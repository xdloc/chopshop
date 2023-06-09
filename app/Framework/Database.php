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
    private function connect(): PDO
    {
        $string = "mysql:hostname=".DB_HOST.";dbname=".DB_NAME;
        return new PDO($string, DB_USER, DB_PASS);
    }

    /**
     * @param $query
     * @param  array  $data
     * @return array|bool
     */
    public function query($query, array $data = []): bool|array
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
}


