<?php

//Api.php

class API
{
	function __construct()
	{
		$this->database_connection();
	}

	function database_connection()
	{
		$this->connect = new PDO("mysql:host=localhost;dbname=gacha", "root", "");
	}

	function fetch_all()
	{
		$query = "SELECT * FROM user ORDER BY id";
		$statement = $this->connect->prepare($query);
		if($statement->execute())
		{
			while($row = $statement->fetch(PDO::FETCH_ASSOC))
			{
				$data[] = $row;
			}
			return $data;
		}
	}

	function insert()
	{
		if(isset($_POST["name"]))
		{
			$form_data = array(
				":username"		=>	base64_encode($_POST["username"]),
				":password"		=>	base64_encode(password_hash($_POST["password"], PASSWORD_DEFAULT)),
				":name"			=>	base64_encode($_POST["name"]),
				":surname"		=>	base64_encode($_POST["surname"]),
				":email"		=>	base64_encode($_POST["email"]),
				":create_date"	=>  date("Y-m-d H:i:s")
			);
			$query = "INSERT INTO user (username, password, name, surname, email, create_date) VALUES (:username, :password, :name, :surname, :email, :create_date)";
			$statement = $this->connect->prepare($query);
			if($statement->execute($form_data))
			{
				$data[] = array(
					"success"	=>	"1"
				);
			}
			else
			{
				$data[] = array(
					"success"	=>	"0"
				);
			}
		}
		else
		{
			$data[] = array(
				"success"	=>	"0"
			);
		}
		return $data;
	}

	function fetch_single($id)
	{
		$query = "SELECT * FROM user WHERE id=\"".$id."\"";
		$statement = $this->connect->prepare($query);
		if($statement->execute())
		{
			foreach($statement->fetchAll() as $row)
			{
				$data["username"] = base64_decode($row["username"]);
				$data["password"] = base64_decode($row["password"]);
				$data["name"] = base64_decode($row["name"]);
				$data["surname"] = base64_decode($row["surname"]);
				$data["email"] = base64_decode($row["email"]);
			}
			return $data;
		}
	}

	function update()
	{
		if(isset($_POST["name"]))
		{
			$form_data = array(
				":username"		=>	base64_encode($_POST["username"]),
				":password"		=>	base64_encode(password_hash($_POST["password"], PASSWORD_DEFAULT)),
				":name"			=>	base64_encode($_POST["name"]),
				":surname"		=>	base64_encode($_POST["surname"]),
				":email"		=>	base64_encode($_POST["email"]),
				":update_date"	=>  date("Y-m-d H:i:s"),
				":id"			=>	$_POST["id"]
			);
			$query = " UPDATE user SET username = :username, password = :password, name = :name, surname = :surname, email = :email. update_date = :update_date WHERE id = :id ";
			$statement = $this->connect->prepare($query);
			if($statement->execute($form_data))
			{
				$data[] = array(
					"success"	=>	"1"
				);
			}
			else
			{
				$data[] = array(
					"success"	=>	"0"
				);
			}
		}
		else
		{
			$data[] = array(
				"success"	=>	"0"
			);
		}
		return $data;
	}
	function delete($id)
	{
		$query = "DELETE FROM user WHERE id = \"".$id."\"";
		$statement = $this->connect->prepare($query);
		if($statement->execute())
		{
			$data[] = array(
				"success"	=>	"1"
			);
		}
		else
		{
			$data[] = array(
				"success"	=>	"0"
			);
		}
		return $data;
	}
}

?>