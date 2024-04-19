CREATE USER 'doctor'@'localhost' IDENTIFIED BY 'doctorpassword';
GRANT SELECT, INSERT, UPDATE, DELETE ON `hospital`.`Patient` TO 'doctor'@'localhost';
GRANT SELECT, INSERT, UPDATE, DELETE ON `hospital`.`Reception` TO 'doctor'@'localhost';
GRANT SELECT, INSERT, UPDATE, DELETE ON `hospital`.`Diagnosis` TO 'doctor'@'localhost';
GRANT SELECT, INSERT, UPDATE, DELETE ON `hospital`.`Medicine` TO 'doctor'@'localhost';
GRANT SELECT, UPDATE ON `hospital`.`Doctor` TO 'doctor'@'localhost';

CREATE USER 'patient'@'localhost' IDENTIFIED BY 'patientpassword';
GRANT SELECT ON `hospital`.`Diagnosis` TO 'patient'@'localhost';
GRANT SELECT ON `hospital`.`Medicine` TO 'patient'@'localhost';
GRANT SELECT ON `hospital`.`Reception` TO 'patient'@'localhost';
GRANT SELECT, UPDATE ON `hospital`.`Patient` TO 'patient'@'localhost';
GRANT SELECT ON `hospital`.`Doctor` TO 'patient'@'localhost';

FLUSH PRIVILEGES;
