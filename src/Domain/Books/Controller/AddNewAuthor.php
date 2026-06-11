<?php

namespace App\Domain\Books\Controller;

use App\Domain\Books\DVO\Author;
use App\Domain\Books\Contract\AuthorProviderInterface;
use App\Domain\Books\Controller\Exception\AuthorAllReadyExistException;
use App\Providers\Exception\AuthorNotFoundException;

class AddNewAuthor
{
    public function __construct(private readonly AuthorProviderInterface $authorProvider)
    {
    }

    public function addNewAuthor(Author $author): Author
    {
        $this->checkIfAuthorExist($author);
        
        return $this->authorProvider->save($author);    
    }

    private function checkIfAuthorExist(Author $author)
    {
        try {
            $this->authorProvider->getByGoodreadId($author->goodreadId);
        } catch (AuthorNotFoundException $e) {
            return;
        }        

        throw new AuthorAllReadyExistException();
    }
}
