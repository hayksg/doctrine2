<?php

namespace Admin\Filter;

use Zend\InputFilter\InputFilter;

class CategoryFilter extends InputFilter
{
    public function __construct()
    {
        $this->add([
            'name' => 'categoryKey',
            'required' => 'true',
            'filters' => [
                ['name' => 'StripTags'],
                ['name' => 'StringTrim'],
            ],
            'validators' => [
                [
                    'name' => 'StringLength',
                    'options' => [
                        'encoding' => 'utf-8',
                        'min' => 3,
                        'max' => 100,
                    ],
                ],
            ],
        ]);

        $this->add([
            'name' => 'categoryName',
            'required' => 'true',
            'filters' => [
                ['name' => 'StripTags'],
                ['name' => 'StringTrim'],
            ],
            'validators' => [
                [
                    'name' => 'StringLength',
                    'options' => [
                        'encoding' => 'utf-8',
                        'min' => 3,
                        'max' => 100,
                    ],
                ],
            ],
        ]);
    }
}
