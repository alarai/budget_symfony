<?php

namespace App\Controller;

use App\Entity\OpRecur;
use App\Form\RecuringType;
use App\Repository\OpRecurRepository;
use App\Traits\EntityGetter;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class RecuringController extends AbstractController {
    use EntityGetter;

    private $entityManager;

    private $repository;

    public function __construct(EntityManagerInterface $entityManager, OpRecurRepository $repository)
    {
        $this->entityManager = $entityManager;
        $this->repository = $repository;
    }

    /**
     * @Route("/recuring", name="recuring")
     */
    public function index() {

        $recuringOps = $this->repository->findBy([], ["nom" => 'ASC']);

        return $this->render("recuring/recuring.html.twig", ["ops" => $recuringOps]);
    }

    /**
     * @Route("/recuring/edit/{id<\d+>}", name="recuring_edit", defaults={"id"=null})
     */
    public function edit($id, Request $request) {
        $recuring = $this->getEntity($id, OpRecur::class);

        if($recuring === null) {
            return $this->redirectToRoute('recuring');
        }

        $form = $this->createForm(RecuringType::class, $recuring);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($recuring);
            $this->entityManager->flush();
            $this->addFlash('success', 'Opération récurrente ' . ($id===null?"ajoutée":"mise à jour"));
            return $this->redirectToRoute('recuring');
        }

        return $this->render('recuring/edit.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/recuring/api/listnotused", name="recuring_notused")
     */
    public function listNotUsedOperations() {
        $opRecurList = $this->repository->getNotUsedInCourant();

        return new JsonResponse(
            ["data" => $opRecurList]
        );
    }

}
