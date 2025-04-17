CREATE DATABASE IF NOT EXISTS pet_adoption;
USE pet_adoption;

-- 1. Adoption Centers
CREATE TABLE adopt_center (
    centre_id INT PRIMARY KEY AUTO_INCREMENT,
    shop_no VARCHAR(255),
    name VARCHAR(255),
    address VARCHAR(255),
    email_id VARCHAR(255) UNIQUE,
    password VARCHAR(255)
);

-- 2. Pet List
CREATE TABLE pet_list (
    pet_id INT PRIMARY KEY AUTO_INCREMENT,
    centre_id INT,
    pet_name VARCHAR(255),
    pet_gender VARCHAR(10),
    pet_breed VARCHAR(255),
    pet_age INT,
    is_adopted BOOLEAN DEFAULT 0,
    FOREIGN KEY (centre_id) REFERENCES adopt_center(centre_id) ON DELETE CASCADE
);

-- 3. Pet Adoption
CREATE TABLE pet_adoption (
    adoption_id INT PRIMARY KEY AUTO_INCREMENT,
    pet_id INT,
    reason_of_adoption TEXT,
    date DATE,
    house_hold VARCHAR(255),
    FOREIGN KEY (pet_id) REFERENCES pet_list(pet_id) ON DELETE CASCADE
);

-- 4. Donation Fee
CREATE TABLE donate_fee (
    donation_id INT PRIMARY KEY AUTO_INCREMENT,
    adoption_id INT,
    date DATE,
    amount DECIMAL(10, 2),
    buyer_info VARCHAR(255),
    FOREIGN KEY (adoption_id) REFERENCES pet_adoption(adoption_id) ON DELETE CASCADE
);

-- 5. Rehoming
CREATE TABLE rehoming (
    rpet_id INT PRIMARY KEY AUTO_INCREMENT,
    donation_id INT,
    rpet_name VARCHAR(255),
    rpet_breed VARCHAR(255),
    rpet_age INT,
    FOREIGN KEY (donation_id) REFERENCES donate_fee(donation_id) ON DELETE CASCADE
);

-- 6. Pet With Center (Multiple availability)
CREATE TABLE pet_with_center (
    pet_id INT,
    centre_id INT,
    PRIMARY KEY (pet_id, centre_id),
    FOREIGN KEY (pet_id) REFERENCES pet_list(pet_id) ON DELETE CASCADE,
    FOREIGN KEY (centre_id) REFERENCES adopt_center(centre_id) ON DELETE CASCADE
);

-- 7. Deleted Pets Log
CREATE TABLE deleted_pets (
    pet_id INT PRIMARY KEY,
    pet_name VARCHAR(255),
    deleted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 8. Pet Log (Optional full log for actions)
CREATE TABLE pet_log (
    log_id INT PRIMARY KEY AUTO_INCREMENT,
    pet_id INT,
    action VARCHAR(255),
    action_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    description TEXT,
    FOREIGN KEY (pet_id) REFERENCES pet_list(pet_id) ON DELETE CASCADE
);

-- 9. Young Pets View (only those under certain age)
CREATE VIEW young_pets AS
SELECT * FROM pet_list
WHERE pet_age <= 2;
