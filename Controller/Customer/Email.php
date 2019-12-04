<?php

namespace Coupon\Target\Controller\Customer;

use Coupon\Target\Block\System\Config;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\Translate\Inline\StateInterface;
use Magento\Framework\Escaper;
use Magento\Framework\Mail\Template\TransportBuilder;

class Email extends \Magento\Framework\App\Helper\AbstractHelper
{
    protected $inlineTranslation;
    protected $escaper;
    protected $transportBuilder;
    protected $logger;
    protected $config;

    public function __construct(
        Context $context,
        StateInterface $inlineTranslation,
        Escaper $escaper,
        TransportBuilder $transportBuilder,
        Config $config
    )
    {
        parent::__construct($context);
        $this->inlineTranslation = $inlineTranslation;
        $this->escaper = $escaper;
        $this->transportBuilder = $transportBuilder;
        $this->logger = $context->getLogger();
        $this->config = $config;
    }

    public function sendEmail($email, $coupon)
    {
        try {
            $endDate = $this->sendDate();
            $persent = $this->config->getValue(2);
            $this->inlineTranslation->suspend();
            $sender = [
                'name' => $this->escaper->escapeHtml('Magento Store'),
                'email' => $this->escaper->escapeHtml('mrlezalit@gmail.com'),
            ];
            $transport = $this->transportBuilder
                ->setTemplateIdentifier('email_demo_template')
                ->setTemplateOptions(
                    [
                        'area' => \Magento\Framework\App\Area::AREA_FRONTEND,
                        'store' => \Magento\Store\Model\Store::DEFAULT_STORE_ID,
                    ]
                )
                ->setTemplateVars([
                    'templateVar' => "$coupon",
                    'templateVar2' => "$endDate",
                    'templateVar3' => "$persent",
                    'subject' => 'you have discount code'
                ])
                ->setFrom($sender)
                ->addTo("$email")
                ->getTransport();
            $transport->sendMessage();
            $this->inlineTranslation->resume();
        } catch (\Exception $e) {
            $this->logger->debug($e->getMessage());
        }
    }

    public function sendDate()
    {
        $tableDate = $this->config->getDate(2);
        $endDate = strtotime("+$tableDate day");
        $date = date("Y-m-d H:i:s", $endDate);
        return $date;
    }
}
