<?php


namespace Coupon\Target\Controller\Customer;

use Magento\Framework\App\Helper\Context;
use Magento\Framework\Mail\MessageInterface;
use Magento\Framework\Mail\MessageInterfaceFactory;
use Magento\Framework\Mail\Template\FactoryInterface;
use Magento\Framework\Mail\Template\SenderResolverInterface;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Framework\Mail\TransportInterfaceFactory;
use Magento\Framework\ObjectManagerInterface;

class Email extends \Magento\Framework\Mail\Template\TransportBuilder
{
    public function __construct(FactoryInterface $templateFactory, MessageInterface $message, SenderResolverInterface $senderResolver, ObjectManagerInterface $objectManager, TransportInterfaceFactory $mailTransportFactory, MessageInterfaceFactory $messageFactory = null)
    {
        parent::__construct($templateFactory, $message, $senderResolver, $objectManager, $mailTransportFactory, $messageFactory);
    }

}