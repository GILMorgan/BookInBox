<?php

namespace App\Domain\Books\Controller;

use App\Domain\Books\DTO\GetBookPageParams;
use App\Domain\Books\DTO\GetBookPageResult;
use App\Domain\Books\Contract\BookProviderInterface;

final class GetBookPage
{
    public function __construct(private readonly BookProviderInterface $bookProvider)
    {
    }

    public function getBookPage(GetBookPageParams $params): GetBookPageResult
    {
        return new GetBookPageResult(
            $this->bookProvider->getPage($params->pageIndex),
            $this->bookProvider->getNbOfBooks()
        );
    }
}
