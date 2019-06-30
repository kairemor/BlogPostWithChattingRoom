<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!-- ---- Include the above in your HEAD tag -------- -->
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Galsen medium : Chat</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="asset/css/chat.css">
    <link rel="stylesheet" href="asset/css/clean-blog.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>

<body>

    <div class="messaging container">
        <div class="inbox_msg">
            <div class="mesgs">
                <div id="message_field" class="msg_history">
                </div>
                <div class="type_msg">
                    <div class="input_msg_write">
                        <form method="POST" action="chat_api.php?task=write">
                            <input type="hidden" id="user" name="user" value="<?php echo $_SESSION['username'] ; ?>">
                            <input type="text" id="message" name="message" class="write_msg"
                                placeholder="Ecrire votre message" />
                            <button type="submit" name="submit" class="msg_send_btn" type="button"><i
                                    class="fa fa-paper-plane" aria-hidden="true"></i></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- <script src="asset/js/app.js"></script> -->
    <?php echo '
	<script>
	var current_user = "'.$_SESSION["username"].'";
	var html = " ";
	function getMessage(){
			$(".msg_history").scrollTop($(document).height());
			var requeteAjax = new XMLHttpRequest();
			requeteAjax.open("GET" , "/chat_api.php") ;
			requeteAjax.onload = function(){
			var resultat =  JSON.parse(requeteAjax.responseText) ;	
				for(let message of resultat){
					if(current_user === message.user)
					{
						html += ` <div class="outgoing_msg">
									<div class="sent_msg">
										<p>${message.message}</p>
											<span class="time_date">${message.create_at} |
											</span> 
									</div>
								</div> ` ; 
					}else{
						if(message.user_image){
						html += `
								<div class="incoming_msg">
									<div class="incoming_msg_img"> <img src="${message.user_image}" src="https://ptetutorials.com/images/user-profile.png" alt="kmtc"> </div>
									<div class="received_msg">
									
									<div class="received_withd_msg">
										<span class="msg_user">${message.user}</span>
										<p>${message.message}</p>
									<span class="time_date"> ${message.create_at} </span></div>
								</div>
									`
						}
						else{
							html += `

										<div class="incoming_msg">
											<div class="incoming_msg_img"> <img src="https://ptetutorials.com/images/user-profile.png" alt="kmtc"> </div>
											<div class="received_msg">
											<span class="msg_user">${message.user}</span>
											<div class="received_withd_msg">
												<p>${message.message}</p>
											<span class="time_date"> ${message.create_at} </span></div>
										</div>
									`
						}
				}}
				var messages = document.getElementById("message_field"); 
				messages.innerHTML = html; 
				html = "" ; 
			}
			requeteAjax.send() ;
			
	}
	
	function postMessage(e){
			e.preventDefault();

			var author = document.querySelector("#user") ;
			var content = document.querySelector("#message") ;

			var data = new FormData();
			data.append("author", author.value);
			data.append("message", content.value);

			var requeteAjax = new XMLHttpRequest();
			requeteAjax.open("POST", "chat_api.php?task=write");
			requeteAjax.onload = function(){
					message.value = "";
					content.focus() ;
					getMessage();
			}
			requeteAjax.send(data);
	}
	document.querySelector("form").addEventListener("submit", postMessage);
	var interval = window.setInterval(getMessage, 1000) ;

	getMessage(); 
	</script>' ; 