<?php

namespace Todo\DataFixtures;

use Silex\Application;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Schema\Table;
use Symfony\Component\Filesystem\Filesystem;
use Todo\Entity\Task;

class FixturesManager
{
    private $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function resetDatabase()
    {
        // 1) check DB permissions
        $dbPath = $this->app['sqlite_path'];
        $dbDir = dirname($dbPath);

        $filesystem = new Filesystem();
        $filesystem->mkdir($dbDir);
        $filesystem->chmod($dbDir, 0777, 0000, true);

        if (!is_writable($dbDir)) {
            throw new \Exception('Unable to write to '.$dbPath);
        }

        // 2) Add some tables bro!
        $schemaManager = $this->getConnection()->getSchemaManager();

        $tasksTable = new Table('tasks');
        $tasksTable->addColumn('id', 'integer', array('unsigned' => true, 'autoincrement' => true));
        $tasksTable->setPrimaryKey(array('id'));
        $tasksTable->addColumn('name', 'string', array('length' => 255));
        $tasksTable->addColumn('description', 'string', array('length' => 255));
        $tasksTable->addColumn('is_done', 'boolean');

        $schemaManager->dropAndCreateTable($tasksTable);
    }

    public function populateData()
    {
        $task = new Task();
        $task->setName('Wake up at 8.30');
        $task->setDescription('I have to wake at 8.30 to go to work');
        $task->setIsDone(1);
        $taskRepo = $this->app['repository.task'];
        $taskRepo->save($task);

        $task1 = new Task();
        $task1->setName('Eat breakfast');
        $task1->setDescription('Have to eat cereal');
        $task1->setIsDone(0);
        $taskRepo = $this->app['repository.task'];
        $taskRepo->save($task1);
    }

    /**
     * @return Connection
     */
    private function getConnection()
    {
        return $this->app['db'];
    }

}