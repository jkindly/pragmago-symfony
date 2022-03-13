<?php


namespace App\Controller;


use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;

class UserPermissionController extends AbstractController
{
    #[Route('/user/{id<\d+>}/disable', name: 'app_user_disable')]
    public function disableUser($id, UserRepository $userRepository, EntityManagerInterface $entityManager): Response
    {
        $user = $userRepository->find($id);

        if (!$user) {
            throw new UserNotFoundException(sprintf('User by %d ID not found!', $id));
        }

        $user->addRole('ROLE_DISABLED');

        $this->addFlash(
            'notice',
            sprintf('User %s has been disabled!', $user->getUsername())
        );

        $entityManager->persist($user);
        $entityManager->flush();

        return $this->redirectToRoute('app_home');
    }

    #[Route('/user/{id<\d+>}/enable', name: 'app_user_enable')]
    public function enableUser($id, UserRepository $userRepository, EntityManagerInterface $entityManager): Response
    {
        $user = $userRepository->find($id);

        if (!$user) {
            throw new UserNotFoundException(sprintf('User by %d ID not found!', $id));
        }

        $user->removeRole('ROLE_DISABLED');

        $this->addFlash(
            'notice',
            sprintf('User %s has been enabled!', $user->getUsername())
        );

        $entityManager->persist($user);
        $entityManager->flush();

        return $this->redirectToRoute('app_home');
    }
}