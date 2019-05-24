<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController {
    /**
     * @Route("/category", name="category")
     */
    public function index() {

        return $this->render("category/category.html.twig");
    }

    /**
     * @Route("/category/edit/{id<\d+>}", name="category_edit", defaults={"id"=null})
     */
    public function edit($id) {
        return new Response('<html><body>category edit ' . $id . '</body></html>');
    }

}
