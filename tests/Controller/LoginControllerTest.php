<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LoginControllerTest extends WebTestCase
{
    public function testLoginPageIsAccessible(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');

        // Vérifie que la page de connexion retourne un code 200 (OK)
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Connexion'); // Adapte le sélecteur si nécessaire
    }

    public function testSuccessfulLogin(): void
    {
        $client = static::createClient();

        // Accède à la page de connexion
        $crawler = $client->request('GET', '/login');
        
        // Récupère le formulaire de connexion
        $form = $crawler->selectButton('Se connecter')->form();

        // Remplis le formulaire avec des identifiants valides
        $form['_email'] = 'user1@test.com'; // Remplace par un email valide en BDD
        $form['_password'] = 'test'; // Remplace par le bon mot de passe

        // Soumets le formulaire
        $client->submit($form);

        // Vérifie la redirection post-connexion (vers la page d'accueil, par exemple)
        $this->assertResponseRedirects('/'); // Remplace '/' par la route de destination après connexion

        // Suivre la redirection
        $client->followRedirect();

        // Vérifie la présence d'un message de succès ou d'un élément de la page d'accueil
        $this->assertSelectorTextContains('.flash-success', 'Bienvenue'); // Adapte en fonction de ta page
    }

    public function testFailedLogin(): void
    {
        $client = static::createClient();

        // Accède à la page de connexion
        $crawler = $client->request('GET', '/login');
        
        // Récupère le formulaire de connexion
        $form = $crawler->selectButton('Se connecter')->form();

        // Remplis le formulaire avec des identifiants incorrects
        $form['_username'] = 'wronguser@test.com';
        $form['_password'] = 'wrongpassword';

        // Soumets le formulaire
        $client->submit($form);

        // Vérifie que l'utilisateur reste sur la page de connexion avec un message d'erreur
        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('.alert-danger'); // Vérifie qu'un message d'erreur est affiché
    }
}
