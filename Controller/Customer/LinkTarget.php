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
    const COUPON_FIVE = 'five';
    const COOKIE_COUPON_NAME = 'coupon';
    /**
     * @var \Magento\Customer\Model\Session
     */
    private $cookieManager;
    private $customerSession;
    private $couponGenerator;
    private $couponTargetCouponsRepository;
    private $coupon;
    private $ruleFactory;
    private $couponTargetCouponsFactory;
    private $couponFactory;
    private $customerFactory;
    private $config;

    public function __construct(
        Context $context,
        PhpCookieManager $cookieManager,
        Session $customerSession,
        CouponGenerator $couponGenerator,
        CouponTargetCouponsRepository $couponTargetCouponsRepository,
        Coupon $coupon,
        RuleFactory $ruleFactory,
        CouponTargetCouponsFactory $couponTargetCouponsFactory,
        CouponFactory $couponFactory,
        CustomerRepositoryInterface $customerRepository,
        Config $config
    )
    {
        $this->cookieManager = $cookieManager;
        $this->customerSession = $customerSession;
        $this->couponGenerator = $couponGenerator;
        $this->couponGenerator = $couponGenerator;
        $this->couponTargetCouponsRepository = $couponTargetCouponsRepository;
        $this->coupon = $coupon;
        $this->ruleFactory = $ruleFactory;
        $this->couponTargetCouponsFactory = $couponTargetCouponsFactory;
        $this->couponFactory = $couponFactory;
        $this->customerRepository = $customerRepository;
        $this->config = $config;

        parent::__construct($context);
    }

    public function getCookieCoupon()
    {
        return $cookieCoupon = $this->cookieManager->getCookie(self::COOKIE_COUPON_NAME);
    }

    /**
     * @param Session $cookieManager
     */
    public function setCookieCoupon($coupon)
    {
        $meta = new PublicCookieMetadata();
        $meta->setPath('/');
        $meta->setDuration(86400 * 30);
        return $this->cookieManager->setPublicCookie('coupon', $coupon, $meta);
    }

    public function generateOneCoupon($ruleId)
    {
        $params = ['length' => 19, 'prefix' => 'DOSCOUNT-', 'qty' => 1];
        $params['rule_id'] = $ruleId;
        $coupon = $this->couponGenerator->generateCodes($params);
        return $coupon;
    }

    /** {@inheritdoc} */
    public function execute()
    {
        // TODO подумать как оптимизировать
        $couponCookie = $this->cookieManager->getCookie('coupon', null);
        $isNewCoupon = false;
        if ($couponCookie) {
            $couponTargetCoupons = $this->couponTargetCouponsRepository->getByCoupon($couponCookie);
            if ($couponTargetCoupons) {
                // передать данные в темплейт
                echo "11*******" . $couponTargetCoupons->getCoupon();
                //
            }
        } else {
            $isNewCoupon = true;
        }
        if ($isNewCoupon) {
            $creator = $this->getRequest()->getParam('user_id');
            try {
                $customerFound = false;
                $customer = $this->customerRepository->getById($creator);
                if ($customer) {
                    $customerFound = true;
                }
            } catch (NoSuchEntityException $e) {
                // set error for view
            }

            if ($customerFound) {
                //$rule =  $coupon = $this->ruleFactory->create()->
                // die('=='.$rule->getRuleId());
                $couponCode = $this->generateOneCoupon($this->config->getRuleId('five'));
                $coupon = $this->couponFactory->create()->loadByCode($couponCode);
                $couponTargetCoupons = $this->couponTargetCouponsFactory->create();
                $couponTargetCoupons->setCoupon($coupon->getCode());

                $couponTargetCoupons->setEntityId($customer->getId());
                $couponTargetCoupons->setCouponId($coupon->getId());

                $couponTargetCoupons->save();
                $this->setCookieCoupon($couponTargetCoupons->getCoupon());
                // передать данные в темплейт
                echo "22*******" . $couponTargetCoupons->getCoupon();
            }

        }
        return $this->resultFactory->create(ResultFactory::TYPE_PAGE);
    }
}
