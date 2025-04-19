-- Disable foreign key checks to allow truncating in any order
SET FOREIGN_KEY_CHECKS = 0;

-- Truncate child tables first to avoid FK constraint errors
TRUNCATE TABLE pet_log;
TRUNCATE TABLE deleted_pets;
TRUNCATE TABLE rehoming;
TRUNCATE TABLE donate_fee;
TRUNCATE TABLE pet_adoption;
TRUNCATE TABLE pet_with_center;
TRUNCATE TABLE pet_list;
TRUNCATE TABLE adopt_center;

-- Reset auto-increment values
ALTER TABLE adopt_center AUTO_INCREMENT = 1;
ALTER TABLE pet_list AUTO_INCREMENT = 1;
ALTER TABLE pet_adoption AUTO_INCREMENT = 1;
ALTER TABLE donate_fee AUTO_INCREMENT = 1;
ALTER TABLE rehoming AUTO_INCREMENT = 1;
ALTER TABLE pet_log AUTO_INCREMENT = 1;

-- Re-enable foreign key checks
SET FOREIGN_KEY_CHECKS = 1;
