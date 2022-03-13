<?php


namespace App\Controller;


use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/{page<\d+>}', name: 'app_home', defaults: ['page' => 1])]
    public function index(UserRepository $userRepository, $page): Response
    {
        $pageNumber = intval($page);
        $resultsPerPage = 10;

        $userCount = count($userRepository->findAll());
        $users = $userRepository->findUsersByPageNumber($pageNumber, $resultsPerPage);

        return $this->render('homepage/index.html.twig', [
            'users' => $users,
            'user_count' => $userCount,
            'results_per_page' => $resultsPerPage,
        ]);
    }
}