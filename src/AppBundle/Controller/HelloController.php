<?php
/**
 * Created by PhpStorm.
 * User: Ahamada
 * Date: 07/07/2018
 * Time: 17:25
 */

namespace AppBundle\Controller;


use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\VarDumper\VarDumper;

class HelloController extends Controller
{
    /**
     * @Route("{lang}/hello/{name}")
     *
     * @return Response
     */
    public function helloAction(Request $request, $lang, $name)
    {
        $msg = '';

        if($lang === 'en'){
            $msg = 'welcome';
        }
        else if ($lang === 'fr'){
            $msg = 'bienvenue';
        }

        return $this->render('hello/hello.html.twig', [
            'msg' => $msg,
            'name'  => $name,
            'lang'  => $lang
        ]);
    }

    /**
     * @Route("/{_locale}/bonjour/{name}", requirements={"_locale":"fr|en"})
     */
    public function helloByProfAction($_locale, $name)
    {

        $msg = ($_locale === 'fr') ? "Bonjour $name" : "Hello $name";

        return new Response($msg);
    }
}
