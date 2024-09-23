<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class AdminAdControllerTest extends WebTestCase
{
    public function testAuthPageIsRestricted(): void
    {
        $client = static::createClient();
        $client->request('GET', 'dashboard');

        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);

    }
}
