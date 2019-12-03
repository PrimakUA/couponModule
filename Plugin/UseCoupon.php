<?php


namespace Coupon\Target\Plugin;


use Coupon\Target\Block\System\Config;
use Coupon\Target\Controller\Customer\LinkTarget;
use Coupon\Target\Model\CouponTargetCouponsRepository;
use Magento\Customer\Model\ResourceModel\CustomerRepository;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\SalesRule\Model\CouponGenerator;

class UseCoupon
{

    private $couponTargetCouponsRepository;
    private $customerFactory;
    private $couponGenerator;
    private $config;
    private $linkTarget;

    public function __construct(
        CouponTargetCouponsRepository $couponTargetCouponsRepository,
        CustomerRepository $customerRepository,
        CouponGenerator $couponGenerator,
        Config $config,
        LinkTarget $linkTarget

    )
    {
        $this->couponTargetCouponsRepository = $couponTargetCouponsRepository;
        $this->customerFactory = $customerRepository;
        $this->couponGenerator = $couponGenerator;
        $this->config = $config;
        $this->linkTarget = $linkTarget;
    }

    public function afterPlace(\Magento\Sales\Api\OrderManagementInterface $subject, $result)
    {
        $couponTargetCoupons = $this->couponTargetCouponsRepository->getByCoupon($result->getCouponCode());
        if ($couponTargetCoupons) {
            try {
                $customer = $this->customerFactory->getById($couponTargetCoupons->getEntityId());
                if ($customer) {
                    $this->linkTarget->generateOneCoupon($this->config->getRuleId('twenty'));
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