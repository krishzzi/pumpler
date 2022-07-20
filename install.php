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

        public function getPDO()
        {
            return $this->pdo;
        }


        public function msg(string $msg_text)
        {
            echo "\e[35m[Tinkle]: " . $msg_text."\e[0m" . PHP_EOL;
        }




    }


    // Tables Details

    $querylist = [

            'users' => "CREATE TABLE IF NOT EXISTS users (
                id INT AUTO_INCREMENT PRIMARY KEY,
                parent_id INT(11) NULL,
                username VARCHAR(255) NULL,
                email VARCHAR(255) NULL,
                mobile VARCHAR(25) NOT NULL,
                password VARCHAR(255) NOT NULL,
                avatar VARCHAR(255) NULL,
                gender VARCHAR(255) NULL,
                education VARCHAR(255) NULL,
                address VARCHAR(255) NULL,
                driving_lic VARCHAR(25) NULL,
                vehicle_number VARCHAR(255) NULL,
                has_role VARCHAR(255) DEFAULT 'customer',
                status BOOLEAN DEFAULT true,
                is_admin BOOLEAN DEFAULT false,
                email_verified_at TIMESTAMP NULL,
                mobile_verified_at TIMESTAMP NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )  ENGINE=INNODB;",


            'access_tokens' => "CREATE TABLE IF NOT EXISTS access_tokens (
                id INT AUTO_INCREMENT PRIMARY KEY,
                token VARCHAR(255),
                user_id INT(11) NULL,
                vehicle_id INT(11) NULL,
                last_used_at TIMESTAMP NULL,
                expire_at TIMESTAMP NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )  ENGINE=INNODB;",


            'vehicles' => "CREATE TABLE IF NOT EXISTS vehicles (
                id INT AUTO_INCREMENT PRIMARY KEY,
                user_id INT(11) NULL,
                category_id INT(11) DEFAULT 1,
                vehicle_number VARCHAR(255) NOT NULL,
                password VARCHAR(255) NOT NULL,
                vehicle_type VARCHAR(255) NULL,
                banner VARCHAR(255) NULL,
                status BOOLEAN DEFAULT true,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )  ENGINE=INNODB;",



            'categories' => "CREATE TABLE IF NOT EXISTS categories (
                id INT AUTO_INCREMENT PRIMARY KEY,
                parent_id INT(11) NULL,
                title VARCHAR(255),
                description VARCHAR(255) ,
                banner VARCHAR(255),
                reward_value INT(11) NULL,
                status BOOLEAN DEFAULT true,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )  ENGINE=INNODB;",


            'nozzles' => "CREATE TABLE IF NOT EXISTS nozzles (
                id INT AUTO_INCREMENT PRIMARY KEY,
                title VARCHAR(255),
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )  ENGINE=INNODB;",




            'fuels' => "CREATE TABLE IF NOT EXISTS fuels (
                id INT AUTO_INCREMENT PRIMARY KEY,
                title VARCHAR(255),
                provider VARCHAR(255) NULL,
                oil_type VARCHAR(255),
                banner VARCHAR(255),
                quantity INT(11),
                price INT(11),
                reward_value INT(11) NULL,
                status BOOLEAN DEFAULT true,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )  ENGINE=INNODB;",



            'gifts' => "CREATE TABLE IF NOT EXISTS gifts (
                id INT AUTO_INCREMENT PRIMARY KEY,
                title VARCHAR(255),
                provider VARCHAR(255) NULL ,
                category_id INT(11),
                banner VARCHAR(255),
                quantity INT(11),
                price INT(11),
                reward_value INT(11) NULL,
                status BOOLEAN DEFAULT true,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )  ENGINE=INNODB;",



            'foods' => "CREATE TABLE IF NOT EXISTS foods (
                id INT AUTO_INCREMENT PRIMARY KEY,
                title VARCHAR(255),
                provider VARCHAR(255) NULL ,
                category_id INT(11),
                banner VARCHAR(255),
                quantity INT(11),
                price INT(11),
                reward_value INT(11) NULL,
                status BOOLEAN DEFAULT true,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )  ENGINE=INNODB;",




            'notifications' => "CREATE TABLE IF NOT EXISTS notifications (
                id INT AUTO_INCREMENT PRIMARY KEY,
                subject VARCHAR(255),
                description VARCHAR(255),
                user_id INT(11) NULL,
                has_seen BOOLEAN DEFAULT true,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )  ENGINE=INNODB;",



            'user_rewards' => "CREATE TABLE IF NOT EXISTS user_rewards (
                id INT AUTO_INCREMENT PRIMARY KEY,
                user_id INT(11),
                vehicle_number VARCHAR (255) NULL,
                reward_point INT(11),
                action_type VARCHAR (255) NULL,
                details VARCHAR (512) NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )  ENGINE=INNODB;",


            'user_schedule' => "CREATE TABLE IF NOT EXISTS user_schedule (
                id INT AUTO_INCREMENT PRIMARY KEY,
                nozzle_id INT(11),
                user_id INT(11),
                shift VARCHAR(255),
                status BOOLEAN DEFAULT false,
                join_at TIMESTAMP NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )  ENGINE=INNODB;",



            'user_fuels' => "CREATE TABLE IF NOT EXISTS user_fuels (
                id INT AUTO_INCREMENT PRIMARY KEY,
                user_id INT(11),
                fuel_id INT(11),
                vehicle_id INT(11),
                nozzle_id INT(11) NULL,
                quantity INT(11),
                price INT(11),
                discount INT(11) NULL,
                amount INT(11),
                use_reward BOOLEAN DEFAULT false,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )  ENGINE=INNODB;",


            'user_gifts' => "CREATE TABLE IF NOT EXISTS user_gifts (
                id INT AUTO_INCREMENT PRIMARY KEY,
                user_id INT(11),
                gift_id INT(11),
                quantity INT(11),
                price INT(11),
                discount INT(11) NULL,
                amount INT(11),
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )  ENGINE=INNODB;",



            'user_foods' => "CREATE TABLE IF NOT EXISTS user_foods (
                id INT AUTO_INCREMENT PRIMARY KEY,
                user_id INT(11),
                food_id INT(11),
                quantity INT(11),
                price INT(11),
                discount INT(11) NULL,
                amount INT(11),
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )  ENGINE=INNODB;",


            'master' => "CREATE TABLE IF NOT EXISTS master (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    web_banner VARCHAR(255) NULL,
                    mobo_seller_banner VARCHAR(255) NULL,
                    mobo_customer_banner VARCHAR(255) NULL,
                    status BOOLEAN DEFAULT true,
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                )  ENGINE=INNODB;",








        ];




    //Run Installer


    $db = new Database();
    $db->msg("Installation Started");
    $db->msg("+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++");
    $db->msg("+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++");
    sleep(1);




    /**
     * Drop All Tables
     */
    $db->msg("Refresh Database");
    $db->run("SET FOREIGN_KEY_CHECKS=0");
    // looping through $querylist
    foreach ($querylist as $key => $statement)
    {
        $query = "DROP TABLE IF EXISTS ".$key;
        $db->run($query);
        $db->msg(" $key    __remove from database");
    }


    // Migration
    $db->msg("Migration Started");
    sleep(1);
    foreach ($querylist as $key => $statement)
    {
        $db->run($statement);
        $db->msg(" $key    __migrating into database");

    }
    $db->msg("Migration Complete");
    sleep(2);
    // Seed
    $db->msg("Check For Seeders");

    $pdo = $db->getPDO();
    sleep(2);

    //Create Admin
    $sql = "INSERT INTO `users` (`id`, `username`, `email`, `mobile`, `vehicle_number`, `password`, `has_role`, `status`, `is_admin`, `email_verified_at`, `mobile_verified_at`, `gender`, `address`, `created_at`, `updated_at`) VALUES (NULL, 'admin', 'admin@example.com', '9900990010', 'WB4560', '".trim('$2y$10$R2cfrBPHjduUXZQDVK5JnOOup6Jfs6D0.PB4lENgUPq5e6fp69paK')."', 'customer', '1', '1', '', NULL, 'male', 'kolkata', current_timestamp(), current_timestamp());";
    $query = $pdo->exec($sql);
    $db->msg("+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++");
    $db->msg("+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++");
    $db->msg("Super Administrator Created");
    sleep(1);
    $db->msg("Now you can login with \n url : domain/admin/login  \n mobile : 90090010 \n password : admin123 ");
    $db->msg("+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++");
    $db->msg("+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++");


    $sql = "INSERT INTO `categories` (`id`, `parent_id`, `title`, `description`, `banner`, `reward_value`, `status`, `created_at`, `updated_at`) VALUES (NULL, NULL , 'untitled', 'untitled category description', NULL, 0 , 1, current_timestamp(), current_timestamp());";
    $query = $pdo->exec($sql);


    $sql = "INSERT INTO `fuels` (`id`, `title`, `provider`, `oil_type`, `banner`, `quantity`, `price`, `reward_value`, `status`, `created_at`, `updated_at`) VALUES (NULL, 'Petrol', 'afa', 'petrol', 'demo.jpg', '100', '110', '2', '1', current_timestamp(), current_timestamp());";
    $query = $pdo->exec($sql);

    $sql = "INSERT INTO `foods` (`id`, `title`, `provider`, `category_id`, `banner`, `quantity`, `price`, `reward_value`, `status`, `created_at`, `updated_at`) VALUES (NULL, 'Biriyani', 'afa', 1, 'demo.jpg', '100', '110', '2', '1', current_timestamp(), current_timestamp());";
    $query = $pdo->exec($sql);

    $sql = "INSERT INTO `gifts` (`id`, `title`, `provider`, `category_id`, `banner`, `quantity`, `price`, `reward_value`, `status`, `created_at`, `updated_at`) VALUES (NULL, 'BleBlade', 'afa', 1, 'demo.jpg', '100', '110', '2', '1', current_timestamp(), current_timestamp());";
    $query = $pdo->exec($sql);

    $sql = "INSERT INTO `nozzles` (`id`, `title`, `created_at`, `updated_at`) VALUES (NULL,'Nozzle-A', current_timestamp(), current_timestamp());";
    $query = $pdo->exec($sql);

    $sql = "INSERT INTO `nozzles` (`id`, `title`, `created_at`, `updated_at`) VALUES (NULL,'Nozzle-B', current_timestamp(), current_timestamp());";
    $query = $pdo->exec($sql);

    $sql = "INSERT INTO `nozzles` (`id`, `title`, `created_at`, `updated_at`) VALUES (NULL,'Nozzle-C', current_timestamp(), current_timestamp());";
    $query = $pdo->exec($sql);






    sleep(2);
    $db->msg("Re Cache Everything");
    $db->msg("Thanks for choosing me/us..");
    $db->run("SET FOREIGN_KEY_CHECKS=1");
    $db->run("SET GLOBAL FOREIGN_KEY_CHECKS=1");
    sleep(2);
    $db->msg("Installation Finish");



