<?php

namespace Coupon\Target\Controller\Link;

use Magento\Framework\App\Action\Context;

class Index extends \Magento\Framework\App\Action\Action
{

    public function execute()
    {
        $this->_view->loadLayout();
        $this->_view->renderLayout();
    }
}