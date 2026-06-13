<?php

namespace App\Domain\Books\Controller;

use App\Domain\Books\DTO\SearchAuthorParams;
use App\Domain\Books\DTO\SearchAuthorResults;
use App\Domain\Books\Contract\AuthorProviderInterface;

final class SearchAuthor
{
    public function __construct(private readonly AuthorProviderInterface $authorProvider) {
    }

    public function searchAuthor(SearchAuthorParams $params): SearchAuthorResults
    {
        return new SearchAuthorResults(
            $this->authorProvider->findByName($params->name)
        );
    }
}
