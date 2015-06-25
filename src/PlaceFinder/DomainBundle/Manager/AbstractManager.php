<?php

namespace PlaceFinder\DomainBundle\Manager;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Common\Persistence\ObjectRepository;
//use LaFourchette\CommonBundle\Manager\ManagerInterface;

/**
 * Class AbstractManager
 *
 * @package PlaceFinder\DomainBundle\Manager
 */
class AbstractManager/* implements ManagerInterface*/
{
    /** @var EntityManagerInterface */
    protected $entityManager;

    /** @var ObjectRepository */
    protected $repository;

    /** @var string */
    protected $class;

    /**
     * @param EntityManagerInterface $entityManager
     * @param                        $class
     */
    public function __construct(EntityManagerInterface $entityManager, $class)
    {
        $this->entityManager = $entityManager;
        $this->repository    = $entityManager->getRepository($class);
        $this->class         = $class;
    }

    public function getEm()
    {
        return $this->em;
    }

    /**
     * {@inheritDoc}
     */
    public function createObject()
    {
        $class = $this->getClass();

        return new $class();
    }

    /**
     * {@inheritDoc}
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * {@inheritDoc}
     */
    public function getReference($id)
    {
        return $this->em->getReference($this->class, $id);
    }

    /**
     * {@inheritDoc}
     */
    public function load($id)
    {
        return $this->repository->find($id);
    }

    /**
     * {@inheritDoc}
     */
    public function loadOneBy(array $criteria)
    {
        return $this->repository->findOneBy($criteria);
    }

    /**
     * {@inheritDoc}
     */
    public function loadBy(array $criteria, array $order = null)
    {
        return $this->repository->findBy($criteria, $order);
    }

    /**
     * {@inheritDoc}
     */
    public function loadAll()
    {
        return $this->repository->findAll();
    }

    /**
     * {@inheritDoc}
     */
    public function flush()
    {
        $this->em->flush();
    }
}
