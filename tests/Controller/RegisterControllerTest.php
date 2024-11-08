<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class RegisterControllerTest extends WebTestCase
{
    public function testSuccessfulLogin(): void
    {
        $client = static::createClient();

        $credentials = [
            'username' => 'user@example.com',
            'password' => 'correctpassword',
        ];

        $client->request('POST', '/api/login_check', [], [], [
            'CONTENT_TYPE' => 'application/json',
        ], json_encode($credentials));

        $this->assertResponseIsSuccessful();
        $data = json_decode($client->getResponse()->getContent(), true);

        $this->assertArrayHasKey('token', $data);
        $this->assertNotEmpty($data['token']);
    }

    public function testRegistration(): void
    {
        $client = static::createClient();

        $uploadedFile = new UploadedFile(
            __DIR__.'/../fixtures/ryan-fabien.jpg',
            'ryan-fabien.jpg'
        );

        $data = [
            'email' => 'newuser@example.com',
            'password' => 'password123',
            'firstName' => 'John',
            'secondName' => 'Doe',
            'birthday' => '1990-01-01',
            'address' => '123 Street Name',
            'phoneNumber' => '123456789',
            'gender' => 'male',
        ];

        $client->request(
            'POST',
            '/api/register',
            [],
            ['avatar' => $uploadedFile],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($data)
        );

        $this->assertResponseIsSuccessful();

        $responseData = json_decode($client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('message', $responseData);
        $this->assertEquals('Registered Successfully', $responseData['message']);
    }

    public function testRegistrationWithInvalidData(): void
    {
        $client = static::createClient();

        $data = [
            'email' => 'invaliduser@example.com',
            'password' => '',
        ];

        $client->request('POST', '/api/register', [], [], [
            'CONTENT_TYPE' => 'application/json',
        ], json_encode($data));

        $this->assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST);

        $responseData = json_decode($client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('errors', $responseData);
    }
}
