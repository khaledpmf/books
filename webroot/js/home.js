$(document).ready(function (e) {

	//Get all data
	populateData();

	//+ NEW button dialog
	$(".add button").click(function(){
		var html = "<form id='add-book' action='' method='post' enctype='multipart/form-data'> <ul> <li> <input class='usr-input form-control form-control-sm' type='text' name='title' placeholder='Title'> </li> <li> <input class='usr-input form-control form-control-sm' type='text' name='author' placeholder='Author'> </li> <li> <div class='input-group'> <input class='usr-input def-date form-control form-control-sm' type='text' name='released' placeholder='Released'> <span class='input-group-addon'><span class='fas fa-calendar' aria-hidden='true'></span></span> </div></li> <li> <input type='button' class='btn btn-primary upload' value='Upload IMG'><i class='filename'></i> <input class='usr-input btn btn-default hidden' type='file' name='image' id='fileToUpload'> </li> <li> <input class='btn btn-primary save' type='submit' value='Save'> <input data-dismiss='modal' class='btn btn-danger back' type='button' value='Back'> </li> </ul> </form>";

		//Show dialog
		bootbox.dialog({
			 	title: "Add new book",
			 	size: "medium",
			 	message: html
			 });

		//Bind buttons events
		$(".upload").on('click',function(){
			chooseImg();
		});

		$("#add-book").on('submit',(function(e) {
			e.preventDefault();

			if(validateFields()){
				//Validate image on server
				$.ajax({
					async: false,
				 	url: "Ajax/validate",  
					type: "POST",      		
					data:  new FormData(this), 
					contentType: false,       
				    cache: false,			
					processData:false,  	
					success: function(data)  
				    {	
				    	if(data.data.success){
				    		saveBook(data.data.img);
				    	}
				    	else{
				    		showError(data.data.error);
				    	}
				    }      
				});
			}else{
				$.notify("All fields are mandatory.", { position:"bottom center",autoHideDelay: 4000, className: "warn"});
			}

		}));

		//Init calendar
		initCalendar();

	});

});

function validateFields(){

	var emptyData = false;

	$(".usr-input").each(function(){
		if($(this).val()==""){
			emptyData = true;
		}
	});

	if(!emptyData){
		return true;
	}
	else{
		return false;
	}
}

function showError(error){
	$.notify(error, { position:"bottom center",autoHideDelay: 4000, className: "error"});
}

function chooseImg(){
	$("#fileToUpload").trigger('click');
	$("#fileToUpload").on('change',function(){
		$(".upload").val("reUpload");
		$(".filename").text($("#fileToUpload").val().replace(/^.+\\/gm,''));
		$(".upload").css('background','#4fa74f');
	});
}

function saveBook(imgName){
	$.ajax({
	url:"books/add/",
	data: $(".usr-input").serialize()+"&img_url="+imgName,
	type: "post"
	}).done(function (books, textStatus, jqXHR){
		populateData();
		bootbox.hideAll();
	});
}

function editBook(id){
	$.ajax({
	url:"books/view/"+id,
	type: "post"
	}).done(function (book, textStatus, jqXHR){
		var html = "<form id='edit-book' action='' method='post' enctype='multipart/form-data'> <ul> <li> <input class='usr-input form-control form-control-sm' type='text' name='title' placeholder='"+book.title+"'> </li> <li> <input class='usr-input form-control form-control-sm' type='text' name='author' placeholder='"+book.author+"'> </li> <li> <div class='input-group'> <input class='usr-input def-date form-control form-control-sm' type='text' name='released' placeholder='"+book.released+"'> <span class='input-group-addon'><span class='fas fa-calendar' aria-hidden='true'></span></span> </div></li> <li> <input type='button' class='btn btn-primary upload' value='Upload IMG'><i class='filename'></i> <input class='usr-input btn btn-default hidden' type='file' name='image' id='fileToUpload'> </li> <li> <input class='btn btn-primary edit' type='submit' value='Save'> <input data-dismiss='modal' class='btn btn-danger back' type='button' value='Back'> </li> </ul> </form>";
		
		//Show dialog with info
		bootbox.dialog({
			 	title: "Edit book info",
			 	size: "medium",
			 	message: html
			 });

		//Bind buttons events
		$(".upload").on('click',function(){
			chooseImg();
		});

		$("#edit-book").on('submit',(function(e) {
			e.preventDefault();

			if(validateFields()){
				//Validate image
				$.ajax({
					async: false,
				 	url: "Ajax/validate",  
					type: "POST",      		
					data:  new FormData(this), 
					contentType: false,       
				    cache: false,			
					processData:false,  	
					success: function(data)  
				    {	
				    	if(data.data.success){
				    		updateBook(id,data.data.img);
				    	}
				    	else{
				    		showError(data.data.error);
				    	}
				    }      
				});
			}else{
				$.notify("All fields are mandatory.", { position:"bottom center",autoHideDelay: 4000, className: "warn"});
			}

		}));

		//Init calendar
		initCalendar();
	});
}


function initCalendar(){
	$('.def-date').datepicker({
		dateFormat: 'mm/dd/yy',
		autoclose: true,
		todayHighlight: true
	});
}

function updateBook(id,imgName){
	$.ajax({
	url:"books/edit/"+id,
	data: $(".usr-input").serialize()+"&img_url="+imgName,
	type: "post"
	}).done(function (books, textStatus, jqXHR){
		populateData();
		bootbox.hideAll();
	});

}

function delBook(id,obj){
bootbox.confirm({
    title: 'Delete',
    message: 'Are you sure?',
    buttons: {
        'cancel': {
            label: 'No',
        },
        'confirm': {
            label: 'Yes',
        }
    },
    callback: function(result) {
		if(result){
			$.ajax({
			url:"books/delete/"+id,
			type: "post"
			}).done(function (books, textStatus, jqXHR){
				obj.closest(".book").remove();
			});
		}
    }
});
}

function populateData(){
	var content = "";
	var authors = [];
	var years = [];
	var titles = [];

	$.ajax({
	url:"books.json",
	type: "post"
	}).done(function (books, textStatus, jqXHR){
			books.forEach(function(book,key){
				content += "<div class='col-sm-6 col-md-3 book'> <div class='thumbnail'> <img src='webroot/upload/"+book.img_url+"' alt='Generic placeholder thumbnail'> </div> <div class='caption'> <h4>"+book.title+"</h4> <h5><i>"+book.author+"</i></h5> <p>"+book.released+"</p> <p> <a href='#'  class='btn btn-primary' onclick='editBook("+book.id+");' role='button'> Edit </a> <a onclick='delBook("+book.id+",this);' class='btn btn-default' role='button'> Delete </a> </p> </div> </div>";
				authors.push(book.author);
				titles.push(book.title);
				years.push(book.released.replace(/^.+\//gm,''));
			});

			//Remove duplicate results in authors, years & title
			var uniqueAuthors = authors.filter(function(elem, index, self) {
			    return index === self.indexOf(elem);
			});
			var uniqueYears = years.filter(function(elem, index, self) {
			    return index === self.indexOf(elem);
			});
			var uniqueTitles = titles.filter(function(elem, index, self) {
			    return index === self.indexOf(elem);
			});


			//Update filters data
    		$( "#author" ).autocomplete({
    		  source: uniqueAuthors,
    		  select: function(event, ui) {
    		  	getFilteredData();
    		  }
    		});

    		$( "#year" ).autocomplete({
    		  source: uniqueYears,
    		  select: function(event, ui) {
    		  	getFilteredData();
    		  }
    		});

    		$( "#title" ).autocomplete({
    		  source: uniqueTitles,
    		  select: function(event, ui) {
    		  	getFilteredData();
    		  }
    		});

    		$( ".filter" ).focusout(function(){
    			getFilteredData();
    		});

    		//Display generated content
			$("#books-data").html(content);
			
	    });
}

function getFilteredData(){
	setTimeout(function(){
		$.ajax({
			url:"books/search",
			data: $(".filter").serialize(),
			type: "post"
			}).done(function (books, textStatus, jqXHR){
				showFilteredData(books);
		});
	},100);
}

function showFilteredData(books){
	var content = "";

	books.forEach(function(book,key){
		content += "<div class='col-sm-6 col-md-3 book'> <div class='thumbnail'> <img src='webroot/upload/"+book.img_url+"' alt='Generic placeholder thumbnail'> </div> <div class='caption'> <h4>"+book.title+"</h4> <h5><i>"+book.author+"</i></h5> <p>"+book.released+"</p> <p> <a href='#'  class='btn btn-primary' onclick='editBook("+book.id+");' role='button'> Edit </a> <a onclick='delBook("+book.id+",this);' class='btn btn-default' role='button'> Delete </a> </p> </div> </div>";
	});
	$("#books-data").html(content);
}