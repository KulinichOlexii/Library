<?php

/**
* Connection management. 
* @author Alexii Kulinich 
* @copyright Copyright (c) 2016 Company
*/

class Connection {
	
 	/* Show books */	
	function showBooks ($db_hostname, $db_username, $db_password, $db_database){
		
		$connection = new mysqli($db_hostname, $db_username, $db_password, $db_database);
if ($connection->connect_errno) {
    echo "Не удалось подключиться к MySQL: (" . $mysqli->connect_errno . ") " . $connection->connect_error;
}
		$connection->set_charset("utf8");
		
	$result = $connection->query("SELECT bookslibrary.*, GROUP_CONCAT(DISTINCT authors.author ORDER BY authors.author ASC SEPARATOR ', ')  AS bookAuthors FROM bookslibrary LEFT JOIN authors ON bookslibrary.ISBN = authors.ISBN GROUP BY authors.ISBN");	
	
	if (!$result) die($connection->error);
	
	echo "<table border='1' cellpadding='5' class='table table-hover table-bordered table-condensed'  id = 'tableList'>
 <tr class = 'tHead book_row'>
 <th>ISBN</th><th>Название</th><th>Автор</th><th>Издательство</th><th>Место издания</th><th>Год издания</th><th>Количество страниц</th><th>Количество экземпляров</th><th>Язык издания</th>
 </tr>"; 
		$countRow = $result->num_rows;

 		for ($i=0; $i<$countRow; ++$i){
 			
 			//$result->data_seek($i);
			$row = $result->fetch_array(MYSQLI_ASSOC); 		
	 		
				
		/* Вывод таблицы */
 		echo "<tbody>";
		echo "<tr class = 'book_row'>";
 		echo "<td class = 'span1'>" . $row ['ISBN'] . "</td>";  		
  		echo "<td class = 'span3'>" . $row ['name'] . "</td>";  		
  		echo "<td class = 'span3'>" . $row ['bookAuthors'] . "</td>";
  		echo "<td class = 'span2'>" . $row ['publishingHouse'] . "</td>";
  		echo "<td class = 'span2'>" . $row ['placePublication']. "</td>";
  		echo "<td class = 'span2'>" . $row ['publishingYear']  . "</td>";
  		echo "<td class = 'span2'>" . $row ['numberPages']     . "</td>";
  		echo "<td class = 'span2'>" . $row ['numberCopies']    . "</td>";
  		echo "<td class = 'span2'>" . $row ['languageEditions']. "</td>";
  		echo "</tr>"; 
  		
  				
	} 	 
	 
 		echo "</tbody></table>";		
	
	
	$result->close();	
	$connection->close();
}		
	


/* Show readers */
	
	function showReaders ($db_hostname, $db_username, $db_password, $db_database){	
	
	$connection = new mysqli($db_hostname, $db_username, $db_password, $db_database);
if ($connection->connect_errno) {
    echo "Не удалось подключиться к MySQL: (" . $mysqli->connect_errno . ") " . $connection->connect_error;
}
		$connection->set_charset("utf8");	
	
		
	$resultReaders = $connection->query("SELECT * FROM reader");
	if (!$resultReaders) die($connection->error);	
	
	echo "<table border='1' cellpadding='5' class='table table-striped table-hover table-bordered table-condensed'  id = 'tableList'>
 <tr tHead>
 <th>№ билета</th><th>Имя</th><th>Фамилия</th><th>Дата рождения</th><th>Пол</th><th>Номер телефона</th><th>Место жительства</th><th>Инв.№ книг на руках</th>
 </tr>"; 
		
		$countReaders=$resultReaders->num_rows;

 		for ($i=0; $i<$countReaders; ++$i){
 				
 			$rowReaders = $resultReaders->fetch_array(MYSQLI_ASSOC); 		
 		
	 		/* Подзапрос: Книги на руках у читателей */
	 		$subResultReaders = $connection->query("SELECT inventoryNumber FROM specimen WHERE idLibraryCard='$rowReaders[idLibraryCard]'");
			$outputReaders = '';
			while($subRowReaders = $subResultReaders->fetch_array(MYSQLI_ASSOC)) {  
				$massivReaders[]=$subRowReaders['inventoryNumber']; 
				$outputReaders = implode(", ",$massivReaders);
			}  
				unset($massivReaders);
				
		
		/* Вывод таблицы */
 		
		echo "<tr>";
 		echo "<td class = 'span1'>" . $rowReaders ['idLibraryCard'] . "</td>";  		
  		echo "<td class = 'span3'>" . $rowReaders ['firstName'] . "</td>";	
  		echo "<td class = 'span2'>" . $rowReaders ['lastName'] . "</td>";
  		echo "<td class = 'span2'>" . $rowReaders ['birthDate']. "</td>";
  		echo "<td class = 'span2'>" . $rowReaders ['gender']  . "</td>";
  		echo "<td class = 'span2'>" . $rowReaders ['phoneNumber']     . "</td>";
  		echo "<td class = 'span2'>" . $rowReaders ['homeAddress']    . "</td>";
  		echo "<td class = 'span3'>" . $outputReaders . "</td>";
  		echo "</tr>"; 	
  		unset($outputReaders);	
	} 	  
 		echo "</table>";		
		
	$resultReaders->close();	
	$connection->close();	
}




/* Overview book */	
	
	function overviewBook ($db_hostname, $db_username, $db_password, $db_database, $isbn){
	
	$connection = new mysqli($db_hostname, $db_username, $db_password, $db_database);
if ($connection->connect_errno) {
    echo "Не удалось подключиться к MySQL: (" . $mysqli->connect_errno . ") " . $connection->connect_error;
}
	$connection->set_charset("utf8");		
	$result = $connection->query("SELECT bookslibrary.ISBN, bookslibrary.name, bookslibrary.publishingHouse, bookslibrary.placePublication, bookslibrary.publishingYear, bookslibrary.numberPages, bookslibrary.numberCopies, bookslibrary.languageEditions, classifiersociofunctional.nameClassifier FROM bookslibrary, classifiersociofunctional WHERE bookslibrary.ISBN='$isbn' AND classifiersociofunctional.ISBN='$isbn' ");	
	 if (!$result) die($connection->error);
	 
	 
		$countRow=$result->num_rows;;

 		for ($i=0; $i<$countRow; ++$i){
 				
 			$row = $result->fetch_array(MYSQLI_ASSOC); 		
 		
	 /* Подзапрос: Автора книги */
	 		
	 		$subResult = $connection->query("SELECT author FROM authors WHERE ISBN='$isbn'");
		
			while($subRow = $subResult->fetch_array(MYSQLI_ASSOC)) {  
				$massiv[]=$subRow['author']; 
				$output = implode(", ",$massiv);
			}  
				unset($massiv);				
				
				
		/* Вывод данных книги*/
		echo "<div id='overwiev-Book'>";
		echo "<h1>Книга</h1>";
		echo "<dl>";
  		echo "<dt>ISBN: </dt>
  		 <dd>" . $row ['ISBN'] . "</dd>
  		 
  		 <dt>Название: </dt>
  		 <dd>" . $row ['name'] . "</dd>
  		 
  		 <dt>Автор: </dt>
  		 <dd>" . $output . "</dd>
  		 
  		 <dt>Издательство: </dt>
  		 <dd>" . $row ['publishingHouse'] . "</dd>
  		 
  		 <dt>Место издания: </dt>
  		 <dd>" . $row ['placePublication'] . "</dd>
  		 
  		 <dt>Год издания: </dt>
  		 <dd>" . $row ['publishingYear'] . "</dd>
  		 
  		 <dt>Предметная область: </dt>
  		 <dd>" . $row ['nameClassifier'] . "</dd>
  		 
  		 <dt>Количество страниц: </dt>
  		 <dd>" . $row ['numberPages'] . "</dd>
  		 
  		 <dt>Количество экземпляров: </dt>
  		 <dd>" . $row ['numberCopies'] . "</dd>
  		 
  		 <dt>Язык издания: </dt>
  		 <dd>" . $row ['languageEditions'] . "</dd>
		 </dl>";		
		}
		
		/* Запрос: Экземпляры книг */
			
	 		$subResultCopies = $connection->query("SELECT * FROM specimen WHERE ISBN='$isbn'");
		
		echo "    
    <div><form id = 'formAddNewSpecimen'>
    	<label><strong>Дата получения экземпляра</strong></label><input  type='date' name='addFormSpecimen' id='addFormSpecimen' class='formAddSpecimen' /><a class='specimenOption btn btn-success' id='addSpecimen' href='#' type='button'><i class='icon-plus icon-white'></i></a></div></center>
    </form></div>
    
    ";
		
		echo "<table border='1' cellpadding='5' class='table table-striped table-hover table-bordered table-condensed '  id = 'overviewtableList'>
 <tr tHead>
 <th><center>Экземпляр</center></th><th><center>Получен</center></th><th><center>Статус</center></th><th><center>Выдан</center></th><th><center>Возврат</center></th><th><center>Читатель</center></th><th><center><a href='#'><i class='icon-trash'></i></a></center></th>
 </tr><tbody>";		
			
		while($subRowCopies = $subResultCopies->fetch_array(MYSQLI_ASSOC)){  			
			 
		
		/* Вывод таблицы экземпляр */
		
		
 		
		echo "<tr class ='specimenBook'>";
 		echo "<td class = 'span2'><center>" . $subRowCopies ['inventoryNumber'] . "</center></td>";  		
  		echo "<td class = 'span2'><div><center><div class = 'specimenReceiptDate specimenReceiptDate1' id='specimenReceiptDate1'><p>" . $subRowCopies ['receiptDate'] . "</p></div><div class = 'specimenReceiptDate'><a class='editSpecimen specimenOption btn btn-success' id='editSpecimen' href='#' type='button'><i class='icon-wrench icon-white'></i></a></div></center></div></td>";  		
  		echo "<td class = 'span2'><center>" . $subRowCopies ['availableStatus']. "</center></td>";
  		echo "<td class = 'span2'><center>" . $subRowCopies ['issueDate'] . "</center></td>";
  		echo "<td class = 'span2'><center>" . $subRowCopies ['returnDate']. "</center></td>";
  		
  		if (!empty ($subRowCopies ['idLibraryCard'])){
			echo "<td class='td_IdCard'><center>" . $subRowCopies ['idLibraryCard']  . "</center></td>";	
		}
		else {
		 	echo "<td class='td_IdCard'><center>
		 	
		 			 	
		 	<div id='preview'> </div>
		 	<div class='input-append id='formbox'>
		 	<form id='formIssueBook'>	
		 	
		 	<input  type='text' name='idCard' id='idCard' class='formIssueContainer'  placeholder='№ читателя' size='16' />
		 	<a class='issueBook btn btn-success' id='issueBook' href='#' type = 'button'><i>Выдать</i></a>
		 	</form>
		 	</div>
		 	</center></td>";
		 } 	
		 	 
  		echo "<td class = 'span1'><center><a class='delitSpecimen specimenOption btn btn-success' id='delitSpecimen' href='#'><i class='icon-trash icon-white'></i></a></center></td>"; 		
  		echo "</tr>";	 	  
 		
	}
	echo "</tbody></table>";
	
	echo "</div>";
	$result->close();
	//$subResult->close();
	$subResultCopies->close();
	$connection->close();	
}


/* Overview reader */
	
	function overviewReader ($db_hostname, $db_username, $db_password, $db_database, $idLibraryCard){
	
	$connection = new mysqli($db_hostname, $db_username, $db_password, $db_database);
if ($connection->connect_errno) {
    echo "Не удалось подключиться к MySQL: (" . $mysqli->connect_errno . ") " . $connection->connect_error;
}
	$connection->set_charset("utf8");		
	$result = $connection->query("SELECT * FROM reader WHERE idLibraryCard='$idLibraryCard'");	
	 if (!$result) die($connection->error);
	 
	 
		$countRow=$result->num_rows;;

 		for ($i=0; $i<$countRow; ++$i){
 				
 			$row = $result->fetch_array(MYSQLI_ASSOC); 		
 							
		/* Вывод данных книги*/
		echo "<h1>Читатель</h1>";
		echo "<dl>";
  		echo "<dt>№ билета: </dt>
  		 <dd>" . $row ['idLibraryCard'] . "</dd>
  		 
  		 <dt>Имя: </dt>
  		 <dd>" . $row ['firstName'] . "</dd>
  		 
  		 <dt>Фамилия: </dt>
  		 <dd>" . $row ['lastName'] . "</dd>
  		 
  		 <dt>Дата рождения: </dt>
  		 <dd>" . $row ['birthDate'] . "</dd>
  		 
  		 <dt>Пол: </dt>
  		 <dd>" . $row ['gender'] . "</dd>
  		 
  		 <dt>Номер телефона: </dt>
  		 <dd>" . $row ['phoneNumber'] . "</dd>  		 
  		 
  		 <dt>Место жительства: </dt>
  		 <dd>" . $row ['homeAddress'] . "</dd>
  		 
		 </dl>";		
		}
		
		/* Запрос: Книги у читателя */
			
	 		$subResult = $connection->query("SELECT bookslibrary.	ISBN, bookslibrary.name, specimen.inventoryNumber, specimen.issueDate FROM bookslibrary, specimen WHERE bookslibrary.ISBN=specimen.ISBN AND specimen.idLibraryCard='$idLibraryCard'");
		
		echo "<h1>Книги на руках</h1>";
		echo "<table border='1' cellpadding='5' class='table table-striped table-hover table-bordered table-condensed'  id = 'overviewtableList'>
 <tr tHead>
 <th><center>ISBN</center></th><th><center>Название</center></th><th><center>№ Экземпляра</center></th><th><center>Дата выдачи</center></th><th><center>Возврат</center></th>
 </tr>";		
			
		while($subRow = $subResult->fetch_array(MYSQLI_ASSOC)){ 
		
		/* Вывод таблицы экземпляр */	
 		
		echo "<tr>";
 		echo "<td class = 'span2'><center>" . $subRow ['ISBN'] . "</center></td>";  		
  		echo "<td class = 'span2'><center>" . $subRow ['name'] . "</center></td>";  		
  		echo "<td class = 'span2'><center>" . $subRow ['inventoryNumber']. "</center></td>";
  		echo "<td class = 'span2'><center>" . $subRow ['issueDate'] . "</center></td>";   				
		echo "<td class = 'span2'><center> <button class='returnBook btn btn-success' id='returnBook' type = 'button'>Вернуть</button></center></td>";		 
  		  		
  		echo "</tr>";	 	  
 		
	}
	echo "</table>";
	$result->close();
	$subResult->close();	
	$connection->close();	
}



/* Add book */
	
	function addBook ($db_hostname, $db_username, $db_password, $db_database){
		
	$connection = new mysqli($db_hostname, $db_username, $db_password, $db_database);
		if ($connection->connect_errno) {
   			echo "Не удалось подключиться к MySQL: (" . $mysqli->connect_errno . ") " . $connection->connect_error;
}
	$connection->set_charset("utf8");	
	
		
	/* Add date to bookslibrary table */
	
	$isbn = $connection->real_escape_string($_POST['isbn']);
	$name = $connection->real_escape_string($_POST['name']);
	$publishingHouse = $connection->real_escape_string($_POST['publishingHouse']);
	$placePublication = $connection->real_escape_string($_POST['placePublication']);
	$publishingYear = $connection->real_escape_string($_POST['publishingYear']);
	$numberPages = $connection->real_escape_string($_POST['numberPages']);	
	$languageEditions = $connection->real_escape_string($_POST['languageEditions']);
	
	
	$number_InventoryNumber = count($_POST['receiptDate']);
	
	
	$query_BooksLibrary = "INSERT INTO bookslibrary(ISBN, name, publishingHouse, placePublication, publishingYear, numberPages, numberCopies, languageEditions) VALUES ('".$isbn."', '".$name."', '".$publishingHouse."', '".$placePublication."', '".$publishingYear."', '".$numberPages."', '".$number_InventoryNumber."', '".$languageEditions."')";
	
	
	if ($connection->query($query_BooksLibrary)){
		
	}
	else{
		echo 'Данные в bookslibrary table не записаны';
	}
	
	/* Add date to authors table */
	$authors = $_POST['author'];
	$numberAuthor = count($authors);
		
		for($i=0; $i<$numberAuthor; $i++){
			if(trim($authors[$i]) !=''){
				$authorsBook = $connection->real_escape_string($authors[$i]);
					
				$query_authors = "INSERT INTO authors(ISBN, author) VALUES ('".$isbn."', '".$authorsBook."')";
				$connection->query($query_authors);
			}
		}
	
	/* Add date to classifiersociofunctional table */
	
	$nameClassifier = $connection->real_escape_string($_POST['nameClassifier']);
	
	$query_classifierSF = "INSERT INTO classifiersociofunctional(ISBN, nameClassifier) VALUES ('".$isbn."', '".$nameClassifier."')";
	if ($connection->query($query_classifierSF)){		
	}
	else{
		echo 'Данные в classifiersociofunctional table не записаны';
	}		
	
	
			
		/* Add date to specimen table */	
	
	$receiptDate = $_POST['receiptDate'];	
		
		for($j=0; $j<$number_InventoryNumber; $j++){
			if(trim($receiptDate[$j]) !=''){
				
					
				$query_specimen = "INSERT INTO specimen(inventoryNumber, receiptDate, ISBN, availableStatus, issueDate, returnDate, idLibraryCard) VALUES (NULL, '".$connection->real_escape_string($receiptDate[$j])."', '".$isbn."', 'В наличии', NULL, NULL, NULL)";
				
				
				$connection->query($query_specimen);
			}
		}		
	$connection->close();	
	}
	
	
/* Add reader */
	
	function addReader ($db_hostname, $db_username, $db_password, $db_database){
		
	$connection = new mysqli($db_hostname, $db_username, $db_password, $db_database);
		if ($connection->connect_errno) {
   			echo "Не удалось подключиться к MySQL: (" . $mysqli->connect_errno . ") " . $connection->connect_error;
}
	$connection->set_charset("utf8");
	/* Add date to reader table */
	
	$firstName = $connection->real_escape_string($_POST['firstName']);
	$lastName = $connection->real_escape_string($_POST['lastName']);
	$birthDate = $connection->real_escape_string($_POST['birthDate']);
	$gender = $connection->real_escape_string($_POST['gender']);
	$phoneNumber = $connection->real_escape_string($_POST['phoneNumber']);
	$homeAddress = $connection->real_escape_string($_POST['homeAddress']);	
		
	$query_reader = "INSERT INTO reader(idLibraryCard, firstName, lastName, birthDate, gender, phoneNumber, homeAddress) VALUES (NULL, '".$firstName."', '".$lastName."', '".$birthDate."', '".$gender."', '".$phoneNumber."', '".$homeAddress."')";
	
	
	if ($connection->query($query_reader)){
		
	}
	else{
		echo 'Данные в reader table не записаны';
	}
	}	
	

/* Delete book */
	
	function delBook ($db_hostname, $db_username, $db_password, $db_database){
		
	$connection = new mysqli($db_hostname, $db_username, $db_password, $db_database);
		if ($connection->connect_errno) {
   			echo "Не удалось подключиться к MySQL: (" . $mysqli->connect_errno . ") " . $connection->connect_error;
}
	$connection->set_charset("utf8");
	
	$isbn = $connection->real_escape_string($_POST['DelISBN']);
		
	$result = $connection->query("DELETE FROM bookslibrary WHERE isbn='$isbn'");	
	if (!$result) echo "Сбой при удалении<br>" . $connection->error . "<br><br>";
	
	
	
	$connection->close();
	
	}	
	
	/* Delete reader */
	
	function delReader ($db_hostname, $db_username, $db_password, $db_database){
		
	$connection = new mysqli($db_hostname, $db_username, $db_password, $db_database);
		if ($connection->connect_errno) {
   			echo "Не удалось подключиться к MySQL: (" . $mysqli->connect_errno . ") " . $connection->connect_error;
}
	$connection->set_charset("utf8");
	
	$id = $connection->real_escape_string($_POST['DelIdLibraryCard']);
		
	$result = $connection->query("DELETE FROM reader WHERE idLibraryCard='$id'");	
	if (!$result) echo "Сбой при удалении<br>" . $connection->error . "<br><br>";
		
	$connection->close();
	
	}
	
	
	/* Issue book */
	
	function issueBook ($db_hostname, $db_username, $db_password, $db_database){
		
	$connection = new mysqli($db_hostname, $db_username, $db_password, $db_database);
		if ($connection->connect_errno) {
   			echo "Не удалось подключиться к MySQL: (" . $mysqli->connect_errno . ") " . $connection->connect_error;
}
	$connection->set_charset("utf8");
	
	$issueInventoryNumber = $connection->real_escape_string($_POST['issueInventoryNumber']);
	$IdCard = $connection->real_escape_string($_POST['IdCard']);
	
	$dt=time(); 
	$issueDate = strftime("%Y-%m-%d %H:%M:%S", $dt);	
		
	$result = $connection->query("UPDATE specimen SET availableStatus='Выдан', issueDate='".$issueDate."', returnDate=NULL, idLibraryCard='".$IdCard."' WHERE InventoryNumber='".$issueInventoryNumber."'");	
	
	if (!$result) echo "Сбой при выдачи книги<br>" . $connection->error . "<br><br>";	
		
	$connection->close();
	
	}
	
	
	/* Return book */
	
	function returnBook ($db_hostname, $db_username, $db_password, $db_database){
		
	$connection = new mysqli($db_hostname, $db_username, $db_password, $db_database);
		if ($connection->connect_errno) {
   			echo "Не удалось подключиться к MySQL: (" . $mysqli->connect_errno . ") " . $connection->connect_error;
}
	$connection->set_charset("utf8");
	
	$returnInventoryNumber = $connection->real_escape_string($_POST['returnInventoryNumber']);
		
	$dt=time(); 
	$returnDate = strftime("%Y-%m-%d %H:%M:%S", $dt);	
		
	$result = $connection->query("UPDATE specimen SET availableStatus='В наличии', returnDate='".$returnDate."', idLibraryCard=NULL WHERE InventoryNumber='".$returnInventoryNumber."'");		
	
	if (!$result) echo "Сбой при возврате книги<br>" . $connection->error . "<br><br>";	
		
	$connection->close();
	
	}
	
	
	/* Edit book ISBN*/
	
	function editBook ($db_hostname, $db_username, $db_password, $db_database){
		
	$connection = new mysqli($db_hostname, $db_username, $db_password, $db_database);
		if ($connection->connect_errno) {
   			echo "Не удалось подключиться к MySQL: (" . $mysqli->connect_errno . ") " . $connection->connect_error;
}
	$connection->set_charset("utf8");
	/* Edit date to bookslibrary table */
	
	$isbn = $connection->real_escape_string($_POST['isbn']);
	$name = $connection->real_escape_string($_POST['name']);
	$publishingHouse = $connection->real_escape_string($_POST['publishingHouse']);
	$placePublication = $connection->real_escape_string($_POST['placePublication']);
	$publishingYear = $connection->real_escape_string($_POST['publishingYear']);
	$numberPages = $connection->real_escape_string($_POST['numberPages']);	
	$languageEditions = $connection->real_escape_string($_POST['languageEditions']);	
	
	$firstISBN = $connection->real_escape_string($_POST['firstISBN']);	
	
	if ($connection->query("UPDATE bookslibrary SET ISBN='".$isbn."', name='".$name."', publishingHouse='".$publishingHouse."', placePublication='".$placePublication."', publishingYear='".$publishingYear."', numberPages='".$numberPages."', languageEditions='".$languageEditions."' WHERE ISBN='".$firstISBN."'")){
		
	}
	else{
		echo 'Данные в bookslibrary table не записаны';
	}
	
	
	/* Edit date to classifiersociofunctional table */
	
	$nameClassifier = $connection->real_escape_string($_POST['nameClassifier']);
		
	if ($connection->query("UPDATE classifiersociofunctional SET nameClassifier='".$nameClassifier."' WHERE ISBN='".$isbn."'")){		
	}
	else{
		echo 'Данные в classifiersociofunctional table не записаны';
	}		
	
	/* Edit date to authors table */

	$numberAuthor = count($_POST['author']);
	
	$connection->query("DELETE FROM authors WHERE isbn='".$isbn."'");
	
		
		for($i=0; $i<$numberAuthor; $i++){
			if(trim($_POST['author'][$i]) !=''){
					
				$query_authors = "INSERT INTO authors(ISBN, author) VALUES ('".$isbn."', '".$connection->real_escape_string($_POST["author"][$i])."')";
				$connection->query($query_authors);
			}
		}
		
	$connection->close();

}

	
	
	
/* Edit reader */
	
	function editReader ($db_hostname, $db_username, $db_password, $db_database){
		
	$connection = new mysqli($db_hostname, $db_username, $db_password, $db_database);
		if ($connection->connect_errno) {
   			echo "Не удалось подключиться к MySQL: (" . $mysqli->connect_errno . ") " . $connection->connect_error;
}
	$connection->set_charset("utf8");
	
	/* Edit date to reader table */
	
	$idLibraryCard = $connection->real_escape_string($_POST['editReaderID']);
	$firstName = $connection->real_escape_string($_POST['firstName']);
	$lastName = $connection->real_escape_string($_POST['lastName']);
	$birthDate = $connection->real_escape_string($_POST['birthDate']);
	$gender = $connection->real_escape_string($_POST['gender']);
	$phoneNumber = $connection->real_escape_string($_POST['phoneNumber']);
	$homeAddress = $connection->real_escape_string($_POST['homeAddress']);	
	
		if ($connection->query("UPDATE reader SET firstName='".$firstName."', lastName='".$lastName."', birthDate='".$birthDate."', gender='".$gender."', phoneNumber='".$phoneNumber."', homeAddress='".$homeAddress."' WHERE idLibraryCard='".$idLibraryCard."'")){
		
		}
		else{
			echo 'Данные в reader table не записаны';
		}
	}
	
	
	
	/* ------------------------Specimen--------------------- */	
	
	
/* Delete specimen */	
	
	function delSpecimen ($db_hostname, $db_username, $db_password, $db_database){
		
	$connection = new mysqli($db_hostname, $db_username, $db_password, $db_database);
		if ($connection->connect_errno) {
   			echo "Не удалось подключиться к MySQL: (" . $mysqli->connect_errno . ") " . $connection->connect_error;
}
	$connection->set_charset("utf8");
	
	$delIdSpecimen = $connection->real_escape_string($_POST['delIdSpecimen']);
		
	$result = $connection->query("DELETE FROM specimen WHERE InventoryNumber='$delIdSpecimen'");	
	if (!$result) echo "Сбой при удалении<br>" . $connection->error . "<br><br>";
	
	
	
	$connection->close();
	
	}
	
	
/* Edit specimen */	
	
	function editSpecimen ($db_hostname, $db_username, $db_password, $db_database){
		
	$connection = new mysqli($db_hostname, $db_username, $db_password, $db_database);
		if ($connection->connect_errno) {
   			echo "Не удалось подключиться к MySQL: (" . $mysqli->connect_errno . ") " . $connection->connect_error;
}
	$connection->set_charset("utf8");
	
	$newReceipDate = $connection->real_escape_string($_POST['newReceipDate']);
	$IdSpecimen = $connection->real_escape_string($_POST['IdSpecimen']); 	
		
	$result = $connection->query("UPDATE specimen SET receiptDate='".$newReceipDate."'WHERE InventoryNumber='".$IdSpecimen."'");	
	if (!$result) echo "Сбой при удалении<br>" . $connection->error . "<br><br>";
	
	$connection->close();
	
	}

/* Add specimen */	
	
	function addSpecimen ($db_hostname, $db_username, $db_password, $db_database){
		
	$connection = new mysqli($db_hostname, $db_username, $db_password, $db_database);
		if ($connection->connect_errno) {
   			echo "Не удалось подключиться к MySQL: (" . $mysqli->connect_errno . ") " . $connection->connect_error;
}
	$connection->set_charset("utf8");
	
	$newSpecimen = $connection->real_escape_string($_POST['newSpecimen']);
	$oldISBN = $connection->real_escape_string($_POST['oldISBN']);
			
	$result = $connection->query("INSERT INTO specimen(inventoryNumber, receiptDate, ISBN, availableStatus, issueDate, returnDate, idLibraryCard) VALUES (NULL, '".$newSpecimen."', '".$oldISBN."', 'В наличии', NULL, NULL, NULL)");	
	if (!$result) echo "Сбой при удалении<br>" . $connection->error . "<br><br>";
	
	$connection->close();
	
	}

}

?>