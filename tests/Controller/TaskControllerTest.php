<?php


namespace App\Tests\Controller;


use App\Entity\Task;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TaskControllerTest extends WebTestCase
{
    private $idTaskAuthorized;
    private $idTaskNotAuthorized;

    public function setUp()
    {
        $em = self::$kernel->getContainer('doctrine');
        $taskRepo = $em->getRepository(Task::class);
        $taskUser = $taskRepo->findOneBy(['user' => 247]);
        $taskNotUser = $taskRepo->findOneBy(['user' => 248]);
        $this->idTaskAuthorized = $taskUser->getId();
        $this->idTaskNotAuthorized = $taskNotUser->getId();
    }

    public function testTasksListNotLoggedIn()
    {
        $client = static::createClient();
        $client->request('GET', '/tasks');

        $this->assertEquals(302, $client->getResponse()->getStatusCode()); //on s'assure que l'appli retourne une redirection

        $crawler = $client->followRedirect();
        $this->assertSame(2, $crawler->filter('form input#username')->count() + $crawler->filter('form input#password')->count()); //et que celle-ci se fait sur /login
    }

    public function testTasksListLoggedIn()
    {
        $client = static::createClient([], [
            'PHP_AUTH_USER' => 'userTest',
            'PHP_AUTH_PW'   => 'userTest',
        ]);
        $client->request('GET', '/tasks');

        $this->assertEquals(200, $client->getResponse()->getStatusCode()); //on s'assure que l'appli retourne un 200

        $this->assertContains("Créer une tâche</a>", $client->getResponse()->getContent());//et qu'il y a le bouton créer une tâche
    }

    public function testCreateTaskNotLoggedIn()
    {
        $client = static::createClient();
        $client->request('GET', '/tasks/create');

        $this->assertEquals(302, $client->getResponse()->getStatusCode()); //on s'assure que l'appli retourne une redirection

        $crawler = $client->followRedirect();
        $this->assertSame(2, $crawler->filter('form input#username')->count() + $crawler->filter('form input#password')->count()); //et que celle-ci se fait sur /login
    }

    public function testCreateTaskAuthorized()
    {
        $client = static::createClient([], [
            'PHP_AUTH_USER' => 'userTest',
            'PHP_AUTH_PW'   => 'userTest',
        ]);
        $client->request('GET', '/tasks/create');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $uniqId = uniqid();
        $client->submitForm('taskAdd', [
            'task[title]' => 'Titre tâche de test : ' . $uniqId,
            'task[content]' => 'Contenu tâche de test'
        ]);
        $this->assertEquals(302, $client->getResponse()->getStatusCode());//on s'assure que ca a fonctionné et que c'est une redirection vers notre liste de tâches

        $client->followRedirect();
        $this->assertContains("Titre tâche de test : " . $uniqId, $client->getResponse()->getContent());//et que la tâche apparait bien dans notre liste de tâche
    }

    public function testEditTaskNotLoggedIn()
    {
        $client = static::createClient();
        $client->request('GET', '/tasks/313/edit');

        $this->assertEquals(302, $client->getResponse()->getStatusCode()); //on s'assure que l'appli retourne une redirection

        $crawler = $client->followRedirect();
        $this->assertSame(2, $crawler->filter('form input#username')->count() + $crawler->filter('form input#password')->count()); //et que celle-ci se fait sur /login
    }

    public function testEditTaskNotAuthorized()
    {
        $client = static::createClient([], [
            'PHP_AUTH_USER' => 'userTest',
            'PHP_AUTH_PW'   => 'userTest',
        ]);
        $client->request('GET', '/tasks/313/edit');

        $this->assertEquals(200, $client->getResponse()->getStatusCode()); //on s'assure que ça retourne une page

        $this->assertContains('<img src="/img/404error.png" alt="Erreur 404 !" />', $client->getResponse()->getContent());//et que celle-ci est celle d'erreur 404
    }

    public function testEditTaskAuthorized()
    {
        $client = static::createClient([], [
            'PHP_AUTH_USER' => 'userTest',
            'PHP_AUTH_PW'   => 'userTest',
        ]);
        $client->request('GET', '/tasks/417/edit');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $uniqId = uniqid();
        $client->submitForm('taskEdit', [
            'task[title]' => 'Titre tâche de test modifiée : ' . $uniqId,
            'task[content]' => 'Contenu tâche de test modifiée'
        ]);
        $this->assertEquals(302, $client->getResponse()->getStatusCode());//on s'assure que ca a fonctionné et que c'est une redirection vers notre liste de tâches

        $client->followRedirect();
        $this->assertContains("La tâche a bien été modifiée", $client->getResponse()->getContent());//et que la tâche apparait bien dans notre liste de tâche
    }

    public function testToggleTaskNotLoggedIn()
    {
        $client = static::createClient();
        $client->request('GET', '/tasks/417/toggle');

        $this->assertEquals(302, $client->getResponse()->getStatusCode()); //on s'assure que l'appli retourne une redirection

        $crawler = $client->followRedirect();
        $this->assertSame(2, $crawler->filter('form input#username')->count() + $crawler->filter('form input#password')->count()); //et que celle-ci se fait sur /login
    }

    public function testToggleTaskNotAuthorized()
    {
        $client = static::createClient([], [
            'PHP_AUTH_USER' => 'userTest',
            'PHP_AUTH_PW'   => 'userTest',
        ]);
        $client->request('GET', '/tasks/313/toggle');

        $this->assertEquals(200, $client->getResponse()->getStatusCode()); //on s'assure que ça retourne une page

        $this->assertContains('<img src="/img/404error.png" alt="Erreur 404 !" />', $client->getResponse()->getContent());//et que celle-ci est celle d'erreur 404
    }

    public function testToggleTaskAuthorized()
    {
        $client = static::createClient([], [
            'PHP_AUTH_USER' => 'userTest',
            'PHP_AUTH_PW'   => 'userTest',
        ]);
        $client->request('GET', '/tasks/417/toggle');

        $this->assertEquals(302, $client->getResponse()->getStatusCode()); //on s'assure que ça retourne bien une redirection

        $client->followRedirect();
        $this->assertContains("<strong>Superbe !</strong>", $client->getResponse()->getContent());// et que ce soit bien une page avec le toaster de validation
    }

    public function testDeleteTaskNotLoggedIn()
    {
        $client = static::createClient();
        $client->request('GET', '/tasks/313/delete');

        $this->assertEquals(302, $client->getResponse()->getStatusCode()); //on s'assure que l'appli retourne une redirection

        $crawler = $client->followRedirect();
        $this->assertSame(2, $crawler->filter('form input#username')->count() + $crawler->filter('form input#password')->count()); //et que celle-ci se fait sur /login
    }

    public function testDeleteTaskNotAuthorized()
    {
        $client = static::createClient([], [
            'PHP_AUTH_USER' => 'userTest',
            'PHP_AUTH_PW'   => 'userTest',
        ]);
        $client->request('GET', '/tasks/313/delete');

        $this->assertEquals(403, $client->getResponse()->getStatusCode()); //on s'assure que ça retourne un 403 non autorisé
    }

    public function testDeleteTaskAuthorized()
    {
        $client = static::createClient([], [
            'PHP_AUTH_USER' => 'userTest',
            'PHP_AUTH_PW'   => 'userTest',
        ]);
        $client->request('GET', '/tasks/417/delete');

        $this->assertEquals(302, $client->getResponse()->getStatusCode()); //on s'assure que ça retourne bien une redirection

        $client->followRedirect();
        $this->assertContains("La tâche a bien été supprimée", $client->getResponse()->getContent());// et que ce soit bien une page avec le toaster de validation
    }
}