CREATE DATABASE IF NOT EXISTS pet_adoption_system;
USE pet_adoption_system;

-- 1. Adoption Centers
CREATE TABLE Adopt_Center (
    Centre_id INT PRIMARY KEY AUTO_INCREMENT,
    Shop_no VARCHAR(255),
    Name VARCHAR(255),
    Address VARCHAR(255),
    email_id VARCHAR(255) UNIQUE,
    password VARCHAR(255)
);

-- 2. Pets
CREATE TABLE Pet_List (
    pet_id INT PRIMARY KEY AUTO_INCREMENT,
    Centre_id INT,
    pet_name VARCHAR(255),
    pet_gender VARCHAR(10),
    pet_breed VARCHAR(255),
    pet_age INT,
    is_adopted BOOLEAN DEFAULT 0,
    FOREIGN KEY (Centre_id) REFERENCES Adopt_Center(Centre_id) ON DELETE CASCADE
);

-- 3. Pet Adoptions
CREATE TABLE Pet_Adoption (
    adoption_id INT PRIMARY KEY AUTO_INCREMENT,
    pet_id INT,
    Reason_of_adoption TEXT,
    date DATE,
    house_hold VARCHAR(255),
    FOREIGN KEY (pet_id) REFERENCES Pet_List(pet_id) ON DELETE CASCADE
);

-- 4. Donation Fees
CREATE TABLE Donate_Fee (
    Donation_id INT PRIMARY KEY AUTO_INCREMENT,
    adoption_id INT,
    Date DATE,
    Amount DECIMAL(10, 2),
    Buyer_info VARCHAR(255),
    FOREIGN KEY (adoption_id) REFERENCES Pet_Adoption(adoption_id) ON DELETE CASCADE
);

-- 5. Rehoming
CREATE TABLE Rehoming (
    Rpet_id INT PRIMARY KEY AUTO_INCREMENT,
    donation_id INT,
    Rpet_name VARCHAR(255),
    Rpet_Breed VARCHAR(255),
    Rpet_age INT,
    FOREIGN KEY (donation_id) REFERENCES Donate_Fee(Donation_id) ON DELETE CASCADE
);

-- 6. Pets available at multiple centers
CREATE TABLE Available_For (
    pet_id INT,
    Centre_id INT,
    PRIMARY KEY (pet_id, Centre_id),
    FOREIGN KEY (pet_id) REFERENCES Pet_List(pet_id) ON DELETE CASCADE,
    FOREIGN KEY (Centre_id) REFERENCES Adopt_Center(Centre_id) ON DELETE CASCADE
);

-- 7. General Donations
CREATE TABLE donations (
    donation_id INT PRIMARY KEY AUTO_INCREMENT,
    donor_name VARCHAR(255),
    donor_email VARCHAR(255),
    amount DECIMAL(10, 2),
    donation_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
