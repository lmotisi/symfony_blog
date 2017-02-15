<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Article;
use AppBundle\Entity\Tag;
use AppBundle\Entity\Categorie;
use AppBundle\Form\CategorieType;
use AppBundle\Form\ArticleType;
use AppBundle\Form\TagType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


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
    public function addArticleAction(Request $request)
    {
        $article = new Article();

        $form = $this->createForm(ArticleType::class, $article);
        $form ->add('save', SubmitType::class, array('label' => "Enregistrer"));

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $article = $form->getData();
            $article->setAuteur($this->getUser());
            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();
            return $this->redirectToRoute('admin');
        }

            return $this->render('admin/addArticle.html.twig',
                array('form'=> $form->createView())
            );
    }

    /**
     * @Route("/ajout_categorie", name="add_categorie")
     */
    public function addCategorieAction(Request $request)
    {
        $categorie = new Categorie();

        $form = $this->createForm(CategorieType::class, $categorie);
        $form ->add('save', SubmitType::class, array('label' => "Enregistrer"));

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $categorie = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($categorie);
            $em->flush();
            return $this->redirectToRoute('admin');
        }
        return $this->render('admin/addCategorie.html.twig',
            array('form'=> $form->createView())
        );
    }

    /**
     * @Route("/ajout_tag", name="add_tag")
     */
    public function addTag(Request $request)
    {
        $tag = new Tag();

        $form = $this->createForm(TagType::class, $tag);
        $form ->add('save', SubmitType::class, array('label' => "Enregistrer"));

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $tag = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($tag);
            $em->flush();
            return $this->redirectToRoute('admin');
        }
        return $this->render('admin/addTag.html.twig',
            array('form'=> $form->createView())
        );
    }





}
