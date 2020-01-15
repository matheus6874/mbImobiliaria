//Função que verifca no modal de login se os campos estão preencidos e o usuário é válido
$(document).ready(function(){  
	$('#login_button').click(function(){  
		var usuario = $('#usuario').val();  
		var password = $('#password').val();  
		if(usuario != '' && password != '')  
		{  
			$.ajax({  
				url:"fazLogin.php",  
				method:"POST",  
				data: {usuario:usuario, password:password},  
				success:function(data) {  
					if(data == 'No') {  
						alert("Usuário ou senha iválido");  
					}  
					if(data == 'Yes')  {  
						window.location.href = "indexRestrito.php";
					}
				}  
			});  
		}  
		else  
		{  
			alert("Preencha o campo login e senha");  
		}  
	});  
});  

$(document).ready(function(){

	$("#formCadastroFuncionario",).validate({
		rules:{
			nome: {
				required: true,
				maxlength: 100,
				minlength: 10,
				minWords: 2
			},
			email: {
				required: true,
				email: true
			},
			estadoCivil :{
				required : true
			},
		}
	})

	$(".cpf").mask("000.000.000-00")
	$(".telefone").mask("(00) 00000-0000")
	$(".cep").mask("99999-999")
	$(".data").mask("00/00/0000")
	$(".salario").mask("999.999.990,00", {reverse: true})

	var options = {
		translation: {
			'A': {pattern: /[A-Z]/},
			'a': {pattern: /[a-zA-Z]/},
			'S': {pattern: /[a-zA-Z0-9]/},
			'L': {pattern: /[a-z]/},
		}
	}
		
	$(".telefone").mask("(00) 0000-00009")
	
	$(".telefone").blur(function(event){
		if ($(this).val().length == 15){
			$(".telefone").mask("(00) 00000-0009")
		}else{
			$(".telefone").mask("(00) 0000-00009")
		}
	})
});

$(document).ready(function(){
	$('#tipoImovelDivSelect').on('change', function() {
	  if ( this.value == '1')//Casa
	  {
		$("#imovelApartamento").hide();
		$("#imovelCasa").show();
		$("#botoes").show();
	  }

	  else if( this.value == '2')//Apartamento
	  {
		  $("#imovelCasa").hide();			
		  $("#imovelApartamento").show();
		  $("#botoes").show();
	  }

		else{
			 $("#imovelCasa").hide();
			  $("#imovelApartamento").hide();
		}
	});
});

function buscaEndereco(cep)
{
	if (cep.length != 9)
		return;

	$.ajax({

		url: 'buscaEndereco.php',
		type: 'POST',
		async: true,
		dataType: 'json',
		data: {'cep': cep},

		success: function (result)
		{

			// se dataType fosse 'html', então seria necessário
			// converter a string JSON recebida em um objeto JavaScript
			// manualmente (utilizando a função JavasScript JSON.parse)

			// Neste exemplo, como dataType foi definido para o valor 'json', então a conversão
			// da string para um objeto JavaScript é realizada automaticamente.

			// NOTA IMPORTANTE 1: Entretanto, todo conteúdo gerado
			// pelo script PHP precisa ser convertido para JSON (no servidor, em PHP).
			// Caso contrário, teremos um erro de conversão para
			// JSON no JavaScript/jQuery, o que faz com que esta parte
			// do código (success:) não seja executada, mas sim a parte
			// definida em 'error:'. Isto pode acontecer mesmo
			// quando o script PHP termina sem gerar erros.

			// NOTA IMPORTANTE 2: Em algumas situações esta funçao pode ser
			// executada mesmo quando o script PHP não termina com sucesso
			// (por exemplo, quando ocorrem erros de sintaxe na linguagem PHP). Isto acontece
			// porque o PHP (em conjunto com o servidor web) pode retornar
			// o código de STATUS '200-OK' mesmo quando há erros/warnings no script.

			if (result != "") {
				document.forms[0]["logradouro"].value = result.rua;
				document.forms[0]["bairro"].value = result.bairro;
				document.forms[0]["cidade"].value = result.cidade;
				document.forms[0]["estado"].value = result.estado;
			}
		},

		error: function (xhr, textStatus, error)
		{
			// xhr é o objecto XMLHttpRequest
			// No caso de um erro HTTP, o terceiro parametro 'error' contem a string 
			// correspondente ao código do erro, como "Not found" ou "Internal Server Error"
			alert(textStatus + error + xhr.responseText);
		}

	});

}

function verificaSenhas() {
	//Limpa valores do formulário de cep.
	var senha = document.getElementById('senhaFuncionario').value;
	var senha2 = document.getElementById('confirmacaoSenhaFuncionario').value;
	if(senha != senha2)
		alert("Senhas diferentes, favor digitar senhas iguais")
}



//Esconde e mostra informações
$(document).ready(function() {

	$(".imgGalery").each(function(i) {
		$(this).delay(200*i).fadeIn();
	});

	$("#missaoClick").click(function(){
		$("#missao").slideToggle(500);

	});

	$("#valoresClick").click(function(){
		$("#valores").slideToggle(500);

	});

	$("#homeClick").click(function(){
		$("#homep").slideToggle(500);

	});
});



function destaca(img){
	img.style.border = '1px solid #C0C0C0';
}

function destaca_n(img){
	img.style.border = '0';
}

function preload() { //Pré carrega as imagens
	imgs=Array('../images/p1.jpg','../images/p2.jpg','../images/p3.jpg','../images/p4.jpg','../images/p5.jpg','../images/p6.jpg');
	imgQtde = imgs.length;
	for(i=0; i<imgQtde; i++){
		var preloading= new Image();
		preloading.src= imgs[i];
	}
}

function SliderStart(){
	preload(); 
	max = 6;
	min = 1;
	PFirst = min;
	transition= true; //Transição entre as imagens
	loadP("../images/p1.jpg"); //Imagem inicial
	document.getElementById("slider").addEventListener("transitionend", endT);
	timer= setInterval(changeP,5000); //Seta o tempo de troca
}

function changeP () {

	transition= false;
	PFirst++;
	if(PFirst>max){
		PFirst= min;
	}
	loadP("../images/p"+PFirst+".jpg");

}

function endT ()  {
	transition =true;
}

function loadP(photo){
	document.getElementById("slider").style.backgroundImage="URL("+photo+")";
}

function prox() {
	clearInterval(timer);
	if(transition){
		transition= false;
		PFirst++;
		if(PFirst>max){
			PFirst= min;
		}
		loadP("../images/p"+PFirst+".jpg");
	}
	timer= setInterval(changeP,5000);

}
function ant() {
	clearInterval(timer);
	if(transition){
		transition= false;
		PFirst--;
		if(PFirst<min){
			PFirst= max;
		}
		loadP("../images/p"+PFirst+".jpg");
	}
	timer= setInterval(changeP,5000);
}
