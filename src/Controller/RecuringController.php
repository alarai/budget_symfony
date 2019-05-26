<?php

namespace App\Controller;

use App\Entity\OpRecur;
use App\Form\RecuringType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class RecuringController extends AbstractController {
    /**
     * @Route("/recuring", name="recuring")
     */
    public function index() {

        $recuringOps = $this->getDoctrine()->getRepository(OpRecur::class)->findBy([], ["nom" => 'ASC']);

        return $this->render("recuring/recuring.html.twig", ["ops" => $recuringOps]);
    }

    private function getRecuring($id) {
        if($id !== null) {
            $recuring = $this->getDoctrine()->getRepository(OpRecur::class)->find($id);
            if($recuring === null) {
                return $this->redirectToRoute('recuring');
            }
        } else {
            $recuring = new OpRecur();
        }

        return $recuring;
    }

    /**
     * @Route("/recuring/edit/{id<\d+>}", name="recuring_edit", defaults={"id"=null})
     */
    public function edit($id, Request $request) {
        $recuring = $this->getRecuring($id);

        $form = $this->createForm(RecuringType::class, $recuring);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($recuring);
            $em->flush();
            $this->addFlash('success', 'Opération récurrente ' . ($id===null?"ajoutée":"mise à jour"));
            return $this->redirectToRoute('recuring');
        }

        return $this->render('recuring/edit.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/recuring/api/listnotused", name="recuring_notused")
     */
    public function listNotUsedOperations() {
        $opRecurList = $this->getDoctrine()->getRepository(OpRecur::class)->getNotUsedInCourant();

        return new JsonResponse(
            ["data" => $opRecurList]
        );
    }

}
