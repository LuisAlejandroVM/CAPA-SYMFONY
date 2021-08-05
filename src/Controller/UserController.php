<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController{

    public function getUsers(): Response{
        return $this->json([
            'message' => 'Listado de Usuarios',
            'path' => 'src/Controller/UserController.php',
        ]);
    }
}
