<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Yaml\Yaml;
use App\Providers\BookProvider;
use App\Services\Books\BookSerializer;

#[AsCommand(
    name: 'bookinbox:db:export',
    description: 'Export all catalogue from database in yaml',
)]
class BookinboxDbExportCommand extends Command
{
    public function __construct(
        private readonly BookProvider $bookProvider,
        private readonly BookSerializer $bookSerializer
    )
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $books = $this->bookProvider->getAll();

        $io = new SymfonyStyle($input, $output);

        foreach ($books as $book) {                          
            $yaml[$book->id] = $this->bookSerializer->toArray($book);       
        }

        file_put_contents(__DIR__ . "/export-book.yaml", Yaml::dump($yaml));

        $io->success('All books exported');

        return Command::SUCCESS;
    }
}
