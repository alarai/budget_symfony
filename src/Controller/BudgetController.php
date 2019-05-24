<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BudgetController extends AbstractController {
    /**
     * @Route("/", name="home")
     */
    public function index() {

        return $this->render("current/current.html.twig");
    }

    /**
     * @Route("/current/api/list", name="current_list")
     */
    public function list() {
        return new Response('<html><body>courant data</body></html>');
    }

    /**
     * @Route("/current/api/listbycat", name="current_listcat")
     */
    public function listByCategory() {
        return new Response('<html><body>courant data category</body></html>');
    }

}

