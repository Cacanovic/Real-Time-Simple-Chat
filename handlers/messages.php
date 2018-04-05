<?php
session_start();
include('../config.php');

$user=$_SESSION['username'];

switch ($_REQUEST['action']) {
	case 'sendMessage':
			$query=$db->prepare("INSERT INTO messages SET user= ?, message=? ");
			$run= $query->execute([$_SESSION['username'] , $_REQUEST['message']]);

			//ako je prosao
			if($run){
				echo "1";
				exit;
			}
		break;
	case 'getMessage':
			$query=$db->prepare("SELECT * FROM  messages ");
			$run= $query->execute();
			$rs=$query->fetchAll(PDO::FETCH_OBJ);

			$chat='';
			foreach ($rs as $message) {
				if($message->user==$user){
					$chat.='<div class="single-message">
								<strong>'.$message->user.': </strong> <br>'.$message->message.'<br><br>
								<span>'.date('h:i a',strtotime($message->date)) .'</span>
							</div>';					
				}else{
					$chat.='<div class="single-message1">
								<strong>'.$message->user.': </strong> <br>'.$message->message.'<br><br>
								<span>'.date('h:i a',strtotime($message->date)) .'</span>
							</div>';	
				}
			}
			echo $chat;
		break;
	
	
}



?>