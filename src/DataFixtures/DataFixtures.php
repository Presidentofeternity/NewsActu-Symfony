<?php

namespace App\DataFixtures;

use DateTime;
use App\Entity\Categorie;
use DateTimeImmutable;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\String\Slugger\SluggerInterface;

class DataFixtures extends Fixture
{
    private SluggerInterface $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }


     # Cette fonction load() sera exécutée en ligne de commande, avec : php bin/console doctrine:fixtures:load --append
       # => le drapeau --append permet de ne pas purger la BDD.
    public function load(ObjectManager $manager): void
    {
        //declaration dune variable de type array avec le nom des differentes catevgorie de newsactu
        $categories = [
            'Politique',
            'Société',
            'people',
            'Economie',
            'Santé',
            'Sport',
            'Espace',
            'Sciences',
            'Mode',
            'Informatique',
            'Ecologie',
            'Cinéma',
            'Hi Tech',
            
        ];
            // le boucle foreach() est optimisé pour les array
                // La syntaxe complète à l'intérieur des parenthèses est : ($key => $value)

        foreach($categories as $cat){
            //instanciation dun objet categorie()
                $categorie = new Categorie();
            ///appel des setters de notre objet $categorie
                $categorie->setName($cat);
                $categorie->setAlias($this->slugger->slug($cat));
                $categorie->setCreatedAt(new DateTime());
                $categorie->setUpdatedAt(new DateTime());
            // entitymanager, on appel sa methode persist() pour inséré en bdd l'objet $categorie
                $manager->persist($categorie);
        }

        // on vide l'entitymanager pour la suite
        $manager->flush();
    }
}
