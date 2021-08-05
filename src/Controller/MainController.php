<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController{

    public function index(): Response{
        return $this->json([
            'message' => 'Hola mundo',
            'path' => 'src/Controller/MainController.php',
        ]);
    }
}