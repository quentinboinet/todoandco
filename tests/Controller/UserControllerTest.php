<?php


namespace App\Tests\Controller;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{
    public function testCreateUserNotLoggedIn()
    {
        $client = static::createClient();
        $client->request('GET', '/users/create');

        $this->assertEquals(302, $client->getResponse()->getStatusCode()); //on s'assure que l'appli retourne une redirection

        $crawler = $client->followRedirect();
        $this->assertSame(2, $crawler->filter('form input#username')->count() + $crawler->filter('form input#password')->count()); //et que celle-ci se fait sur /login
    }

    public function testCreateUserNotAuthorized()
    {
        $client = static::createClient([], [
            'PHP_AUTH_USER' => 'userTest',
            'PHP_AUTH_PW'   => 'userTest',
        ]);
        $client->request('GET', '/users/create');

        $this->assertEquals(403, $client->getResponse()->getStatusCode()); //on s'assure que l'appli retourne un 403 non autorisé

        //TODO : tester affichage page perso de non autorisé
    }

    public function testCreateUserAuthorized()
    {
        $client = static::createClient([], [
            'PHP_AUTH_USER' => 'adminTest',
            'PHP_AUTH_PW'   => 'adminTest',
        ]);
        $client->request('GET', '/users/create');

        $this->assertEquals(200, $client->getResponse()->getStatusCode()); //on s'assure que l'appli retourne un 200

        $client->submitForm('userAdd', [
            'user[username]' => 'testAdd' . uniqid(),
            'user[password][first]' => 'testAdd',
            'user[password][second]' => 'testAdd',
            'user[email]' => 'testEdit' . uniqid() . '@test.fr',
            'user[roles]' => 'ROLE_USER'
        ]);

        $this->assertEquals(302, $client->getResponse()->getStatusCode());//on s'assure qu'on a bien une redirection

        $client->followRedirect();
        $this->assertContains("<strong>Superbe !</strong> L&#039;utilisateur a bien été ajouté.", $client->getResponse()->getContent());//et que celle-ci se fait sur /users avec message de création de l'user
    }

    public function testEditUserNotLoggedIn()
    {
        $client = static::createClient();
        $client->request('GET', '/users/248/edit');

        $this->assertEquals(302, $client->getResponse()->getStatusCode()); //on s'assure que l'appli retourne une redirection

        $crawler = $client->followRedirect();
        $this->assertSame(2, $crawler->filter('form input#username')->count() + $crawler->filter('form input#password')->count()); //et que celle-ci se fait sur /login
    }

    public function testEditUserNotAuthorized()
    {
        $client = static::createClient([], [
            'PHP_AUTH_USER' => 'userTest',
            'PHP_AUTH_PW'   => 'userTest',
        ]);
        $client->request('GET', '/users/248/edit');

        $this->assertEquals(403, $client->getResponse()->getStatusCode()); //on s'assure que l'appli retourne un 403 non autorisé

        //TODO : tester affichage page perso de non autorisé
    }

    public function testEditUserAuthorized()
    {
        $client = static::createClient([], [
            'PHP_AUTH_USER' => 'adminTest',
            'PHP_AUTH_PW'   => 'adminTest',
        ]);
        $client->request('GET', '/users/248/edit');

        $this->assertEquals(200, $client->getResponse()->getStatusCode()); //on s'assure que l'appli retourne un 200

        $client->submitForm('userEdit', [
            'user[username]' => 'testEdit' . uniqid(),
            'user[email]' => 'testEdit' . uniqid() . '@test.fr',
            'user[roles]' => 'ROLE_USER'
        ]);

        $this->assertEquals(302, $client->getResponse()->getStatusCode());//on s'assure qu'on a bien une redirection

        $client->followRedirect();
        $this->assertContains("<strong>Superbe !</strong> L&#039;utilisateur a bien été modifié", $client->getResponse()->getContent());//et que celle-ci se fait sur /users avec message de création de l'user
    }

    public function testEditUserDoesNotExistUserAuthorized()
    {
        $client = static::createClient([], [
            'PHP_AUTH_USER' => 'adminTest',
            'PHP_AUTH_PW'   => 'adminTest',
        ]);
        $client->request('GET', '/users/225/edit');

        $this->assertEquals(404, $client->getResponse()->getStatusCode()); //on s'assure que l'appli retourne un 404 not found
    }
}