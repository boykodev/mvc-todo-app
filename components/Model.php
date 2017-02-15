<?php

namespace components;

class Model
{
    protected $db;
    protected $table;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function getById($id) {
        $query = $this->db->prepare("
            SELECT * FROM {$this->table}
            WHERE id=:id
        ");

        $query->bindParam(':id', $id, \PDO::PARAM_INT);
        $query->execute();

        $result = $query->fetch(\PDO::FETCH_ASSOC);

        return $result;
    }

    public function getWhere($key, $value) {
        $query = $this->db->prepare("
            SELECT * FROM {$this->table}
            WHERE {$key} = :value
        ");

        $query->bindParam(':value', $value, \PDO::PARAM_STR);
        $query->execute();

        $result = $query->fetch(\PDO::FETCH_ASSOC);

        return $result;
    }

    public function getAll() {
        $query = $this->db->prepare("
            SELECT * FROM {$this->table}
            ORDER BY id DESC
        ");

        $query->execute();

        $result = $query->fetchAll(\PDO::FETCH_ASSOC);

        return $result;
    }

    public function getAllWhere($key, $value) {
        $query = $this->db->prepare("
            SELECT * FROM {$this->table}
            WHERE {$key} = :value
            ORDER BY id DESC
        ");

        $query->bindParam(':value', $value, \PDO::PARAM_STR);
        $query->execute();

        $result = $query->fetchAll(\PDO::FETCH_ASSOC);

        return $result;
    }

}