<?php

include_once "config.php";

//ce fichier contient les fonctions génériques pour certaines opérations avec la base de donnée

function connectDB($which)
{
	$conn = new mysqli(DBHOST, DBS[$which]['DBuser'], DBS[$which]['password'],
		DBS[$which]['name']);

	// Check connection
	if ($conn->connect_error) {
		failedSql("Connection failed: " . $conn->connect_error);
	}
	$conn->query("SET NAMES UTF8");
	return $conn;
}

//make this check in the datbase its existence
function itemExists($whatID)
{
	$conn = connectDB('central');
	$query = "SELECT * FROM Articles WHERE ID='$whatID';";
	
	$result = $conn->query($query);
	
	$conn->close();

	return ($result->num_rows > 0);
}

//TODO
function orderByTri($tri)
{
	return "";
	//return " ORDER BY"....
}

function getAllItems($categ = DEFAULTCATEG, $tri = DEFAULTTRI)
{
	$rep = array();
	$query = "SELECT * FROM Articles";
	if ($categ !== 'all')
		$query .= " WHERE categorie='$categ'";
	
	$query .= orderByTri($tri);
	$query .= ';';


	$conn = connectDB('central');
	
	$result = $conn->query($query);

	$conn->close();

	while($row = $result->fetch_assoc()) {
		array_push($rep, $row);
	}

	return $rep;
}


// returns an array of items from the DB that have these IDs
// $IDs is an array of ids
function getFromIDs($IDs, $tri = DEFAULTTRI)
{
	if (empty($IDs))
		return array();

	$rep = array();
	$query = "SELECT * FROM Articles";

	$query .= " WHERE ";
	$IDarraykeys = array_keys($IDs);
	$lastKey = end($IDarraykeys);
	foreach ($IDs as $key => $elem)
	{	
		$query .= "ID='$elem'";
		if ($key !== $lastKey)
			$query .= " OR ";
	}

	$query .= orderByTri($tri);
	$query .= ';';


	$conn = connectDB('central');
	
	$result = $conn->query($query);

	$conn->close();

	while($row = $result->fetch_assoc()) {
		array_push($rep, $row);
	}

	return $rep;
}

function addInDB($table, $values, $db = 'central')
{
	$colNames = "";
	$valueslist = "";

	$allkeys = array_keys($values);
	$lastKey = end($allkeys);
	foreach ($values as $key => $i)
	{
		$colNames .= $key;
		$valueslist .= "'$i'";

		if ($key !== $lastKey)
		{
			$colNames .= ", ";
			$valueslist .= ", ";
		}
	}
	$query = "INSERT INTO $table ($colNames) VALUES ($valueslist);";

	$conn = connectDB($db);
	$result = $conn->query($query);
	$lastId = $conn->insert_id;
	$conn->close();
	return $lastId;
}

function updateInDb($table, $values, $where, $db = 'central')
{
	$conn = connectDB($db);

	$valueslist = "";
	$allkeys = array_keys($values);
	$lastKey = end($allkeys);
	foreach ($values as $key => $i)
	{
		$valueslist .= "$key='$i'";
		if ($key !== $lastKey)
			$valueslist .= ", ";
	}

	$query = "UPDATE $table SET $valueslist WHERE $where;";
	$result = $conn->query($query);
	$conn->close();
	return $result;
}

function addAddr($username, $addr)
{
	$addrId = getUserInfo($username, 'adress_id');

	$result = true;
	if ($addrId === NULL)
	{
		$adressId = addInDB('adresse', array(
			'adresse_ligne' => $addr['adresse_ligne'],
			'code_postal' => $addr['code_postal'],
			'telephone' => $addr['telephone'],
			'ville' => $addr['ville'],
			'pays' => $addr['pays']));
		$conn = connectDB('central');
		$query = "UPDATE users SET adress_id='$adressId' WHERE username='$username';";
		$result2 = $conn->query($query);
		$conn->close();
	}
	else
	{
		$result = updateInDb('adresse', array(
			'adresse_ligne' => $addr['adresse_ligne'],
			'code_postal' => $addr['code_postal'],
			'telephone' => $addr['telephone'],
			'ville' => $addr['ville'],
			'pays' => $addr['pays']), "ID='" . $addrId . "'");
	}

	return ($result === true && (!isset($result2) || $result2 === true));
}

// pretty much the previous function copypasted
function addCard($username, $card)
{
	$cardId = getUserInfo($username, 'bank_info_id', 'secure');

	$result = true;
	if ($cardId === NULL)
	{
		$cardId = addInDB('bank_info', array(
			'type_carte' => $card['type_carte'],
			'code_secur' => $card['code_secur'],
			'num_carte' => $card['num_carte'],
			'date_exp' => $card['date_exp'],
			'nom' => $card['nom']), 'secure');

		$conn = connectDB('secure');
		$query = "UPDATE users SET bank_info_id='$cardId' WHERE username='$username';";
		$result2 = $conn->query($query);
		$conn->close();
	}
	else
	{
		$result = updateInDb('bank_info', array(
			'type_carte' => $card['type_carte'],
			'num_carte' => $card['num_carte'],
			'nom' => $card['nom'],
			'date_exp' => $card['date_exp'],
			'code_secur' => $card['code_secur']), "ID='" . $cardId . "'", 'secure');
	}

	return ($result === true && (!isset($result2) || $result2 === true));
}

// all the parameters should be right, make sure to check wrong input before alling this function
function addUserCentral($username, $fullname, $email, $userstatus)
{
	$query = "INSERT INTO users (username, nom_complet, email, statut, est_verifie)
		VALUES ('$username', '$fullname', '$email', '$userstatus', '0');";

	$conn = connectDB('central');
	$result = $conn->query($query);
	
	$conn->close();

	return ($result === true);
}

function getUserInfo($username, $what, $db = 'central')
{
	$query = "SELECT * FROM users WHERE username='$username';";
	$conn = connectDB($db);

	$result = $conn->query($query);
	
	$conn->close();
	
	if ($result === false)
		return false;
	if ($what === false || $what === "TOUT")
		return $return->fetch_assoc();
	return $result->fetch_assoc()[$what];
}

function updateItemInfo($ID, $what, $value)
{
	$db = 'central';
	$query = "UPDATE Articles SET $what='$value' WHERE ID='$ID';";
	$conn = connectDB($db);

	$result = $conn->query($query);
	
	$conn->close();
	
	return ($result !== false);
}


function getAdress($username)
{
	$query = "SELECT adresse.* 
		FROM users, adresse
		WHERE username='$username' AND users.adress_id=adresse.ID;";

	$conn = connectDB('central');

	$result = $conn->query($query);

	$conn->close();

	if ($result->num_rows === 0)
		return false;
	return $result->fetch_assoc();
}

function getCB($username)
{
	$query = "SELECT bank_info.* 
		FROM users, bank_info
		WHERE username='$username' AND users.bank_info_id=bank_info.ID;";

	$conn = connectDB('secure');

	$result = $conn->query($query);

	$conn->close();

	if ($result->num_rows === 0)
		return false;
	return $result->fetch_assoc();
}


//récupérer les variations correspondant à un article en particulier
function getVariation($id){
	$query = "SELECT * 
		FROM variation
		WHERE article_id='$id';";

	$conn = connectDB('central');

	$result = $conn->query($query);

	$conn->close();

	$rep = array();
	while ($row = $result->fetch_assoc())
	{
		if (!isset($rep[$row['type']]))
			$rep[$row['type']] = array();
		array_push($rep[$row['type']], $row);
	}
	return $rep;
}

?>
