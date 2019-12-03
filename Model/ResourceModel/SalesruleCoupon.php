<?php

namespace Coupon\Target\Model\ResourceModel;

use \Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use \Magento\Framework\Model\ResourceModel\Db\Context;

class SalesruleCoupon extends AbstractDb
{

    public function __construct(Context $context)
    {
        parent::__construct($context);
    }

    protected function _construct()
    {
        $this->_init('salesrule_coupon', 'coupon_id');
    }

}
