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
            $this->db->update('tasks', $taskData, array('task_id' => $task->getId()));
        }
        else {
            $this->db->insert('tasks', $taskData);
            // Get the id of the newly created task and set it on the entity.
            $id = $this->db->lastInsertId();
            $task->setId($id);
        }
    }


}