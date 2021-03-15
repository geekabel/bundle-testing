
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
{{path('pages.details')}}



              <?php

namespace App\Form\PostType;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class)
            ->add('body', TextareaType::class)
            ->add('save', SubmitType::class)
        ;
    }
}

