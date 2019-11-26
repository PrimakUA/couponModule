<?php


namespace Coupon\Target\Block;


use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Customer\Model\Session;

class Formation extends Template
{
    public $sessionCurrent;

    public function __construct(Session $sessionCurrent, Template\Context $context, array $data = []
    )
    {
        $this->sessionCurrent = $sessionCurrent;
        parent::__construct($context, $data);
    }

    public function getName()
    {
        return$this->sessionCurrent->getCustomerData()->getFirstname();
    }

    public function getEmail()
    {
        return $this->sessionCurrent->getCustomer()->getEmail();
    }

    public function getLink()
    {

       return $link = $this->getBaseUrl() . 'coupon_target/customer/linktarget/user_id/' . $this->sessionCurrent->getCustomer()->getId();
        // TODO $this->getUrl('coupon_target/customer/index/target_link/') , getUrl() вторым параметром принимает массив параметров

    }
}

