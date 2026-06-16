<?php

namespace App\Services\Books;

use App\Domain\Books\DTO\SaveBookParams;
use Symfony\Component\HttpFoundation\Request;

final class BookJson
{
    public function toDto(Request $request): SaveBookParams
    {
        $json = json_decode($request->getContent());

        $book = new SaveBookParams(
            $json->title,
            $json->isbn13,
            $json->isbn10,
            $json->publisher,
            $json->publishDate,
            $json->nbPages,
            explode(", ", $json->authors),
            $json->serieName,
            $json->serieNumber,
        );

        return $book;
    }
}
