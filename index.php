<?php
	//Message Vars
	$msg ='';
	$msgClass = '';

	//check For Submit
	if(filter_has_var(INPUT_POST, 'submit')){
		echo 'Submited'; //paspaudus submit mygtuka virsuje atsiras submited
		// Get Form Data
		$name = htmlspecialchars($_POST['name']); //kad formoj prie value islaikyti reiksmes
		$email = htmlspecialchars($_POST['email']);
		$message = htmlspecialchars($_POST['message']);

		//check required fields

		if(!empty($email) && !empty($name) && !empty($message)){
			//Passed
			//echo 'PASSED';

			//Check Email //Siuntimas suveiks tik tokiu atveju jei ikelsim i serveri
			if(filter_var($email, FILTER_VALIDATE_EMAIL) === false){
				//failed
				$msg = 'Please use a valid email';
				$msgClass ='alert-danger';

			} else {
				//Passed
				//echo 'PASSED';
				//Recipien Email

				$toEmail = 'darius@gmail.com'; //emailas i kuri bus siunciama
				//Subject
				$subject = 'Contact request From'.$name;
				$body ='<h2>Contact Request</h2>
					<h4>Name</h4><p>'.$name.'</p>
					<h4>Email</h4><p>'.$email.'</p>
					<h4>Message</h4><p>'.$message.'</p>
				';
				
				//Emails Header
				$headers ="MIME-Version: 1.0"."\r\n";
				$headers .="Content-Type:text/html;charset=UTF-8". "
					\r\n";

				//Additional header
				
				$headers .=	"From: " .$name. "<".$email.">"."r\n";

				if(mail($toEmail, $subject, $body, $headers)){
					//Email Sent
					$msg = 'Your email has been sent';
					$msgClass = 'alert-success';
				} else {
					//Failed
					$msg = 'Your email was not sent';
					$msgClass = 'alert-danger';
				}	
				
			}

		} else {
			//Failed
			$msg = 'Please fill in all fields';
			$msgClass ='alert-danger';
		}
	}
?>


<!DOCTYPE html>
<html>
<head>
	<title> Contact us</title>
	<link rel="stylesheet" href="https://bootswatch.com/4/cosmo/bootstrap.min.css">
</head>
<body>
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
		<div class="container">
			<div class="navbar-header">
				<a class="navbar-brand" href="index.php">My Website</a>
			</div>
		</div>
	</nav>
		<div class="container">

			<?php if($msg !=''): ?> <!--message not equal to nothing -->
				<div class="alert <?php echo $msgClass; ?>"><?php echo $msg; ?></div>
			<?php endif; ?>	

			<form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
				<div class="form-group">
					<label>Name</label>
					<input class="form-control" type="text" name="name" value="<?php echo isset($_POST['name']) ? $name : ''; ?> ">
				</div>
				<div class="form-group">
					<label>Email</label>
					<input class="form-control"type="email" name="email" value="<?php echo isset($_POST['email']) ? $email : ''; ?> "><!--jei laukelyje bus ivesta reiksme, ji isliks uzpildyta po submit paspaudimo (klaidos atveju, jei kiti laukai nebus uzpildyti) -->
				</div>
				<div class="form-group">
					<label>Message</label>
					<textarea class="form-control" name="message"><?php echo isset($_POST['message']) ? $message : ''; ?> </textarea>
				</div>
				<br>
					<button class="btn btn-primary" type="submit" name="submit">Submit</button>
			</form>
		</div>	
</body>
</html>


