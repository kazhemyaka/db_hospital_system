INSERT INTO Patient (First_Name, Last_Name, Photo_Url, Birthday, Gender, Address, Phone, Email, Password)
VALUES ('Alejandro', 'Nunez', '../photos_of_users/alejandro.jpeg', '1998-12-12', 'Male', '123 Main St, City', '+380502342341', 'alejandro@example.com', SHA2('alejandro1234', 256));
INSERT INTO Patient (First_Name, Last_Name, Photo_Url, Birthday, Gender, Address, Phone, Email, Password)
VALUES ('Jane', 'Smith', '../photos_of_users/jane.jpg', '1985-08-15', 'Female', '456 Elm St, City', '+380983784585', 'jane.smith@example.com', SHA2('jane1234', 256));
INSERT INTO Patient (First_Name, Last_Name, Photo_Url, Birthday, Gender, Address, Phone, Email, Password)
VALUES ('Michael', 'Johnson', '../photos_of_users/michael.webp', '1978-03-22', 'Male', '789 Oak St, City', '+380439583409', 'michael.johnson@example.com', SHA2('michael1234', 256));
INSERT INTO Patient (First_Name, Last_Name, Photo_Url, Birthday, Gender, Address, Phone, Email, Password)
VALUES ('Emily', 'Davis', '../photos_of_users/emily.jpeg', '1992-11-28', 'Female', '321 Pine St, City', '+380234829545', 'emily.davis@example.com', SHA2('emily1234', 256));
INSERT INTO Patient (First_Name, Last_Name, Photo_Url, Birthday, Gender, Address, Phone, Email, Password)
VALUES ('David', 'Anderson', '../photos_of_users/david.jpeg', '1980-07-18', 'Male', '654 Cedar St, City', '+380490358353', 'david.anderson@example.com', SHA2('david1234', 256));

SELECT * FROM Patient;