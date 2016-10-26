<?php

namespace Admin\Form;

use Zend\Form\Form;

class CategoryForm extends Form
{
    public function __construct()
    {
        parent::__construct('category');

        $this->setAttributes([
            'class' => 'form-horizontal',
        ]);

        $this->add([
            'name' => 'categoryKey',
            'type' => 'text',
            'attributes' => [
                'class'    => 'form-control',
                'id'       => 'categoryKey',
                'required' => 'required',
            ],
            'options' => [
                'label' => 'Category key',
                'min'   => 3,
                'max'   => 100,
            ],
        ]);

        $this->add([
            'name' => 'categoryName',
            'type' => 'text',
            'attributes' => [
                'class'    => 'form-control',
                'id'       => 'categoryName',
                'required' => 'required',
            ],
            'options' => [
                'label' => 'Category name',
                'min'   => 3,
                'max'   => 100,
            ],
        ]);

        $this->add([
            'name' => 'submit',
            'type' => 'submit',
            'attributes' => [
                'class' => 'btn btn-info',
                'value' => 'Submit',
            ],
        ]);
    }
}
