<?php

namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Admin\Model\ArticleTable;
use Admin\Form\ArticleForm;
use Blog\Entity\Article;

class ArticleController extends AbstractActionController
{
    private $articleTable;
    private $articleForm;

    public function __construct(
        ArticleTable $articleTable,
        ArticleForm $articleForm
    ) {
        $this->articleTable = $articleTable;
        $this->articleForm  = $articleForm;
    }

    public function indexAction()
    {
        $paginator = $this->articleTable->getAllArticles(true);

        $currentPageNumber = $this->params()->fromRoute('page', 1);
        $paginator->setCurrentPageNumber($currentPageNumber);

        $itemCountPerPage = 6;
        $paginator->setItemCountPerPage($itemCountPerPage);

        $viewModel = new ViewModel([
            'articles' => $paginator,
            'i' => 0,
            'currentPageNumber' => $currentPageNumber,
            'itemCountPerPage'  => $itemCountPerPage,
        ]);
        return $viewModel;
    }

    public function addAction()
    {
        $status = $message = '';
        $article = new Article();
        $form = $this->articleForm;
        $form->bind($article);
        $request = $this->getRequest();

        if ($request->isPost()) {
            //$form->setData($request->getPost());
            $form->setData($this->params()->fromPost());

            if ($form->isValid()) {
                $this->articleTable->persistArticle($article);
                $this->articleTable->flushArticle();

                $status  = 'success';
                $message = 'Article was added';
            } else {
                return ['form' => $form];
            }
        } else {
            return ['form' => $form];
        }

        if ($message) {
            $this->flashMessenger()->setNamespace($status)->addMessage($message);
        }

        return $this->redirect()->toRoute('admin/article');
    }

    public function editAction()
    {
        $status = $message = '';
        $id = (int)$this->params()->fromRoute('id', 0);
        $article = $this->articleTable->findArticle($id);

        if (! $article) {
            $status  = 'error';
            $message = 'Article not found';

            $this->flashMessenger()->setNamespace($status)->addMessage($message);

            return $this->redirect()->toRoute('admin/article');
        }

        $form = $this->articleForm;
        $form->bind($article);
        $request = $this->getRequest();

        if ($request->isPost()) {
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $this->articleTable->persistArticle($article);
                $this->articleTable->flushArticle();

                $status  = 'success';
                $message = 'Article was edited';
            } else {
                return [
                    'id'   => $id,
                    'form' => $form,
                ];
            }
        } else {
            return [
                'id'   => $id,
                'form' => $form,
            ];
        }

        if ($message) {
            $this->flashMessenger()->setNamespace($status)->addMessage($message);
        }

        return $this->redirect()->toRoute('admin/article');
    }

    public function deleteAction()
    {
        $id = (int)$this->params()->fromRoute('id', 0);
        $status  = 'success';
        $message = 'The article was deleted';

        try {
            $repository = $this->articleTable->getRepository();
            $article = $repository->find($id);
            $this->articleTable->removeArticle($article);
            $this->articleTable->flushArticle();
        } catch (\Exception $e) {
            $status  = 'error';
            $message = 'The article not found';
        }

        if ($message) {
            $this->flashMessenger()->setNamespace($status)->addMessage($message);
        }

        return $this->redirect()->toRoute('admin/article');
    }
}
