<?php

namespace Coupon\Target\Block;

use Coupon\Target\Controller\Customer\LinkTarget;
use Magento\Framework\View\Element\Template;
use Coupon\Target\Block\System\Config;

class Component extends \Magento\Framework\View\Element\Template
{
    public $linkTarget;

    public $config;

    public function __construct(Config $config, LinkTarget $linkTarget, Template\Context $context, array $data = [])
    {
        $this->config = $config;
        $this->linkTarget = $linkTarget;
        parent::__construct($context, $data);
    }
}