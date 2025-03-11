<?php

namespace App\Command;

use App\Feature\Reader\Interface\ReaderConfiguratorInterface;
use App\Feature\Reader\Service\Http\FeedHttpClient;
use App\Service\Adapters\OnetFeed;
use App\Service\NotifierSender;
use App\ValueObjects\TelegramConfig;
use Laminas\Feed\Reader\Reader;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Vjik\TelegramBot\Api\TelegramBotApi;

#[AsCommand(
    name: 'app:run',
    description: 'Add a short description for your command',
)]
class RunCommand extends Command
{
    public function __construct(
        private readonly FeedHttpClient $client,
        private readonly TelegramConfig $telegramConfig,
        private readonly NotifierSender $notifierSender,
        private readonly OnetFeed $onetFeed,
        private readonly ReaderConfiguratorInterface $readerConfigurator,
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

        $bot = new TelegramBotApi($this->telegramConfig->botToken);

        $chatId = -1002461478314;

        //$bot->sendMessage($chatId, 'kurwa bober');

        $lastCheckedAt = null;
        $posts = $this->onetFeed->getPostsAfter(new \DateTimeImmutable('2025-03-01'));

        foreach ($posts as $post) {
            $this->notifierSender->send($chatId, $post);
            usleep(100);
        }

        return Command::SUCCESS;
    }
}
