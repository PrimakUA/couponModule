<?php


namespace Coupon\Target\Service;


use Coupon\Target\Block\System\Config;
use Coupon\Target\Model\CouponTargetCouponsFactory;
use Coupon\Target\Model\CouponTargetCouponsRepository;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Model\Session;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Stdlib\Cookie\PhpCookieManager;
use Magento\Framework\Stdlib\Cookie\PublicCookieMetadata;
use Magento\SalesRule\Model\Coupon;
use Magento\SalesRule\Model\CouponFactory;
use Magento\SalesRule\Model\CouponGenerator;
use Magento\SalesRule\Model\RuleFactory;

class CouponService
{
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

    private $request;

    public function __construct(
        PhpCookieManager $cookieManager,
        Session $customerSession,
        CouponGenerator $couponGenerator,
        CouponTargetCouponsRepository $couponTargetCouponsRepository,
        Coupon $coupon,
        RuleFactory $ruleFactory,
        CouponTargetCouponsFactory $couponTargetCouponsFactory,
        CouponFactory $couponFactory,
        CustomerRepositoryInterface $customerRepository,
        RequestInterface $request,
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
        $this->request = $request;
        $this->config = $config;
    }

    public function getCookieCoupon()
    {
        return $cookieCoupon = $this->cookieManager->getCookie(self::COOKIE_COUPON_NAME, null);
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
        $params = ['length' => 19, 'prefix' => 'DISCOUNT-', 'qty' => 1];
        $params['rule_id'] = $ruleId;
        $coupon = $this->couponGenerator->generateCodes($params);
        return $coupon;
    }

    public function targetCoupon($couponCookie)
    {
        return $targetCoupon = $this->couponTargetCouponsRepository->getByCoupon($couponCookie);
    }

    private function generateNewCoupon($customer)
    {
        $couponCode = $this->generateOneCoupon($this->config->getRuleId('five'));
        $coupon = $this->couponFactory->create()->loadByCode($couponCode);
        $couponTargetCoupons = $this->couponTargetCouponsFactory->create();
        $couponTargetCoupons->setCoupon($coupon->getCode());
        $couponTargetCoupons->setEntityId($customer->getId());
        $couponTargetCoupons->setCouponId($coupon->getId());
        $couponTargetCoupons->save();
        $this->setCookieCoupon($couponTargetCoupons->getCoupon());

        return $couponTargetCoupons->getCoupon();
    }


    /** {@inheritdoc} */
    public function getCouponCode()
    {
        // TODO подумать как оптимизировать
        $couponCookie = $this->getCookieCoupon();
        $isNewCoupon = false;
        if ($couponCookie) {
            return $couponCookie;
        }

        $creator = $this->request->getParam('user_id');
        try {
            $customerFound = false;
            $customer = $this->customerRepository->getById($creator);
        } catch (NoSuchEntityException $e) {
            return '';
        }

        return $this->generateNewCoupon($customer);
    }
}
