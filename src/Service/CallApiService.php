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

    public function sendMicrojobs($message)
    {
        return $this->postApi('microjobs', $message);
    }

    public function editPosts(int $id, $message)
    {
        return $this->putApi('posts/' . $id, $message);
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

    public function deletePost($id){
        return $this->deleteApi($id);
    }

    private function getApi(string $var)
    {
        $response = $this->client->request('GET', self::BASE_URL . $var, [
            'headers' => [
                'Accept-type' => 'application/json',
                'Content-Type' => 'application/json',
            ],
        ]);

        return $response->getContent();
    }

    private function postApi(string $var, array $message)
    {

        $response = $this->client->request('POST', self::BASE_URL . $var, [
            'headers' => [
                'Accept-type' => 'application/json',
                'Content-Type' => 'application/json',
            ],
            'json' => $message,
        ]);
        return json_decode($response->getContent());
    }

    private function putApi(string $var, array $message = [])
    {

        $response = $this->client->request('PUT', self::BASE_URL . $var, [
            'headers' => [
                'Accept-type' => 'application/json',
                'Content-Type' => 'application/json',
            ], 
            'json' => $message,   
        ]);
        return dump(json_encode($response->getContent()));
    }

    private function deleteApi(int $var)
    {

        $response = $this->client->request('DELETE', self::BASE_URL . $var, [
            'headers' => [
                'Accept-type' => 'application/json',
                'Content-Type' => 'application/json',
            ],
        ]);
        return $response->getContent();
    }
}
