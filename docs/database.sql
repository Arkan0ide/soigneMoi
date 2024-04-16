CREATE DATABASE IF NOT EXISTS soignemoi;

USE soignemoi;

CREATE TABLE doctors (
    id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    user_id INT NOT NULL,
    speciality_id INT NOT NULL,
    registration_number VARCHAR(255) NOT NULL,
    UNIQUE INDEX UNIQ_DOCTORS_USER_ID (user_id),
    INDEX IDX_DOCTORS_SPECIALITY_ID (speciality_id)
) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB;

CREATE TABLE drugs (
    id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    name VARCHAR(255) NOT NULL
) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB;

CREATE TABLE medications (
    id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    drug_id INT NOT NULL,
    prescription_id INT NOT NULL,
    dosage VARCHAR(255) NOT NULL,
    UNIQUE INDEX UNIQ_MEDICATIONS_DRUG_ID_PRESCRIPTION_ID (drug_id, prescription_id),
    INDEX IDX_MEDICATIONS_PRESCRIPTION_ID (prescription_id)
) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB;

CREATE TABLE opinions (
    id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    prescription_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    date DATE NOT NULL,
    description VARCHAR(255) NOT NULL,
    UNIQUE INDEX UNIQ_OPINIONS_PRESCRIPTION_ID (prescription_id)
) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB;

CREATE TABLE patients (
    id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    user_id INT NOT NULL,
    address VARCHAR(255) NOT NULL,
    UNIQUE INDEX UNIQ_PATIENTS_USER_ID (user_id)
) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB;

CREATE TABLE prescription (
    id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    user_id INT NOT NULL,
    doctor_id INT NOT NULL,
    start_date DATE NOT NULL,
    end_date DATE NOT NULL,
    INDEX IDX_PRESCRIPTION_USER_ID (user_id),
    INDEX IDX_PRESCRIPTION_DOCTOR_ID (doctor_id)
) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB;

CREATE TABLE schedule (
    id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    doctor_id INT NOT NULL,
    patient_id INT NOT NULL,
    date_time_begin DATETIME NOT NULL,
    date_time_end DATETIME NOT NULL,
    INDEX IDX_SCHEDULE_DOCTOR_ID (doctor_id),
    INDEX IDX_SCHEDULE_PATIENT_ID (patient_id)
) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB;

CREATE TABLE specialities (
    id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    name VARCHAR(255) NOT NULL
) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB;

CREATE TABLE users (
    id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    email VARCHAR(180) NOT NULL,
    roles JSON NOT NULL,
    password VARCHAR(255) NOT NULL,
    firstname VARCHAR(255) NOT NULL,
    lastname VARCHAR(255) NOT NULL,
    UNIQUE INDEX UNIQ_USERS_EMAIL (email)
) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB;

CREATE TABLE visits (
    id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    patient_id INT NOT NULL,
    doctor_id INT NOT NULL,
    speciality_id INT NOT NULL,
    start_date DATE NOT NULL,
    end_date DATE NOT NULL,
    reason VARCHAR(255) NOT NULL,
    INDEX IDX_VISITS_PATIENT_ID (patient_id),
    INDEX IDX_VISITS_DOCTOR_ID (doctor_id),
    INDEX IDX_VISITS_SPECIALITY_ID (speciality_id)
) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB;

ALTER TABLE doctors ADD CONSTRAINT FK_DOCTORS_USER_ID FOREIGN KEY (user_id) REFERENCES users (id);
ALTER TABLE doctors ADD CONSTRAINT FK_DOCTORS_SPECIALITY_ID FOREIGN KEY (speciality_id) REFERENCES specialities (id);
ALTER TABLE medications ADD CONSTRAINT FK_MEDICATIONS_DRUG_ID FOREIGN KEY (drug_id) REFERENCES drugs (id);
ALTER TABLE medications ADD CONSTRAINT FK_MEDICATIONS_PRESCRIPTION_ID FOREIGN KEY (prescription_id) REFERENCES prescription (id);
ALTER TABLE opinions ADD CONSTRAINT FK_OPINIONS_PRESCRIPTION_ID FOREIGN KEY (prescription_id) REFERENCES prescription (id);
ALTER TABLE patients ADD CONSTRAINT FK_PATIENTS_USER_ID FOREIGN KEY (user_id) REFERENCES users (id);
ALTER TABLE prescription ADD CONSTRAINT FK_PRESCRIPTION_USER_ID FOREIGN KEY (user_id) REFERENCES patients (id);
ALTER TABLE prescription ADD CONSTRAINT FK_PRESCRIPTION_DOCTOR_ID FOREIGN KEY (doctor_id) REFERENCES doctors (id);
ALTER TABLE schedule ADD CONSTRAINT FK_SCHEDULE_DOCTOR_ID FOREIGN KEY (doctor_id) REFERENCES doctors (id);
ALTER TABLE schedule ADD CONSTRAINT FK_SCHEDULE_PATIENT_ID FOREIGN KEY (patient_id) REFERENCES patients (id);
ALTER TABLE visits ADD CONSTRAINT FK_VISITS_PATIENT_ID FOREIGN KEY (patient_id) REFERENCES patients (id);
ALTER TABLE visits ADD CONSTRAINT FK_VISITS_DOCTOR_ID FOREIGN KEY (doctor_id) REFERENCES doctors (id);
ALTER TABLE visits ADD CONSTRAINT FK_VISITS_SPECIALITY_ID FOREIGN KEY (speciality_id) REFERENCES specialities (id);

INSERT INTO `drugs`(`name`) VALUES ('Paracétamol');
INSERT INTO `specialities` (name) VALUES ('Médecine Générale');
INSERT INTO `users`(`id`, `email`, `roles`, `password`, `firstname`, `lastname`) VALUES (1,'drHouse@soignemoi.com','["ROLE_DOCTOR"]','password','Doctor','House');
INSERT INTO `users`(`id`, `email`, `roles`, `password`, `firstname`, `lastname`) VALUES (2,'patient@soignemoi.com','["ROLE_PATIENT"]','password','John','Doe');
INSERT INTO `doctors`(`id`, `user_id`, `speciality_id`, `registration_number`) VALUES (1,1,1,123456789);
INSERT INTO `patients`(`id`, `user_id`, `address`) VALUES (1,2,'Mon adresse');
INSERT INTO `visits`(`id`, `patient_id`, `doctor_id`, `speciality_id`, `start_date`, `end_date`, `reason`) VALUES (1,1,1,1,'2024-04-14','2024-04-15','Opération');
INSERT INTO `schedule`(`id`, `doctor_id`, `patient_id`, `date_time_begin`, `date_time_end`) VALUES (1,1,1,'2024-04-15 09:00:00','2024-04-15 10:00:00')
INSERT INTO `prescription`(`id`, `user_id`, `doctor_id`, `start_date`, `end_date`) VALUES (1,1,1,'2024-04-15','2024-04-18')
INSERT INTO `opinions`(`id`, `prescription_id`, `title`, `date`, `description`) VALUES (1,1,'PostOp','2024-04-15','Patient en bonne forme');
INSERT INTO `medications`(`id`, `drug_id`, `prescription_id`, `dosage`) VALUES (1,1,1,' 2CP par jour')