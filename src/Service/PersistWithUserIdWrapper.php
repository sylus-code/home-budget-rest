<?php

namespace App\Service;

use App\Entity\UserIdAwareInterface;
use Coderaf\Spiderman\SecurityBundle\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;

class PersistWithUserIdWrapper
{
    private $em;
    private $security;
    
    public function __construct(EntityManagerInterface $em, Security $security)
    {
        $this->em =$em;
        $this->security = $security;
    }
    
    public function save(UserIdAwareInterface $entity)
    {
        $entity = $this->wrapWithUserId($entity);
        $this->em->persist($entity);
        $this->em->flush();
    }

    public function wrapWithUserId(UserIdAwareInterface $entity)
    {
        /** @var User $user */
        $user = $this->security->getUser();
        $userId = $user->getId();
        $entity->setUserId($userId);

        return $entity;
    }
}
