<?php


namespace App\EventListener;


use App\Entity\Task;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\Security\Core\Security;

class UserAssignedTask
{
    /**
     * @var Security
     */
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function prePersist(Task $task, LifecycleEventArgs $eventArgs)
    {
        $task->setUser($this->security->getUser());
    }
}