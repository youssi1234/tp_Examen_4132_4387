-- Correction de la table exam_membre
CREATE TABLE exam_membre (
    id_membre INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    nom VARCHAR(250) NOT NULL,
    ddns VARCHAR(50) NOT NULL,
    genre VARCHAR(1) NOT NULL,
    email VARCHAR(250) NOT NULL,
    ville VARCHAR(250) NOT NULL,
    mdp VARCHAR(250) NOT NULL,
    image_profil VARCHAR(250)
);

-- Correction de la table exam_categorie_objet
CREATE TABLE exam_categorie_objet (
    id_categorie INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    nom_categorie VARCHAR(250) NOT NULL -- Ajout de NOT NULL
);

-- Correction de la table exam_objet
CREATE TABLE exam_objet (
    id_objet INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    nom_objet VARCHAR(250),
    id_categorie INT NOT NULL,
    id_membre INT NOT NULL,
    FOREIGN KEY (id_categorie) REFERENCES exam_categorie_objet (id_categorie) ON DELETE CASCADE,
    FOREIGN KEY (id_membre) REFERENCES exam_membre (id_membre) ON DELETE CASCADE
);

-- Correction de la table exam_images_obje
CREATE TABLE exam_images_obje (
    id_image INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    id_objet INT NOT NULL, -- Ajout de NOT NULL
    nom_image VARCHAR(250),
    FOREIGN KEY (id_objet) REFERENCES exam_objet (id_objet) ON DELETE CASCADE
);

-- Correction de la table exam_emprunt
CREATE TABLE exam_emprunt (
    id_emprunt INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    id_objet INT,
    id_membre INT,
    date_emprunt DATETIME,
    date_retour DATETIME,
    FOREIGN KEY (id_objet) REFERENCES exam_objet (id_objet) ON DELETE CASCADE,
    FOREIGN KEY (id_membre) REFERENCES exam_membre (id_membre) ON DELETE CASCADE
);

-- Insertion des données dans la table exam_membre
INSERT INTO exam_membre (nom, ddns, genre, email, ville, mdp, image_profil) VALUES
('Alice Dupont', '1990-05-15', 'F', 'alice.dupont@example.com', 'Paris', 'motdepasse123', 'profile_alice.jpg'),
('Bob Martin', '1985-11-22', 'M', 'bob.martin@example.com', 'Lyon', 'motdepasse123', 'profile_bob.jpg'),
('Carole Lefevre', '1992-03-01', 'F', 'carole.lefevre@example.com', 'Marseille', 'motdepasse123', 'profile_carole.jpg'),
('David Bernard', '1988-08-10', 'M', 'david.bernard@example.com', 'Toulouse', 'motdepasse123', 'profile_david.jpg');

-- Insertion des données dans la table exam_categorie_objet
INSERT INTO exam_categorie_objet (nom_categorie) VALUES
('Esthétique'),
('Bricolage'),
('Mécanique'),
('Cuisine');

-- Insertion des données dans la table exam_objet (10 objets par membre, répartis sur les catégories)
INSERT INTO exam_objet (nom_objet, id_categorie, id_membre) VALUES
-- Membre 1 (Alice Dupont) - id_membre = 1
('Kit de maquillage', 1, 1),
('Sèche-cheveux professionnel', 1, 1),
('Perceuse visseuse', 2, 1),
('Boîte à outils complète', 2, 1),
('Clé à molette', 3, 1),
('Cric hydraulique', 3, 1),
('Robot pâtissier', 4, 1),
('Set de couteaux de chef', 4, 1),
('Fer à lisser', 1, 1),
('Scie sauteuse', 2, 1),
-- Membre 2 (Bob Martin) - id_membre = 2
('Vernis à ongles', 1, 2),
('Pinceau de maquillage', 1, 2),
('Marteau et clous', 2, 2),
('Niveau à bulle', 2, 2),
('Jeu de clés à douille', 3, 2),
('Compresseur d''air', 3, 2),
('Mixeur plongeant', 4, 2),
('Machine à café expresso', 4, 2),
('Kit de manucure', 1, 2),
('Pistolet à colle', 2, 2),
-- Membre 3 (Carole Lefevre) - id_membre = 3
('Lisseur vapeur', 1, 3),
('Miroir grossissant', 1, 3),
('Ponceuse électrique', 2, 3),
('Établi portable', 2, 3),
('Multimètre', 3, 3),
('Chargeur de batterie', 3, 3),
('Autocuiseur', 4, 3),
('Balance de cuisine', 4, 3),
('Kit de soins du visage', 1, 3),
('Tournevis électrique', 2, 3),
-- Membre 4 (David Bernard) - id_membre = 4
('Trousse de rasage', 1, 4),
('Brosse nettoyante visage', 1, 4),
('Défonceuse', 2, 4),
('Perforateur burineur', 2, 4),
('Clé dynamométrique', 3, 4),
('Extracteur de rotule', 3, 4),
('Friteuse sans huile', 4, 4),
('Grille-pain design', 4, 4),
('Kit de coiffure', 1, 4),
('Pistolet à peinture', 2, 4);

-- Insertion des données dans la table exam_emprunt (10 emprunts)
INSERT INTO exam_emprunt (id_objet, id_membre, date_emprunt, date_retour) VALUES
(3, 2, '2024-01-10 10:00:00', '2024-01-15 14:30:00'), -- Bob emprunte la perceuse d'Alice
(17, 1, '2024-02-01 11:30:00', '2024-02-05 16:00:00'), -- Alice emprunte le mixeur de Bob
(23, 4, '2024-03-05 09:00:00', '2024-03-10 12:00:00'), -- David emprunte la ponceuse de Carole
(37, 3, '2024-04-12 15:00:00', '2024-04-18 10:00:00'), -- Carole emprunte la friteuse de David
(1, 2, '2024-05-20 08:00:00', NULL), -- Bob emprunte le kit de maquillage d'Alice (non retourné)
(11, 1, '2024-06-01 13:00:00', NULL), -- Alice emprunte le vernis à ongles de Bob (non retourné)
(5, 4, '2024-06-15 10:00:00', '2024-06-20 11:00:00'), -- David emprunte la clé à molette d'Alice
(25, 1, '2024-07-01 14:00:00', '2024-07-03 16:00:00'), -- Alice emprunte le multimètre de Carole
(31, 2, '2024-07-10 09:00:00', NULL), -- Bob emprunte la trousse de rasage de David (non retourné)
(7, 3, '2024-07-12 16:00:00', '2024-07-14 18:00:00'); -- Carole emprunte le robot pâtissier d'Alice


UPDATE exam_emprunt SET date_retour = NULL WHERE date_retour = '9999-01-01';