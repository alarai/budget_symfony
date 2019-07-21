<?php

namespace App\Controller;

use App\Entity\Moyen;
use App\Form\MoyenType;
use App\Repository\MoyenRepository;
use App\Traits\EntityGetter;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PaymentController extends AbstractController  {
    use EntityGetter;

    private $entityManager;

    private $repository;

    public function __construct(EntityManagerInterface $entityManager, MoyenRepository $repository)
    {
        $this->entityManager = $entityManager;
        $this->repository = $repository;
    }

    /**
     * @Route("/payment", name="payment")
     */
    public function index() {
        $paymentList = $this->repository->findBy([], ["nom" => "ASC"]);

        return $this->render('payment/payment.html.twig', ["payments" => $paymentList]);
    }

    /**
     * @Route("/payment/edit/{id<\d+>}", name="payment_edit", defaults={"id"=null})
     */
    public function edit($id, Request $request) {

        $payment = $this->getEntity($id, Moyen::class);

        if($payment === null) {
            return $this->redirectToRoute('payment');
        }

        $form = $this->createForm(MoyenType::class, $payment);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($payment);
            $this->entityManager->flush();
            $this->addFlash('success', 'Moyen de paiement ' . ($id===null?"ajouté":"mis à jour"));
            return $this->redirectToRoute('payment');
        }

        return $this->render('payment/edit.html.twig', ['form' => $form->createView()]);
    }

}
