$(document).ready( function()
{
	isLogged().then(
		result => getPage(),
		error => alert("Rejected: " + error)
	);
	//Отправка комментария--------------------

	$("#form").submit(function(){

		var error = [];
		var formData = new FormData(this);
		var email = formData.get('email');
		var name =  formData.get('name');
		var text =  formData.get('text');

		if(!formData.get('name')){
			error.push('No Name');
		}

		if(formData.get('uploadimage')){
			if(!formData.get('uploadimage').type.match(/(.png)|(.jpeg)|(.jpg)|(.gif)$/i))  {
				error.push('НЕ тот формат. Картинка дожна быть : JPG, GIF, PNG');
			}
		}

		if(error.length==0)
		{
			$.ajax({
				type: "POST",
				url: "index/upload",
				data:  formData,
				processData: false,
				contentType: false,
				success: function(data)
				{
					if(data=='true')
					{
						$('#form')[0].reset();
						$('#success_ms').show();
						setTimeout(function(){
							$('#success_ms').hide();
						}, 2000);
					}
					else{
						$('#danger_ms').html(data);
						$('#danger_ms').show();
						setTimeout(function(){
							$('#danger_ms').hide();
						}, 2000);
					}
				}
			});
		}

		else {
			alert (error[0]);
			return false;
		}
		return false;
	});

	//Вход В админку---------------------------------------
	$('#signinBtn').on('click', function(){
		var admin = $("#admin").val();
		var passwd = $("#password1").val();
		if(admin != 0 && passwd != 0)
		{
			var params =
			{
				'admin' : admin,
				'passwd' : passwd ,
			};
			$.ajax({
				url : 'admin/logIn' ,
				method : 'POST' ,
				data : {
					params : params,
				},
			}).done(function( msg ) {
				if(msg=="true") {
					getPage();
					$('#form2')[0].reset();
					$(".modal").modal("hide");
					$('#alert-success').html('Успешный вход!');
					$("#alert-success").show();
					setTimeout(function(){
						$('#alert-success').hide();
					}, 5000);
					$("#logOut").show();
					$("#login").hide();
					$('.res a').show();
					$('#signinBtn').hide();
				}
				else{
					$('#alert-danger').html(msg);
					$("#alert-danger").show();
					setTimeout(function(){
						$('#alert-danger').hide();
					}, 2000);
				}
			});
		}
		else{
			$('#alert-danger').html('Заполните логин и пароль');
			$("#alert-danger").show();
			setTimeout(function(){
				$('#alert-danger').hide();
			}, 2000);
		}
		return false;
	});

	//Выход из админки--------------

	$('#logOut').on('click', function(){
		$.ajax({
			url : 'admin/logOut' ,
			method : 'POST' ,
			success : function(data){
				pagination(1);
				$('.alert').hide();
				$('.res a').hide();
				$("#logOut").hide();
				$("#login").show();
				$('#signinBtn').show();
			},
			error : function(data){
				alert("ошибка");
			}
		});
	});

	//Измениние комментария--------------------------------
	$('#updateCom').on('click', function(){
		if(confirm('точно изменить коментарий?')){
			var id = $("#idChange").val();
			var name = $("#nameChange").val();
			var email = $("#emailChange").val();
			var text = $("#textChange").val();
			console.log('Text'+text);
			if(name != 0 && email != 0 && text !=0 )
			{
				var params =
				{
					'id' : id,
					'name' : name,
					'email' : email ,
					'text' : text ,
				};
				$.ajax({
					url : 'admin/update' ,
					method : 'POST' ,
					data : {
						params : params,
					},
				}).done(function( msg ) {

					if(msg=="true") {
						getPage();
						$('#alert-success').html('Комментарий Изменен');
						$("#alert-success").show();
						setTimeout(function(){
							$('#alert-success').hide();
						}, 5000);
					}
					else{
						$('#alert-danger').html(msg);
						$("#alert-danger").show();
						setTimeout(function(){
							$('#alert-danger').hide();
						}, 5000);
					}
				});
			}
			else{
				$('#alert-danger').html('Заполните все поля!');
				$("#alert-danger").show();
				setTimeout(function(){
					$('#alert-danger').hide();
				}, 5000);
			}

		}

		return false;
	});

	//Форма для Входа в админку-------------------------

	$('#login').on('click', ()=> {
		$('#form2').show();
		$('#signInFormButton').show();
		$('#formChange').hide();
		$('#formChangeButton').hide();
	});

	$( "#selectorID" ).change(function() {
		pagination(1);
	});
});

//вывести все комм-ии --------------------------------

function showTask(page=1)
{
	let b = isLogged().then(
		result => {
			var sort = $('select').val();
			var params =
			{
				'status' : result,
				'sort' : sort,
				'page' : page,
			};
			$.ajax({
				url : 'index/showTask' ,
				method : 'POST' ,
				data : {
					params : params,
				},
				success : function(comments){
					$("#content").html(comments);
				},
				error : function(){
					alert("ошибка");
				}
			});
		},
		error => console.log("RejectedShowCom: " + error)
	);
}

//Форма для изменения комментария ------------------------------------------------
function changeElement(id){
	$('.alert').hide();
	$('#form2').hide();
	$('#signInFormButton').hide();
	$('#formChange').show();
	$('#formChangeButton').show();
	$('#idChange').html(id);
	$('#nameChange').html($('#name'+id).html());
	$('#emailChange').html($('#email'+id).html());
	$('#textChange').html($('#text'+id).html());
}

//Пропустить комментарий ------------------------------------------------

function accessElement(id){
	var params =
	{
		'id' : id,
		'isPass' : 1,
	};
	$.ajax({
		url : 'admin/isPass' ,
		method : 'POST' ,
		data : {
			params : params,
		},
		success : function(comments){
			$('#comment'+id).addClass('doneElement');
			$('#return'+id).hide();
			$('#delete'+id).show();
		},
		error : function(comments){
			alert("ошибка");
		}
	});
}

//Удалить комментарий ------------------------------------------------

function deleteElement(id){
	var params =
	{
		'id' : id,
		'isPass' : 0,
	};
	$.ajax({
		url : 'admin/isPass' ,
		method : 'POST' ,
		data : {
			params : params,
		},
		success : function(comments){
			if (comments=="true") {
				$('#comment'+id).removeClass('doneElement');
				$('#return'+id).removeClass('displayNone');
				$('#delete'+id).hide();
			}
			else {
				alert(comments);
			}
		},
		error : function(comments){
			alert("ошибка");
		}
	});
}


//Пагинация страниц комментарий ------------------------------------------------------

function pagination(page=1){
	let b = isLogged().then(result => {
		var sort = $('select').val();
		var params =
		{
			'status' : result,
			'sort' : sort,
			'page' : page,
		};
		$.ajax({
			url : 'index/pagination' ,
			method : 'POST' ,
			data : {
				params :params,
			},
			success : function(comments){
				$(".pagination").html(comments);
			},
			error : function(comments){
				alert(comments);
			}
		});
		showTask(page);
	},
	error => console.log("RejectedShowCom: " + error)
);

}

function isLogged (){
	let status = new Promise((resolve, reject) => {
		$.ajax({
			url : 'admin/isLog' ,
			method : 'POST' ,
		}).done(function( msg ) {
			if(msg=="true"){
				$("#logOut").show();
				$("#login").hide();
				$('.res a').show();
				resolve("true");
			}
			if(msg=="false"){
				$("#logOut").hide();
				$("#login").show();
				$('.res a').hide();
				resolve("false");
			}
		});
	});
return  status;
}

function getPage() {
	$.ajax({
		url : 'index/getPage',
		method : 'GET',
		success : function(comments){
			pagination(comments);
		},
		error : function(comments){
			alert( "Значение: " + comments['responseText'] );
		}
	});
}

//Влидация email ---------------------------------------------------------

function isValidEmailAddress(emailAddress) {
	var pattern = /^([a-z0-9_\.-])+@[a-z0-9-]+\.([a-z]{2,4}\.)?[a-z]{2,4}$/i;
	return pattern.test(emailAddress);
}
