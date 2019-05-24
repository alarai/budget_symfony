<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RecuringController extends AbstractController {
    /**
     * @Route("/recuring", name="recuring")
     */
    public function index() {

        return $this->render("recuring/recuring.html.twig");
    }

    /**
     * @Route("/recuring/edit/{id<\d+>}", name="recuring_edit", defaults={"id"=null})
     */
    public function edit($id) {
        return new Response('<html><body>Recuring edit ' . $id . '</body></html>');
    }

}
