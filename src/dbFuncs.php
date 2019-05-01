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
	$lastKey = end(array_keys($IDs));
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

function addUserCentral($username, $fullname, $email)
{
	return true;
}

?>
