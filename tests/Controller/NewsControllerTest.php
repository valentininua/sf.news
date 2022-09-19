<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 *     Functional test for the controllers defined inside NewsController.
 *     $ cd your-symfony-project/
 *     $ ./vendor/bin/phpunit
 */
class NewsControllerTest extends WebTestCase
{
    public function testIndex(): void
    {
        $client = static::createClient();
        $client->request('GET', '/');
        $this->assertResponseStatusCodeSame(200);
    }

    public function testNews(): void
    {
        $client = static::createClient();
        $client->request('GET', '/news');
        static::assertResponseRedirects('/login');
    }

}
