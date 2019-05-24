<?php

namespace App\Controller;

use App\Entity\Categories;
use App\Form\CategoriesType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController {
    /**
     * @Route("/category", name="category")
     */
    public function index() {

        $categories = $this->getDoctrine()->getRepository(Categories::class)->findBy([], ['nom' => 'ASC']);

        return $this->render("category/category.html.twig", ['categories' => $categories]);
    }

    private function getCategory($id) {
        if($id !== null) {
            $category = $this->getDoctrine()->getRepository(Categories::class)->find($id);
            if($category === null) {
                return $this->redirectToRoute('category');
            }
        } else {
            $category = new Categories();
        }

        return $category;
    }

    /**
     * @Route("/category/edit/{id<\d+>}", name="category_edit", defaults={"id"=null})
     */
    public function edit($id, Request $request) {
        $category = $this->getCategory($id);

        $form = $this->createForm(CategoriesType::class, $category);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();
            $this->addFlash('success', 'Catégorie ' . ($id===null?"ajouté":"mis à jour"));
            return $this->redirectToRoute('category');
        }

        return $this->render('category/edit.html.twig', ['form' => $form->createView()]);
    }

}
