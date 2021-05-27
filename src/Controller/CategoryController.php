<?php

namespace App\Controller;


use App\Entity\Category;
use App\Entity\Program;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;



/**
 *  @Route("/categories", name="category_")
 */

class CategoryController extends AbstractController
{

    /**
     *
     * @Route("/", name="index")
     * @return Response 
     */

    public function index(): Response
    {
        $categories = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findAll();

        return $this->render(
            'category/index.html.twig',
            ['categories' => $categories]
        );
    }

    /**
     * @Route("/{categoryName}", name="show")
     */

     public function show(string $categoryName): Response 
     {
        $category = $this->getDoctrine()
        ->getRepository(Category::class)
        ->findOneBy(['name' => $categoryName]);

        if(!$category) {
             throw $this->createNotFoundException(
                'No category with name : '.$categoryName.'was found in category\'s table.'
            );
        }

        $programs = $this->getDoctrine()
        ->getRepository(Program::class)
        ->findBy([
                 'category' => $category->getId()],
                ['id' => 'DESC'],3);
        return $this->render('category/show.html.twig', ['name' => $categoryName, 'programs' => $programs]);
     }
}
