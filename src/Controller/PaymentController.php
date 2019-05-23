<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PaymentController {
    /**
     * @Route("/payment")
     */
    public function index() {

        return new Response('<html><body>Payment list</body></html>');
    }

    /**
     * @Route("/payment/add")
     */
    public function add() {
        return new Response('<html><body>Payment add</body></html>');
    }

    /**
     * @Route("/payment/edit/{id<\d+>}")
     */
    public function edit($id) {
        return new Response('<html><body>Payment edit ' . $id . '</body></html>');
    }

}
