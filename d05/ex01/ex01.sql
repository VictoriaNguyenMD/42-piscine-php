CREATE TABLE ft_table (
	`id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	`login` VARCHAR(255) NOT NULL DEFAULT 'toto',
	`group`	ENUM('staff', 'student', 'other') NOT NULL,
	`creation_date` DATE NOT NULL
);
