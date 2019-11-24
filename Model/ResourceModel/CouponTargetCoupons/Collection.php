<?php
namespace Coupon\Target\Model\ResourceModel\CouponTargetCoupons;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'id';
    protected $_eventPrefix = 'coupon_target_coupons_collection';
    protected $_eventObject = 'coupon_target_coupons_collection';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Coupon\Target\Model\CouponTargetCoupons', 'Coupon\Target\Model\ResourceModel\CouponTargetCoupons');
    }

}