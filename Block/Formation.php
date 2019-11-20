<?php


namespace Coupon\Target\Block;


use Magento\Framework\View\Element\Template;
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

    public function getEmail()
    {
        return $this->sessionCurrent->getCustomer()->getEmail();
    }

    public function getLink()
    {
       return $link = $this->getBaseUrl() . 'coupon_target/target_link/get/target_link/' . $this->sessionCurrent->getCustomer()->getId();
    }
}

