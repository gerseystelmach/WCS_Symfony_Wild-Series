<?php

namespace App\Controller;

use App\Repository\ActorRepository;
use App\Repository\ProgramRepository;
use App\Entity\Actor;
use App\Entity\Program;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 *  @Route("/actor", name="actor_")
 */

class ActorController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(ActorRepository $actorRepository): Response
    {
        return $this->render('actor/index.html.twig', [
            'actors' => $actorRepository->findAll(),
        ]);
    }

    /**
     * @Route("/{id}", name="show", methods={"GET"})
     */
     public function show(Actor $actor): Response
    {
        
        return $this->render('actor/show.html.twig', [
            'actor' => $actor,
        ]);
    }
}
