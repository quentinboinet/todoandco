<?php


namespace App\Tests\Controller;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BaseController extends WebTestCase
{
    public function getService($serviceName)
    {
        $kernel = self::bootKernel();
        return $kernel->getContainer()
            ->get($serviceName)
            ->getManager();
    }

    public function loginClient($username, $password)
    {
        return static::createClient([], [
            'PHP_AUTH_USER' => $username,
            'PHP_AUTH_PW'   => $password
        ]);
    }
}