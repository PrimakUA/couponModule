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
    private $state;

    public function __construct
    (
        Config $config,
        CouponService $couponService,
        Email $email,
        State $state,
        string $name = null
    )
    {
        $this->config = $config;
        $this->couponService = $couponService;
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
        $emailExample = 'borat@mail.kz';
        $couponExample = '123456789009876543';
        $this->state->setAreaCode('frontend');
        $this->couponService->generateOneCoupon($this->config->getRuleId('five'));
        $this->email->sendEmail($emailExample, $couponExample);
        $output->writeln("Done!");
    }
}