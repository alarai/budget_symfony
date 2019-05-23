<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController {
    /**
     * @Route("/category")
     */
    public function index() {

        return new Response('<html><body>category list</body></html>');
    }

    /**
     * @Route("/category/add")
     */
    public function add() {
        return new Response('<html><body>category add</body></html>');
    }

    /**
     * @Route("/category/edit/{id<\d+>}")
     */
    public function edit($id) {
        return new Response('<html><body>category edit ' . $id . '</body></html>');
    }

}
