<?php

namespace App\Command;

use App\Services\Books\OpenLibraryApi;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'bookinbox:book:addAuthor',
    description: 'Add a short description for your command',
)]
class BookinboxBookAddAuthorCommand extends Command
{
    public function __construct(
        private readonly OpenLibraryApi $openLibraryApi
    )
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('openLibraryId', InputArgument::REQUIRED, 'openLibrary author\'s Id')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $id = $input->getArgument('openLibraryId');

        $author = $this->openLibraryApi->getAuthor($id);

        $io->success('Author successfully added');

        return Command::SUCCESS;
    }
}
