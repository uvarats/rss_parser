<?php

namespace App\Command;

use App\Message\CheckFeedCommand;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsCommand(
    name: 'feed:check',
    description: 'Manually checks the feed',
)]
class FeedCheckCommand extends Command
{
    public function __construct(
        private readonly MessageBusInterface $bus,
    )
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('id', null, InputArgument::REQUIRED)
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $feedId = $input->getArgument('id');

        if (empty($feedId)) {
            $io->error('Please, provide feed id as an argument');

            return Command::FAILURE;
        }

        if (!is_numeric($feedId)) {
            $io->error('Please, provide valid int feed id');

            return Command::FAILURE;
        }

        $feedId = (int)$feedId;

        if ($feedId <= 0) {
            $io->error('You are pretty idiot. Do you know, that id must be positive? How did you do this, kurwa?');
        }

        $this->bus->dispatch(new CheckFeedCommand(feedId: $feedId));

        return Command::SUCCESS;
    }
}
