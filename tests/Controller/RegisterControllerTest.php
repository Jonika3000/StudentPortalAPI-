<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Response;

class RegisterControllerTest extends WebTestCase
{
    public function testRegistration(): void
    {
        $client = static::createClient();

        $tempFile = tempnam(sys_get_temp_dir(), 'test').'.jpg';
        $image = imagecreatetruecolor(100, 100); // Create a blank 100x100 image
        imagejpeg($image, $tempFile); // Save the image as a JPEG
        imagedestroy($image);

        $uploadedFile = new UploadedFile(
            $tempFile,
            'test-image.jpg',
            'image/jpeg',
            null,
            true
        );

        $data = [
            'email' => 'user@example.com',
            'password' => 'correctpassword',
            'firstName' => 'John',
            'secondName' => 'Doe',
            'birthday' => '1990-01-01',
            'address' => '123 Street Name',
            'phoneNumber' => '123456789',
            'gender' => 'Male',
        ];

        $client->request(
            'POST',
            '/api/register',
            ['data' => json_encode($data)],
            ['avatar' => $uploadedFile],
            ['CONTENT_TYPE' => 'multipart/form-data']
        );

        $this->assertResponseIsSuccessful();

        $responseData = json_decode($client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('message', $responseData);
        $this->assertEquals('Registered Successfully', $responseData['message']);
    }

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

//    public function testRegistrationWithInvalidData(): void
//    {
//        $client = static::createClient();
//
//        $data = [
//            'username' => 'invaliduser@example.com',
//            'password' => '',
//        ];
//
//        $client->request('POST', '/api/register', [], [], [
//            'CONTENT_TYPE' => 'application/json',
//        ], json_encode($data));
//
//        $this->assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST);
//
//        $responseData = json_decode($client->getResponse()->getContent(), true);
//        $this->assertArrayHasKey('errors', $responseData);
//    }
}
