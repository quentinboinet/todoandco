<?php

namespace App\EventListener;

use App\Entity\Task;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\Security;

class UserAssignedTask extends AbstractController
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
        if (!is_null($this->security->getUser())) {
            $task->setUser($this->security->getUser());
        }
    }

    public function preRemove(Task $task, LifecycleEventArgs $eventArgs)
    {
        if ($task->getUser() !== $this->security->getUser()) {

            throw new AccessDeniedException('Vous n\'avez pas la permission de supprimer cette tâche !');
        }
    }
}