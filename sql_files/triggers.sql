DELIMITER $$
CREATE TRIGGER `before_insert_reception` BEFORE INSERT ON `Reception`
    FOR EACH ROW
BEGIN
    DECLARE current_datetime DATETIME;
    DECLARE error_message VARCHAR(255);
    SET current_datetime = NOW();

    IF NEW.Rec_Date > DATE(current_datetime) OR NEW.Rec_Time > TIME(current_datetime) THEN
        SET error_message = 'Cannot insert a date or time in the future!';
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = error_message;
    END IF;
END$$
DELIMITER ;

DELIMITER $$
CREATE TRIGGER `before_update_reception` BEFORE UPDATE ON `Reception`
    FOR EACH ROW
BEGIN
    DECLARE current_datetime DATETIME;
    DECLARE error_message VARCHAR(255);
    SET current_datetime = NOW();

    IF NEW.Rec_Date > DATE(current_datetime) OR NEW.Rec_Time > TIME(current_datetime) THEN
        SET error_message = 'Cannot update to a date or time in the future!';
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = error_message;
    END IF;
END$$
DELIMITER ;

DELIMITER $$
CREATE TRIGGER `before_insert_diagnosis` BEFORE INSERT ON `Diagnosis`
    FOR EACH ROW
BEGIN
    DECLARE current_datetime DATETIME;
    DECLARE error_message VARCHAR(255);
    SET current_datetime = NOW();

    IF NEW.Diagnosis_Date > DATE(current_datetime) THEN
        SET error_message = 'Cannot insert a date in the future!';
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = error_message;
    END IF;
END$$
DELIMITER ;

DELIMITER $$
CREATE TRIGGER `before_update_diagnosis` BEFORE UPDATE ON `Diagnosis`
    FOR EACH ROW
BEGIN
    DECLARE current_datetime DATETIME;
    DECLARE error_message VARCHAR(255);
    SET current_datetime = NOW();

    IF NEW.Diagnosis_Date > DATE(current_datetime) THEN
        SET error_message = 'Cannot insert a date in the future!';
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = error_message;
    END IF;
END$$
DELIMITER ;

DELIMITER $$
CREATE TRIGGER `before_insert_medicine` BEFORE INSERT ON `Medicine`
    FOR EACH ROW
BEGIN
    DECLARE current_datetime DATETIME;
    DECLARE error_message VARCHAR(255);
    SET current_datetime = NOW();

    IF NEW.Treatment_Date > DATE(current_datetime) THEN
        SET error_message = 'Cannot insert a date in the future!';
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = error_message;
    END IF;
END$$

DELIMITER $$
CREATE TRIGGER `before_update_medicine` BEFORE UPDATE ON `Medicine`
    FOR EACH ROW
BEGIN
    DECLARE current_datetime DATETIME;
    DECLARE error_message VARCHAR(255);
    SET current_datetime = NOW();

    IF NEW.Treatment_Date > DATE(current_datetime) THEN
        SET error_message = 'Cannot insert a date in the future!';
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = error_message;
    END IF;
END$$