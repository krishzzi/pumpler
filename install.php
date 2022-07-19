<?php

class Database {


	/**
	 * @var PDO
	 */
	private $pdo;

	public function __construct()
	{

		$db = "pump";
		$dbDsn = "mysql:host=localhost;port=3306;dbname=".$db;
		$this->pdo = new PDO($dbDsn, 'root', '');
		$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}


	public function run(string $statement)
	{
		return $this->pdo->exec($statement);
	}




}


// Tables Details

	$query = [

		"CREATE TABLE IF NOT EXISTS users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            title VARCHAR(255) NULL,
    		email VARCHAR(255) NULL,
    		mobile VARCHAR(25) NULL,
    		vehicle_no VARCHAR(255) NOT NULL,
    		vehicle_type VARCHAR(255) NULL,
    		password VARCHAR(255) NOT NULL,
    		role VARCHAR(255) DEFAULT 'customer',
    		status BOOLEAN DEFAULT true,
    		is_admin BOOLEAN DEFAULT false,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )  ENGINE=INNODB;",


		"CREATE TABLE IF NOT EXISTS access_tokens (
            id INT AUTO_INCREMENT PRIMARY KEY,
            token VARCHAR(255),
    		user_id INT(11),
    		last_used_at TIMESTAMP NULL,
    		expire_at TIMESTAMP NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )  ENGINE=INNODB;",

		"ALTER TABLE `access_tokens` ADD CONSTRAINT `user_id` FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE ON UPDATE CASCADE;",


		"CREATE TABLE IF NOT EXISTS categories (
            id INT AUTO_INCREMENT PRIMARY KEY,
            title VARCHAR(255),
    		description VARCHAR(255) ,
    		status BOOLEAN DEFAULT true,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )  ENGINE=INNODB;",

		"CREATE TABLE IF NOT EXISTS products (
            id INT AUTO_INCREMENT PRIMARY KEY,
            title VARCHAR(255),
    		quantity INT(11),
    		price INT(11),
    		status BOOLEAN DEFAULT true,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )  ENGINE=INNODB;",

		"CREATE TABLE IF NOT EXISTS product_categories (
            category_id INT(11),
    		product_id INT(11)
        )  ENGINE=INNODB;",

		"ALTER TABLE `product_categories` ADD CONSTRAINT `category_id` FOREIGN KEY (`category_id`) REFERENCES `categories`(`id`) ON DELETE CASCADE ON UPDATE CASCADE; ALTER TABLE `product_categories` ADD CONSTRAINT `product_id` FOREIGN KEY (`product_id`) REFERENCES `products`(`id`) ON DELETE CASCADE ON UPDATE CASCADE;",


		"CREATE TABLE IF NOT EXISTS pumps (
            id INT AUTO_INCREMENT PRIMARY KEY,
            title VARCHAR(255),
    		address INT(11),
    		status BOOLEAN DEFAULT true,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )  ENGINE=INNODB;",

		"CREATE TABLE IF NOT EXISTS user_pumps (
            pump_id INT(11),
    		user_id INT(11),
    		duty_from TIMESTAMP NULL,
    		duty_to TIMESTAMP NULL
        )  ENGINE=INNODB;",


//		"ALTER TABLE `user_pumps` ADD CONSTRAINT `user_id` FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE ON UPDATE CASCADE; ALTER TABLE `user_pumps` ADD CONSTRAINT `pump_id` FOREIGN KEY (`pump_id`) REFERENCES `pumps`(`id`) ON DELETE CASCADE ON UPDATE CASCADE;",
//
//		"CREATE TABLE IF NOT EXISTS user_products (
//            product_id INT(11),
//    		user_id INT(11)
//        )  ENGINE=INNODB;",

//		"ALTER TABLE `user_products` ADD CONSTRAINT `user_id` FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE ON UPDATE CASCADE; ALTER TABLE `user_products` ADD CONSTRAINT `product_id` FOREIGN KEY (`product_id`) REFERENCES `products`(`id`) ON DELETE CASCADE ON UPDATE CASCADE;",
//








	];


//ALTER TABLE `posts` ADD CONSTRAINT `user_id` FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE ON UPDATE CASCADE;




//Run

$db = new Database();


foreach ($query as $statement)
{
	$db->run($statement);
}
