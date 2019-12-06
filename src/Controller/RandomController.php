<?php

namespace App\Controller;

use App\Entity\Random;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class RandomController extends AbstractController
{
    /**
     * @Route("/random", name="random")
     */
    public function index()
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/RandomController.php',
        ]);
    }

    /**
     * @Route("/generate", name="generate")
     */
    public function showGenerate()
    {
        $entityManager = $this->getDoctrine()->getManager();

        $randomInt = random_int(-2147483648, 2147483647);

        $random = new Random();
        $random->setNumber($randomInt);

        $entityManager->persist($random);
        $entityManager->flush();

        return $this->json([
            'id' => $random->getId(),
            'number' => $randomInt
        ]);
    }

    /**
     * @Route("/retrieve/{id}", name="retrieve")
     */
    public function showRetrieve(int $id) {
        $random = $this->getDoctrine()
            ->getRepository(Random::class)
            ->find($id);

        if (!$random) {
            return $this->json([
                'error' => 'No random number found by id ' . $id
            ]);
        }

        return $this->json([
            'id' => $id,
            'number' => $random->getNumber()
        ]);
    }
}
