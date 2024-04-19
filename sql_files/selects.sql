SELECT
    Medicine_ID,
    Diagnosis_ID,
    Doctor.Doc_Photo_Url,
    CONCAT(Doctor.Doc_First_Name, ' ', Doctor.Doc_Last_Name) AS Doctor_Name,
    Medicine_Name,
    Medicine_Prescription,
    Treatment_Date
FROM Medicine JOIN Doctor ON Medicine.Doctor_ID = Doctor.Doctor_ID WHERE Medicine.Patient_ID = 3;

SELECT
    Patient.Patient_ID,
    Photo_Url,
    CONCAT(First_Name, ' ', Last_Name) AS Patient_Name,
    Birthday,
    Gender,
    Address,
    Phone,
    Email,
    Doctor.Doc_Photo_Url,
    CONCAT(Doctor.Doc_First_Name, ' ', Doctor.Doc_Last_Name) AS Doctor_Name
FROM Patient LEFT JOIN (SELECT DISTINCT Patient_ID, Doctor_ID FROM Reception) Reception ON Patient.Patient_ID = Reception.Patient_ID
    LEFT JOIN Doctor ON Reception.Doctor_ID = Doctor.Doctor_ID;

SELECT
    Patient.Patient_ID,
    Photo_Url,
    CONCAT(First_Name, ' ', Last_Name) AS Patient_Name,
    Birthday,
    Gender,
    Address,
    Phone,
    Email
FROM Patient JOIN (SELECT DISTINCT Patient_ID, Doctor_ID FROM Reception) Reception ON Patient.Patient_ID = Reception.Patient_ID
    JOIN Doctor ON Reception.Doctor_ID = Doctor.Doctor_ID WHERE Doctor.Doctor_ID = 1;

SELECT
    Medicine_ID,
    Diagnosis_ID,
    Patient.Photo_Url, CONCAT(Patient.First_Name, ' ', Patient.Last_Name) AS Patient_Name,
    Medicine_Name,
    Medicine_Prescription,
    Treatment_Date
FROM Medicine JOIN Patient ON Medicine.Patient_ID = Patient.Patient_ID WHERE Doctor_ID = 1;