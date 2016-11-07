<?php


include_once 'login.php';
include_once 'connection.php';

$connect = new Connection ();	
		
//error_reporting(-1);	

	
	if (!empty($_POST['searchISBN'])){	
	
$connect->overviewBook($db_hostname, $db_username, $db_password, $db_database, $_POST['searchISBN']);	
	}	
	
	else if (!empty($_POST['idLibraryCard'])){		
$connect->overviewReader($db_hostname, $db_username, $db_password, $db_database, $_POST['idLibraryCard']);
	
	}
	
	
	else if (!empty($_POST['isbn']) && empty($_POST['firstISBN'])){	
		$connect->addBook($db_hostname, $db_username, $db_password, $db_database);
		$connect->showBooks($db_hostname, $db_username, $db_password, $db_database);
		
		
	}	
	
	
	else if (!empty($_POST['firstName']) && !empty($_POST['lastName'] && empty($_POST['editReaderID']))){		
		$connect->addReader($db_hostname, $db_username, $db_password, $db_database);
		$connect->showReaders($db_hostname, $db_username, $db_password, $db_database);		
	}
	
	else if (isset($_POST['DelISBN'])){
$connect->delBook($db_hostname, $db_username, $db_password, $db_database);
}
	
	else if (!empty($_POST['DelIdLibraryCard'])){		
$connect->delReader($db_hostname, $db_username, $db_password, $db_database);	
	}
	
	/*
	else if (!empty($_POST['issueInventoryNumber']) && empty($_POST['IdCard']) || !empty($_POST['issueInventoryNumber']) && !is_numeric($_POST['IdCard'])){			
echo "Введите № цифрами";	
	}
	*/
	
	else if (!empty($_POST['issueInventoryNumber']) && !empty($_POST['IdCard'])){			
$connect->issueBook($db_hostname, $db_username, $db_password, $db_database);	
$connect->overviewBook($db_hostname, $db_username, $db_password, $db_database, $_POST['oldISBN']);
	}
	
	else if (!empty($_POST['returnInventoryNumber'])){			
	$connect->returnBook($db_hostname, $db_username, $db_password, $db_database);	
	$connect->overviewReader($db_hostname, $db_username, $db_password, $db_database, $_POST['numberReader']);
	}
	
	else if (!empty($_POST['firstISBN'])){
		$connect->editBook($db_hostname, $db_username, $db_password, $db_database);
		$connect->showBooks($db_hostname, $db_username, $db_password, $db_database);
	}
	
	 else if (!empty($_POST['editReaderID'])){
		$connect->editReader($db_hostname, $db_username, $db_password, $db_database);
		$connect->showReaders($db_hostname, $db_username, $db_password, $db_database);
	}
	
	else if (!empty($_POST['delIdSpecimen'])){
		$connect->delSpecimen($db_hostname, $db_username, $db_password, $db_database);
	}
	
	else if (!empty($_POST['newReceipDate'])){
		$connect->editSpecimen($db_hostname, $db_username, $db_password, $db_database);
		$connect->overviewBook($db_hostname, $db_username, $db_password, $db_database, $_POST['oldISBN']);
	}
	
	else if (!empty($_POST['newSpecimen'])){
		$connect->addSpecimen($db_hostname, $db_username, $db_password, $db_database);
		$connect->overviewBook($db_hostname, $db_username, $db_password, $db_database, $_POST['oldISBN']);					
	}
	
?>


