<?php


namespace App\Tests\Entity;


use App\Entity\Task;
use PHPUnit\Framework\TestCase;

class TaskTest extends TestCase
{
    private $task;

    public function setUp()
    {
        $this->task = new Task();
    }

    public function testId()
    {
        $this->assertNull($this->task->getId());
    }

    public function testCreatedAt()
    {
        $this->assertLessThanOrEqual(new \DateTime(), $this->task->getCreatedAt()); //la date de création de la tâche dans le setUp doit être antérieure à celle crée au moment du test

        $createdAtBefore = $this->task->getCreatedAt();
        $this->task->setCreatedAt(new \DateTime());
        $this->assertLessThanOrEqual( $this->task->getCreatedAt(), $createdAtBefore);
    }

    public function testTitle()
    {
        $this->task->setTitle("titleTest");
        $this->assertSame("titleTest", $this->task->getTitle());
    }

    public function testContent()
    {
        $this->task->setContent("content test");
        $this->assertSame("content test", $this->task->getContent());
    }

    public function testIsDone()
    {
        $this->assertFalse($this->task->isDone());

        $this->task->setIsDone(true);
        $this->assertTrue($this->task->isDone());

        $this->task->toggle(false);
        $this->assertFalse($this->task->isDone());
    }
}