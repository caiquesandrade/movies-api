<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Repository\MovieRepository;
use DateTime;
use DateTimeZone;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/movies", name="movies_")
 */
class MovieController extends AbstractController
{
    /**
     * @Route("/", name="index", methods={"GET"})
     */
    public function index()
    {
        $movies = $this->getDoctrine()->getRepository(Movie::class)->findAll();

        return $this->json([
            'data' => $movies
        ]);


    }

    /**
     * @Route("/", name="create", methods={"POST"})
     */
    public function create(Request $request)
    {
        $data = $request->request->all();
        $movie = new Movie();
        $movie->setName($data['name']);
        $movie->setGender($data['gender']);
        $movie->setWeek($data['week']);
        $movie->setDescription($data['description']);
        $movie->setCreatedAt(new DateTime('now', new DateTimeZone('America/Sao_Paulo')));
        $movie->setUpdatedAt(new DateTime('now', new DateTimeZone('America/Sao_Paulo')));

        $doctrine = $this->getDoctrine()->getManager();
        $doctrine->persist($movie);
        $doctrine->flush();

        return $this->json([
            'data' => 'Movie '. $movie->getName() . ' with id ' . $movie->getId() . ' created !'
        ]);
    }

    /**
     * @Route("/{id}", name="show", methods={"GET"})
     */
    public function show(Movie $movie)
    {
        return $this->json([
            'data' => $movie
        ]);
    }

    /**
     * @Route("/{id}", name="update", methods={"PUT", "PATCH"})
     */
    public function update(Request $request, Movie $movie)
    {
        $data = $request->request->all();
        $movie->setName($data['name']);
        $movie->setGender($data['gender']);
        $movie->setWeek($data['week']);
        $movie->setDescription($data['description']);
        $movie->setUpdatedAt(new DateTime('now', new DateTimeZone('America/Sao_Paulo')));

        $doctrine = $this->getDoctrine()->getManager();
        $doctrine->flush();

        return $this->json([
            'data' => 'Movie '. $movie->getName() . ' with id ' . $movie->getId() . ' updated !'
        ]);
    }

    /**
     * @Route("/{id}", name="delete", methods={"DELETE"})
     */
    public function delete(Request $request, Movie $movie)
    {
        $manager = $this->getDoctrine()->getManager();

        $manager->remove($movie);
        $manager->flush();

        return $this->json([
            'data' => 'Movie deleted !'
        ]);
    }

    /**
     * @Route("/week-movie/{week}", name="week_movie", methods={"GET"})
     */
    public function weekMovie(Request $request)
    {
        $week = $request->get('week');
        $movies = $this->getDoctrine()->getRepository(Movie::class)->findBy(['week' => $week]);

        return $this->json([
            'data' => $movies
        ]);
    }
}
