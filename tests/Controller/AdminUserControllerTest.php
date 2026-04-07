<?php

namespace tests\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AdminUserControllerTest extends WebTestCase
{
	public function testListNormalUser() 
	{
		$client = static::createClient();
		$userRepository = static::getContainer()->get(UserRepository::class);
		$users = $userRepository->findAll();

		$client->loginUser($users[0]);

        $crawler = $client->request('GET', '/admin/user');

        $this->assertResponseIsSuccessful();
    }

    public function testAddUser()
    {
    	$client = static::createClient();
		$userRepository = static::getContainer()->get(UserRepository::class);
		$users = $userRepository->findAll();

		$client->loginUser($users[0]);

        $crawler = $client->request('GET', '/admin/user/add');

        $this->assertResponseIsSuccessful();
    }
}
