<?php

namespace App\Command;

use App\Feature\Reader\Interface\ReaderConfiguratorInterface;
use App\Message\CheckFeedCommand;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsCommand(
    name: 'app:run',
    description: 'Add a short description for your command',
)]
class RunCommand extends Command
{
    public function __construct(
        private readonly ReaderConfiguratorInterface $readerConfigurator,
        private readonly MessageBusInterface $bus,
    )
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $this->readerConfigurator->configure();

        $envelope = $this->bus->dispatch(new CheckFeedCommand(feedId: 2));
        dd($envelope);

        return Command::SUCCESS;
    }
}
