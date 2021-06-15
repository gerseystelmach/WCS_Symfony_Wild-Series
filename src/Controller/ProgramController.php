<?php

namespace App\Controller;



use App\Entity\Program;
use App\Entity\Season;
use App\Entity\Episode;
use Symfony\Component\Mime\Email;
use App\Form\ProgramType;
use Symfony\Component\Mailer\MailerInterface;
use App\Service\Slugify;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;



/**
 *  @Route("/programs", name="program_")
 */

class ProgramController extends AbstractController
{
    /**
     * Show all rows from Program’s entity
     *
     * @Route("/", name="index")
     * @return Response 
     */
    public function index(): Response
    {
        $programs = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findAll();

        return $this->render(
            'program/index.html.twig',
            ['programs' => $programs]
        );
    }

     /**
     * The controller for the program add form
     *
     * @Route("/new", name="new")
     */

    public function new(Request $request, EntityManagerInterface $entityManager, Slugify $slugify, MailerInterface $mailer) : Response

    {
      
        // Create a new program Object
        $program = new program();
        // Create the associated Form
        $form = $this->createForm(ProgramType::class, $program);
         // Get data from HTTP request
        $form->handleRequest($request);
        // Was the form submitted ?
        if ($form->isSubmitted() && $form->isValid()) 
        {
        // Deal with the submitted data
        // Get the Entity Manager
        $entityManager = $this->getDoctrine()->getManager();
      
        $slug = $slugify->generateSlug($program->getTitle());
        $program->setSlug($slug);
         // Persist Category Object
        $entityManager->persist($program);
        // Flush the persisted object
        $entityManager->flush();

        $email = (new Email())
                ->from($this->getParameter('mailer_from'))
                ->to('gerseystelmach@gmail.com')
                ->subject('Une nouvelle série vient d\'être publiée !')
                ->html($this->renderView('Program/newProgramEmail.html.twig', ['program' => $program]));
                $mailer->send($email);
        // Finally redirect to categories list
        return $this->redirectToRoute('program_index');
        }

        
               // Render the form
        return $this->render('program/new.html.twig', [
            "form" => $form->createView(),
        ]);

    }

    /**
     * @Route("/{program_slug}", name="show")
     * @ParamConverter("program", class="App\Entity\Program", options={"mapping": {"program_slug": "slug"}})
     * @return Response
     */

    public function show(Program $program): Response
    {
       
        $seasons = $this->getDoctrine()
            ->getRepository(Season::class)
            ->findBy([
                'program' => $program,
            ]);


        if (!$program) {
            throw $this->createNotFoundException(
                'No program with : ' . $program . ' found in program\'s table.'
            );
        }
        
        return $this->render('program/show.html.twig', [
            'program' => $program,
            'seasons' => $seasons,
                    ]);
    }

    /**
     * @Route("/{program_slug}/seasons/{season_id}", name="season_show", methods={"GET"})
     * * @ParamConverter("program", class="App\Entity\Program", options={"mapping": {"program_slug": "slug"}})
     * * @ParamConverter("season", class="App\Entity\Season", options={"mapping": {"season_id": "id"}})
     * @return Response
     */

    public function showSeason(Program $program, Season $season): Response
    {
      
        $episodes = $this->getDoctrine()
            ->getRepository(Episode::class)
            ->findBy([
                'season' => $season,
            ]);

        if (!$program) {
            throw $this->createNotFoundException(
                'No program with id : ' . $program . ' found in program\'s table.'
            );
        }

        if (!$season) {
            throw $this->createNotFoundException(
                'No program with id : ' . $season . ' found in seasons\'s table.'
            );
        }

        return $this->render('program/season_show.html.twig', ['program' => $program, 'season' => $season, 'episodes' => $episodes]);
    }

    /**
     * @Route("/{program_slug}/seasons/{season_id}/episodes/{episode_slug}", name="episode_show", methods={"GET"})
     * @ParamConverter("program", class="App\Entity\Program", options={"mapping": {"program_slug": "slug"}})
     * @ParamConverter("season", class="App\Entity\Season", options={"mapping": {"season_id": "id"}})
     * @ParamConverter("episode", class="App\Entity\Episode", options={"mapping": {"episode_slug": "slug"}})
     * @return Response
     */

    public function showEpisode(Program $program, Season $season, Episode $episode): Response
    {
         
        return $this->render('program/episode_show.html.twig', ['program' => $program, 'season' => $season, 'episode' => $episode]);
    }
}
