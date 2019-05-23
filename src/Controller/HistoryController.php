<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HistoryController {
    /**
     * @Route("/history")
     */
    public function index() {

        return new Response('<html><body>history list</body></html>');
    }

    /**
     * @Route("/history/api/list/{year<\d+>}/{month<\d+>}")
     */
    public function list($year, $month) {
        return new Response('<html><body>history data' . $year . '/'. $month . '</body></html>');
    }

    /**
     * @Route("/history/api/listbycat/{year<\d+>}/{month<\d+>}")
     */
    public function listByCategory($year, $month) {
        return new Response('<html><body>history data category' . $year . '/'. $month . '</body></html>');
    }

}

