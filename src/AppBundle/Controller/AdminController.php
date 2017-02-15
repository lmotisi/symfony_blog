<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * @Route("/admin")
 */
class AdminController extends Controller
{
    /**
     * @Route("/", name="admin")
     */
    public function adminAction()
    {
        return $this->render('admin/admin.html.twig', array(
        ));
    }

    /**
     * @Route("/ajout_article", name="add_article")
     */
    public function addArticleAction()
    {
        return $this->render('admin/addArticle.html.twig', array(
        ));
    }

    /**
     * @Route("/ajout_categorie", name="add_categorie")
     */
    public function addCategorieAction()
    {
        return $this->render('admin/addCategorie.html.twig', array(
        ));
    }

    /**
     * @Route("/ajout_tag", name="add_tag")
     */
    public function addTag()
    {
        return $this->render('admin/addTag.html.twig', array(
        ));
    }

}
