<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GraphicsController {
    /**
     * @Route("/graphics")
     */
    public function index() {

        return new Response('<html><body>category list</body></html>');
    }

}
