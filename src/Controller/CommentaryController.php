<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Commentary;
use App\Form\CommentaryFormType;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CommentaryController extends AbstractController
{
    /**
     * @Route("/ajouter-un-commentaire?article_id={id}", name="add_commentary", methods={"GET|POST"})
     */
    public function addCommentary(Article $article, Request $request, EntityManagerInterface $entityManager): Response
    {
        $commentary = new Commentary();

        $form = $this->createForm(CommentaryFormType::class, $commentary)
            ->handleRequest($request);

            if($form->isSubmitted() && $form->isValid() ===false){
                $this->addFlash('warning', 'votre commentaire est vide!'); 

                return $this->redirectToRoute('show_article', [
                    'cat_alias' => $article->getCategory()->getAlias(),
                    'article_alias'  => $article->getAlias(),
                    'id'=> $article->getId()
                ]);
            }
            
            if($form->isSubmitted() && $form->isValid()){

                $commentary->setArticle($article);
                $commentary->setCreatedAt(new DateTime());
                $commentary->setUpdatedAt(new DateTime());

                $entityManager->persist($commentary);
                $entityManager->flush();

                $this->addFlash('success', " vous avez commenter l'article <strong> ". $article->getTitle() . " <strong> avec succès ! ");
                
                return $this->redirectToRoute('show_article', [
                    'cat_alias' => $article->getCategory()->getAlias(),
                    'article_alias'  => $article->getAlias(),
                    'id'=> $article->getId()
                ]);
            }

        return $this->render('rendered/form_commentary.html.twig', [
            'form' => $form->createView()
        ]);
    }



}
