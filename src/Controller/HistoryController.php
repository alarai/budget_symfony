<?php

namespace App\Controller;

use App\Entity\Historique;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class HistoryController extends AbstractController {
    /**
     * @Route("/history/{year<\d+>}/{month<\d+>}", name="history", defaults={"year"=-1, "month"=-1})
     */
    public function index($year, $month) {
        if($year === -1) { $year = date('Y'); }
        if($month === -1) { $month = date('m'); }


        return $this->render("history/history.html.twig", [
            'annee' => $year,
            'mois'  => $month,
            'liste' => $this->getDoctrine()->getRepository(Historique::class)->getMonthList(),
        ]);
    }

    /**
     * @Route("/history/api/list/{year<\d+>}/{month<\d+>}", name="history_list", defaults={"year"=-1, "month"=-1})
     */
    public function list($year, $month) {
        $data = $this->getDoctrine()->getRepository(Historique::class)->findBy(['mois' => $month, 'annee' => $year]);

        $response = new JsonResponse([
            "data" => $data
        ]);
        return $response;
    }

    /**
     * @Route("/history/api/listbycat/{year<\d+>}/{month<\d+>}", name="history_listcat", defaults={"year"=-1, "month"=-1})
     */
    public function listByCategory($year, $month) {

        $data = $this->getDoctrine()->getRepository(Historique::class)->getMonthListByCat($year, $month);

        $response = new JsonResponse([
            "id" => 'expenses',
            "name" => 'Dépenses',
            "animation" => false,
            "colorByPoint" => true,
            "data" => $data
        ]);
        return $response;
    }

}

