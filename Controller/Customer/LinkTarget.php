<?php


namespace Coupon\Target\Controller\Customer;

use Coupon\Target\Model\CouponTargetCoupons;
use Coupon\Target\Model\CouponTargetCouponsFactory;
use Coupon\Target\Model\CouponTargetCouponsRepository;
use Coupon\Target\Model\ResourceModel\SalesruleCoupon;
use Magento\Customer\Model\Session;
use Magento\Customer\Model\SessionFactory;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
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

    public function __construct(
        Context $context,
        PhpCookieManager $cookieManager,
        Session $customerSession,
        CouponGenerator $couponGenerator,
        CouponTargetCouponsRepository $couponTargetCouponsRepository,
        Coupon $coupon,
        RuleFactory $ruleFactory,
        CouponTargetCouponsFactory $couponTargetCouponsFactory,
        CouponFactory $couponFactory
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
        $params = ['length' => 10, 'prefix' => 'LINK-', 'qty' =>1];
        $params['rule_id'] = $ruleId;
        $coupon = $this->couponGenerator->generateCodes($params);

        return $coupon;
    }


    /** {@inheritdoc} */
    public function execute()
    {

        // TODO подумать как оптимизировать
      //  $customer = $this->customerSession->getCustomer();
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
            //$rule =  $coupon = $this->ruleFactory->create()->
           // die('=='.$rule->getRuleId());

            $couponCode = $this->generateOneCoupon(10);

            $coupon = $this->couponFactory->create()->loadByCode($couponCode);

            $couponTargetCoupons = $this->couponTargetCouponsFactory->create();
            $couponTargetCoupons->setCoupon($coupon->getCode());
            $creator = $this->getRequest()->getParam('user_id');
            $couponTargetCoupons->setEntityId($creator);
            $couponTargetCoupons->setCouponId($coupon->getId());

            $couponTargetCoupons->save();

            $this->setCookieCoupon($couponTargetCoupons->getCoupon());

            // передать данные в темплейт
            echo "22*******" . $couponTargetCoupons->getCoupon();
        }

        return $this->resultFactory->create(ResultFactory::TYPE_PAGE);
    }
}
