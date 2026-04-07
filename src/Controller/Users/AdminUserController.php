<?php

namespace App\Controller\Users;

use App\Services\Users\CurrentUser;
use App\Domain\Users\Controller\AddController;
use App\Domain\Users\Controller\ListController;
use App\Domain\Users\DTO\User;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Uid\Uuid;

final class AdminUserController extends AbstractController
{
    public function __construct(
        private readonly CurrentUser $currentUser,
        private readonly ListController $listController,
        private readonly AddController $addController,
    ) {
    }

    #[Route('/admin/user', name: 'app_admin_user')]
    public function index(): Response
    {
        return $this->render(
            "users/admin/list.html.twig",
            [
                "users" => $this->listController->getAllUsers($this->currentUser->getUser()),
            ]
        );    
    }
   
    #[Route('/admin/user/add', name: 'app_admin_user_add')]
    public function add(Request $request): Response
    {
        $form = $this->createForm(UserType::class, new User());
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $id = (string) Uuid::v4();
            $user = $form->getData();
            $user->id = $id;

            $this->addController->addUser(
                $this->currentUser->getUser(),
                $user
            );    
        }

        return $this->render(
            "users/admin/add.html.twig",
            [
                "userForm" => $form
            ]
        );
    }
}
