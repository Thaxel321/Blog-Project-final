<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\AdminUserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig'
        );
    }

    /**
     * @Route("/admin/listUser", name="liste_user")
     */
    public function list(UserRepository $repo){
        $users = $repo->findAll();


        return $this->render('admin/listUser.html.twig', [
            'users' => $users,
        ]);
    }

    /**
     * @Route("admin/user/edit/{id}", name="admin_edit_user")
     */
    public function formUser(Request $request, User $user, EntityManagerInterface $manager){
        $form = $this->createForm(AdminUserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $article = $form->getData();

            $manager->persist($article);
            $manager->flush();

            return $this->redirectToRoute('liste_user');
        }
        return $this->renderForm('admin/editUser.html.twig',[
            'formUser' => $form,
        ]);
    }
}
