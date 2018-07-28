<?php

namespace AppBundle\Controller;

use AppBundle\Form\ArticleType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use AppBundle\Entity\Article;
use Symfony\Component\VarDumper\VarDumper;

/**
 * Class ArticleController
 * @package AppBundle\Controller
 *
 * @Route("/articles")
 */
class ArticleController extends Controller
{
    /**
     * @Route("/")
     *
     * @return Response
     *
     * L'envoi de EntityManagerInterface $entityManager comme param: permet de se lier à la BDsans avoir besoin de l'instancier=> avantage depuis symf 3.4 (ne marche pas sur version anciennes)
     */
    public function indexAction(EntityManagerInterface $entityManager)
    {
        $articles=$entityManager->getRepository( Article::class )->findAll();

        return $this->render( 'article/index.html.twig', array(
            'articles'=>$articles
        ));
    }

    /**
     * @Route("/{id}", requirements={"id"="\d+"})
     *
     * @return Response
     */
    public function showAction($id, EntityManagerInterface $entityManager)
    {
        $article=$entityManager->getRepository( Article::class )->find($id);
        $articles=$entityManager->getRepository( Article::class )->findAll();

        $article_len=count($articles);
        $suiv=($id==$article_len) ? null : $id+1;
        $prec=($id==1) ? null : $id-1;


        return $this->render( 'article/show.html.twig', array(
            'article'=>$article,
            'prec'=>$prec,
            'suiv'=>$suiv
        ));
    }

    /**
     * @Route("/new")
     *
     * @return Response
     */
    public function newAction(Request $request, EntityManagerInterface $entityManager)
    {
        $article = new Article();

        $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            $entityManager->persist($article);
            $entityManager->flush();

            return $this->redirectToRoute('app_article_index');
        }

        return $this->render( 'article/new.html.twig', array(
            'new_form'  => $form->createView()
        ));
    }

    /**
     * @Route("/edit/{id}")
     *
     * @return Response
     */
    public function editAction(EntityManagerInterface $entityManager, $id)
    {
        $old=$entityManager->getRepository(Article::class)->find($id);
        $old->setTitle($old->getTitle().' modifié');
        $old->setContent($old->getTitle().' modifié');
        $entityManager->persist($old);
        $entityManager->flush();
        return $this->render( 'article/edit.html.twig', array(
            'article'=>$old));
    }

    /**
     * @Route("/delete/{id}")
     *
     * @return Response
     */
    public function deleteAction(EntityManagerInterface $entityManager, $id)
    {
        $article=$entityManager->getRepository(Article::class)->find($id);
        $entityManager->remove($article);
        $entityManager->flush();
        return $this->redirect($this->generateUrl("app_article_index"));
    }
}
