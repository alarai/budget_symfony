<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RecuringController {
    /**
     * @Route("/recuring")
     */
    public function index() {

        return new Response('<html><body>Recuring list</body></html>');
    }

    /**
     * @Route("/recuring/add")
     */
    public function add() {
        return new Response('<html><body>Recuring add</body></html>');
    }

    /**
     * @Route("/recuring/edit/{id<\d+>}")
     */
    public function edit($id) {
        return new Response('<html><body>Recuring edit ' . $id . '</body></html>');
    }

}
