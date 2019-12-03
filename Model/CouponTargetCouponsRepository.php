<?php
namespace Coupon\Target\Model;

use Coupon\Target\Api\CouponTargetCouponsRepositoryInterface;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Coupon\Target\Api\Data\CouponTargetCouponsInterface;
use Coupon\Target\Model\ResourceModel\CouponTargetCoupons as ResourceModel;
use Coupon\Target\Model\ResourceModel\CouponTargetCoupons\CollectionFactory;
use Coupon\Target\Model\CouponTargetCouponsFactory;
use Magento\Framework\Exception\CouldNotDeleteException;

class CouponTargetCouponsRepository implements CouponTargetCouponsRepositoryInterface
{
    /** @var ResourceModel */
    protected $resource;

    /** @var CouponTargetCouponsFactory  */
    protected $couponTargetCouponsFactory;

    /** @var CollectionProcessorInterface */
    protected $collectionProcessor;

    /** @var CollectionFactory */
    protected $collectionFactory;

    public function __construct(
        ResourceModel $resource,
        CouponTargetCouponsFactory $couponTargetCouponsFactory,
        CollectionProcessorInterface $collectionProcessor,
        CollectionFactory $collectionFactory
    ) {
        $this->resource                 = $resource;
        $this->couponTargetCouponsFactory           = $couponTargetCouponsFactory;
        $this->collectionProcessor      = $collectionProcessor;
        $this->collectionFactory        = $collectionFactory;
    }

    /** {@inheritdoc} */
    public function getById($id)
    {
        $coupons = $this->couponTargetCouponsFactory->create();
        $this->resource->load($coupons, $id);

        if (!$coupons->getId()) {
            throw new NoSuchEntityException(__('Coupons with id "%1" does not exist.', $id));
        }

        return $coupons;
    }

    /** {@inheritdoc} */
    public function getByCoupon($coupon)
    {
        $coupons = $this->couponTargetCouponsFactory->create();
        $this->resource->load($coupons, $coupon, 'coupon');

        if (!$coupons->getId()) {
            return null;
        }

        return $coupons;
    }

    /** {@inheritdoc} */
    public function save(CouponTargetCouponsInterface $coupons)
    {
        try {
            $this->resource->save($coupons);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }

        return $coupons;
    }
}
