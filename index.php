<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Chat system</title>
	<link rel="stylesheet" href="style.css">
	<script
	  src="https://code.jquery.com/jquery-3.3.1.js"
	  integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
	  crossorigin="anonymous"></script>
</head>
<body>
	
	<div id="wrapper">
		<h1>Welcome <?php session_start(); echo $_SESSION['username'];  ?> to my website</h1>
		<div class="chat_wrapper">
			<div id="chat">
				
			</div>
			<form method="POST" id="messageForm">
				<textarea name="message" class="textarea" cols="30" rows="10"></textarea>	
				
			</form>
		</div>
	</div>
	
	<script>
		LoadChat();
		//ovdje postavljamo interval za refresovanje poruka 
		setInterval(function(){
			LoadChat();
		},1000);

		function LoadChat(){
			$.post('handlers/messages.php?action=getMessage', function(response){

				//postavljanje da je skrolovano do dna da se poslednje poruke koje su poslate vide
				//i dozvoljava da se skroluje chat
				var scrollpos= $('#chat').scrollTop();
				var scrollpos= parseInt(scrollpos)+520;
				var scrollHeight=$('#chat').prop('scrollHeight');

				$('#chat').html(response);

				if(scrollpos < scrollHeight ) {

				}else{
					$('#chat').scrollTop( $('#chat').prop('scrollHeight') );
				}
				
			});
		}

		//enterom sumbitujemo formu
		$(".textarea").keyup(function(e){
			//ovaj uslov ce biti tacan samo kada pritisnemo enter jer je asci broj od entera 13 
			if (e.which==13){
				//submitujemo formu
				$('form').submit();
			}
		});

		//kad god je forma submitovana
		$('form').submit(function(){
			var message=$('.textarea').val();
			//slanje poruke post metodom
			$.post('handlers/messages.php?action=sendMessage&message=' + message,function(response){

				if(response==1){
					$("#messageForm")[0].reset();
					LoadChat();
				}
			});
			return false;

		});




	</script>


</body>
</html>