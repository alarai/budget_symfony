<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HistoryController extends AbstractController {
    /**
     * @Route("/history", name="history")
     */
    public function index() {

        return $this->render("history/history.html.twig");
    }

    /**
     * @Route("/history/api/list/{year<\d+>}/{month<\d+>}", name="history_list")
     */
    public function list($year, $month) {
        return new Response('<html><body>history data' . $year . '/'. $month . '</body></html>');
    }

    /**
     * @Route("/history/api/listbycat/{year<\d+>}/{month<\d+>}", name="history_listcat")
     */
    public function listByCategory($year, $month) {
        return new Response('<html><body>history data category' . $year . '/'. $month . '</body></html>');
    }

}

