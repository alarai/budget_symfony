<?php

namespace App\Controller;

use App\Entity\Historique;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class GraphicsController extends AbstractController {
    /**
     * @Route("/graphics", name="graphics")
     */
    public function index() {

        $data = $this->getDoctrine()->getRepository(Historique::class)->chartHistoryData(2016);

        return $this->render('graphics/graphics.html.twig', ['data' => $data]);
    }

}
