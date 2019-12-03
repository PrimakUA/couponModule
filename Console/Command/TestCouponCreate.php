<?php


namespace Coupon\Target\Console\Command;

use Coupon\Target\Block\System\Config;
use Coupon\Target\Controller\Customer\Email;
use Coupon\Target\Service\CouponService;
use Coupon\Target\Setup\SetupService\CreateCartPriceRuleService;
use Magento\Framework\App\State;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


class TestCouponCreate extends Command
{
    private $config;
    private $couponService;
    private $email;

    public function __construct
    (
        Email $email,
        Config $config,
        CouponService $couponService,
        string $name = null
    )
    {
        $this->email = $email;
        $this->config = $config;
        $this->couponService = $couponService;
        parent::__construct($name);
    }

    protected function configure()
    {
        $this->setName('coupon:create')->setDescription('Test coupon Create');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->couponService->generateOneCoupon($this->config->getRuleId('five'));
        $this->email->sendEmail();
        $output->writeln("Done!");
    }
}