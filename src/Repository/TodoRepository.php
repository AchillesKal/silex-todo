<?php

namespace Todo\Repository;

use Doctrine\DBAL\Connection;
use Todo\Entity\Task;

class TodoRepository
{

    /**
     * @var \Doctrine\DBAL\Connection
     */
    protected $db;

    public function __construct(Connection $db)
    {
        $this->db = $db;
    }

    /**
     * Saves the todo to the database.
     *
     * @param \Todo\Entity\Task $task
     */
    public function save($task)
    {
        $taskData = array(
            'name' => $task->getName(),
            'description' => $task->getDescription(),
            'is_done' => $task->getIsDone(),
        );
        if ($task->getId()) {
            $this->db->update('tasks', $taskData, array('id' => $task->getId()));
        }
        else {
            $this->db->insert('tasks', $taskData);
            // Get the id of the newly created task and set it on the entity.
            $id = $this->db->lastInsertId();
            $task->setId($id);
        }
    }

    public function findOneById($id)
    {
        $sql = "SELECT * FROM tasks WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue("id", $id);
        $stmt->execute();
        $tasksData = $stmt->fetch();
        $task = $this->buildTask($tasksData);
        return $task;
    }

    public function findAll()
    {
        $tasksData = $this->db->fetchAll('SELECT * FROM tasks');

        $tasks = array();
        foreach ($tasksData as $taskData) {
            $taskId = $taskData['id'];
            $tasks[$taskId] = $this->buildTask($taskData);
        }

        return $tasks;
    }

    public function delete($task)
    {
        return $this->db->delete('tasks', array('id' => $task->getId()));
    }

    private function buildTask($taskData)
    {
        $task = new Task();
        $task->setId($taskData['id']);
        $task->setName($taskData['name']);
        $task->setDescription($taskData['description']);
        $task->setIsDone($taskData['is_done']);

        return $task;
    }

}