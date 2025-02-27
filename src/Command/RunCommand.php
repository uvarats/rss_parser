<?php

namespace App\Command;

use App\Service\Http\FeedHttpClient;
use App\Service\TelegramSender;
use App\ValueObjects\PostData;
use App\ValueObjects\TelegramConfig;
use Laminas\Feed\Reader\Entry\Atom;
use Laminas\Feed\Reader\Reader;
use League\Uri\Uri;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Vjik\TelegramBot\Api\Constant\MessageEntityType;
use Vjik\TelegramBot\Api\TelegramBotApi;
use Vjik\TelegramBot\Api\Type\InputFile;
use Vjik\TelegramBot\Api\Type\MessageEntity;

#[AsCommand(
    name: 'app:run',
    description: 'Add a short description for your command',
)]
class RunCommand extends Command
{
    public function __construct(
        private readonly FeedHttpClient $client,
        private readonly TelegramConfig $telegramConfig,
        private readonly TelegramSender $sender,
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
        $bot = new TelegramBotApi($this->telegramConfig->botToken);

        $chatId = -1002461478314;

        //$bot->sendMessage($chatId, 'kurwa bober');

        Reader::setHttpClient($this->client);

        $channel = Reader::import('https://wiadomosci.onet.pl/.feed');
        dd($channel);

        /** @var Atom $item */
        foreach ($channel as $item) {
            $enclosure = $item->getEnclosure();

            if ($enclosure instanceof \stdClass && property_exists($enclosure, 'url')) {
                $enclosure = $enclosure->url;
            } elseif(!is_string($enclosure)) {
                $enclosure = null;
            }

            $postData = new PostData(
                id: $item->getId(),
                title: $item->getTitle(),
                link: $item->getPermalink(),
                createdAt: \DateTimeImmutable::createFromMutable($item->getDateCreated()),
                updatedAt: \DateTimeImmutable::createFromMutable($item->getDateModified()),
                enclosureLink: Uri::new($enclosure)->withScheme('https')->toString(),
                description: html_entity_decode(strip_tags($item->getContent())),
            );

            dd($postData);

            $this->sender->send($chatId, $postData);

            break;
        }

        return Command::SUCCESS;
    }
}
