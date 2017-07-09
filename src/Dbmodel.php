<?php
/**
 * Dbmodel class
 * Defines all DB operations
 * 
 * @package src
 * @version 1.0.0
 */

class Dbmodel {
	public $conn;

	/*
	 * Purpose: Create DB PDO object
	 */
	private function connectDB() {
		$configObj = new Config();
		$settings = $configObj->getAllConfig();
		try {
			$this->conn = new PDO("mysql:host={$settings['DB_HOST']};dbname={$settings['DB_NAME']}", $settings['DB_USERNAME'], $settings['DB_PASSWORD']);
			$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
		catch(PDOException $e) {
			echo "Error: " . $e->getMessage();
		}
	}

	/*
	 * Purpose: Get database connection
	 */
	public function getDBConn() {
		$this->connectDB();
		return $this->conn;
	}

	/*
	 * Purpose: Save User details in database
	 */
	public function saveUser($data) {
		$this->connectDB();
		$stmt = $this->conn->prepare("INSERT into users (fb_id, first_name, last_name, is_active, access_token) VALUES (:fb_id, :first_name, :last_name, :is_active, :access_token)");
		$stmt->bindParam(':fb_id', $data['fb_id']);
		$stmt->bindParam(':first_name', $data['first_name']);
		$stmt->bindParam(':last_name', $data['last_name']);
		$stmt->bindParam(':is_active', $data['is_active']);
		$stmt->bindParam(':access_token', $data['access_token']);
		$stmt->execute();
		return $this->conn->lastInsertId();
	}

	/*
	 * Purpose: get user's data from DB
	 */
	public function getUser($fbId = 0) {
		$this->connectDB();
		$stmt = $this->conn->prepare("SELECT id FROM users where fb_id = :fbId");
		$stmt->bindParam(':fbId', $fbId);
		$stmt->execute();
		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		$res = $stmt->fetch();
		return $res;
	}

	/*
	 * Purpose: Update user data in database
	 */
	public function updateUser($data = array(), $deauth = 0) {
		if(sizeof($data)) {
			$this->connectDB();
			if(!$deauth) {
				$stmt = $this->conn->prepare("UPDATE users set first_name = :fname, last_name = :lname, access_token = :access_token where fb_id = :fbId");
				$stmt->bindParam(':fname', $data['first_name']);
				$stmt->bindParam(':lname', $data['last_name']);
				$stmt->bindParam(':access_token', $data['access_token']);
			} else {
				$stmt = $this->conn->prepare("UPDATE users set is_active = :is_active where fb_id = :fbId");
				$stmt->bindParam(':is_active', $data['is_active']);
			}
			$stmt->bindParam(':fbId', $data['fb_id']);
			$stmt->execute();
		}
		return false;
	}
}