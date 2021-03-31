<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class CallApiService
{
    public const BASE_URL = 'https://jsonplaceholder.typicode.com/';

    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    /*public function getUser(): array
    {
    return $this->getApi('users');
    }*/

    public function sendMicrojobs($message)
    {
        return $this->postApi('microjobs', $message);
    }

    public function getPosts()
    {
        
        return $this->getApi('posts');
    }
    
    public function getPostsById($id)
    {
    return $this->getApi('posts/' . $id);
    }

    public function sendPost($message)
    {
        return $this->postApi('posts', $message);
    }

    private function getApi(String $var)
    {
        $response = $this->client->request('GET', self::BASE_URL . $var, [
            'headers' => [
                'Accept-type' => 'application/json',
                'Content-Type' => 'application/json',
            ],
        ]);

        return $response->getContent();
    }

    private function postApi(String $var, array $message)
    {

        $response = $this->client->request('POST', 'https://jsonplaceholder.typicode.com/' . $var, [
            'headers' => [
                'Accept-type' => 'application/json',
                'Content-Type' => 'application/json',
            ],
            'json' => $message,
        ]);
        return json_decode($response->getContent());
    }
}
