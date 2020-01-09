<?php


namespace App\Tests\Controller;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{
    public function testCreateUserNotAuthorized()
    {
        $client = static::createClient([], [
            'PHP_AUTH_USER' => 'userTest',
            'PHP_AUTH_PW'   => 'userTest',
        ]);
        $client->request('GET', '/users/create');

        $this->assertEquals(403, $client->getResponse()->getStatusCode()); //on s'assure que l'appli retourne un 403 non autorisé

        //TODO : tester redirect sur accueil et affichage page perso de non autorisé
    }

}