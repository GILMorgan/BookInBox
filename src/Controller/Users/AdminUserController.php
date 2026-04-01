<?php

namespace App\Controller\Users;

use App\Services\Users\CurrentUser;
use App\Domain\Users\Controller\ListController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AdminUserController extends AbstractController
{
	public function __construct(
		private readonly CurrentUser $currentUser,
		private readonly ListController $listController 
	)
	{
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
}
