<?php
namespace Coupon\Target\Api\Data;

use Magento\Customer\Model\Customer;
use Magento\Tests\NamingConvention\true\string;

interface CouponTargetCouponsInterface
{
    const TABLE_NAME                = 'coupon_target_coupons';

    const ID_FIELD                  = 'id';
    const COUPON_ID_FIELD           = 'coupon_id';
    const COUPON_FIELD              = 'coupon';
    const ENTITY_ID_FIELD           = 'entity_id';

    const CACHE_TAG                 = 'coupon_target';

    const REGISTRY_KEY              = 'coupon_target_coupons';

    /**
     * @return mixed
     */
    public function getId();

    /**
     * @return string
     */
    public function getCoupon();

    /**
     * @param string
     * @return CouponTargetCouponsInterface
     */
    public function setCoupon($coupon);

    /**
     * @return Customer
     */
    public function getCustomer();
}
