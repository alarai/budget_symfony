<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BudgetController {
    /**
     * @Route("/")
     */
    public function index() {

        return new Response('<html><body>courant list</body></html>');
    }

    /**
     * @Route("/current/api/list")
     */
    public function list() {
        return new Response('<html><body>courant data</body></html>');
    }

    /**
     * @Route("/current/api/listbycat")
     */
    public function listByCategory() {
        return new Response('<html><body>courant data category</body></html>');
    }

}

