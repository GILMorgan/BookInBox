<?php

namespace App\Services;

use App\Domain\Books\DTO\SaveBookParams;
use App\Domain\Books\Contract\AuthorProviderInterface;
//use Symfony\Component\Uid\Uuid;

class GoodReadParser
{
    public function __construct(
        private readonly AuthorProviderInterface $authorProvider
    ) {
    }

    public function parse(string $filepath): SaveBookParams
    {
        $dom = $this->readFile($filepath);
        $json = $this->extractJson($dom);

        return new SaveBookParams(
            $this->getTitle($json),
            $this->getIsbn13($json),
            $this->getIsbn10($dom),
            $this->getPublisher($dom),
            $this->getPublishDate($dom),
            $this->getNumberOfPages($json),
            $this->getAuthors($dom),
        );
    }

    private function readFile(string $filepath): \DOMDocument
    {
        $doc = new \DOMDocument();
        libxml_use_internal_errors(true);
        $doc->loadHTML(file_get_contents($filepath));

        return $doc;
    }

    private function extractJson(\DOMDocument $doc): \stdClass
    {
        $xpath = new \DOMXPath($doc);
        $items = $xpath->query("//script[@type='application/ld+json']");

        return json_decode($items->item(0)->nodeValue);


        /*
        $numberOfPages = $this->getNumberOfPages($json);

        return [$title, $isbn, $numberP]$book;*/
    }

    private function getTitle(\stdClass $json): string
    {
        return html_entity_decode($json->name, ENT_QUOTES | ENT_HTML5);
    }

    private function getAuthors(\DOMDocument $doc): array
    {
        $xpath = new \DOMXPath($doc);

        $contributors = $xpath->query("//span/a[@class='ContributorLink']");
        
        foreach ($contributors as $contributor) {
            $role = $xpath->query("./span[@data-testid='role']", $contributor);

            if (!count($role)) {
                $goodreadId = $this->getGoodReadIdFromLink($contributor->getAttribute("href"));
                $authors[] = $this->authorProvider->getByGoodreadId($goodreadId)->id;
            }
        }

        return $authors;
    }

    private function getPublisher(\DomDocument $doc): string
    {
        $xpath = new \DOMXPath($doc);
        $publishString = $xpath->query("//dl/div[@class='DescListItem'][2]/dd")->item(0)->nodeValue;

        preg_match("/(.*\d{4}) by (.*)/", $publishString, $matches);

        if (isset($matches[2])) {
            return $matches[2];
        }

        return "";
    }

    private function getPublishDate(\DomDocument $doc): string
    {
        $xpath = new \DOMXPath($doc);
        $publishString = $xpath->query("//dl/div[@class='DescListItem'][2]/dd")->item(0)->nodeValue;

        preg_match("/(.*\d{4}) by (.*)/", $publishString, $matches);

        if (isset($matches[1])) {
            return $matches[1];
        }

        return "";
    }

    private function getGoodReadIdFromLink(string $href): string
    {
        preg_match("/show\/(\d*)\./", $href, $matches);

        return $matches[1];
    }

    private function getIsbn13(\stdClass $json): string
    {
        if (isset($json->isbn)) {
            return (string) $json->isbn;
        }

        return "";
    }

    private function getIsbn10(\DOMDocument $doc): string
    {
        $xpath = new \DOMXPath($doc);
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
