<?php

namespace tests\Form;

use App\Domain\Users\DTO\User;
use App\Form\UserType;
use Symfony\Component\Form\Test\TypeTestCase;

class UserTypeTest extends TypeTestCase
{  
    public function testSubmitValidAdminData()
    {
        $data = [
            "email" => "newUser@bookinbox.com",
            "roles" => "ADMIN",
            "password" => "motdepasse",
        ];

        $user = new User();

        $form = $this->factory->create(UserType::class, $user);
        $form->submit($data);

        $this->assertTrue($form->isSynchronized());
        $this->assertSame("newUser@bookinbox.com", $user->email);
        $this->assertSame(["ADMIN", "USER"], $user->roles);
    }

    public function testSubmitValidUserData()
    {
        $data = [
            "email" => "newUser@bookinbox.com",
            "roles" => "USER",
            "password" => "motdepasse",
        ];

        $user = new User();

        $form = $this->factory->create(UserType::class, $user);
        $form->submit($data);

        $this->assertTrue($form->isSynchronized());
        $this->assertSame("newUser@bookinbox.com", $user->email);
        $this->assertSame(["USER"], $user->roles);
    }
}
