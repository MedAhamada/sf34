<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\VarDumper\VarDumper;

/**
 * @Route("/users")
 */
class UserController extends Controller
{

    /**
     * @param EntityManagerInterface $em
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("/", name="user_index")
     */
    public function indexAction(EntityManagerInterface $em)
    {
        $users = $em
            ->getRepository(User::class)
            ->findAll();

        return $this->render('user/index.html.twig', [
            'users'    => $users
        ]);
    }

    /**
     * @param EntityManagerInterface $entityManager
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("/new", name="user_new")
     */
    public function newAction(Request $request, EntityManagerInterface $entityManager)
    {
        $user = new User();

        /*** Option 1: Sans les classes formulaire ****/
        // $form = $this->createFormBuilder($user)
        //     ->add('name', TextType::class)
        //     ->add('email', EmailType::class)
        //    ->add('submit', SubmitType::class)
        //     ->getForm();

        /*** Option 2: Les classes ***/

        $form = $this->createForm(UserType::class, $user);

        // Dire à Symfony de traiter la soumission du formulaire.
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            $entityManager->persist($user);
            $entityManager->flush();

            $indexURL = $this->generateUrl('user_index');
            return $this->redirect($indexURL);
        }

        return $this->render('user/new.html.twig', array(
            'new_form'  => $form->createView()
        ));
    }

    /**
     * @param Request $request
     * @param $id
     * @param EntityManagerInterface $entityManager
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     *
     * @Route("/{id}/edit", name="user_edit", requirements={"id":"\d+"})
     */
    public function editAction(Request $request, $id, EntityManagerInterface $entityManager)
    {
        $user = $entityManager->getRepository(User::class)->find($id);

        $form = $this->createFormBuilder($user)
            ->add('name', TextType::class)
            ->add('email', EmailType::class)
            ->add('submit', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            $entityManager->flush();

            $indexURL = $this->generateUrl('user_index');
            return $this->redirect($indexURL);
        }

        return $this->render('user/edit.html.twig', array(
            'edit_form' => $form->createView()
        ));
    }

    /**
     * @param $id
     * @param EntityManagerInterface $entityManager
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     *
     * @Route("/{id}/delete", name="user_delete", requirements={"id":"\d+"})
     */
    public function deleteAction($id, EntityManagerInterface $entityManager)
    {
        $user = $entityManager->getRepository(User::class)->find($id);

        if (null !== $user){
            $entityManager->remove($user);

            $entityManager->flush();
        }

        $indexURL = $this->generateUrl('user_index');
        return $this->redirect($indexURL);
    }

    /**
     * @param $id
     * @param EntityManagerInterface $entityManager
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("/{id}/show", name="user_show", requirements={"id":"\d+"})
     */
    public function showAction($id, EntityManagerInterface $entityManager)
    {
        $user = $entityManager->getRepository(User::class)->find($id);

        return $this->render('user/show.html.twig', [
            'user'  => $user
        ]);
    }
}
