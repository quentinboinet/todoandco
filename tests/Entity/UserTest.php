<?php

namespace App\Tests\Entity;

use App\Entity\Task;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    private $user;

    public function setUp()
    {
        $this->user = new User();
    }

    public function testId()
    {
        $this->assertNull($this->user->getId());
    }

    public function testUsername()
    {
        $this->user->setUsername("test");
        $this->assertSame("test", $this->user->getUsername());
    }

    public function testEmail()
    {
        $this->user->setEmail("test@live.fr");
        $this->assertSame("test@live.fr", $this->user->getEmail());
    }

    public function testPassword()
    {
        $this->user->setPassword("passwordtest");
        $this->assertSame("passwordtest", $this->user->getPassword());
    }

    public function testTask()
    {
        $task = new Task();

        $this->user->addTask($task);
        $this->assertCount(1, $this->user->getTasks());

        $this->user->removeTask($task);
        $this->assertCount(0, $this->user->getTasks());
    }

    public function testRoles()
    {
        $this->user->setRoles(["ROLE_USER"]);
        $this->assertSame(["ROLE_USER"], $this->user->getRoles());
    }
}