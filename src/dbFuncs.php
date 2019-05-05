<?php

include_once "config.php";

//ce fichier contient les fonctions génériques pour certaines opérations avec la base de donnée

// initializes a connection to the database $which
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

// returns whether an item with this ID exists
function itemExists($whatID)
{
	$conn = connectDB('central');
	$query = "SELECT * FROM Articles WHERE ID='$whatID';";
	
	$result = $conn->query($query);
	
	$conn->close();

	return ($result->num_rows > 0);
}

// returns the string to be used to order the SQL query results
function orderByTri($tri = "prix-up")
{
	if (empty($tri))
		return "";
	$tritab = explode('-', $tri);
	$rep = " ORDER BY " . $tritab[0];
	if ($tritab[1] === 'up')
		$rep .= " DESC";
	else
		$rep .= " ASC";
	return $rep;
}

function getAllItems($filtrer, $tri = DEFAULTTRI)
{
	$rep = array();
	$query = "SELECT * FROM Articles WHERE 1";
	if ($filtrer[0] !== 'all')
		$query .= " AND categorie='$filtrer[0]'";

	if ($filtrer[1] !== 'ttt')
		$query .= " AND date_ajout> ADDDATE(NOW(), INTERVAL -'$filtrer[1]' MONTH)";

	if ($filtrer[2] > 0)
		$query .= " AND prix<'$filtrer[2]'";

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

// deletes those rows in $table, where the values match the column the database
function delInDB($table, $colName, $values, $db = 'central')
{
	if (empty($colName) || empty($values) || empty($table))
		return false;
	$valuesRestrict = "";

	$allkeys = array_keys($values);
	$lastKey = end($allkeys);
	foreach ($values as $key => $i)
	{
		$valuesRestrict .= "$colName='$i'";

		if ($key !== $lastKey)
		{
			$valuesRestrict .= " OR ";
		}
	}
	$query = "DELETE FROM $table WHERE $valuesRestrict;";

	$conn = connectDB($db);
	$result = $conn->query($query);
	$conn->close();
	return ($result !== false);
}

function getUsersItems($username, $tri = DEFAULTTRI)
{
	if (empty($username))
		return array();

	$rep = array();
	$query = "SELECT * FROM Articles";

	$query .= " WHERE vendeur_username='$username'";

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

// adds those values to a single row in $table in that database
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

// updates the row(s) specified by the where string, with those values in $table in that database $db
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

// adds an adress in the database. $addr must be an array containing the right keys for an adress
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
		$result2 = updateInDb('users', array('adress_id' => $adressId), "username='$username'");
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
// adds a credit card in the database. $card must be an array containing the right keys for a card
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
		$result2 = updateInDb('users', array('bank_info_id' => $cardId), "username='$username'", 'secure');
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
// adds a user in the central database (the user is added in the secure database in auth.php)
function addUserCentral($username, $fullname, $email, $userstatus)
{
	$result = addInDB('users', array(
		'username' => $username,
		'nom_complet' => $fullname,
		'email' => $email,
		'statut' => $userstatus,
		'est_verifie' => '0'), 'central');
	return ($result === true);
}   

// returns a user's info. $what is the column in the users table that will be given
function getUserInfo($username, $what, $db = 'central')
{
	$query = "SELECT * FROM users WHERE username='$username';";
	$conn = connectDB($db);

	$result = $conn->query($query);
	
	$conn->close();
	
	if ($result === false || $result->num_rows == 0)
		return false;
	if ($what === false || $what === "TOUT")
		return $result->fetch_assoc();
	return $result->fetch_assoc()[$what];
}

// will update a single collumn in an Item's row
function updateItemInfo($ID, $what, $value)
{
	$db = 'central';
	$query = "UPDATE Articles SET $what='$value' WHERE ID='$ID';";
	$conn = connectDB($db);

	$result = $conn->query($query);
	
	$conn->close();
	
	return ($result !== false);
}

// returns the address of a user
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

// returns the credit card of a user
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
//renvoie un tableau avec pour indice, le type
function getVariationFctType($id){
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

//récupérer les variations correspondant à un article en particulier
//renvoie un tableau avec pour indice, le nom
function getVariationFctNom($id){
	$query = "SELECT * 
		FROM variation
		WHERE article_id='$id';";

	$conn = connectDB('central');

	$result = $conn->query($query);

	$conn->close();

	$rep = array();
	while ($row = $result->fetch_assoc())
	{
		if (!isset($rep[$row['nom']]))
			$rep[$row['nom']] = array();
		array_push($rep[$row['nom']], $row);
	}
	return $rep;
}

?>
