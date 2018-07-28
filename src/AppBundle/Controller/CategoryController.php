<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class CategoryController
 * @package AppBundle\Controller
 *
 * @Route("/categories")
 */
class CategoryController extends Controller
{

    /**
     * @param EntityManagerInterface $em
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("/", name="category_index")
     */
    public function indexAction(EntityManagerInterface $em)
    {
        $categories = $em
            ->getRepository(Category::class)
            ->findAll();

        return $this->render('category/index.html.twig', [
            'categories'    => $categories
        ]);
    }

    /**
     * @param EntityManagerInterface $entityManager
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     *
     * @Route("/new", name="category_new")
     */
    public function newAction(EntityManagerInterface $entityManager)
    {
        $category = new Category();
        $category->setName('Voyage ' . microtime());

        $entityManager->persist($category);
        $entityManager->flush();

        $indexURL = $this->generateUrl('category_index');
        return $this->redirect($indexURL);
    }

    /**
     * @param $id
     * @param EntityManagerInterface $entityManager
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     *
     * @Route("/{id}/edit", name="category_edit", requirements={"id":"\d+"})
     */
    public function editAction($id, EntityManagerInterface $entityManager)
    {
        $category = $entityManager->getRepository(Category::class)->find($id);

        if (null !== $category){
            $category->setName('Travel - Update ' . microtime(true));

            $entityManager->flush();
        }

        $indexURL = $this->generateUrl('category_index');
        return $this->redirect($indexURL);
    }

    /**
     * @param $id
     * @param EntityManagerInterface $entityManager
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     *
     * @Route("/{id}/delete", name="category_delete", requirements={"id":"\d+"})
     */
    public function deleteAction($id, EntityManagerInterface $entityManager)
    {
        $category = $entityManager->getRepository(Category::class)->find($id);

        if (null !== $category){
            $entityManager->remove($category);

            $entityManager->flush();
        }

        $indexURL = $this->generateUrl('category_index');
        return $this->redirect($indexURL);
    }

    /**
     * @param $id
     * @param EntityManagerInterface $entityManager
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("/{id}/show", name="category_show", requirements={"id":"\d+"})
     */
    public function showAction($id, EntityManagerInterface $entityManager)
    {
        $category = $entityManager->getRepository(Category::class)->find($id);

        return $this->render('category/show.html.twig', [
            'category'  => $category
        ]);
    }
}
