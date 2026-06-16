<?php

namespace App\Domain\Books\Controller;

use App\Domain\Books\DTO\GetAuthorPageParams;
use App\Domain\Books\DTO\GetAuthorPageResult;
use App\Domain\Books\Contract\AuthorProviderInterface;

final class GetAuthorPage
{
    public function __construct(private readonly AuthorProviderInterface $authorProvider)
    {
    }

    public function getAuthorPage(GetAuthorPageParams $params): GetAuthorPageResult
    {
        return new GetAuthorPageResult(
            $this->authorProvider->getPage($params->pageIndex),
            $this->authorProvider->getNbOfAuthors(),
        );
    }
}
