<?php

namespace App\Command;

use App\Services\Books\OpenLibraryApi;
use App\Domain\Books\Controller\AddNewAuthor;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Question\Question;

#[AsCommand(
    name: 'bookinbox:book:addAuthor',
    description: 'Add a new author',
)]
class BookinboxBookAddAuthorCommand extends Command
{
    public function __construct(
        private readonly OpenLibraryApi $openLibraryApi,
        private readonly AddNewAuthor $addNewAuthor
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
        $helper = new QuestionHelper();
        $question = new Question('Goodread Id ?');

        $id = $input->getArgument('openLibraryId');

        $author = $this->openLibraryApi->getAuthor($id);
        if (!$author->goodreadId) {
            $author->goodreadId = $helper->ask($input, $output, $question);
        }

        $this->addNewAuthor->addNewAuthor($author);

        $io->success('Author successfully added');

        return Command::SUCCESS;
    }
}
