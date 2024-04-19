INSERT INTO Doctor (Doc_First_Name, Doc_Last_Name, Doc_Photo_Url, Speciality, Doc_Phone, Doc_Email, Doc_Password)
VALUES ('John', 'Doe', '../photos_of_users/john.jpeg', 'General', '+380502342344', 'john@example.com', SHA2('john1234', 256));
INSERT INTO Doctor (Doc_First_Name, Doc_Last_Name, Doc_Photo_Url, Speciality, Doc_Phone, Doc_Email, Doc_Password)
VALUES ('Kate', 'Smith', '../photos_of_users/kate.jpg', 'Dentist', '+380682340935', 'kate@example.com', SHA2('kate1234', 256));
INSERT INTO Doctor (Doc_First_Name, Doc_Last_Name, Doc_Photo_Url, Speciality, Doc_Phone, Doc_Email, Doc_Password)
VALUES ('Mike', 'Johnson', '../photos_of_users/mike.jpg', 'Dermatologist', '+380980987897', 'mike@example.com', SHA2('mike1234', 256));
INSERT INTO Doctor (Doc_First_Name, Doc_Last_Name, Doc_Photo_Url, Speciality, Doc_Phone, Doc_Email, Doc_Password)
VALUES ('Lora', 'Williams', '../photos_of_users/lora.jpg', 'Cardiologist', '+380345848540', 'lora@example.com', SHA2('lora1234', 256));
INSERT INTO Doctor (Doc_First_Name, Doc_Last_Name, Doc_Photo_Url, Speciality, Doc_Phone, Doc_Email, Doc_Password)
VALUES ('Alex', 'Brown', '../photos_of_users/alex.jpeg', 'Neurologist', '+380345848540', 'alex@example.com', SHA2('alex1234', 256));

SELECT * FROM Doctor;