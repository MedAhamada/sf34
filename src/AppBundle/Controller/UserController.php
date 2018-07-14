<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * @Route("/users")
 */
class UserController extends Controller
{
    /**
     * @Route("/", name="user_index")
     */
    public function indexAction()
    {
        // Récupérer tous les users de la base de données.

        return $this->render('user/index.html.twig', array(
            // ...
        ));
    }

    /**
     * @Route("/show", name="user_show")
     */
    public function showAction()
    {
        // Afficher un utilisateur.

        return $this->render('user/show.html.twig', array(
            // ...
        ));
    }

    /**
     * @Route("/{username}/show", name="user_show_by_username")
     */
    public function showByUsernameAction($username)
    {
        // Show user by username
        return $this->render('user/show.html.twig', array(
            // ...
        ));
    }

}
