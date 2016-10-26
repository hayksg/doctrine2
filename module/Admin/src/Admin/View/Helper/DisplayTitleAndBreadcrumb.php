<?php

namespace Admin\View\Helper;

use Zend\View\Helper\AbstractHelper;

class DisplayTitleAndBreadcrumb extends AbstractHelper
{
    public function __invoke($headTitle, $breadcrumb) 
    {
    
        $html = "<div class='row'>
                    <div class='col-xs-6'>
                        <h3>%s</h3>
                    </div>
                    <div class='col-xs-6'>
                        <div class='breadcrumb-box'>%s</div>
                    </div>
                </div>";
            
        printf($html, $headTitle, $breadcrumb);
    }
}
