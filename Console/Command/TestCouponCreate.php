<?php


namespace Coupon\Target\Console\Command;

use Coupon\Target\Block\System\Config;
use Coupon\Target\Controller\Customer\LinkTarget;
use Coupon\Target\Setup\SetupService\CreateCartPriceRuleService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


class TestCouponCreate extends Command
{
    private $config;
    private $linkTarget;


    public function __construct
    (
        Config $config,
        LinkTarget $linkTarget,
        string $name = null
    )
    {
        $this->config = $config;
        $this->linkTarget = $linkTarget;
        parent::__construct($name);
    }

    protected function configure()
    {
        $this->setName('coupon:create')->setDescription('Test coupon Create');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->linkTarget->generateOneCoupon($this->config->getRuleId('five'));
        $output->writeln("Done!");
    }
}