<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Categorie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('title', TextType::class,[
            'label' => 'Titre de l\'article',
            'constraints' => [
                new NotBlank([
                    'message' => "ce champ ne peut etre vide"
                ]),
                new Length([
                    'min' => 5,
                    'max' => 255,
                    'minMessage' => "Votre titre est trop court , Le nombre de caracteres minimal est {{ limit }} ",
                    'maxMessage' => "Votre titre est trop long , Le nombre de caracteres maximal est {{ limit }} ",
                ])
            ]
        ])
        ->add('subtitle' , TextType::class,[
            'label' => 'Sous-titre',
            'constraints' => [
                new NotBlank([
                    'message' => "ce champ ne peut etre vide"
                ]),
                new Length([
                    'min' => 5,
                    'max' => 255,
                    'minMessage' => "Votre sous-titre est trop court , Le nombre de caracteres minimal est {{ limit }} ",
                    'maxMessage' => "Votre sous-titre est trop long , Le nombre de caracteres maximal est {{ limit }} ",
                ]),
            ]
        ])
        ->add('content', TextareaType::class, [
            'label' => false,
            'attr' => [
                'placeholder' => 'Ici le contenu de l\'article'
            ],
        ])
        ->add('category', EntityType::class,[
            'class' => Categorie::class,
            'choice_label' => 'name',
            'label' => 'Choisissez une cat??gorie'
        ]  )
        ->add('photo' , FileType::class, [
            'label' =>'Photo d\'illustration',
            // 'data_class' => permet de param??trer le type de classe de donn??es ?? null.
            # par d??fault data_class = File
            'data_class' => null,
            'attr' => [
                'data-default-file' => $options['photo']
            ],
            'constraints' => [
                new Image([
                    'mimeTypes' => ['image/jpeg', 'image/png'],
                    'mimeTypesMessage' => " les types de photos autoris?? sont .jpeg ou .png",
                ]),
            ],
            

        ] )
     


        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
            // 'allow_file_upload' => permet d'autoriser les upload de fichier dans le formulaire
            'allow_file_upload' => true,
            // 'photo' => permet de r??cup??rer la photo existante lors d'un update
            'photo' => null,

            // Configure your form options here
        ]);
    }
}
