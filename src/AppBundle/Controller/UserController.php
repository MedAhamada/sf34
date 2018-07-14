<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\VarDumper\VarDumper;

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
        $url = $this->exemple();

        VarDumper::dump($url);

        return $this->render('user/show.html.twig', array(
            // ...
        ));
    }

    public function exemple()
    {
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

        $username = 42;

        $urlIndex = $this->generateUrl('user_show_by_username', array(
            'username'  => $username,
            'id'        => 45,
            'location'  => "Marrakech"
        ));

        return $urlIndex;
    }

    /**
     * @Route("/{username}/show", methods={"POST", "PUT", "GET"}, name="user_show_by_username", requirements={"username"="\d+"})
     */
    public function showByUsernameAction($username)
    {
        // Show user by username
        return $this->render('user/show.html.twig', array(
            // ...
        ));
    }

    /**
     * @Route("/edit/{username}", name="user_edit")
     */
    public function editAction($username = "johndoe")
    {
        VarDumper::dump($username);

        return $this->render('user/show.html.twig', array(
            // ...
        ));
    }

}
