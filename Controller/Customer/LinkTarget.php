<?php

namespace Coupon\Target\Controller\Customer;

use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;


class LinkTarget extends Action
{
    /** {@inheritdoc} */
    public function execute()
    {
        return $this->resultFactory->create(ResultFactory::TYPE_PAGE);
    }
}
