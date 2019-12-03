<?php


namespace Coupon\Target\Console\Command;

use Coupon\Target\Block\System\Config;
use Coupon\Target\Controller\Customer\Email;
use Coupon\Target\Controller\Customer\LinkTarget;
use Coupon\Target\Setup\SetupService\CreateCartPriceRuleService;
use Magento\Framework\App\State;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


class TestCouponCreate extends Command
{
    private $config;
    private $linkTarget;
    private $email;
    private $state;

    public function __construct
    (
        Config $config,
        LinkTarget $linkTarget,
        Email $email,
        State $state,
        string $name = null
    )
    {
        $this->config = $config;
        $this->linkTarget = $linkTarget;
        $this->email = $email;
        $this->state = $state;
        parent::__construct($name);
    }

    protected function configure()
    {
        $this->setName('coupon:create')->setDescription('Test coupon Create');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->state->setAreaCode('frontend');
        $this->linkTarget->generateOneCoupon($this->config->getRuleId('five'));
        $this->email->sendEmail();
        $output->writeln("Done!");
    }
}