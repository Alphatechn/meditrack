CREATE TABLE `type_users` (
    `id` INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    `libelle` VARCHAR(255) NOT NULL,
    `role` VARCHAR(255) NOT NULL,
    `created_at` DATETIME,
    `updated_at` DATETIME
);

CREATE TABLE `users` (
    `id` INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    `nom` VARCHAR(255) NOT NULL,
    `prenom` VARCHAR(255) NOT NULL,
    `telephone` BIGINT NOT NULL,
    `adresse` VARCHAR(255) NOT NULL,
    `email` VARCHAR(255),
    `email_verified_at` DATETIME,
    `password` VARCHAR(255) NOT NULL,
    `status` TINYINT(1) NOT NULL DEFAULT 0,
    `sit_mat` VARCHAR(255) NOT NULL,
    `sexe` TEXT,
    `profil` VARCHAR(255) DEFAULT 'imgp.jpg',
    `is_delete` TINYINT(1) NOT NULL DEFAULT 0,
    `remember_token` VARCHAR(255),
    `id_type_user` INT NOT NULL,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    FOREIGN KEY (`id_type_user`) REFERENCES `type_users`(`id`)
);

CREATE TABLE `patient` (
    `id` INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    `code` VARCHAR(255) NOT NULL,
    `date_naissance` DATE NOT NULL,
    `lieu` VARCHAR(255) NOT NULL,
    `contact_urgent` BIGINT NOT NULL,
    `id_user` INT NOT NULL,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    `is_delete` TINYINT(1) NOT NULL DEFAULT 0,
    FOREIGN KEY (`id_user`) REFERENCES `users`(`id`)
);

CREATE TABLE `personnel` (
    `id` INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    `date_embauche` DATE NOT NULL,
    `matricule` VARCHAR(255) NOT NULL,
    `id_user` INT NOT NULL,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    `is_delete` TINYINT(1) NOT NULL DEFAULT 0,
    FOREIGN KEY (`id_user`) REFERENCES `users`(`id`)
);

CREATE TABLE `categories` (
    `id` INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    `libelle` VARCHAR(255) NOT NULL,
    `status` INT NOT NULL DEFAULT 0,
    `created_at` DATETIME,
    `updated_at` DATETIME
);

CREATE TABLE `medicament` (
    `id` INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    `id_cat` INT NOT NULL,
    `libelle` TEXT,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    `prix` DECIMAL(10, 2),
    FOREIGN KEY (`id_cat`) REFERENCES `categories`(`id`)
);

CREATE TABLE `service` (
    `id` INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    `libelle` VARCHAR(255) NOT NULL,
    `status` INT NOT NULL DEFAULT 0,
    `created_at` DATETIME,
    `updated_at` DATETIME
);

CREATE TABLE `appartenir` (
    `id` INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    `date_debut` DATE,
    `date_fin` DATE,
    `id_ser` INT NOT NULL,
    `id_per` INT NOT NULL,
    `status` INT DEFAULT 0,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    FOREIGN KEY (`id_ser`) REFERENCES `service`(`id`),
    FOREIGN KEY (`id_per`) REFERENCES `personnel`(`id`)
);

CREATE TABLE `examen` (
    `id` INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    `libelle` VARCHAR(255) NOT NULL,
    `prix_examen` DECIMAL(10, 2) NOT NULL,
    `status` INT NOT NULL DEFAULT 0,
    `created_at` DATETIME,
    `updated_at` DATETIME
);

CREATE TABLE `prive` (
    `id` INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    `id_user` INT,
    `pass` TEXT,
    `created_at` DATETIME,
    `updated_at` DATETIME
);

CREATE TABLE `consultation` (
    `id` INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    `temperature` DECIMAL(5, 2) NOT NULL,
    `poids` DECIMAL(5, 2) NOT NULL,
    `taille` DECIMAL(5, 2) NOT NULL,
    `type_cons` VARCHAR(255) NOT NULL,
    `symptome` VARCHAR(255) NOT NULL,
    `diagnostique` VARCHAR(255) NOT NULL,
    `exam_recom` VARCHAR(255) NOT NULL,
    `status` TINYINT(1) NOT NULL DEFAULT 0,
    `id_pat` INT NOT NULL,
    `id_pers` INT NOT NULL,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    FOREIGN KEY (`id_pat`) REFERENCES `patient`(`id`),
    FOREIGN KEY (`id_pers`) REFERENCES `personnel`(`id`)
);

CREATE TABLE `caisse` (
    `id` INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    `motif` VARCHAR(255) NOT NULL,
    `prix` DECIMAL(10, 2) NOT NULL,
    `verser` DECIMAL(10, 2) NOT NULL,
    `reste` DECIMAL(10, 2) NOT NULL,
    `lettre` VARCHAR(255) NOT NULL,
    `etat_caisse` VARCHAR(255) NOT NULL,
    `numero_recu` VARCHAR(255) NOT NULL,
    `id_pers` INT NOT NULL,
    `id_pat` INT NOT NULL,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    FOREIGN KEY (`id_pers`) REFERENCES `personnel`(`id`),
    FOREIGN KEY (`id_pat`) REFERENCES `patient`(`id`)
);

CREATE TABLE `caisse_mvts` (
    `id` INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    `libelle` VARCHAR(255) NOT NULL,
    `montant` DECIMAL(10, 2) NOT NULL,
    `num_recu` VARCHAR(255) NOT NULL,
    `created_at` DATETIME,
    `updated_at` DATETIME
);

CREATE TABLE `transfert` (
    `id` INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    `date_envoi` DATE,
    `date_recu` DATE,
    `etat_transf` VARCHAR(255) NOT NULL,
    `motif` TEXT,
    `id_pat` INT NOT NULL,
    `id_pers` INT,
    `id_pers_r` INT,
    `id_ser` INT NOT NULL,
    `id_cons` INT,
    `etat_caisse` INT DEFAULT 0,
    `status` INT DEFAULT 0,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    FOREIGN KEY (`id_pat`) REFERENCES `patient`(`id`),
    FOREIGN KEY (`id_ser`) REFERENCES `service`(`id`)
);

CREATE TABLE `resultp` (
    `id` INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    `id_pat` INT NOT NULL,
    `id_pers` INT NOT NULL,
    `id_cons` INT,
    `exam` TEXT NOT NULL,
    `result_text` TEXT,
    `result_image` TEXT,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    FOREIGN KEY (`id_pat`) REFERENCES `patient`(`id`),
    FOREIGN KEY (`id_pers`) REFERENCES `personnel`(`id`)
);

CREATE TABLE `rendez_vous` (
    `id` INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    `date_r` DATETIME NOT NULL,
    `id_pat` INT NOT NULL,
    `id_pers` INT NOT NULL,
    `motif_r` TEXT,
    `notes` TEXT,
    `id_cons` INT,
    `status` VARCHAR(255) NOT NULL,
    `is_delete` TINYINT(1) NOT NULL DEFAULT 0,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    FOREIGN KEY (`id_pers`) REFERENCES `personnel`(`id`),
    FOREIGN KEY (`id_pat`) REFERENCES `patient`(`id`)
);

CREATE TABLE `soin` (
    `id` INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    `libelle` VARCHAR(255) NOT NULL,
    `cout` DECIMAL(10, 2) NOT NULL,
    `traitement` VARCHAR(255) NOT NULL,
    `status` INT NOT NULL DEFAULT 0,
    `created_at` DATETIME,
    `updated_at` DATETIME
);

CREATE TABLE `prescrire` (
    `id` INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    `dose` DECIMAL(10, 2) NOT NULL,
    `prise` VARCHAR(255) NOT NULL,
    `status` TINYINT(1) NOT NULL DEFAULT 0,
    `id_consul` INT NOT NULL DEFAULT 0,
    `id_pat` INT NOT NULL DEFAULT 0,
    `id_pers` INT NOT NULL DEFAULT 0,
    `medicament` TEXT NOT NULL,
    `created_at` DATETIME,
    `updated_at` DATETIME
);

CREATE TABLE `resultat` (
    `id` INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    `etat_result` VARCHAR(255) NOT NULL,
    `status` INT NOT NULL,
    `created_at` DATETIME,
    `updated_at` DATETIME
);
