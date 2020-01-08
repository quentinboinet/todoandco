<?php


namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testHomePageWhenNotLoggedIn()
    {
        $client = static::createClient();
        $client->request('GET', '/');

        $this->assertEquals(302, $client->getResponse()->getStatusCode()); //on vérifie qu'il y a bien une redirection si on n'est pas loggué

        $crawler = $client->followRedirect();
        $this->assertSame(2, $crawler->filter('form input#username')->count() + $crawler->filter('form input#password')->count()); //on vérifie qu'il y a bien le champ username et password
    }

    public function testHomePageWhenLoggedIn()
    {
        $client = static::createClient([], [
            'PHP_AUTH_USER' => 'userTest',
            'PHP_AUTH_PW'   => 'userTest',
        ]);
        $client->request('GET', '/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());//on vérifie qu'on arrive sur la page d'accueil

        $this->assertContains('Bienvenue sur Todo List, l\'application vous permettant de gérer l\'ensemble de vos tâches sans effort !', $client->getResponse()->getContent()); //on vérifie qu'il s'agit bien de la page d'accueil
    }
}