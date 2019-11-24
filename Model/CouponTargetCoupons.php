<?php
namespace Coupon\Target\Model;

use Coupon\Target\Api\Data\CouponTargetCouponsInterface;

class CouponTargetCoupons extends \Magento\Framework\Model\AbstractModel implements \Magento\Framework\DataObject\IdentityInterface
{
    const CACHE_TAG = 'coupon_target_coupons';

    protected $_cacheTag = 'coupon_target_coupons';

    protected $_eventPrefix = 'coupon_target_coupons';

    protected function _construct()
    {
        $this->_init('Coupon\Target\Model\ResourceModel\CouponTargetCoupons');
    }

    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    public function getDefaultValues()
    {
        $values = [];

        return $values;
    }

    /** {@inheritdoc} */
    public function setCoupon($coupon)
    {
        $this->setData(CouponTargetCouponsInterface::COUPON_FIELD, $coupon);

        return $this;
    }

}