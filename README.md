# EQuizine - Application web de gestion de quiz

**Template visiteur - joueur:** https://bootstrapmade.com/impact-bootstrap-business-website-template/

**Template administrateur - formateur:** https://www.creative-tim.com/product/material-dashboard-pro?ref=sidebarfree

### Comptes et codes de match de présentation

- Administrateur
    - responsable - resp22_ZUIQ
    - aDupuys - aDupuys
- Formateur
    - mOvret - mOvret
    - eAffigliati - eAffigliati
    - sMartin - sMartin
    - tMartin - tMartin
    - cOrthy - cOrthy
- Codes de match
    - HR76HU97 - Activé - Harry Potter
    - DS76EU34 - Activé - Death Stranding
    - DS76HU34 - Désactivé - Death Stranding
    - SP76DG97 - Désactivé - Spider-Man
    - HG76DE97 - Activé - Hunger Games
    - SH45HU56 - Activé - Sherlock Holmes(Film)
    - SH78HV10 - Désactivé - Sherlock Holmes(Film)
    - SH22JU02 - Activé - Sherlock Holmes(Série)

### Descriptifs des versions

- V1
    
    La version 1 de l’application affiche la page d’accueil de l’application qui affiche les 5 dernières actualités.
    
    Un visiteur peut afficher les questions et réponses d’un match en saisissant un code de match et un pseudo. 
    
    Les responsables  peuvent se connecter et se déconnecter de leur espace privé et accéder à leur profil, pour le modifier. 
    
    Le formateur peut également afficher les données d’un match. 
    
    L’administrateur peut afficher la liste des profils.
    
- V2
    
    Le formateur peut afficher la liste des informations des quiz actifs associés à leur match, remettre à zéro et activer/désactiver les matchs qui lui appartiens. Il peut créer un nouveau match à partir d’un quiz actif non vide.
    
    Le visiteur peut participer à un match en saisissant un code de match et un pseudo. Il devient joueur et peut soumettre ses réponses pour afficher son score final et visualiser la correction, si le formateur l’a autorisé.
    

### Information sur la base de données

Nom de la base utilisé: zal-zaffiglen_1

### Descriptif des fonctions, procédures, triggers et vues de la base

- Fonctions
    - QuizIdQuizNom → prend en paramètre l’id d’un quiz et renvoie le nom associé
    - HashMdp → prend en paramètre un text et le renvoie hashé et salé
    - idPseudo → prend en paramètre l’identifiant d’un responsable et renvoie le pseudo associé
    - listeJoueur → prend en paramètre le code d’un match et renvoie une liste contenant tout les joueurs ayant participé
    - matchAssoQuiz → prend en paramètre l’identifiant d’un quiz et renvoie un text contenant les matchs et formateurs associés au quiz
    - nbQuestion → prend en paramètre l’identifiant d’un quiz et renvoie le nombre de question associé au quiz
    - pseudoId → prend en paramètre le pseudo d’un responsable et renvoie son identifiant
- Procédures
    - actuFinMatch → prend en paramètre le code d’un match et insère une actualité contenant le code du match, sa date de début, sa date de fin et la liste des joueurs ayant participé.
    - codeMtc → prend en entrer l’identifiant d’un quiz et passe en sortie un code de match généré automatiquement
    - nbMatch → passe en sortie le nombre de match non commencé, commencé et fini
    - newsBestJou → prend en entrer un pseudo et un code de match et insère une actualité indiquant que le joueur a obtenu le meilleur score à un quiz
    - newsModQuiz → prend en entrer le code d’un quiz et insère une actualité indiquant le nombre de question restante
- Trigger
    - finMatch → Appel la procédure actuFinMatch si un match se termine
    - hashMdp → Appel la fonction hashMdp sur le nouveau mot de passe avant son insertion
    - modQuizNews → Appel la procédure newsModQuiz après suppression d’une question
    - newJou → Appel la procédure newsBestJou si le joueurs inséré atteint le meilleur score
    - razMatch → Supprime tout les joueurs associés au match qui change de date de début et remet sa date de fin à null
- Vue
    - mtcScoreAvg → liste les match et leur moyenne associé

### Améliorations possible

Pour développer on pourrait ajouter certaine fonctionnalité, comme la gestion des quiz, des questions, des réponses et des actualités pour les formateurs. Mais aussi l’ajout d’un chronomètre pour les questions.

### Procédure d’installation de l’application web (Windows)

1. Télécharger et installer WAMP
2. Faire un clique droit sur l’application WampServeur généré et choisissez “Ouvrir l’emplacement du fichier”
3. Ouvrez le dossier “www”
4. Créer un dossier qui portera le nom de votre projet sans espace(le nom vous servira pour accéder à la page de votre site)
5. Copier-coller le contenue du dossier CodeIgniter dans votre nouveau dossier
6. Ouvrez le fichier config.php - NomDeVotreProjet/application/config/config.php
7. Remplacer la ligne $config[”base_url”]… par $config[”base_url”]="http://localhost/NomDeVotreProjet/"
8. Ouvrez le fichier database.php - NomDeVotreProjet/application/config/database.php
9. Remplacez dans ces lignes 'username' => 'root' et 'password' => 'root' le mot root par vos identifiants de connexion à la base de données
10. Double cliquez sur l’application WampServeur et attendez quelque seconde que le serveur local démarre
11. En bas à droite dans la barre des tâches, un logo WampServeur apparait
12. Une fois qu’il est vert faite un clique gauche dessus et sélectionner “phpmyadmin”
13. Une page web avec un formulaire s’affiche. Inséré vos identifiants de connexion à la base de données utilisé précédemment et appuyez sur entrée
14. Cliquez sur le lien “Nouvelle base de données” à gauche de la page
15. Dans le champ “Nom de la base de données” insérez “zal3-zaffiglen_1”, choisissez comme interclassement “utf8_general_ci” et cliquez sur créer
16. Cliquez sur l’onglet Import en haut de la page
17. Cliquez sur le bouton “Choisir Fichier” ou “Choose File” et sélectionner le fichier “Create.sql”
18. Cliquez sur le bouton “Go” en bas à droite
19. Répétez les actions 16 à 18 pour les fichiers: function_procedures.sql - trigger.sql - view.sql et eQuizineInsertComplet.sql
20. Vous pouvez maintenant afficher la page avec l’url:"http://localhost/NomDeVotreProjet"
