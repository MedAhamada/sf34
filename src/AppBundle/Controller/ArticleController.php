<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Article;
use AppBundle\Manager\ArticleManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\VarDumper\VarDumper;

class ArticleController extends Controller
{
    /**
     * @Route("/articles")
     */
    public function indexAction(EntityManagerInterface $entityManager)
    {
        // Valable pour la version 2 de Symfony.
        //
        // $entityManager = $this->getDoctrine()->getManager();
        //

        $articles = $entityManager->getRepository(Article::class)->findAll();

        return $this->render('article/index.html.twig', array(
            "articles"=>$articles
        ));
    }

    /**
     * @Route("/articles/{id}", requirements={"id"="\d+"})
     */
    public function showAction($id, EntityManagerInterface $entityManager, ArticleManager $articleManager)
    {

        $article = $entityManager->getRepository(Article::class)->find($id);

        $article = $articleManager->updateArticle($article);

        VarDumper::dump($article);

        $articles = [
            [
                'id'    => 1,
                'title' => 'Titre 1',
                'content'   => 'Exemple de contenu 1'
            ],
            [
                'id'    => 2,
                'title' => 'Titre 2',
                'content'   => 'Exemple de contenu 1'
            ],
            [
                'id'    => 3,
                'title' => 'Titre 3',
                'content'   => 'Exemple de contenu 1'
            ],
            [
                'id'    => 4,
                'title' => 'Titre 4',
                'content'   => 'Exemple de contenu 1'
            ],
            [
                'id'    => 5,
                'title' => 'Titre 5',
                'content'   => 'Exemple de contenu 1'
            ],
            [
                'id'    => 6,
                'title' => 'Titre 6',
                'content'   => 'Exemple de contenu 1'
            ],
            [
                'id'    => 7,
                'title' => 'Titre 7',
                'content'   => 'Exemple de contenu 1'
            ],
            [
                'id'    => 8,
                'title' => 'Titre 8',
                'content'   => 'Exemple de contenu 1'
            ],
            [
                'id'    => 9,
                'title' => 'Titre 9',
                'content'   => 'Exemple de contenu 1'
            ],
            [
                'id'    => 10,
                'title' => 'Titre 10',
                'content'   => 'Exemple de contenu 1'
            ],
        ];

        $min =0;
        $max=0;

        $index=array_search($id, array_column($articles, 'id'))+1;

        $suiv=($index==10) ? null : $index+1;
        $prec=($index==1) ? null : $index-1;
        return $this->render('article/show.html.twig', array(
            'articles'=>$articles,
            'index'=>$index,
            'prec'=>$prec,
            'suiv'=>$suiv

        ));
    }

    /**
     * @Route("/articles/new")
     */
    public function newAction(Request $request, ArticleManager $articleManager)
    {
        $article = $articleManager->createArticle();

        return $this->render('article/new.html.twig', array(
            'article'   => $article
        ));
    }
    /**
     * @Route("/articles/{id}/delete")
     */
    public function deleteAction($id, ArticleManager $articleManager)
    {
        $articleManager->deleteArticle($id);

        return $this->redirect($this->generateUrl('app_article_index'));
    }

}
