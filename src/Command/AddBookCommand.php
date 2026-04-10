<?php

namespace App\Command;


use App\Repository\BookRepository;
use App\Entity\Book;
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
        private readonly BookRepository $bookRepository,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        foreach (new \DirectoryIterator(__DIR__) as $fileInfo) {        
            if ($fileInfo->getExtension() === "html") {
                var_dump($fileInfo);
            }

        }

   
        return Command::SUCCESS;
    }
}
