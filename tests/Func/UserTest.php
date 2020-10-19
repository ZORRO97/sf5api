<?php


namespace App\Tests\Func;


use App\DataFixtures\AppFixtures;
use Faker\Factory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserTest extends AbstractEndPoint
{
    private $userPayload = '{"email": "%s", "password": "sesameouvretoi"}';

    public function testGetUsers(): void
    {

        $response = $this->getResponseFromRequest(
            Request::METHOD_GET,
            '/api/users',
            '',
            [],
            true);
        $responseContent = $response->getContent();
        $responseDecoded = json_decode($responseContent);


        self::assertEquals(Response::HTTP_OK,$response->getStatusCode());
        self::assertJson($responseContent);
        self::assertNotEmpty($responseDecoded);
    }

    public function testPostUser(): void
    {

        $response = $this->getResponseFromRequest(
            Request::METHOD_POST,
            '/api/users',
            $this->getPayload(),
            [],
            true);
        $responseContent = $response->getContent();
        $responseDecoded = json_decode($responseContent);

        self::assertEquals(Response::HTTP_CREATED,$response->getStatusCode());
        self::assertJson($responseContent);
        self::assertNotEmpty($responseDecoded);
    }

    public function testGetDefaultUser(): void
    {
        $response = $this->getResponseFromRequest(
            Request::METHOD_GET,
            '/api/users/1',
            '',
            ['email' => AppFixtures::DEFAULT_USER['email']],
            true);
        $responseContent = $response->getContent();

        $responseDecoded = json_decode($responseContent,true);

        self::assertEquals(Response::HTTP_OK,$response->getStatusCode());
        self::assertJson($responseContent);
        self::assertNotEmpty($responseDecoded);
    }

    public function getPayload()
    {
        $faker = Factory::create();
        return sprintf($this->userPayload, $faker->email);

    }

}
