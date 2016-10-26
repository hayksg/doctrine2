<?php

namespace Admin\Model;

use Doctrine\ORM\EntityManager;

class CategoryTable
{
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getAllCategories()
    {
        $sql  = "SELECT c ";
        $sql .= "FROM Blog\Entity\Category c ";
        $sql .= "ORDER BY c.id ASC";

        $query = $this->entityManager->createQuery($sql);
        return ($query->getResult()) ? $query->getResult() : false;
    }

    public function persistCategory($obj)
    {
        $this->entityManager->persist($obj);
    }

    public function flushCategory()
    {
        $this->entityManager->flush();
    }

    public function findCategory($obj, $id)
    {
        return $this->entityManager->find($obj, $id);
    }

    public function getRepository($obj)
    {
        return $this->entityManager->getRepository($obj);
    }

    public function removeCategory($obj)
    {
        $this->entityManager->remove($obj);
    }
}
