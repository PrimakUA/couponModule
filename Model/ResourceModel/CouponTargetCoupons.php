<?php

namespace Coupon\Target\Model\ResourceModel;

use \Magento\Framework\Model\ResourceModel\Db\Context;
use \Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class CouponTargetCoupons extends AbstractDb
{

    public function __construct(Context $context)
    {
        parent::__construct($context);
    }

    protected function _construct()
    {
        $this->_init('coupon_target_coupons', 'id');
    }

}
