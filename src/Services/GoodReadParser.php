<?php

namespace App\Services;

use App\Domain\Books\DTO\Book;
use App\Domain\Books\Contract\AuthorProviderInterface;
use Symfony\Component\Uid\Uuid;

class GoodReadParser
{
    public function __construct(
        private readonly AuthorProviderInterface $authorProvider
    ) {
    }

    public function parse(string $filepath): Book
    {
        $book = new Book();
        $book->id = (string )Uuid::v4();
        $book->openlibraryId = "";
        $book->serieName = "";
        $book->serieNumber = 0;

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
        
        $book->title = html_entity_decode($json->name, ENT_QUOTES | ENT_HTML5);
        $book->isbn13 = $this->getIsbn($json);
        $book->numberOfPages = $this->getNumberOfPages($json);

        return $book;
    }

    private function getEditionDetails(string $filepath, Book $book): Book
    {
        $doc = $this->readFile($filepath);
        $xpath = new \DOMXPath($doc);

        $book->isbn10 = $this->getIsbn10($xpath);
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
                $goodreadId = $this->getGoodReadIdFromLink($contributor->getAttribute("href"));
                $book->authors[] = $this->authorProvider->getByGoodreadId($goodreadId)->id;
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

    private function getIsbn(\stdClass $json): string
    {
        if (isset($json->isbn)) {
            return (string) $json->isbn;
        }

        return "";
    }

    private function getIsbn10(\DOMXPath $xpath): string
    {
        $editionDetails = $xpath->query("//div[@class='EditionDetails']")->item(0);
        $node = $xpath->query("//span[@data-testid='asin']", $editionDetails)->item(0);

        if (!$node) {
            return "";
        }

        return trim($node->nodeValue);
    }

    private function getNumberOfPages(\stdClass $json): int
    {
        if (isset($json->numberOfPages)) {
            return $json->numberOfPages;
        }

        return 0;
    }
}
