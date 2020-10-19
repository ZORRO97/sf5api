<?php

namespace App\Tests\Unit;

use App\Entity\Sejour;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    /**
     * @var User
     */
    private $user;

    protected function SetUp():void
    {
        parent::setUp();
        $this->user = new User();
    }

    public function testGetEmail(): void
    {
        $value = 'bullshit@gg.com';

        $response =  $this->user->setEmail($value);
        $getEmail = $this->user->getEmail();

        self::assertInstanceOf(User::class, $response);
        self::assertEquals($value, $getEmail);
        self::assertEquals($value, $this->user->getUsername());
    }

    public function testGetRoles(): void
    {
        $value = ['ROLE_ADMIN'];
        $response = $this->user->setRoles($value);
        self::assertInstanceOf(User::class,$response);
        self::assertContains('ROLE_USER',$this->user->getRoles());
        self::assertContains('ROLE_ADMIN',$this->user->getRoles());

    }

    public function testGetPassword(): void
    {
        $value = 'password';
        $response = $this->user->setPassword($value);
        self::assertInstanceOf(User::class,$response);
        self::assertEquals($value,$this->user->getPassword());

    }

    public function testGetArticle(): void
    {
        $value = new Sejour();
        $response = $this->user->addSejour($value);

        self::assertInstanceOf(User::class, $response);
        self::assertCount(1,$this->user->getSejours());
        self::assertTrue($this->user->getSejours()->contains($value));

        $response = $this->user->removeSejour($value);

        self::assertInstanceOf(User::class, $response);
        self::assertCount(0,$this->user->getSejours());
        self::assertFalse($this->user->getSejours()->contains($value));
    }
}
