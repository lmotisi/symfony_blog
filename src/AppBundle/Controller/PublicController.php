<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use AppBundle\Form\ArticleType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use AppBundle\Entity\Article;
use AppBundle\Entity\Commentaire;
use AppBundle\Form\CommentaireType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

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
    public function detailsAction(Request $request, Article $article)
    {
        $commentairesExistants = $this->getDoctrine()->getRepository('AppBundle:Commentaire')->findBy(['article' => $article]);
        $commentaire = new Commentaire();
        $commentaireForm = $this->createForm(CommentaireType::class, $commentaire);
        $commentaireForm ->add('save', SubmitType::class, array('label' => "Poster"));

        $commentaireForm->handleRequest($request);
        $deleteForm = $this->createDeleteForm($article);

        if ($commentaireForm->isSubmitted() && $commentaireForm->isValid()) {
            $commentaire = $commentaireForm->getData();
            $commentaire->setArticle($article);
            $em = $this->getDoctrine()->getManager();
            $em->persist($commentaire);
            $em->flush();

            $commentairesExistants = $this->getDoctrine()->getRepository('AppBundle:Commentaire')->findBy(['article' => $article]);
            $commentaire = new Commentaire();
            $commentaireForm = $this->createForm(CommentaireType::class, $commentaire);
            $commentaireForm ->add('save', SubmitType::class, array('label' => "Poster"));
            return $this->render('public/details.html.twig', array(
                'article' => $article,
                'commentaire_form' => $commentaireForm->createView(),
                'commentaires' => $commentairesExistants,
                'delete_form' => $deleteForm->createView()
            ));
        }

        return $this->render('public/details.html.twig', array(
            'article' => $article,
            'commentaire_form' => $commentaireForm->createView(),
            'commentaires' => $commentairesExistants,
            'delete_form' => $deleteForm->createView()
        ));
    }


    /**
     * @Route("/{id}/edit", name="edit_article")
     * @Method({"GET", "POST"})
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function editAction(Request $request, Article $article)
    {
        $editForm = $this->createForm(ArticleType::class, $article);
        $editForm ->add('save', SubmitType::class, array('label' => "Editer l'article"));
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('details', array('id' => $article->getId()));
        }

        return $this->render('public/edit.html.twig', array(
            'article' => $article,
            'edit_form' => $editForm->createView(),
        ));
    }


    /**
     * @Route("/{id}", name="delete_article")
     * @Method("DELETE")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function deleteAction(Request $request, Article $article)
    {
        $form = $this->createDeleteForm($article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($article);
            $em->flush($article);
        }

        return $this->redirectToRoute('liste');
    }


    /**
     * @param Article $article
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Article $article)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('delete_article', array('id' => $article->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }
}
