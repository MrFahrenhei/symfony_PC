<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OlaMundoController
{
    /**
     * @Route("/hello")
     */

    public function HelloWorld(Request $request): Response{
        $pathInfo = $request->getPathInfo();
        $theQuery = $request->query->all();
        return new JsonResponse([
            'mensagem' => 'Hello World',
            'pathInfo' => $pathInfo,
            'query' => $theQuery
        ]);
    }
}