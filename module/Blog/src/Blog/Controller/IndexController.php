<?php

namespace Blog\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Doctrine\ORM\EntityManager;
use Zend\Paginator\Paginator;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator;
use Blog\Entity\Comment;
use DoctrineORMModule\Form\Annotation\AnnotationBuilder;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;

class IndexController extends AbstractActionController
{
    private $em; // Entity Manager
    
    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }

    public function indexAction()
    {
        $qb = $this->em->createQueryBuilder();
        $qb->add('select', 'a')
           ->add('from', 'Blog\Entity\Article AS a')
           ->add('where', 'a.isPublic = 1')
           ->add('orderBy', 'a.id DESC');
        
        //$query = $qb->getQuery();
        //$articles = $query->getResult();
        
        $adapter = new DoctrinePaginator(new ORMPaginator($qb));
        $paginator = new Paginator($adapter);
        $paginator->setCurrentPageNumber($this->params()->fromRoute('page', 1));
        $paginator->setItemCountPerPage(6);
        
        $viewModel = new ViewModel([
            'articles' => $paginator,
        ]);
        return $viewModel;
    }
    
    protected function getCommentForm($comment)
    {
        $builder = new AnnotationBuilder($this->em);
        $form = $builder->createForm(new Comment());
        $form->setHydrator(new DoctrineObject($this->em, '\Comment'));
        $form->bind($comment);
        
        return $form;
    }

    public function articleAction()
    {
        $id = (int)$this->params()->fromRoute('id', 0);
        $article = $this->em->find('Blog\Entity\Article', $id);
        
        if (! $article) {
            return $this->notFoundAction();
        }
        
        $comment = new Comment();
        $form = $this->getCommentForm($comment);
        
        return [
            'article' => $article,
            'form'    => $form,
        ];
    }
}
