<?php
namespace App\Command;

use App\Service\Adapter\CardPaymentRequest;
use App\Service\Factory\CardProcessorFactory;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:card-payment')]
class CardPaymentCommand extends Command
{
    public function __construct(
        private CardProcessorFactory $cardProcessorFactory
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addArgument('provider', InputArgument::REQUIRED, 'The provider name is required');
        $this->addArgument('amount', InputArgument::REQUIRED, 'The amount is required');
        $this->addArgument('currency', InputArgument::REQUIRED, 'The currency is required');
        $this->addArgument('cardNumber', InputArgument::REQUIRED, 'The cardNumber is required');
        $this->addArgument('cardExpMonth', InputArgument::REQUIRED, 'The cardExpMonth is required');
        $this->addArgument('cardExpYear', InputArgument::REQUIRED, 'The cardExpYear is required');
        $this->addArgument('cardCvv', InputArgument::REQUIRED, 'The cardCvv is required');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $provider = $this->cardProcessorFactory->getProvider($input->getArgument('provider'));
        $amount = $input->getArgument('amount');
        $currency = $input->getArgument('currency');
        $cardNumber = $input->getArgument('cardNumber');
        $cardExpMonth = $input->getArgument('cardExpMonth');
        $cardExpYear = $input->getArgument('cardExpYear');
        $cardCvv = $input->getArgument('cardCvv');

        $cardPaymentRequest = new CardPaymentRequest(
            $cardNumber,
            $cardExpMonth,
            $cardExpYear,
            $cardCvv,
            $currency,
            $amount
        );

        $cardPaymentResponse = $provider->chargeCard($cardPaymentRequest);
        $output->writeln(json_encode($cardPaymentResponse));
        return Command::SUCCESS;
    }
}
