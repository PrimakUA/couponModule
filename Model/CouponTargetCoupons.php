<?php
namespace Coupon\Target\Model;


use Magento\Framework\Model\AbstractModel;
use Magento\Framework\DataObject\IdentityInterface;

use Coupon\Target\Api\Data\CouponTargetCouponsInterface;
use Coupon\Target\Model\ResourceModel\CouponTargetCoupons as ResourceModel;

class CouponTargetCoupons extends \Magento\Framework\Model\AbstractModel implements \Magento\Framework\DataObject\IdentityInterface
{
    /**
     * No route page id
     */
    const NOROUTE_PAGE_ID = 'no-route';

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
    public function getCouponId()
    {
        return $this->getData(CouponTargetCouponsInterface::COUPON_ID_FIELD);
    }

    /** {@inheritdoc} */
    public function setCouponId($coupon_id)
    {
        $this->setData(CouponTargetCouponsInterface::COUPON_ID_FIELD, $coupon_id);

        return $this;
    }

    /** {@inheritdoc} */
    public function setCoupon($coupon)
    {
        $this->setData(CouponTargetCouponsInterface::COUPON_FIELD, $coupon);

        return $this;
    }

    /** {@inheritdoc} */
    public function getCoupon()
    {
        return $this->getData(CouponTargetCouponsInterface::COUPON_FIELD);
    }

    /** {@inheritdoc} */
    public function getEntityId()
    {
        return $this->getData(CouponTargetCouponsInterface::ENTITY_ID_FIELD);
    }


    /** {@inheritdoc} */
    public function setEntityId($entity_id)
    {
        $this->setData(CouponTargetCouponsInterface::ENTITY_ID_FIELD, $entity_id);

        return $this;
    }
}