<?php

namespace models;

use components\Model;
use library\Task;

class Tasks extends Model
{

    protected $table = 'tasks';

    public function getById($id) {
        $result = parent::getById($id);

        return new Task($result);
    }

    public function getAll() {
        $result = parent::getAll();

        $tasks = array();
        foreach ($result as $task_data) {
            $tasks[] = new Task($task_data);
        }

        return $tasks;
    }

    public function getAllWhere($key, $value) {
        $result = parent::getAllWhere($key, $value);

        $tasks = array();
        foreach ($result as $task_data) {
            $tasks[] = new Task($task_data);
        }

        return $tasks;
    }

    public function saveToDatabase(Task $task) {
        if ($task->getId()) {
            $this->_updateTask($task);
        } else {
            return $this->_addTask($task);
        }
    }

    private function _addTask(Task $task) {
        $props = $task->getAsArray(array('id'));

        $cols = implode(',', array_keys($props));
        $vals = "'" . implode("','", $props) . "'";

        $query = $this->db->prepare("
            INSERT INTO {$this->table} ($cols)
            VALUES ($vals)
        ");

        $query->execute();

        return $this->db->lastInsertId();
    }

    private function _updateTask(Task $task) {
        $task_id = $task->getId();
        $props = $task->getAsArray(array('id'));

        $set_values = array();
        foreach ($props as $key => $value) {
            $set_values[] = "$key='$value'";
        }

        $set_values = implode(',', $set_values);

        $query = $this->db->prepare("
            UPDATE {$this->table}
            SET $set_values
            WHERE id = $task_id
        ");

        $query->bindParam(':task_id', $task_id, \PDO::PARAM_INT);

        return $query->execute();
    }
}