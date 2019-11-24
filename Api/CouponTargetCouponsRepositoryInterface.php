<?php
namespace Coupon\Target\Api;

interface CouponTargetCouponsRepositoryInterface
{
    /**
     * @param int $id
     * @return \Coupon\Target\Api\Data\CouponTargetCouponsInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById($id);

    /**
     * @param int $coupon
     * @return \Coupon\Target\Api\Data\CouponTargetCouponsInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getByCoupon($coupon);

    /**
     * @param \Coupon\Target\Api\Data\CouponTargetCouponsInterface $lessons
     * @return \Coupon\Target\Api\Data\CouponTargetCouponsInterface
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     */
    public function save(\Coupon\Target\Api\Data\CouponTargetCouponsInterface $couponTargetCoupons);
}
