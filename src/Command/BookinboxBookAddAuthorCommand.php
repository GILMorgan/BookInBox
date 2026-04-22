<?php

namespace App\Command;

use App\Services\Books\OpenLibraryApi;
use App\Domain\Books\Contract\AuthorProviderInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'bookinbox:book:addAuthor',
    description: 'Add a new author',
)]
class BookinboxBookAddAuthorCommand extends Command
{
    public function __construct(
        private readonly OpenLibraryApi $openLibraryApi,
        private readonly AuthorProviderInterface $authorProvider
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('openLibraryId', InputArgument::REQUIRED, 'openLibrary author\'s Id');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $id = $input->getArgument('openLibraryId');

        $author = $this->openLibraryApi->getAuthor($id);
        $this->authorProvider->save($author);

        $io->success('Author successfully added');

        return Command::SUCCESS;
    }
}
