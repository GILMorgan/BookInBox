<?php

namespace App\Services;

use App\Domain\Books\DTO\Book;
use Symfony\Component\Uid\Uuid;

class GoodReadParser
{
    public function parse(string $filepath): Book
    {
        $book = new Book();
        $book->id = (string )Uuid::v4();
        $book->openlibraryId = "";

        $book = $this->extractJson($filepath, $book);
        $book = $this->getEditionDetails($filepath, $book);
        $book = $this->getAuthors($filepath, $book);

        return $book;
    }

    private function readFile(string $filepath): \DOMDocument
    {
        $doc = new \DOMDocument();
        libxml_use_internal_errors(true);
        $doc->loadHTML(file_get_contents($filepath));

        return $doc;
    }

    private function extractJson(string $filepath, Book $book): Book
    {
        $doc = $this->readFile($filepath);
        $xpath = new \DOMXPath($doc);
        $items = $xpath->query("//script[@type='application/ld+json']");
        $json = json_decode($items->item(0)->nodeValue);
        
        $book->title = $json->name;
        $book->isbn13 = $json->isbn;
        $book->numberOfPages = $json->numberOfPages;

        return $book;
    }

    private function getEditionDetails(string $filepath, Book $book): Book
    {
        $doc = $this->readFile($filepath);
        $xpath = new \DOMXPath($doc);
        $editionDetails = $xpath->query("//div[@class='EditionDetails']")->item(0);

        $book->isbn10 = trim($xpath->query("//span[@data-testid='asin']", $editionDetails)->item(0)->nodeValue);
        [$publishDate, $publisher] = $this->formatPublisher($xpath->query("//dl/div[@class='DescListItem'][2]/dd")->item(0)->nodeValue);

        $book->publisher = $publisher;
        $book->publishDate = $publishDate;

        return $book;
    }

    private function getAuthors(string $filepath, Book $book): Book
    {
        $doc = $this->readFile($filepath);
        $xpath = new \DOMXPath($doc);

        $authors = [];
        $contributors = $xpath->query("//span/a[@class='ContributorLink']");
        
        foreach ($contributors as $contributor) {
            $role = $xpath->query("./span[@data-testid='role']", $contributor);

            if (!count($role)) {
                $book->authors[] = $this->getGoodReadIdFromLink($contributor->getAttribute("href"));
            }
        }

        return $book;
    }

    private function formatPublisher(string $publishInfo): array
    {
        preg_match("/(.*\d{4}) by (.*)/", $publishInfo, $matches);

        return [$matches[1], $matches[2]];
    }

    private function getGoodReadIdFromLink(string $href): string
    {
        preg_match("/show\/(\d*)\./", $href, $matches);

        return $matches[1];
    }
}
