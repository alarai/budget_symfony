<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class GraphicsController extends AbstractController {
    /**
     * @Route("/graphics", name="graphics")
     */
    public function index() {

        return $this->render('graphics/graphics.html.twig');
    }

}
