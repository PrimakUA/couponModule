<?php


namespace Coupon\Target\Plugin;


use Coupon\Target\Model\CouponTargetCouponsRepository;
use Magento\Customer\Model\ResourceModel\CustomerRepository;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\SalesRule\Model\CouponGenerator;

class UseCoupon
{

    private $couponTargetCouponsRepository;
    private $customerFactory;
    private $couponGenerator;

    public function __construct(
        CouponTargetCouponsRepository $couponTargetCouponsRepository,
        CustomerRepository $customerRepository,
        CouponGenerator $couponGenerator

    )
    {
        $this->couponTargetCouponsRepository = $couponTargetCouponsRepository;
        $this->customerFactory = $customerRepository;
        $this->couponGenerator = $couponGenerator;
    }

    public function afterPlace(\Magento\Sales\Api\OrderManagementInterface $subject, $result)
    {
        $couponTargetCoupons = $this->couponTargetCouponsRepository->getByCoupon($result->getCouponCode());
        if ($couponTargetCoupons) {
            try {
                $customer = $this->customerFactory->getById($couponTargetCoupons->getEntityId());
                if ($customer) {
                    $params = ['length' => 19, 'prefix' => 'DOSCOUNT-', 'qty' =>1];
                    $params['rule_id'] = 11;
                    $coupon = $this->couponGenerator->generateCodes($params);
                    if ($coupon) {
                        //echo 'send new coupon '.$coupon[0].' to email '.$customer->getEmail();
                    }
                }
            } catch (NoSuchEntityException $e) {
            }
        }

        return $result;
        //die();
    }
}
