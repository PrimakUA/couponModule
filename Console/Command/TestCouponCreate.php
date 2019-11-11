<?php


namespace Coupon\Target\Console\Command;

use Coupon\Target\Setup\SetupService\CreateCartPriceRuleService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Coupon\Target\Service\GenerateCouponService;


class TestCouponCreate extends Command
{
    protected function configure()
    {
        $this->setName('coupon:create')->setDescription('Test coupon Create');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln("Done!");
      
    }
}
