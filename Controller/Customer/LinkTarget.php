<?php

namespace Coupon\Target\Controller\Customer;

use Coupon\Target\Block\System\Config;
use Coupon\Target\Model\CouponTargetCoupons;
use Coupon\Target\Model\CouponTargetCouponsFactory;
use Coupon\Target\Model\CouponTargetCouponsRepository;
use Coupon\Target\Model\ResourceModel\SalesruleCoupon;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Model\CustomerFactory;
use Magento\Customer\Model\Session;
use Magento\Customer\Model\SessionFactory;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Stdlib\Cookie\PhpCookieManager;
use Magento\Framework\Stdlib\Cookie\PublicCookieMetadata;
use Magento\SalesRule\Model\CouponFactory;
use Magento\SalesRule\Model\CouponGenerator;
use Magento\SalesRule\Model\Coupon;
use Magento\SalesRule\Model\RuleFactory;


class LinkTarget extends Action
{

    /** {@inheritdoc} */
    public function execute()
    {

        return $this->resultFactory->create(ResultFactory::TYPE_PAGE);
    }
}
