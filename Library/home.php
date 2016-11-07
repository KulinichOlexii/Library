<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
	<head>
		<title>Library</title>
		<meta charset="utf-8">	
		<meta name="viewport" content="width=device-width, initial-scale=1">	
		<link href="\bootstrap\css\bootstrap.min.css" rel ="stylesheet">			
		<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js"></script> 					
		<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.15.0/jquery.validate.js"></script>				
		<script type="text/javascript" src="\bootstrap\js\bootstrap.min.js"></script>	
		<link href="style.css" rel="stylesheet">
		<script type="text/javascript" src="script.js"></script>		<?php include_once 'server.php'?>
		
	</head>	
	<body>
	
	<div id = "wrapper">
	
	<!-- Sidebar -->
	<div id="sidebar-wrapper">
		<ul class="sidebar-nav">
		
		<li><a href="#" id="returnMenu"><i class="icon-chevron-left icon-white"></i></a></li>
		
		<li><a href="#" id="showBooks"><i class="icon-book icon-white"></i> Показать книги </a></li>
				
		<ul class="sidebar-subNav">				
			<li><a href="#" id="showBook"><i class="icon-eye-open icon-white"></i> Обзор </a></li>
			<li><a href="#" id="addBook"><i class="icon-plus icon-white"></i> Добавить </a></li>
			<li><a href="#" id="editBook"><i class="icon-wrench icon-white"></i> Редактировать </a></li>
			<li><a href="#" id="delBook" type="submit"><i class="icon-trash icon-white"></i> Удалить </a></li>
		</ul>
			
			<li><a href="#" id="showReaders"><i class="showMenu icon-user icon-white"></i> Показать читателей </a></li>
			
		<ul class="sidebar-subNav">	
			<li><a href="#" id="showReader"><i class="icon-eye-open icon-white"></i> Обзор </a></li>
			<li><a href="#" id="addReader"><i class="icon-plus icon-white"></i> Добавить </a></li>
			<li><a href="#" id="editReader"><i class="bookMenu icon-wrench icon-white"></i> Редактировать </a></li>
			<li><a href="#" id="delReader"><i class="icon-trash icon-white"></i> Удалить </a></li>			
		</ul>
		
		</ul>
	</div>
	
	<!-- Page content -->
	<div id="page-content-wrapper">
		<div class="container-fluid">
			<div class="row">
				<div class="col-lg-12 col-md-12" id="table">
					<a href="#" class="btn btn-success"  id="menu-toggle" ><i class="icon-align-justify"></i></a>
														
					<div id="booksList" class="tableList booksTable col-lg-12 col-md-12">					
					<h1>Список книг</h1>
					<div id="Books_List">
					<?php  $connect->showBooks($db_hostname, $db_username, $db_password, $db_database);?>					
					</div>
					</div>	
					
					<div id="readerList" class="tableList readerTable col-lg-12 col-md-12">
					<h1>Список читателей</h1>
					<div id="Readers_List">
					<?php $connect->showReaders($db_hostname, $db_username, $db_password, $db_database);?>
					</div>						
					</div>
					
					<div id="overview" class="overviewTable col-lg-12 col-md-12">												
					</div>	
													
				</div>				
				
								
				<div class="container-form-book col-lg-12" id="container-form-book">
					<div id="legend-form-book">
						<legend><h1>Добавить книгу</h1></legend>
					</div>
					<div id="edit-form-book">
						<legend><h1>Редактировать книгу</h1></legend>
					</div>				
					<div class="form-book" id="form-book">	
						<form id="addBookForm" name="addBookForm">
						<table border='1' cellpadding='5' class='table table-striped table-hover table-bordered table-condensed'  id = 'tableFormBook'>
						<tr>
							<td class = 'span3'><input type="text" name="isbn" class="formBookContainer" id="formBookISBN" placeholder="ISBN" /></td>
							<td class = 'span3'><input type="text" name="name" class="formBookContainer" id="formBookName" placeholder="Название" /></td>
							
						</tr>
						
						<tr id="row-Author" class="rowAuthor">
						<td class = 'span3'><input type="text" name="author[]" class="formBookContainer BookAuthor" id="formBookAuthor" placeholder="Автор" /></td>
						<td><center><button name="batton" type="button" class="btn btn-success" id="buttonAddAuthor">Добавить автора</button></center></td>
						</tr>						
						<tr>
						<td><input type="text" name="publishingHouse" class="formBookContainer" id="publishingHouse" placeholder="Издательство" /></td>
						<td><input type="text" name="placePublication" class="formBookContainer" id="placePublication"  placeholder="Место издания" /></td>
						</tr>
						
						<tr>
						<td><input type="text" name="publishingYear" class="formBookContainer" id="publishingYear" placeholder="Год издания" /></td>
						<td><input type="text" name="numberPages" class="formBookContainer" id="numberPages"  placeholder="Количество страниц" /></td>
						</tr>
						
						<tr>
						<td>
						<select  name="nameClassifier" id="nameClassifier" class="formBookContainer1"  />
							<option selected disabled>Предметная область</option>
							<option>Научная</option>
							<option>Научно-популярная</option> 
							<option>Справочная</option>  
							<option>Учебная</option>  
							<option>Литературно-художественная</option>   
						</select>
						</td>
						<td><input type="text" name="languageEditions" id="languageEditions" class="formBookContainer" placeholder="Язык издания" /></td>
						</tr>
						
						<tr id="row-Specimen" class="rowSpecimen">
						<td><label>Дата получения экземпляра</label><input type="date" name="receiptDate[]" class="formBookContainer" id="receiptDate" placeholder="Дата получения" /></td>
						<td><center><button name="batton" type="button" class="btn btn-success" id="buttonAddSpecimen">Добавить экземпляр</button></center></td>
						
						</tr>
						
						</table>					 	
  				 			 				
					<div id="legend-form-book">
						<button class="btn btn-success" id="buttonAddBook" type="button" />Добавить книгу</button>
					</div>
					<div id="edit-form-book">
						<button class="btn btn-success" id="buttonEditBook" type="button" />Редактировать книгу</button>
					</div>	
												
  					</form>
				
				
				</div>
			</div>
			
			
			
			<div class="container-form-reader col-lg-12" id="container-form-reader">
					<div id="legend-form-reader" class="legend-form-reader">
						<legend><h1>Добавить читателя</h1></legend>
					</div>
					<div id="edit-form-reader">
						<legend><h1>Редактировать читателя</h1></legend>
					</div>
					<div class="form-reader" id="form-reader">	
						<form id="addReaderForm" name="addReaderForm">
						<table border='1' cellpadding='5' class='table table-striped table-hover table-bordered table-condensed'  id = 'tableFormReader'>
						<tr>
							<td class = 'span3'><input type="text" name="firstName" class="formReaderContainer" id="formReaderFirstName" placeholder="Имя" /></td>
							<td class = 'span3'><input type="text" name="lastName" class="formReaderContainer" id="formReaderLastName" placeholder="Фамилия" /></td>
							
						</tr>
						
						<tr>
						<td><label>Дата рождения</label><input type="date" name="birthDate" class="formReaderContainer" id="birthDate" placeholder="Дата рождения" /></td>
						<td>
						<select  name="gender" id="gender" class="formReaderContainer"  />
							<option selected disabled>Пол</option>
							<option>Мужской</option>
							<option>Женский</option> 
							   
						</select>
						</td>
						</tr>
												
						<tr>
						<td><input type="text" name="phoneNumber" class="formReaderContainer" id="phoneNumber" placeholder="Номер телефона" /></td>
						<td><input type="text" name="homeAddress" class="formReaderContainer" id="homeAddress"  placeholder="Домашний адрес" /></td>
						</tr>						
						</table>					 	
  				 			 				
					<div id="legend-form-reader" class="legend-form-reader">
						<button class="btn btn-success" id="buttonAddReader" type="button" />Добавить читателя</button>
					</div>
					<div id="edit-form-reader">
						<button class="btn btn-success" id="buttonEditReader" type="button" />Редактировать читателя</button>
					</div>
												
  					</form>
				
				
				</div>
			</div>
			
			
			
			
			
			
			
			
			</div>			
		</div>		
	</div>
	
	</body>
	
</html>