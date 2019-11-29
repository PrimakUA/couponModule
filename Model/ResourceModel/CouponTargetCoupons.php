<?php
namespace Coupon\Target\Model\ResourceModel;

class CouponTargetCoupons extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{

    public function __construct(
        \Magento\Framework\Model\ResourceModel\Db\Context $context
    )
    {
        parent::__construct($context);
    }

    protected function _construct()
    {
        $this->_init('coupon_target_coupons', 'id');
    }

}
