<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class PublicController extends Controller
{
    /**
     * @Route("/", name="accueil")
     */
    public function accueilAction()
    {
        $articles = $this->getDoctrine()->getRepository('AppBundle:Article')->findLast5Articles();
        return $this->render('public/accueil.html.twig', array('articles' => $articles));
    }


    /**
     * @Route("/liste", name="liste")
     */
    public function listeAction()
    {
        $articles = $this->getDoctrine()->getRepository('AppBundle:Article')->findAllByDate();
        return $this->render('public/liste.html.twig', array('articles' => $articles));
    }

    /**
     * @Route("/details/{id}", name="details")
     */
    public function detailsAction($id)
    {
        $article = $this->getDoctrine()->getRepository('AppBundle:Article')->find($id);
        return $this->render('public/details.html.twig', array('article' => $article));

    }
}
