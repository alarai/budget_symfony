<?php

namespace App\Controller;

use App\Entity\Moyen;
use App\Form\MoyenType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PaymentController extends AbstractController  {
    /**
     * @Route("/payment", name="payment")
     */
    public function index() {
        $paymentList = $this->getDoctrine()->getRepository(Moyen::class)->findBy([], ["nom" => "ASC"]);

        return $this->render('payment/payment.html.twig', ["payments" => $paymentList]);
    }

    private function getPayment($id) {
        if($id !== null) {
            $payment = $this->getDoctrine()->getRepository(Moyen::class)->find($id);
            if($payment === null) {
                return $this->redirectToRoute('payment');
            }
        } else {
            $payment = new Moyen();
        }

        return $payment;
    }

    /**
     * @Route("/payment/edit/{id<\d+>}", name="payment_edit", defaults={"id"=null})
     */
    public function edit($id, Request $request) {

        $payment = $this->getPayment($id);

        $form = $this->createForm(MoyenType::class, $payment);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($payment);
            $em->flush();
            $this->addFlash('success', 'Moyen de paiement ' . ($id===null?"ajouté":"mis à jour"));
            return $this->redirectToRoute('payment');
        }

        return $this->render('payment/edit.html.twig', ['form' => $form->createView()]);
    }

}
