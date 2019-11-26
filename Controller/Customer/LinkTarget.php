<?php


namespace Coupon\Target\Controller\Customer;

use Coupon\Target\Model\CouponTargetCouponsRepository;
use Magento\Customer\Model\Session;
use Magento\Customer\Model\SessionFactory;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Stdlib\Cookie\PhpCookieManager;
use Magento\Framework\Stdlib\Cookie\PublicCookieMetadata;
use Magento\SalesRule\Model\CouponGenerator;

class LinkTarget extends Action
{
    /**
     * @var \Magento\Customer\Model\Session
     */
    private $cookieManager;
    private $customerSession;
    private $couponGenerator;
    private $couponTargetCouponsRepository;

    public function __construct(
        Context $context,
        PhpCookieManager $cookieManager,
        Session $customerSession,
        CouponGenerator $couponGenerator,
        CouponTargetCouponsRepository $couponTargetCouponsRepository

    )
    {
        $this->cookieManager = $cookieManager;
        $this->customerSession = $customerSession;
        $this->couponGenerator = $couponGenerator;
        $this->couponGenerator = $couponGenerator;
        $this->couponTargetCouponsRepository = $couponTargetCouponsRepository;

        parent::__construct($context);
    }

    /** {@inheritdoc} */
    public function execute()
    {

        // TODO подумать как оптимизировать
        $customerId = $this->customerSession->getCustomer()->getId();
        $couponCookie = $this->cookieManager->getCookie('coupon', null);

        $isNewCoupon = false;
        if ($couponCookie) {

            $couponCookie = 'COMMAND-9S6Y9PL281';
            $coupon = $this->couponTargetCouponsRepository->getByCoupon($couponCookie);
            if ($coupon) {
                //
            } else {
                $isNewCoupon = true;
            }
        } else {
            $isNewCoupon = true;
        }

        if ($isNewCoupon) {
            $params = ['length' => 10, 'prefix' => 'COMMAND-', 'rule_id' => 11, 'qty' =>1];
            $coupon = $this->couponGenerator->generateCodes($params);

            //$couponTargetCoupons->setCoupon($coupon);
            //$couponTargetCoupons->save();


            $meta = new PublicCookieMetadata();
            $meta->setPath('/');
            $meta->setDuration(86400 * 30);
            $this->cookieManager->setPublicCookie('coupon', $coupon[0], $meta);

           //
        }

        return $this->resultFactory->create(ResultFactory::TYPE_PAGE);
    }
}
