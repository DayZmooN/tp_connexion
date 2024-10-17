<?php

namespace App\DataFixtures;

use App\Entity\Utilisateur;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 * Class UtilisateurFixture
 *
 * Cette classe est responsable de la création d'utilisateurs fictifs dans la base de données
 * pour les besoins de développement et de tests. Elle utilise le service de hachage de mots de passe
 * de Symfony.
 */
class UtilisateurFixture extends Fixture
{
    /**
     * @var UserPasswordHasherInterface
     */
    private UserPasswordHasherInterface $hasher;

    /**
     * UtilisateurFixture constructor.
     *
     * @param UserPasswordHasherInterface $hasher Instance du service pour hacher les mots de passe.
     */
    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    /**
     * Charge les données de test dans la base de données.
     *
     * Cette méthode crée des utilisateurs standards, des administrateurs et un super administrateur.
     *
     * @param ObjectManager $manager L'objet gestionnaire d'entités.
     */
    public function load(ObjectManager $manager): void
    {
        // Création d'utilisateurs standards
        for ($i = 0; $i < 10; $i++) {
            $user = new Utilisateur();
            $user->setEmail('user' . $i . '@test.com');
            $passwordHashed = $this->hasher->hashPassword($user, '123456');
            $user->setPassword($passwordHashed);
            $manager->persist($user);
        }

        // Création d'administrateurs
        for ($i = 0; $i < 2; $i++) {
            $user = new Utilisateur();
            $user->setEmail('admin' . $i . '@test.com');
            $passwordHashed = $this->hasher->hashPassword($user, '123456');
            $user->setPassword($passwordHashed);
            $user->addRole('ROLE_ADMIN');
            $manager->persist($user);
        }

        // Création d'un super administrateur
        $user = new Utilisateur();
        $user->setEmail('superadmin@test.com');
        $passwordHashed = $this->hasher->hashPassword($user, '123456');
        $user->setPassword($passwordHashed);
        $user->addRole('ROLE_SUPER_ADMIN');
        $manager->persist($user);

        // Sauvegarde des entités dans la base de données
        $manager->flush();
    }
}
