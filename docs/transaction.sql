BEGIN;

-- Création de l'utilisateur et récupération de son id
INSERT INTO `users`(`email`, `roles`, `password`, `firstname`, `lastname`) VALUES ('doctor@soignemoi.com','["ROLE_DOCTOR"]','password','Pascal','Perrod');
SET @id_user := LAST_INSERT_ID();

-- Création d'une spécialité et récupération de son id
INSERT INTO `specialities`(`name`) VALUES ('Psychologie');
SET @id_speciality := LAST_INSERT_ID();

-- Création du docteur associé à l'utilisateur et à la spécialité précédemment crée
INSERT INTO `doctors`(`user_id`, `speciality_id`, `registration_number`) VALUES (@id_user, @id_speciality,'123456789');

COMMIT;