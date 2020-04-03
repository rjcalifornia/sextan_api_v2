<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use App\Entity\Contacts;


class SextansApiController extends AbstractController
{
    /**
     * @Route("/", name="sextans_api")
     */
    public function index()
    {
        /*
        return $this->render('sextans_api/index.html.twig', [
            'controller_name' => 'SextansApiController',
        ]);*/
        
        return $this->render('home/index.html.twig');
    }
    
    /**
     * Returns a JSON with the contacts stored in the database
     *
     * @Route("/api/v1/show-users/", name="show_users_api")  
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function ShowAllUsersAction(Request $request)
    {
     //   header("Access-Control-Allow-Origin: *");
        $em = $this->getDoctrine()->getManager();
         $query = $em->createQuery('SELECT m 
                  FROM App:Contacts m
                  ORDER BY m.id ASC');
         $contacts = $query->getResult();
         
         $baseurl = $request->getSchemeAndHttpHost();
         
         $responseArray = array();
        foreach($contacts as $obj){
            $responseArray[] = array(
                "id" => $obj->getId(),
                "name" => $obj->getFullname(),
                "username" => $obj->getUsername(),
                "email" => $obj->getEmail(),
                "phone" => $obj->getPhone(),
                 "filename" => $baseurl .'/sextan_api_v2/public/uploads/brochures/'. $obj->getFilename(),
                    
            );
            
                     
        }
        return new JsonResponse($responseArray);
    }
    
    /**
     * Stores a contact in the database
     *
     * @Route("/api/v1/save-user/", name="save_user_api")  
     * @param Request $request
     * @return JsonResponse
     */
    public function saveSingleUserAction(Request $request)
    {
       // header("Access-Control-Allow-Origin: *");
        $em = $this->getDoctrine()->getManager();
        
      //  $data = json_decode($request->getContent(), true);
        $data = $request;
        
        
        if($data != null){
            
        $get_file = $request->files->get('file');
        $temp_name = pathinfo($get_file->getClientOriginalName(), PATHINFO_FILENAME);
        $file_name = $temp_name.'-'.uniqid().'.'.$get_file->guessExtension();
        
        try 
                {
                   
                    $get_file->move(
                        $this->getParameter('file_storage'),
                        $file_name
                    );
                }
                
                
                catch (FileException $e) {
                    
                }

        $get_fullname =$data->get('fullname');
        $get_username =$data->get('username');
        $get_email =$data->get('email');
        $get_phone =$data->get('phone');
        
        $contact = new Contacts();
        
        $contact->setFullname($get_fullname);
        $contact->setUsername($get_username);
        $contact->setEmail($get_email);
        $contact->setPhone($get_phone);
        $contact->setFilename($file_name);
        $em->persist($contact);
        $em->flush();
        
        $responseArray[] = array(
                "id" => $contact->getFullname(),
                "message" => 'Contact stored successfully'
            );
        
            }
            else
            {
                $responseArray[] = ["message" => "No data received", "error-code" =>  "400" ];
            }
            
        
         return new JsonResponse($responseArray);

    }
}
