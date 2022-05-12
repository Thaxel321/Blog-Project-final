<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleFormType;
use App\Repository\ArticleRepository;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{

    /**
     * @Route("/", name="home")
     */

    public function index() : Response{

        return $this->render('blog/index.html.twig'
        );
    }

    /**
     * @Route("/articles", name="articles")
     */

    public function liste_articles(ArticleRepository $repo){
        $articles = $repo->findAll();

        return $this->render('blog/articles.html.twig', [
            'articles' => $articles,
        ]);
    }

    /**
     * @Route("/article/new", name="addArticle")
     * @Route("/article/edit/{id}", name= "article_edit")
     *
     */
    public function formArticle(Article $article = null, Request $request, EntityManagerInterface $manager,
                                FileUploader $fileUploader){

        date_default_timezone_set('Europe/Paris');
        if (!$article) {
            $article = new Article();
            $article->setCreateAt(new \DateTime());
        }

        $form = $this->createForm(ArticleFormType::class, $article);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $article = $form->getData();

            $articleFile = $form->get('image')->getData();
            if ($articleFile) {
                $articleFileName = $fileUploader->upload($articleFile);
                $article->setImage($articleFileName);
            }

            $manager->persist($article);
            $manager->flush();

            return $this->redirectToRoute('articles');
        }
        return $this->renderForm('blog/addArticle.html.twig',[
            'form' => $form,
        ]);

    }

    /**
     * @Route("/article/{id}", name="anArticle")
     */
    public function anArticle($id, ArticleRepository $repo){
        $article = $repo->find($id);
        return $this->render('blog/anArticle.html.twig', [
            'article' => $article,
        ]);
    }

    /**
     * @Route("/article/remove/{id}", name="article_delete")
     */
    public function remove_article(Article $article, EntityManagerInterface $entityManager) {
        $entityManager->remove($article);
        $entityManager->flush();

        return $this->redirectToRoute('articles');
    }

}
