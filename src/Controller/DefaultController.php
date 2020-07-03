<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/api/demo")
     */
    public function demo()
    {
        $user = $this->getUser();

        if ($user instanceof User) {
            $user = $user->getEmail();
        }

        return new JsonResponse([
            'user' => $user,
        ]);
    }
}
