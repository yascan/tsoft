<?php

namespace Tsoft\Core;

abstract class Model
{
    protected $table;
    protected $db;
    protected $select = '*';
    protected $where;
    protected $orderBy;
    protected $join;
    protected $limit;

    public function __construct()
    {
        $instance = Database::getInstance();
        $this->db = $instance->getConnection();
    }

    /**
     * @param string|array $column
     * @return $this
     */
    public function select(string|array $column)
    {
        $this->select = is_array($column) ? implode(', ', $column) : $column;
        return $this;
    }

    /**
     * @param array $where
     * @return $this
     */
    public function where(array $where)
    {
        $whereMap = array_map(function ($key, $value) {
            return "$key = '$value'";
        }, array_keys($where), $where);
        $this->where = "WHERE " . implode(' and ', $whereMap);
        return $this;
    }

    /**
     * @param string $column
     * @param string $order
     * @return $this
     */
    public function orderBy(string $column, string $order)
    {
        $order = strtoupper($order) == "ASC" ? strtoupper($order) : 'DESC';
        $this->orderBy = "ORDER BY $column $order";
        return $this;
    }

    /**
     * @return array|false
     */
    public function get()
    {
        //echo $this->selectString(); exit;
        $query = $this->db->prepare($this->selectString());
        $query->execute();
        return $query->fetchAll(\PDO::FETCH_OBJ);
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function findById(int $id)
    {
        $this->where(['id' => intval($id)]);
        $this->limit(1);
        $query = $this->db->prepare($this->selectString());
        $query->execute();
        return $query->fetch(\PDO::FETCH_OBJ);
    }

    /**
     * @param array $data
     * @return bool
     */
    public function update(array $data)
    {
        $keyData = array_map(function ($key) {
            return "$key=:$key, ";
        }, array_keys($data));
        $keyData = rtrim($keyData,', ');
        $query = $this->db->prepare("UPDATE $this->table SET $keyData $this->where $this->limit");
        return $query->execute($data);
    }

    /**
     * @return bool
     */
    public function delete()
    {
        $query = $this->db->prepare("DELETE FROM $this->table $this->where $this->limit");
        return $query->execute();
    }

    /**
     * @param array $data
     * @return bool
     */
    public function insert(array $data)
    {
        $keys = array_keys($data);
        $fields = implode(',', $keys);
        $placeholders = rtrim(str_repeat('?,', count($keys)), ',');
        $query = $this->db->prepare("INSERT INTO $this->table ($fields) VALUES ($placeholders)");
        return $query->execute(array_values($data));
    }

    /**
     * @param $join
     * @return $this
     */
    public function join($join)
    {
        $this->join = $join;
        return $this;
    }

    /**
     * @return string
     */
    private function selectString(): string
    {
        return "SELECT $this->select FROM $this->table $this->join $this->where $this->orderBy $this->limit";
    }

    /**
     * @param int $limit
     * @return $this
     */
    public function limit(int $limit)
    {
        $this->limit = "LIMIT $limit";
        return $this;
    }


}