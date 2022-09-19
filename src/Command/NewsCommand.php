<?php

namespace App\Command;

use App\Service\NewsService;
use jcobhams\NewsApi\NewsApiException;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Command\LockableTrait;

#[AsCommand(
    name: 'app:news',
    description: 'the list of downloaded news.',
)]
class NewsCommand extends Command
{
    use LockableTrait;

    public function __construct(
        private readonly NewsService $newsService
    ) {
        parent::__construct(); //  new NewsBbcService
    }
    protected function configure(): void
    {
        $this
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    /**
     * @throws NewsApiException
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        if (!$this->lock()) {
            $output->writeln('The command is already running in another process.');

            return Command::SUCCESS;
        }

        $this->newsService->handle();


        $io = new SymfonyStyle($input, $output);


        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');

        return Command::SUCCESS;
    }
}
