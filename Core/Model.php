<?php

namespace Tsoft\Core;

abstract class Model
{
    protected $table;
    protected $db;
    protected $select = '*';
    protected $where;
    protected $update;

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
     * @return array|false
     */
    public function get()
    {
        $query = $this->db->prepare("SELECT $this->select FROM $this->table $this->where");
        $query->execute();
        return $query->fetchAll(\PDO::FETCH_OBJ);
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function findById(int $id)
    {
        $query = $this->db->prepare("SELECT $this->select FROM $this->table WHERE id=:id LIMIT 1");
        $query->execute(compact('id'));
        return $query->fetch(\PDO::FETCH_OBJ);
    }

    /**
     * @param array $data
     * @return bool
     */
    public function update(array $data)
    {
        $updateMap = array_map(function ($key, $value) {
            return "$key=:$key";
        }, array_keys($data), $data);
        $this->update = implode(', ', $updateMap);
        $query = $this->db->prepare("UPDATE $this->table SET $this->update $this->where");
        return $query->execute($data);
    }

    /**
     * @return bool
     */
    public function delete()
    {
        $query = $this->db->prepare("DELETE FROM $this->table $this->where");
        return $query->execute();
    }

    /**
     * @param array $data
     * @return bool
     */
    public function create(array $data)
    {
        $keys = array_keys($data);
        $fields = implode(',', $keys);
        $placeholders = rtrim(str_repeat('?,', count($keys)), ',');
        $query = $this->db->prepare("INSERT INTO $this->table ($fields) VALUES ($placeholders)");
        return $query->execute(array_values($data));
    }


}