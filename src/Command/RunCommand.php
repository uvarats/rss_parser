<?php

namespace App\Command;

use App\Feature\Feed\ValueObject\FeedId;
use App\Feature\Reader\Interface\ReaderConfiguratorInterface;
use App\Message\AddFeedChatMessage;
use App\Message\CheckFeedCommand;
use App\Message\CheckOnetMessage;
use App\Service\Adapters\OnetFeed;
use App\Service\NotifierSender;
use App\ValueObjects\TelegramConfig;
use Cake\Chronos\Chronos;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Messenger\MessageBusInterface;
use Vjik\TelegramBot\Api\TelegramBotApi;

#[AsCommand(
    name: 'app:run',
    description: 'Add a short description for your command',
)]
class RunCommand extends Command
{
    public function __construct(
        private readonly TelegramConfig $telegramConfig,
        private readonly NotifierSender $notifierSender,
        private readonly OnetFeed $onetFeed,
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

        $this->bus->dispatch(new CheckFeedCommand(feedId: 1));

        return 0;

        $this->bus->dispatch(new CheckOnetMessage(Chronos::now()->subMinutes(10)));

        $bot = new TelegramBotApi($this->telegramConfig->botToken);

        $chatId = -1002461478314;

        //$bot->sendMessage($chatId, 'kurwa bober');

        $lastCheckedAt = null;
        $posts = $this->onetFeed->getPostsAfter(new \DateTimeImmutable('2025-03-01'));

        try {
            foreach ($posts as $post) {
                if ($post->id !== 'urn:uuid:beee8abc-1912-4257-8591-0e7197b7f94c') {
                    continue;
                }

                $this->notifierSender->send($chatId, $post);
                usleep(100);
            }
        } catch (\Throwable $e) {
            dd($e, $post);
        }

        return Command::SUCCESS;
    }
}
