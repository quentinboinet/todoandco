<?php


namespace App\Tests\Controller;

class SecurityControllerTest extends BaseController
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
        $this->assertContains('Se déconnecter', $this->client->getResponse()->getContent()); //on vérifie qu'il s'agit bien de la page d'accueil

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
        $this->client->request('GET', '/login');
        $crawler = $this->client->submitForm('login', ['_username' => 'userTest', '_password' => 'userTest']);

        $this->client->followRedirect();
        $this->assertContains('Se déconnecter', $this->client->getResponse()->getContent()); //on vérifie qu'il s'agit bien de la page d'accueil

        $this->client->request('GET', '/logout');
        $this->client->followRedirect();
        $crawler = $this->client->followRedirect();
        $this->assertSame(2, $crawler->filter('form input#username')->count() + $crawler->filter('form input#password')->count()); //on vérifie qu'on retombe bien sur la page de login (il y a bien le champ username et password)
    }
}