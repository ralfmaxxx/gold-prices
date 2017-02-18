<?php

namespace AppBundle\Command;

use AppBundle\Query\QueryFunctionInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class BiggestGainCommand extends Command
{
    private const COMMAND_NAME = 'app:gold_prices:biggest_gain';
    private const COMMAND_DESCRIPTION = 'Returns information about biggest gain';

    private const ARGUMENT_MONEY_NAME = 'money_amount';

    private const ARGUMENT_MONEY_DESCRIPTION = 'How much money you have to invest';

    private const ARGUMENT_MONEY_DEFAULT = 600000;

    private const ARGUMENT_MONEY = [
        self::ARGUMENT_MONEY_NAME,
        InputArgument::OPTIONAL,
        self::ARGUMENT_MONEY_DESCRIPTION,
        self::ARGUMENT_MONEY_DEFAULT,
    ];

    private const GAIN_MESSAGE_PATTERN = 'You can earn "%s" PLN if you buy on "%s" and sell on "%s"';

    private const SUCCESS_EXIT_CODE = 0;

    private $biggestGainQueryFunction;

    public function __construct(QueryFunctionInterface $biggestGainQueryFunction)
    {
        $this->biggestGainQueryFunction = $biggestGainQueryFunction;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName(self::COMMAND_NAME)
            ->setDescription(self::COMMAND_DESCRIPTION)
            ->addArgument(...self::ARGUMENT_MONEY);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $money = intval($input->getArgument(self::ARGUMENT_MONEY_NAME)) * 100;

        $gainFunction = $this->biggestGainQueryFunction;

        $gain = $gainFunction();

        $output->write(
            sprintf(
                self::GAIN_MESSAGE_PATTERN,
                number_format($gain['gain'] == 0 ? $gain['gain'] : $gain['gain'] * $money / 10000, 2),
                $gain['buy_day'],
                $gain['sell_day']
            )
        );

        return self::SUCCESS_EXIT_CODE;
    }
}
