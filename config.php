<?php
	function connect(){
		$db_host = "fdb30.awardspace.net";
		$db_user = "3632228_exbd";
		$db_name = "3632228_exbd";
		$db_password = "@ExBD123456";

		$dsn = "mysql:host=$db_host;dbname=$db_name;charset=utf8mb4";

		$options = [
			PDO::ATTR_EMULATE_PREPARES   => false,
			PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
			PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
		];


		try {
			$pdo = new PDO($dsn, $db_user, $db_password, $options);
			return $pdo;
		}
		catch (Exception $e) {
			exit('Falha na conexão com o MySql: '. $e->getMessage());
		}
	}
?>