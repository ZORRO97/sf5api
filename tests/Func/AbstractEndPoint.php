<?php


namespace App\Tests\Func;


use App\DataFixtures\AppFixtures;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

abstract class AbstractEndPoint extends WebTestCase
{

    private $serverInformations = ['ACCEPT' => 'application/json', 'CONTENT_TYPE' => 'application/json'];
    protected $tokenNotFound = 'JWT Token introuvable';
    protected $loginPayload = '{"username":"%s", "password":"%s"}';

    public function getResponseFromRequest(
        string $method,
        string $uri,
        string $payload = '',
        array $parameter,
        bool $withAuthentification = true
    ): Response
    {
        $client = $this->createAuthentificationClient($withAuthentification);

        $client->request(
            $method,
            $uri . '.json',
            $parameter,
            [],
            $this->serverInformations,
            $payload
        );

        return $client->getResponse();
    }

    protected function createAuthentificationClient(bool $withAuthentification): KernelBrowser
    {
        $client = self::createClient();

        if (!$withAuthentification) {
            return $client;
        }

        $client->request(
            Request::METHOD_POST,
            '/api/login_check',
            [],
            [],
            $this->serverInformations,
            sprintf($this->loginPayload, AppFixtures::DEFAULT_USER['email'], AppFixtures::DEFAULT_USER['password'])
        );
        $data = json_decode($client->getResponse()->getContent(), true);
        $client->setServerParameter('HTTP Authorization', sprintf('Bearer %s', $data['token']));
        return $client;
    }
}
