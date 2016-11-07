$(document).ready(function(){
	
/*Button to add input Author------------*/	
var i = 1;
	$('#buttonAddAuthor').click(function(){
		var row_id = $(".rowAuthor").last().attr("id");
		i++;
		$("#"+row_id).after('<tr class="addRowAuthor rowAuthor" id="row-Author'+i+'"><td><input type="text" name="author[]" class="formBookContainer"  placeholder="Автор" /></td><td><center><button name="remove" type="button" class="btn btn-danger btn_remove" id="'+i+'">X</button></center></td></tr>');	
	});
	
	$(document).on('click','.btn_remove', function(){
			var button_id = $(this).attr("id");
			$("#row-Author"+button_id+'').remove();				
		});
	
/*Button to add input Specimen------------*/	
var j = 1;
	$('#buttonAddSpecimen').click(function(){
		var row_id = $(".rowSpecimen").last().attr("id");
		j++;
		$("#"+row_id).after('<tr class="addrowSpecimen rowSpecimen" id="row-Specimen'+j+'"><td><label>Дата получения экземпляра</label><input type="date" name="receiptDate[]" class="formBookContainer" id="receiptDate" /></td><td><center><button name="remove" type="button" class="btn btn-danger btn_removeSpecimen" id="'+j+'">X</button></center></td></tr>');	
	});

	$(document).on('click','.btn_removeSpecimen', function(){
			var button_id = $(this).attr("id");
			$("#row-Specimen"+button_id+'').remove();				
	});

/*Sidebar toogle script------------*/	

$("#menu-toggle").click(function (e){
	e.preventDefault();
	$("#wrapper").toggleClass("menuDisplayed");		
});
	
/*Menu toogle script-------------*/

	$(".sidebar-subNav").hide().prev().click(function(){
		$(".sidebar-subNav").not(this).slideUp('slow');
		$(this).next().not(":visible").slideDown('slow');
		
	});
		
	
/*Books table toogle script------------*/	

$("#showBooks, #showBook, #delBook").click(function (e){
	e.preventDefault();
	$("#page-content-wrapper").removeClass("readerTable overviewTable addBook addReader editBook editReader");	
	$("#page-content-wrapper").addClass("booksTable");	
	$("#overview").empty();		
});
	
/*Readers table toogle script---------------*/	

$("#showReaders, #showReader, #delReader").click(function (e){
	e.preventDefault();
	$("#page-content-wrapper").removeClass("booksTable overviewTable addBook addReader editBook editReader");	
	$("#page-content-wrapper").addClass("readerTable");
	$("#overview").empty();		
});	
	
	
/*Validate add book form-----------------------*/	

$("#addBookForm").validate({
		errorElement: "span",
        errorClass: "help-block",		
	rules:{
		isbn: {
			required: true,
			maxlength: 10,
			digits: true
		},
		name: {
			required: true,
			rangelength: [3, 100]			
		},
		'author[]': {
			required: true,
			rangelength: [3, 40]			
		},
		publishingHouse: {
			required: true,			
			maxlength: 30
		},
		placePublication: {
			required: true,			
			maxlength: 30
		},
		publishingYear: {
			required: true,			
			maxlength: 4,
			digits: true
		},
		numberPages: {
			required: true,			
			maxlength: 5,
			digits: true
		},
		nameClassifier: {
			required: true
		},
		languageEditions: {
			required: true,			
			maxlength: 20
		},
		'receiptDate[]': {
			required: true
		}
	},
	messages: {
		isbn: {
			required: 'Заполните поле',
			maxlength: 'Не более 10 цифр',
			digits: 'Вводите только цифры'
		},
		name: {
			required: 'Заполните поле',
			rangelength: 'От 3 до 100 символов'
		},
		'author[]': {
			required: 'Заполните поле',
			rangelength:'От 3 до 40 символов'
		},
		publishingHouse: {
			required: 'Заполните поле',
			maxlength: 'Не более 30 символов'
		},
		placePublication: {
			required: 'Заполните поле',
			maxlength: 'Не более 30 символов'
		},
		publishingYear: {
			required: 'Заполните поле',
			maxlength: 'Не более 4 символов',
			digits: 'Вводите только цифры'
		},
		numberPages: {
			required: 'Заполните поле',
			maxlength: 'Не более 5 символов',
			digits: 'Вводите только цифры'
		},
		nameClassifier: {
			required: 'Заполните поле'
		},
		languageEditions: {
			required: 'Заполните поле',
			maxlength: 'Не более 20 символов'
		},
		'receiptDate[]': {
			required: 'Заполните поле'
		}
	}	
});

/*Validate add reader form-----------------------*/

$("#addReaderForm").validate({
		errorElement: "span",
        errorClass: "help-block",		
	rules:{
		firstName: {
			required: true,
			rangelength: [2, 100]
		},
		lastName: {
			required: true,
			rangelength: [2, 100]			
		},
		birthDate: {
			required: true			
		},
		gender: {
			required: true
		},
		phoneNumber: {
			required: true,			
			maxlength: 50,
			digits: true
		},
		homeAddress: {
			required: true,			
			maxlength: 150
		}
	},
	messages: {
		firstName: {
			required: 'Заполните поле',
			rangelength: 'От 2 до 100 символов'
		},
		lastName: {
			required: 'Заполните поле',
			rangelength: 'От 2 до 100 символов'
		},
		birthDate: {
			required: 'Заполните поле'
		},
		gender: {
			required: 'Заполните поле'
		},
		phoneNumber: {
			required: 'Заполните поле',
			maxlength: 'Не более 50 символов',
			digits: 'Вводите только цифры'
		},
		homeAddress: {
			required: 'Заполните поле',
			maxlength: 'Не более 150 символов'
		}
	}		
});

/*Validate issue book form-----------------------*/

$("#formIssueBook").validate({
		errorElement: "span",
        errorClass: "help-block",		
	rules:{
		addFormSpecimen: {
			required: true,
			digits: true		
		}
	},
	messages: {
		addFormSpecimen: {		
			required: 'Заполните поле',			
			digits: 'Вводите только цифры'
		}		
	},

submitHandler: function(form){
$(form).ajaxSubmit({
target: '#preview',
success: function() {
$('#formbox').slideUp('fast');
}
});
}
		
});
	
/*Add book toogle script---------------*/
	
$("#addBook").click(function (e){
	e.preventDefault();	
	$('#row-Specimen').show();	
	$("#addBookForm").find('.editRowAuthor').remove();
	$("#addBookForm").find('.addRowAuthor').remove();
	$("#addBookForm").find('.addrowSpecimen').remove();
	$("#addBookForm")[0].reset();    	
	$("#page-content-wrapper").removeClass("booksTable overviewTable readerTable editBook");	
	$("#page-content-wrapper").toggleClass("addBook");
	$("#overview").empty();
		
});	

/*Add reader toogle script---------------*/	

$("#addReader").click(function (e){
	e.preventDefault();	
	$("#addReaderForm")[0].reset();
	$("#page-content-wrapper").removeClass("overviewTable readerTable editReader");		
	$("#page-content-wrapper").toggleClass("addReader");
	$("#overview").empty();
				
});	



/*Post form: add book-----------------*/

$("#buttonAddBook").click(function(){
	
	if ($("#addBookForm").validate().checkForm()){
		$.ajax({
			url:"server.php",
			method:"POST",
			data:$("#addBookForm").serialize(),
			success: function(data){
				$("#Books_List").empty();
				$("#Books_List").append(data);				
			}			
		});	
		$("#page-content-wrapper").removeClass("readerTable overviewTable addBook addReader editBook editReader");	
	$("#page-content-wrapper").addClass("booksTable");	
	}
	
		
});


/*Post form: add reader-----------------*/

$("#buttonAddReader").click(function(){
	if ($("#addReaderForm").validate().checkForm()){
		$.ajax({
			url:"server.php",
			method:"POST",
			data:$("#addReaderForm").serialize(),
			success: function(data){				
				$("#Readers_List").empty();
				$("#Readers_List").append(data);			
			}		
		});	
		$("#page-content-wrapper").removeClass("booksTable overviewTable addBook addReader editBook editReader");	
	$("#page-content-wrapper").addClass("readerTable");
	}
		
});

/*Post form: isset book-----------------*/

$("#overview").on("click", ".issueBook", function () {
	
		
	
	if ($("#overview").find("#idCard").validate().checkForm()){         	
	var issueInventoryNumber = $(this).closest('tr').find('td:eq(0)').text();
	var IdCard = $('#idCard').val();
	var oldISBN = $("#overview").find('dd:eq(0)').text();			
	
		$.post("server.php",{	
		issueInventoryNumber: issueInventoryNumber,
		IdCard: IdCard,
		oldISBN: oldISBN				
		},
		function(data){
			$("#overview").empty();
			$("#overview").append(data);						
		}	
		);
	
	}
});

/*Post form: return book-----------------*/

$("#overview").on("click", ".returnBook", function () {
         	
	var returnInventoryNumber = $(this).closest('tr').find('td:eq(2)').text();	
	var numberReader = $("#overview").find('dd:eq(0)').text();
	
	$.post("server.php",{	
	returnInventoryNumber: returnInventoryNumber,
	numberReader: numberReader				
	},
	function(data){
		$("#overview").empty();
		$("#overview").append(data);						
	}	
	);			
});


/*Post: select book in table by row-------------*/ 

$('.tableList').on('click', 'tr', function(e){
	event.preventDefault();                
                 
	/*Select the book to overview------------*/  
	  
 	if ($("a").is("#showBook.active")){
 		    
		var searchISBN = $(this).find('td:eq(0)').text();		
						
			$("#page-content-wrapper").removeClass("booksTable editBook");
			$("#page-content-wrapper").toggleClass("overviewTable");
			
				$.post("server.php",{	
		   				searchISBN: searchISBN		
				},
					function(data){
						$('#overview').html(data);
					}	
				);
				
				
		/*Select the book to edit*/ 
		
		$("#editBook").click(function(){ 
		
		$("#addBookForm").find('.editRowAuthor').remove();
			 
 	    
		var isbn = $("#overview").find('dd:eq(0)').text();		
		var name = $("#overview").find('dd:eq(1)').text();		
		var author = $("#overview").find('dd:eq(2)').text();
		
		var splitstr = author.split(',');
		
				
		
			for (k=0;k<splitstr.length;k++){				
				var td_id = $(".BookAuthor").last().attr("id");
				$("#"+td_id).val(splitstr[k]);				
				if (k+1<splitstr.length){
					var row_id = $(".rowAuthor").last().attr("id");
					i++;
				$("#"+row_id).after('<tr class="editRowAuthor rowAuthor" id="row-Author'+i+'"><td><input type="text" name="author[]" class="BookAuthor formBookContainer" id="formBookAuthor'+i+'"  placeholder="Автор" /></td><td><center><button name="remove" type="button" class="btn btn-danger btn_remove" id="'+i+'">X</button></center></td></tr>');
				}						
			}				
		
		var publishingHouse = $("#overview").find('dd:eq(3)').text();
		var placePublication = $("#overview").find('dd:eq(4)').text();
		var publishingYear = $("#overview").find('dd:eq(5)').text();
		var nameClassifier = $.trim($("#overview").find('dd:eq(6)').text());		
		var numberPages = $("#overview").find('dd:eq(7)').text();
		var languageEditions = $("#overview").find('dd:eq(9)').text();							
			$('#formBookISBN').val(isbn);			
			$('#formBookName').val(name);						
			$('#publishingHouse').val(publishingHouse);			
			$('#placePublication').val(placePublication);		
			$('#publishingYear').val(publishingYear);			
			$('#numberPages').val(numberPages);
			$('#nameClassifier').val(nameClassifier);			
			$('#languageEditions').val(languageEditions);
			
			
			$("#addBookForm").find('.addRowAuthor').remove();
			$("#addBookForm").find('.addrowSpecimen').remove();	
			$('#row-Specimen').hide();			
			$("#page-content-wrapper").removeClass("booksTable overviewTable addBook");		
			$("#page-content-wrapper").addClass("editBook");
						
		/*Post form: edit book*/

$("#buttonEditBook").click(function(){
	
	if ($("#addBookForm").validate().checkForm()){	
			
			var firstISBN = $("#overview").find('dd:eq(0)').text();
						
		$.ajax({
			url:"server.php",
			method:"POST",
			data:$('#addBookForm').serialize() +'&'+$.param({ firstISBN: firstISBN }),
			success: function(data){
				$("#Books_List").empty();
				$("#Books_List").append(data);			
			}		
		});	
		
		$("#page-content-wrapper").removeClass("readerTable overviewTable addBook addReader editBook editReader");	
	$("#page-content-wrapper").addClass("booksTable");
	}		
});
				
							
	}); 	
							
	}  	
	
	
	
	/*Select the reader to overview------------*/
			
	else if ($("a").is("#showReader.active")){    
		var idLibraryCard = $(this).find('td:eq(0)').text();
			$("#page-content-wrapper").removeClass("readerTable");				$("#page-content-wrapper").addClass("overviewTable");
				$.post("server.php",{	
		   				idLibraryCard: idLibraryCard		
				},
					function(data){
						$('#overview').html(data);
					}	
				);
	
	
	/*Select the reader to edit*/ 
		$("#editReader").click(function(){ 	
 	    
		var formReaderFirstName = $("#overview").find('dd:eq(1)').text();				
		var formReaderLastName = $("#overview").find('dd:eq(2)').text();		
		var birthDate = $("#overview").find('dd:eq(3)').text();
		var gender = $("#overview").find('dd:eq(4)').text();
		var phoneNumber = $("#overview").find('dd:eq(5)').text();
		var homeAddress = $("#overview").find('dd:eq(6)').text();
									
			$('#formReaderFirstName').val(formReaderFirstName);	
			$('#formReaderLastName').val(formReaderLastName);	
			$('#birthDate').val(birthDate);			
			$('#gender').val(gender);		
			$('#phoneNumber').val(phoneNumber);			
			$('#homeAddress').val(homeAddress);				
			
			$("#page-content-wrapper").removeClass("overviewTable readerTable addReader");	
			$("#page-content-wrapper").addClass("editReader");
						
			
			/*Post form: edit reader*/

$("#buttonEditReader").click(function(){
	
	if ($("#addReaderForm").validate().checkForm()){	
		
		var editReaderID = $("#overview").find('dd:eq(0)').text();
						
		$.ajax({
			url:"server.php",
			method:"POST",
			data:$('#addReaderForm').serialize() +'&'+$.param({ editReaderID: editReaderID }),
			success: function(data){							
				$("#Readers_List").empty();
				$("#Readers_List").append(data);				
			}		
		});						
			
		$("#page-content-wrapper").removeClass("booksTable overviewTable addBook addReader editBook editReader");	
	$("#page-content-wrapper").addClass("readerTable");		
	}		
});
				
							
	});
	
	
	
	}
	
		/*Select the book to delete-------------*/
		    
 	else if ($("a").is("#delBook.active")){ 
 			    
		var delISBN = $(this).find('td:eq(0)').text();				
		if(confirm("Вы действительно хотите удалить?")){
			
			/*Delete book*/
				     
		$.post("server.php",
		{	
			DelISBN: delISBN						
		},
		function(data){							
		});
		$(this).closest('tr').remove();
		}
		
							
	}	
	
	/*Select the reader to delete-------------*/
	    
 	else if ($("a").is("#delReader.active")){ 		    
		var del = $(this).find('td:eq(0)').text();
		
		
		if ($(this).find('td:eq(7)').text() !=''){
			alert("Читатель не вернул книги");
		}
		else {
			if(confirm("Вы действительно хотите удалить?")){
			
			/*Delete reader*/	     
			$.post("server.php",
			{	
				DelIdLibraryCard: del						
			},
			function(data){								
			}	
			);
			$(this).closest('tr').remove();
			}			
		}
						
	}	
					
	else {
		var selected = $(this).hasClass("found");
   		$('.tableList tr').removeClass("found");
    		if(!selected)
           	 $(this).addClass("found");
	}
			
			
});

				/*-------------Specimen -----------*/
				
/*Delete specimen -----------*/

$('#overview').on('click', '.delitSpecimen', function(e){
	e.preventDefault();	
		if(confirm("Вы действительно хотите удалить?")){
			var delIdSpecimen = $(this).closest('tr').find('td:eq(0)').text();		
    		$(this).closest('tr').remove();	     
			$.post("server.php",
			{	
				delIdSpecimen: delIdSpecimen						
			},
			function(data){							
			}	
			);
		}    	
});

/*Edit specimen -----------*/

$('#overview').on('click', '.editSpecimen', function(e){
	e.preventDefault();	
		
			var editIdSpecimen = $(this).closest('td').find('p:eq(0)').text();		
			
			$(this).closest('td').find('div:first').hide().after("<center><div class='changeReceiptDate input-append'><input  type='date' name='editReceipDate' id='editReceipDate' class='formEditReceipDate'  /><a class='buttonEditReceipDate btn btn-warning' id='buttonEditReceipDate' href='#'><i class='icon-ok icon-white'></i></a></div></center>");
			$(".buttonEditReceipDate").click(function(){
			
			var newReceipDate = $(this).closest('td').find('.formEditReceipDate').val();	
			var IdSpecimen = $(this).closest('tr').find('td:eq(0)').text();
			var oldISBN = $("#overview").find('dd:eq(0)').text();								     
			$.post("server.php",
			{	
				newReceipDate: newReceipDate,
				IdSpecimen: IdSpecimen,
				oldISBN: oldISBN						
			},
			function(data){
				$("#overview").empty();
				$("#overview").append(data);										
			});
				
		    	}); 	
		    	
});


/*Add specimen -----------*/

$('#overview').on('click', '#addSpecimen', function(e){
	e.preventDefault();	
		
			var newSpecimen = $(this).closest('form').find('input:eq(0)').val();		
			var oldISBN = $("#overview").find('dd:eq(0)').text();				 
			$.post("server.php",
			{	
				newSpecimen: newSpecimen,
				oldISBN: oldISBN						
			},
			function(data){				
				$("#overview").empty();
				$("#overview").append(data);				
			});
					    	
});




/*Select sidebar-nav-----------*/
$("a").on("click", function(e){
	e.preventDefault();		
    $("a").removeClass("active");       
    $(this).addClass("active");	
    
    
    	
});	
					

/*Button in sidebar-nav show List-----------------*/
$("#returnMenu").on("click", function(e){
	e.preventDefault();	
	$("#page-content-wrapper").removeClass("booksTable readerTable overviewTable addBook addReader editBook editReader");	       
    	
	     	
});	
	
	
	
});	

