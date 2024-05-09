<?php
class Database
{
	private $dbtype = DB_TYPE;
	private $dbhost = DB_HOST;
	private $dbuser = DB_USER;
	private $dbpass = DB_PASS;
	private $dbname = DB_NAME;
	private $charset = DB_CHARSET;

	private $conn;
	private $stmt;

	public function __construct()
	{
		$dsn = $this->dbtype . ':host=' . $this->dbhost . ';dbname=' . $this->dbname . ';charset=' . $this->charset;

		$opt = [
			PDO::ATTR_PERSISTENT => true,
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
		];

		try {
			$this->conn = new PDO($dsn, $this->dbuser, $this->dbpass, $opt);
		} catch (PDOException $err) {
			die("Connection failed: " . $err->getMessage());
		}
	}

	public function query($qry) {
		$this->stmt = $this->conn->prepare($qry);
	}

	public function bind($param, $value, $type=null) {
		if (is_null($type)) {
			switch (true) {
				case is_int($value):
					$type = PDO::PARAM_INT;
					break;
				case is_bool($value):
					$type = PDO::PARAM_BOOL;
					break;
				case is_null($value):
					$type = PDO::PARAM_NULL;
					break;
				default:
					$type = PDO::PARAM_STR;
			}
		}

		$this->stmt->bindValue($param, $value, $type);
	}

	public function execute() {
		$this->stmt->execute();
	}

	public function resultSet() {
		$this->execute();
		return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	public function single()
	{
		$this->execute();
		return $this->stmt->fetch(PDO::FETCH_ASSOC);
	}

	public function rowCount()
	{
		return $this->stmt->rowCount();
	}

	public function quote($string)
	{
		return $this->conn->quote($string);
	}
}