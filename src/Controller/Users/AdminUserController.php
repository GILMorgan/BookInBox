<?php

namespace App\Controller\Users;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\SecurityBundle\Security;

final class AdminUserController extends AbstractController
{
	public function __construct(private readonly Security $security)
	{
	}

	#[Route('/admin/user', name: 'app_admin_user')]
	public function index(): Response
	{
		return $this->render(
			"users/admin/list.html.twig",
			[]
		);	
	}
}
