CREATE TABLE voters (
    id INT(11) NOT NULL AUTO_INCREMENT COMMENT "unique voter ID",
    user_name VARCHAR(255) NOT NULL COMMENT "voter name",
    candidate ENUM('Hillary Clinton', 'Donald Trump') NOT NULL COMMENT 'candidate being voted for',
    inserted_at TIMESTAMP NOT NULL COMMENT "time vote was recorded",
    PRIMARY KEY (`id`) 
);
