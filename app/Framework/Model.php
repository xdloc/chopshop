<?php
declare(strict_types=1);

namespace App\Framework;

/**
 * Trait Model
 * @package App\Framework
 */
trait Model
{
    use Database;

    protected int $limit = 10;
    protected int $offset = 0;
    protected string $orderType = "desc";
    protected string $orderColumn = "id";
    public array $errors = [];

    /**
     * @return array|bool
     */
    public function findAll(): bool|array
    {

        $query = "select * from $this->table order by $this->orderColumn $this->orderType limit $this->limit offset $this->offset";
        return $this->query($query);
    }

    /**
     * @param $data
     * @param  array  $data_not
     * @return array|bool
     */
    public function where($data, array $data_not = []): bool|array
    {
        $query = $this->selectFrom($data, $data_not);

        $query .= " order by $this->orderColumn $this->orderType limit $this->limit offset $this->offset";
        $data = array_merge($data, $data_not);

        return $this->query($query, $data);
    }

    /**
     * @param $data
     * @param  array  $data_not
     * @return bool|mixed
     */
    public function first($data, array $data_not = []): mixed
    {
        $query = $this->selectFrom($data, $data_not);

        $query .= " limit $this->limit offset $this->offset";
        $data = array_merge($data, $data_not);

        $result = $this->query($query, $data);
        if ($result) {
            return $result[0];
        }

        return false;
    }

    /**
     * @param $data
     * @return bool
     */
    public function insert($data): bool
    {
        if (!empty($this->allowedColumns)) {
            foreach ($data as $key => $value) {

                if (!in_array($key, $this->allowedColumns, true)) {
                    unset($data[$key]);
                }
            }
        }

        $keys = array_keys($data);

        $query = "insert into $this->table (".implode(",", $keys).") values (:".implode(",:", $keys).")";
        return (bool)$this->query($query, $data);
    }

    /**
     * @param  int  $id
     * @param  array  $data
     * @param  string  $id_column
     * @return bool
     */
    public function update(int $id, array $data, string $id_column = 'id'): bool
    {
        if (!empty($this->allowedColumns)) {
            foreach ($data as $key => $value) {

                if (!in_array($key, $this->allowedColumns, true)) {
                    unset($data[$key]);
                }
            }
        }

        $keys = array_keys($data);
        $query = "update $this->table set ";

        foreach ($keys as $key) {
            $query .= $key." = :".$key.", ";
        }

        $query = trim($query, ", ");
        $query .= " where $id_column = :$id_column ";
        $data[$id_column] = $id;

        return (bool)$this->query($query, $data);
    }

    /**
     * @param  int  $id
     * @param  string  $id_column
     * @return bool
     */
    public function delete(int $id, string $id_column = 'id'): bool
    {
        $data[$id_column] = $id;
        $query = "delete from $this->table where $id_column = :$id_column ";
        return (bool)$this->query($query, $data);
    }

    /**
     * @param $data
     * @param  array  $data_not
     * @return string
     */
    protected function selectFrom($data, array $data_not): string
    {
        $keys = array_keys($data);
        $keys_not = array_keys($data_not);
        $query = "select * from $this->table where ";

        foreach ($keys as $key) {
            $query .= $key." = :".$key." && ";
        }

        foreach ($keys_not as $key) {
            $query .= $key." != :".$key." && ";
        }

        return trim($query, " && ");
    }


}