# tp_connexion

## Contexte
Ce projet est une application web développée avec Symfony, visant à gérer les utilisateurs d'un système. Il permet de créer, gérer et authentifier des utilisateurs tout en fournissant des fonctionnalités spécifiques aux rôles d'administration.

# Documentation des Routes

| Nom du Contrôleur       | URL                   | Paramètres         | Rôles                  | Page Twig                    | Description                                     |
|-------------------------|-----------------------|---------------------|------------------------|-------------------------------|-------------------------------------------------|
| AdminController         | /admin                | N/A                 | ROLE_ADMIN, ROLE_SUPER_ADMIN | admin/index.html.twig        | Affiche la page d'administration pour les admins. |
| HomeController          | /                     | N/A                 | Tous                   | home/index.html.twig         | Affiche la page d'accueil.                       |
| RegistrationController   | /register             | N/A                 | N/A                    | registration/register.html.twig | Gère l'enregistrement d'un nouvel utilisateur.   |
| SecurityController      | /login                | N/A                 | N/A                    | security/login.html.twig     | Affiche le formulaire de connexion.              |
| SecurityController      | /logout               | N/A                 | N/A                    | N/A                           | Gère la déconnexion de l'utilisateur.            |
| SuperAdminController    | /super/admin          | N/A                 | ROLE_SUPER_ADMIN       | super_admin/index.html.twig  | Affiche la page d'administration pour le super admin. |
| SuperAdminController    | /{id}                 | id (Utilisateur)    | ROLE_SUPER_ADMIN       | N/A                           | Met à jour le rôle d'un utilisateur à ROLE_ADMIN. |

## Fonctionnalités Principales

1. **Gestion des Utilisateurs** :
    - **Inscription** : Les nouveaux utilisateurs peuvent s'enregistrer via un formulaire d'inscription. Les mots de passe sont hachés pour garantir la sécurité des données.
    - **Rôles d'Utilisateur** : Trois types de rôles sont définis : `ROLE_USER`, `ROLE_ADMIN`, et `ROLE_SUPER_ADMIN`. Chaque rôle a des permissions spécifiques, limitant l'accès à certaines fonctionnalités de l'application.

2. **Authentification** :
    - **Connexion et Déconnexion** : Les utilisateurs peuvent se connecter et se déconnecter en toute sécurité. Un système de notification informe les utilisateurs des erreurs d'authentification.

3. **Interface Administrateur** :
    - **Tableau de Bord Admin** : Les utilisateurs avec un rôle d'admin peuvent accéder à un tableau de bord leur permettant de voir et gérer les utilisateurs inscrits.
    - **Gestion des Rôles** : Les super administrateurs ont la capacité de modifier les rôles des utilisateurs, leur permettant d'accorder ou de retirer des permissions.

4. **Page d'Accueil** :
    - Une page d'accueil simple qui fournit des informations générales sur l'application et permet aux utilisateurs d'accéder aux différentes fonctionnalités.

## Technologies Utilisées
- **Symfony** : Framework PHP pour le développement de l'application.
- **Doctrine** : ORM utilisé pour la gestion des entités et des bases de données.
- **Twig** : Moteur de templates pour rendre les pages HTML.
- **CSS et JavaScript** : Pour le style et l'interactivité des pages.

## Objectif du Projet
L'objectif principal de ce projet est de fournir une interface utilisateur intuitive pour la gestion des utilisateurs, en garantissant la sécurité des données et en respectant les rôles et permissions. Ce projet peut servir de base pour des applications plus complexes nécessitant une gestion des utilisateurs.

## Public Cible
Ce projet s'adresse principalement aux développeurs souhaitant intégrer une gestion des utilisateurs dans leurs applications, ainsi qu'aux administrateurs qui auront besoin de gérer l'accès et les permissions au sein de l'application.

## Conclusion
Ce projet met en œuvre les meilleures pratiques en matière de sécurité et de gestion des utilisateurs, tout en offrant une interface claire et fonctionnelle. Il constitue un excellent point de départ pour des applications nécessitant une gestion robuste des utilisateurs.