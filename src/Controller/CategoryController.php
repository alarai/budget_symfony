<?php

namespace App\Controller;

use App\Entity\Categories;
use App\Form\CategoriesType;
use App\Repository\CategoriesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Traits\EntityGetter;

class CategoryController extends AbstractController
{
    use EntityGetter;

    private $entityManager;

    private $repository;

    public function __construct(EntityManagerInterface $entityManager, CategoriesRepository $repository)
    {
        $this->entityManager = $entityManager;
        $this->repository = $repository;
    }

    /**
     * @Route("/category", name="category")
     */
    public function index()
    {
        $categories = $this->repository->findBy([], ['nom' => 'ASC']);

        return $this->render("category/category.html.twig", ['categories' => $categories]);
    }

    /**
     * @Route("/category/edit/{id<\d+>}", name="category_edit", defaults={"id"=null})
     */
    public function edit($id, Request $request)
    {
        $category = $this->getEntity($id, Categories::class);

        if ($category === null) {
            return $this->redirectToRoute('category');
        }

        $form = $this->createForm(CategoriesType::class, $category);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($category);
            $this->entityManager->flush();
            $this->addFlash('success', 'Catégorie ' . ($id===null?"ajouté":"mis à jour"));
            return $this->redirectToRoute('category');
        }

        return $this->render('category/edit.html.twig', ['form' => $form->createView()]);
    }
}
