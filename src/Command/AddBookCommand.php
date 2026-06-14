<?php

namespace App\Command;

use App\Domain\Books\Controller\AddBook;
use App\Services\GoodReadParser;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:addBook',
    description: 'Add a short description for your command',
)]
class AddBookCommand extends Command
{
    public function __construct(
        private readonly GoodReadParser $goodReadParser,
        private readonly AddBook $addBook
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        foreach (new \DirectoryIterator(__DIR__) as $fileInfo) {        
            if ($fileInfo->getExtension() === "html") {
                $dto = $this->goodReadParser->parse($fileInfo->getPathName());
                $this->addBook->addBook($dto);
            }
        }
   
        return Command::SUCCESS;
    }
}
