<?php
/**
 * Created by PhpStorm.
 * User: Ahamada
 * Date: 21/07/2018
 * Time: 15:25
 */

namespace AppBundle\Manager;


use AppBundle\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;

class ArticleManager
{
    /** @var EntityManagerInterface */
    private $entityManager;

    /**
     * ArticleManager constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function createArticle()
    {
        $article = new Article();
        $article->setTitle('Titre d exemple');
        $article->setContent('Some content');
        $article->setCreatedAt(new \DateTime());

        $this->entityManager->persist($article);
        $this->entityManager->flush();

        return $article;
    }

    public function updateArticle(Article $article)
    {
        $article->setTitle('Titre modifié');

        $this->entityManager->flush();

        return $article;
    }

    public function deleteArticle($articleId)
    {
        // Recupère l'article
        $article = $this->entityManager->getRepository(Article::class)->find($articleId);

        $this->entityManager->remove($article);
        $this->entityManager->flush();
    }

}