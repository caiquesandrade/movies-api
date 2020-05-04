<?php

namespace App\Controller;

use Exception;
use App\Entity\Movie;
use App\Repository\MovieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @Route("api/movies", name="movies_")
 */
class MovieController extends AbstractController
{    
    /**
     * @Route("/", name="index", methods={"GET"})
     */
    public function index()
    {
        try {
            $movies = $this->getDoctrine()->getRepository(Movie::class)->findAll();
    
            return $this->json([
                'data' => $movies,
                'code' => Response::HTTP_OK
            ]);

        } catch (Exception $e) {
            return $this->json([
                'data' => $e->getMessage(),
                'code' => $e->getCode()
            ]);
        }
    }

    /**
     * @Route("/", name="create", methods={"POST"})
     */
    public function create(Request $request, ValidatorInterface $validator)
    {
        try {
            $movie = new Movie;
            $movie = MovieRepository::saveOrUpdateMovie($request, $movie);
            $errors = $validator->validate($movie);
            if (count($errors) > 0) {
                foreach ($errors as $error) {
                    $data[] = [
                        'message' => $error->getMessage(), 
                        'value' => $error->getPropertyPath()
                    ];
                }
                return $this->json([
                    'data' => $data,
                    'code' => Response::HTTP_BAD_REQUEST
                ]);
            }
            $doctrine = $this->getDoctrine()->getManager();
            $doctrine->persist($movie);
            $doctrine->flush();
    
            return $this->json([
                'data' => $movie,
                'code' => Response::HTTP_CREATED
            ]);

        } catch (Exception $e) {
            return $this->json([
                'data' => $e->getMessage(),
                'code' => $e->getCode()
            ]);
        }
    }

    /**
     * @Route("/{id}", name="show", methods={"GET"})
     */
    public function show(Movie $movie)
    {
        try {

            return $this->json([
                'data' => $movie,
                'code' => Response::HTTP_OK
            ]);

        } catch (Exception $e) {
            return $this->json([
                'data' => $e->getMessage(),
                'code' => $e->getCode()
            ]);
        }
    
        
    }

    /**
     * @Route("/{id}", name="update", methods={"PUT", "PATCH"})
     */
    public function update(Request $request, Movie $movie, ValidatorInterface $validator)
    {
        try {
            $movie = MovieRepository::saveOrUpdateMovie($request, $movie);
            $errors = $validator->validate($movie);
            if (count($errors) > 0) {
                foreach ($errors as $error) {
                    $data[] = [
                        'message' => $error->getMessage(), 
                        'value' => $error->getPropertyPath()
                    ];
                }
                return $this->json([
                    'data' => $data,
                    'code' => Response::HTTP_BAD_REQUEST
                ]);
            }
            $doctrine = $this->getDoctrine()->getManager();
            $doctrine->flush();
    
            return $this->json([
                'data' => $movie,
                'code' => Response::HTTP_OK
            ]);

        } catch (Exception $e) {
            return $this->json([
                'data' => $e->getMessage(),
                'code' => $e->getCode()
            ]);
        }
    }

    /**
     * @Route("/{id}", name="delete", methods={"DELETE"})
     */
    public function delete(Request $request, Movie $movie)
    {
        try {
            $manager = $this->getDoctrine()->getManager();

            $manager->remove($movie);
            $manager->flush();
    
            return $this->json([
                'data' => $movie,
                'code' => Response::HTTP_NO_CONTENT
            ]);

        } catch (Exception $e) {
            return $this->json([
                'data' => $e->getMessage(),
                'code' => $e->getCode()
            ]);
        }
    }

    /**
     * @Route("/week-movie/{week}", name="week_movie", methods={"GET"})
     */
    public function weekMovie(Request $request)
    {
        try {
            $week = $request->get('week');
            $movies = $this->getDoctrine()->getRepository(Movie::class)->findBy(['week' => $week]);
    
            return $this->json([
                'data' => $movies,
                'code' => Response::HTTP_OK
            ]);
            
        } catch (Exception $e) {
            return $this->json([
                'data' => $e->getMessage(),
                'code' => $e->getCode()
            ]);
        }
    }
}
