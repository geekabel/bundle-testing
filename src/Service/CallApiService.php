<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class CallApiService
{

    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    public function getUser(): array
    {
        return $this->getApi('users');
    }

    public function sendMicrojobs($message)
    {
        return $this->postApi('microjobs', $message);
    }

    public function getPosts(): array
    {

        return $this->getApi('posts');
    }

    public function getPostsById($id): array
    {
        return $this->getApi('posts/' . $id);
    }

    public function sendPost($message)
    {
        return $this->postApi('posts', $message);
    }

    private function getApi(String $var)
    {
        $response = $this->client->request('GET', 'https://jsonplaceholder.typicode.com/' . $var, [
            'headers' => [
                'Accept-type' => 'application/json',
                'Content-Type' => 'application/json',
            ],
        ]);

        return $response->toArray();
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
