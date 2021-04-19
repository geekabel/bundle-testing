
### GET REQUEST TO TEST HTTPCLIENT COMPONENT 
     
     
     public function fetchInformation(HttpClientInterface $httpClient, Request $request)
     {
          $httpClient = HttpClient::create();
          //$numberOfresults = 30;
          $url = 'http://jsonplaceholder.typicode.com/posts'; 

          $response = $httpClient->request('POST', $url, [

               'headers' => [
                    'Accept-type' => 'application/json',
                    'Content-Type' => 'application/json'
               ],

               'body' => [
                    'msg' => 'Hello there',
                    'name' =>  'toto',
                    'title' => 'occaecati excepturi'
               ],
          ]);
          if ($response->getStatusCode() === 200) {

               $data = $response->getContent();
               
               dd($data); 
          }else{

               throw new Exception("la requete n'a pas pas abouti");
          }
        
          //return $this->render('pages/api.html.twig', $data);
     }




