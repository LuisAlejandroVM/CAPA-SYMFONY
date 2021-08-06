<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController{

    public function getUsers(){
        $em = $this->getDoctrine()->getManager();
        $listUsers = $em->getRepository('App:Users')->findBy([], ['name' => 'ASC']);
        return $this->render('user/users.html.twig', [
            'listUsers' => $listUsers
        ]);
    }

    public function createUser(Request $request){
        $em = $this->getDoctrine()->getManager();

        $users = new \App\Entity\Users();

        $form_users = $this->createForm(\App\Form\UserType::class, $users);
        $form_users->handleRequest($request);

        if($form_users->isSubmitted() && $form_users->isValid()){
            // Create user
        }

        // do redirection
    }
}
