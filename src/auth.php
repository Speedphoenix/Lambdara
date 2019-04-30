<?php

include_once "config.php";

function passIsSecure($password)
{
	return (is_string($password) && (strlen($password) >= 8));
}

$answer = null;

if (isset($_POST['formtype']) && 
		($_POST['formtype'] === 'register' && isset($_POST['fullname'])
		&& isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password'])
		&& isset($_POST['confirm-password']))
	||
		($_POST['formtype'] === 'login' && isset($_POST['username'])
		&& isset($_POST['password'])))
{
	$conn = new mysqli(DBHOST, DBS['secure']['DBuser'], DBS['secure']['password'],
		DBS['secure']['name'];

	// Check connection
	if ($conn->connect_error) {
		//do something instead of dying
		//die("Connection failed: " . $conn->connect_error);
	} 
	$conn->query("SET NAMES UTF8");

	if ($_POST['formtype'] === 'login')
	{
		$result = $conn->query("SELECT * FROM users WHERE id=" . $_POST['username'] . ";");
		if ($result->num_rows !== 1)
			$result = $conn->query("SELECT * FROM users WHERE email=" . $_POST['username'] . ";");
		$answer = "Invalid username or password";	
	}
	else // register
	{

	}

/*
	$result = $conn->query("SELECT * FROM membre WHERE Prenom like '%MA%' ORDER BY Prenom asc");
	if ($result->num_rows > 0) {
		// output data of each row
		while($row = $result->fetch_assoc()) {
			echo "id: " . $row["ID"]. " - Nom: " . $row["Nom"]. " " . $row["Prenom"]. "<br>";
		}
	} else {
		echo "0 results";
	}
*/
	$conn->close();

}


/*
define("DBS", array(
	"secure" => array(
		"name" => "id9327242_secure",
		"DBuser" => "id9327242_root",
		"password" => "rootroot"),
	"central" => array(
		"name" => "id9327242_central",
		"DBuser" => "id9327242_root2",
		"password" => "rootroot")
	));

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// ou bien mysqli_connect()

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
//echo "Connected successfully";

$conn->query("SET NAMES UTF8");

$result = $conn->query("SELECT * FROM membre WHERE Prenom like '%MA%' ORDER BY Prenom asc");
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "id: " . $row["ID"]. " - Nom: " . $row["Nom"]. " " . $row["Prenom"]. "<br>";
    }
} else {
    echo "0 results";
}

$conn->close();
*/
?>
