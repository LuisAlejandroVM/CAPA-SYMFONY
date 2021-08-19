<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

// Importamos html2pdf
use Spipu\Html2Pdf\Html2Pdf;

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
            $users->setStatus(1);
            $em->persist($users);
            $em->flush();

            return $this->redirectToRoute('getUsers');
        }

        return $this->render('user/user_create.html.twig', [
            'form_users' => $form_users->createView()
        ]);
    }

    public function updateUser(Request $request, $id){
        $em = $this->getDoctrine()->getManager();

        $users = $em->getRepository('App:Users')->find($id);

        $form_users = $this->createForm(\App\Form\UserType::class, $users);
        $form_users->handleRequest($request);

        if($form_users->isSubmitted() && $form_users->isValid()){
            $em->persist($users);
            $em->flush();

            return $this->redirectToRoute('getUsers');
        }

        return $this->render('user/user_update.html.twig', [
            'form_users' => $form_users->createView()
        ]);
    }

    public function deleteUser(Request $request, $id){
        $em = $this->getDoctrine()->getManager();

        $users = $em->getRepository('App:Users')->find($id);

        $users->setStatus(0);
        $em->persist($users);
        $em->flush();
        
        return $this->redirectToRoute('getUsers');
    }

    public function getPDF(Request $request){
        $em = $this->getDoctrine()->getManager();
        $listUsers = $em->getRepository('App:Users')->findBy([], ['name' => 'ASC']);

        ob_start();

        $html = ob_get_clean();
        
        $html = $this->renderView('reports/users.html.twig', [
            'listUsers' => $listUsers,
            'actualDate' => ''
        ]);

        $html2pdf = new Html2Pdf('P', 'LETTER', 'fr', true, 'UTF-8', array('10', '10', '10', '10'));
        $html2pdf->pdf->SetDisplayMode('real');
        $html2pdf->setDefaultFont('helvetica');
        $html2pdf->writeHTML($html);

        $cadena = 'Users.pdf';
        $originales = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿŔŕ';
        $modificadas = 'aaaaaaaceeeeiiiidnoooooouuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr';

        $cadena = utf8_decode($cadena);
        $cadena = strtr($cadena, utf8_decode($originales), $modificadas);
        $cadena = strtoupper($cadena);

        ob_end_clean();

        return new Response($html2pdf->Output(utf8_encode($cadena), 'D'), 200, [
            'Content-Type' => 'application/pdf;charset=UTF-8'
        ]);
    }
}
