<?php

namespace Admin\Filter;

use Zend\InputFilter\InputFilter;

class ArticleFilter extends InputFilter
{
    public function __construct()
    {
        $this->add([
            'name' => 'title',
            'required' => true,
            'filters' => [
                ['name' => 'stripTags'],
                ['name' => 'stringTrim'],
            ],
            'validators' => [
                [
                    'name' => 'stringLength',
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
