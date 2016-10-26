<?php

namespace Admin\Form;

use Zend\Form\Form;
use Zend\Form\Element;
use Doctrine\ORM\EntityManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use DoctrineModule\Form\Element\ObjectSelect;

class ArticleForm extends Form
{
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        parent::__construct('article');
        $this->entityManager = $entityManager;
        $this->createElement();
        $this->setHydrator(new DoctrineObject($entityManager));
    }

    public function createElement()
    {
        $this->setAttributes([
            'class' => 'form-horizontal',
            'id'    => 'article-form',
        ]);

        $title = new Element\Text('title');
        $title->setLabel('Title');
        $title->setAttributes([
            'class'    => 'form-control',
            'id'       => 'title',
            'required' => 'required',
        ]);
        $this->add($title);

        $shortArticle = new Element\Textarea('shortArticle');
        $shortArticle->setLabel('Short Article');
        $shortArticle->setAttributes([
            'class'    => 'form-control',
            'id'       => 'shortArticle',
            'required' => 'required',
        ]);
        $this->add($shortArticle);

        $article = new Element\Textarea('article');
        $article->setLabel('Article');
        $article->setAttributes([
            'class'    => 'form-control',
            'id'       => 'article',
            'required' => 'required',
        ]);
        $this->add($article);

        $category = new ObjectSelect('category');
        $category->setLabel('Category');
        $category->setAttributes([
            'class'    => 'form-control',
            'id'       => 'category',
            'required' => 'required',
        ]);
        $category->setOptions([
            'empty_option'   => 'Select category',
            'object_manager' => $this->entityManager,
            'target_class'   => 'Blog\Entity\Category',
            'property'       => 'categoryName',
        ]);
        $this->add($category);

        $isPublic = new Element\Checkbox('isPublic');
        $isPublic->setLabel('Is public');
        $isPublic->setAttributes([
            'id'       => 'isPublic',
        ]);
        $isPublic->setOptions([
            'set_hidden_element' => true,
            'checked_value'      => 1,
            'unchecked_value'    => 0,
        ]);
        $this->add($isPublic);

        $submit = new Element\Submit('submit');
        $submit->setAttributes([
            'class' => 'btn btn-info',
            'value' => 'Submit',
        ]);
        $this->add($submit);
    }
}
