<?php

namespace Admin\Model;

use Doctrine\ORM\EntityManager;
use Zend\Paginator\Paginator;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator;

class ArticleTable
{
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getAllArticles($paginator = false)
    {
        $qb = $this->entityManager->createQueryBuilder();
        $qb->select('a')
           ->from('Blog\Entity\Article', 'a')
           ->orderBy('a.id', 'DESC');

        if ($paginator) {
            $adapter = new DoctrinePaginator(new ORMPaginator($qb));
            $paginatorObject =  new Paginator($adapter);
            return $paginatorObject ? $paginatorObject : false;
        } else {
            $query = $qb->getQuery();
            return $query->getResult() ? $query->getResult() : false;
        }
    }

    public function findArticle($id)
    {
        return $this->entityManager->find('Blog\Entity\Article', $id);

    }

    public function persistArticle($obj)
    {
        $this->entityManager->persist($obj);
    }

    public function flushArticle()
    {
        $this->entityManager->flush();
    }

    public function getRepository()
    {
        return $this->entityManager->getRepository('Blog\Entity\Article');
    }

    public function removeArticle($obj)
    {
        $this->entityManager->remove($obj);
    }
}
