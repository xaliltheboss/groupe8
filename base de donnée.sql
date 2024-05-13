-- Table pour les formations
CREATE TABLE formations (
    id_formation INT AUTO_INCREMENT PRIMARY KEY,
    libelle_formation VARCHAR(100)
);

-- Table pour les matières
CREATE TABLE matieres (
    id_matiere INT AUTO_INCREMENT PRIMARY KEY,
    code_matiere VARCHAR(20),
    libelle_matiere VARCHAR(100),
    id_formation INT,
    FOREIGN KEY (id_formation) REFERENCES formations(id_formation)
);


-- Table pour les étudiants
CREATE TABLE etudiants (
    id_etudiant INT AUTO_INCREMENT PRIMARY KEY,
    matricule VARCHAR(20),
    nom VARCHAR(50),
    prenom VARCHAR(50),
    adresse VARCHAR(100),
    telephone VARCHAR(20),
    id_formation INT,
    FOREIGN KEY (id_formation) REFERENCES formations(id_formation)
);

-- Table pour les notes
CREATE TABLE notes (
    id_note INT AUTO_INCREMENT PRIMARY KEY,
    id_etudiant INT,
    id_matiere INT,
    valeur_note FLOAT,
    FOREIGN KEY (id_etudiant) REFERENCES etudiants(id_etudiant),
    FOREIGN KEY (id_matiere) REFERENCES matieres(id_matiere)
);