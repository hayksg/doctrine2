<?php

namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Admin\Model\CategoryTable;
use Admin\Form\CategoryForm;
use Blog\Entity\Category;

class CategoryController extends AbstractActionController
{
    private $categoryTable;
    private $categoryForm;

    public function __construct(
        CategoryTable $categoryTable,
        CategoryForm $categoryForm
    ) {
        $this->categoryTable = $categoryTable;
        $this->categoryForm = $categoryForm;
    }

    public function indexAction()
    {
        $categories = $this ->categoryTable->getAllCategories();

        $viewModel = new ViewModel([
            'categories' => $categories,
        ]);
        return $viewModel;
    }

    public function addAction()
    {
        $status = $message = '';
        $form = $this->categoryForm;
        $request = $this->getRequest();

        if ($request->isPost()) {
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $category = new Category();
                $category->exchangeArray($form->getData());

                $this->categoryTable->persistCategory($category);
                $this->categoryTable->flushCategory();

                $status  = 'success';
                $message = 'Category was added';
            } else {
                return ['form' => $form];
            }
        } else {
            return ['form' => $form];
        }

        if ($message) {
            $this->flashMessenger()->setNamespace($status)->addMessage($message);
        }

        return $this->redirect()->toRoute('admin/category');
    }

    public function editAction()
    {
        $status = $message = '';
        $id = (int)$this->params()->fromRoute('id', 0);
        $category = $this->categoryTable->findCategory('Blog\Entity\Category', $id);

        if (! $category) {
            $status  = 'error';
            $message = 'Category not found';
            $this->flashMessenger()->setNamespace($status)->addMessage($message);

            return $this->redirect()->toRoute('admin/category');
        }

        $form = $this->categoryForm;
        $form->bind($category);
        $request = $this->getRequest();

        if ($request->isPost()) {
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $this->categoryTable->persistCategory($category);
                $this->categoryTable->flushCategory();

                $status  = 'success';
                $message = 'Category was edited';
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

        return $this->redirect()->toRoute('admin/category');
    }

    public function deleteAction()
    {
        $id = (int)$this->params()->fromRoute('id', 0);
        $status  = 'success';
        $message = 'Category was deleted';

        try {
            $repository = $this->categoryTable->getRepository('Blog\Entity\Category');
            $category = $repository->find($id);
            $this->categoryTable->removeCategory($category);
            $this->categoryTable->flushCategory();
        } catch (\Exception $e) {
            $status  = 'error';
            $message = 'Category not found';
        }

        if ($message) {
            $this->flashMessenger()->setNamespace($status)->addMessage($message);
        }

        return $this->redirect()->toRoute('admin/category');
    }
}
