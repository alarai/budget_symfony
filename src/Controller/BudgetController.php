<?php

namespace App\Controller;

use App\Entity\Categories;
use App\Entity\Courant;
use App\Entity\Moyen;
use App\Form\CurrentType;
use App\Entity\OpRecur;
use App\Repository\CourantRepository;
use App\Traits\EntityGetter;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class BudgetController extends AbstractController
{
    use EntityGetter;

    private $entityManager;

    private $repository;

    public function __construct(EntityManagerInterface $entityManager, CourantRepository $repository)
    {
        $this->entityManager = $entityManager;
        $this->repository = $repository;
    }

    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        return $this->render("current/current.html.twig");
    }

    /**
     * @Route("/current/api/list", name="current_list")
     */
    public function list()
    {
        $data = $this->repository->findAll();

        $response = new JsonResponse([
            "data" => $data
        ]);
        return $response;
    }

    /**
     * @Route("/current/api/listbycat", name="current_listcat")
     */
    public function listByCategory()
    {
        $data = $this->repository->getByCategorie();

        $response = new JsonResponse([
            "id" => 'expenses',
            "name" => 'Dépenses',
            "animation" => false,
            "colorByPoint" => true,
            "data" => $data
        ]);
        return $response;
    }

    /**
     * @Route("/current/edit/{id<\d+>}", name="current_edit", defaults={"id"=null})
     */
    public function edit($id, Request $request)
    {
        $current = $this->getEntity($id, Courant::class);

        if ($current === null) {
            return $this->redirectToRoute('home');
        }

        $form = $this->createForm(CurrentType::class, $current);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($current);
            $this->entityManager->flush();
            $this->addFlash('success', 'Opération ' . ($id===null?"ajoutée":"mise à jour"));
            return $this->redirectToRoute('home');
        }

        return $this->render('current/edit.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/current/api/remove/{id<\d+>}", name="current_remove", defaults={"id"=-1})
     */
    public function remove($id)
    {
        $item = $this->repository->find($id);
        if ($item != null) {
            $this->entityManager->remove($item);
            $this->entityManager->flush();
        }

        return new JsonResponse([
            "status" => $item!=null,
        ]);
    }

    /**
     * @Route("/current/api/status/{id<\d+>}/{state<\d+>}", name="current_status", defaults={"id"=-1, "state"=-1})
     */
    public function status($id, $state)
    {
        $item = $this->repository->find($id);
        if ($item != null) {
            $item->setSurcompte($state==="1");
            $this->entityManager->persist($item);
            $this->entityManager->flush();
        }

        return new JsonResponse([
            "status" => $item!=null,
        ]);
    }

    /**
     * @Route("/current/api/addrecur/{id<\d+>}", name="current_addrecur", defaults={"id"=-1})
     */
    public function addRecuringOperation($id)
    {
        $opRecur = $this->getDoctrine()->getRepository(OpRecur::class)->find($id);
        if ($opRecur == null) {
            return new JsonResponse(["status" => false, "message" => "Recuring Not found"]);
        }

        $itemExist = $this->repository->findBy(["opRecur" => $id]);
        if ($itemExist) {
            return new JsonResponse(["status" => false, "message" => "Recuring already added"]);
        }

        $operation = new Courant();
        $operation->setNom($opRecur->getNom());
        $operation->setSurcompte(true);
        $operation->setCategorie($opRecur->getCategorie());
        $operation->setMoyen($opRecur->getMoyen());
        $operation->setValeur($opRecur->getValeur());
        $operation->setOpRecur($opRecur);

        $this->entityManager->persist($operation);
        $this->entityManager->flush();


        return new JsonResponse(["status" => true]);
    }

    /**
     * @Route("/current/api/totals", name="current_total")
     */
    public function apiTotals()
    {
        $remainingTotal = $this->repository->getRemainingTotal();
        $remainingDone = $this->repository->getRemainingPassed();
        $remainingRecuring = $this->getDoctrine()->getRepository(OpRecur::class)->getNotUsedTotal();

        return new JSonResponse([
            "total" => $remainingTotal["valeur"],
            "done" => $remainingDone["valeur"],
            "recuring" => $remainingRecuring["valeur"],
        ]);
    }
    /**
     * @Route("/current/api/historize/{year<\d+>}/{month<\d+>}", name="current_historize", defaults={"month"=-1, "year"=-1})
     */
    public function historize($year, $month)
    {
        if (!preg_match('/^20[0-9]{2}$/', $year) || !preg_match('/^1[0-2]$|^0?[1-9]$/', $month)) {
            return new JsonResponse(["status" => false]);
            ;
        }

        $remain = $this->repository->getRemainingPassed()["valeur"];

        $this->repository->historizeData($month, $year);
        $this->repository->removeAllPassedOperations();

        $moyen = $this->getDoctrine()->getRepository(Moyen::class)->find(5);
        $categorie = $this->getDoctrine()->getRepository(Categories::class)->find(27);



        $courant = new Courant();
        $courant->setValeur($remain);
        $courant->setMoyen($moyen);
        $courant->setCategorie($categorie);
        $courant->setSurcompte(true);
        $courant->setNom("Reste mois - 1");

        $this->entityManager->persist($courant);
        $this->entityManager->flush();

        return new JsonResponse(["status" => true]);
        ;
    }
}
