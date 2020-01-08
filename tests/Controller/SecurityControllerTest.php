<?php


namespace App\Tests\Controller;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SecurityControllerTest extends WebTestCase
{
    private $client;

    public function setUp(): void
    {
        $this->client = static::createClient();
    }

    public function testLoginPageIsUp()
    {
        $this->client->request('GET', '/login');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    public function testAuhtenticationUser()
    {
        $this->client->request('GET', '/login');
        $crawler = $this->client->submitForm('login', ['_username' => 'userTest', '_password' => 'userTest']);

        $this->client->followRedirect();
        $this->assertContains('Bienvenue sur Todo List, l\'application vous permettant de gérer l\'ensemble de vos tâches sans effort !', $this->client->getResponse()->getContent()); //on vérifie qu'il s'agit bien de la page d'accueil

        $this->assertNotContains('Créer un utilisateur' , $this->client->getResponse()->getContent()); //on vérifie qu'il ne s'agit pas de la page admin
    }

    public function testAuhtenticationAdmin()
    {
        $this->client->request('GET', '/login');
        $crawler = $this->client->submitForm('login', ['_username' => 'adminTest', '_password' => 'adminTest']);

        $this->client->followRedirect();
        $this->assertContains('Créer un utilisateur', $this->client->getResponse()->getContent()); //on vérifie qu'il s'agit bien de la page d'accueil version admin

    }

    public function testAuhtenticationFail()
    {
        $this->client->request('GET', '/login');
        $crawler = $this->client->submitForm('login', ['_username' => 'testWrong', '_password' => 'testWrong']);

        $this->client->followRedirect();
        $this->assertContains('Vos identifiants sont incorrects !', $this->client->getResponse()->getContent()); //on vérifie qu'il s'agit bien de la page de login avec le message d'erreur
    }

    public function testLogout()
    {
        $client = static::createClient([], [
            'PHP_AUTH_USER' => 'userTest',
            'PHP_AUTH_PW'   => 'userTest',
        ]);
        $client->request('GET', '/logout');

        $client->followRedirect();
        $this->assertContains('Bienvenue sur Todo List, l\'application vous permettant de gérer l\'ensemble de vos tâches sans effort !', $client->getResponse()->getContent()); //on vérifie qu'on arrive bien sur la page de login à nouveau
    }
}