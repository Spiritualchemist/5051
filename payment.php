<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Payment extends CI_Controller {
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('register_model');
	}
	
	
	function add_registration()
	{
	 	$arr['scripts_css'] = array('Styles.css');
		$arr['scripts_js'] = array('validation/register.js');
		
		extract($_REQUEST);
		
		$arr['data'] = array(
		'fname'=>'',
		'lname'=>'',
		'email'=>'',
		'password'=>'',
		'created_date'=>'',
		'updated_date'=>'');
		
		$arr['msg_email_exist'] = '';
		$arr['msg'] = '';
		
		$this->load->view('register',$arr);
	}
	
	function index()
	{
	 	$arr['scripts_css'] = array('Styles.css');
		$arr['scripts_js'] = array('validation/register.js');
		
		extract($_REQUEST);
		
		$arr['data'] = array(
		'fname'=>'',
		'lname'=>'',
		'email'=>'',
		'password'=>'',
		'created_date'=>'',
		'updated_date'=>'');
		
		$arr['msg_email_exist'] = '';
		$arr['msg'] = '';
		
		$this->load->view('register',$arr);
	}
	
	function registration_process()
	{ 		
		$arr['scripts_css'] = array('Styles.css');
		$arr['scripts_js'] = array('validation/register.js');
		
		extract($_REQUEST);
		
		$arr['data'] = array('fname'=>stripslashes($fname),
		'lname'=>stripslashes($lname),
		'email'=>stripslashes($email),
		'password'=>stripslashes($password),
		'last_login'=>date('Y-m-d H:m:s'),	
		'status'=>'i',
		'created_date'=>date('Y-m-d H:m:s'),
		'updated_date'=>date('Y-m-d H:m:s'));
		
		$last_login = date('Y-m-d H:m:s');
		$arr['msg_email_exist'] = '';
		$arr['msg'] = '';
		
		##function to check email is already exist or not.
		$chkemail=$this->register_model->chkEmailExist($email);
		if(!empty($chkemail))
		{					 
			$arr['msg_email_exist'] = 'This email is already exist.';
			$this->load->view('register',$arr);
			
		}else
		{  	
			$config['wordwrap'] = TRUE; // TRUE or FALSE (boolean)    Enable word-wrap.
			$config['wrapchars'] = 76; // Character count to wrap at.
			$config['mailtype'] = 'html'; // text or html Type of mail. If you send HTML email you must send it as a complete web page. Make sure you don't have any relative links or relative image paths otherwise they will not work.
			$config['charset'] = 'utf-8'; // Character set (utf-8, iso-8859-1, etc.).
			$config['validate'] = FALSE; // TRUE or FALSE (boolean)    Whether to validate the email address.
			$config['priority'] = 1; // 1, 2, 3, 4, 5    Email Priority. 1 = highest. 5 = lowest. 3 = normal.
			$config['crlf'] = "\r\n"; // "\r\n" or "\n" or "\r" Newline character. (Use "\r\n" to comply with RFC 822).
			$config['newline'] = "\r\n"; // "\r\n" or "\n" or "\r"    Newline character. (Use "\r\n" to comply with RFC 822).
			$config['bcc_batch_mode'] = FALSE; // TRUE or FALSE (boolean)    Enable BCC Batch Mode.
			$config['bcc_batch_size'] = 200; // Number of emails in each BCC batch.
		
			$this->load->library('email');
			$this->email->initialize($config);
			
			ini_set("SMTP", SMTP);
			ini_set("sendmail_from", FROM);
			ini_set("smtp_port", PORT);
		
			$last_id=$this->register_model->insertUser($arr['data']);	
			$user_id = base64_encode($last_id);
			$arr['msg'] = 'register';
			

			$url = site_url().'register/activeUser?id='.$user_id;
			
			$message = '<html xmlns="http://www.w3.org/1999/xhtml">
			<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
            <title>Gigster Mailer</title>
            </head><body><table style="width:600px;margin:0 auto;height:auto; border:10px solid #FFBC03; padding: 5px;">
 <tr>
    <td style="background-image:url('.site_url().'/images/header.jpg); width:570px;"  valign="top" colspan="2">
	</td>
 </tr>
  <tr>
    <td style="font-size:18px;" colspan="2">
	  Gigster Registration 
	</td> 
 </tr>
  
 <tr>
    <td style="font-size:14px;" colspan="2"> To complete your registraton, please click below written link.</td>
 </tr>
  <tr>
    <td style="font-size:14px;" colspan="2">'.$url.'</td>
 </tr>
 <tr>
    <td  height="20px" colspan="2"></td>
 </tr>
 
<tr>
   <td style="font-size:14px;" colspan="2">Regards,<br /> 
        Gigster Team<br />
       <a href="http://www.gigster.info">www.gigster.info</a></td> 
 </tr>
</table></body></html>';	

//			include("phpMailer/class.phpmailer.php");			
//			$mail = new PHPMailer(); // defaults to using php "mail()"
			
//			$body             = eregi_replace("[\]",'',$message);
//						
//			$mail->From       = "gigster.info@gmail.com";
//			$mail->FromName   = "Gigster Info";
//			$mail->Subject    = "Gigster Registration";
//			//$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!";
//			$mail->MsgHTML($body);
//			$mail->AddAddress($email, $fname); //add address whose to send
//			//$mail->AddAttachment("phpMailer/examples/images/phpmailer.gif");             // attachment if need
//			
//			$mail->Send();
			
			$this->email->from('gigster.info@gmail.com', 'Gigster Info');
			$this->email->to($email);
			$this->email->subject("Gigster Registration");
			$this->email->message($message);
			
			$this->email->send();
			
			$this->load->view('register_message',$arr);
		}
	}
	
	function add_payment()
	{
	 	$arr['scripts_css'] = array('Styles.css');
		$arr['scripts_js'] = array('validation/payment.js');
		
		extract($_REQUEST);
		


		$arr['data'] = array(
		'fname'=>'',
		'lname'=>'',
		'creditCardType'=>'',
		'card_number'=>'',
		'expDateMonth'=>'',
		'expDateYear'=>'',
		'cvv'=>'');
		
		$arr['msg_email_exist'] = '';
		$arr['msg'] = '';
		
		$this->load->view('payment',$arr);
	}
	
	function payment_process()
	{ 	
		session_start();	
		
		$arr['scripts_css'] = array('Styles.css');
		$arr['scripts_js'] = array('validation/payment.js');
		
		extract($_REQUEST);
		
		require_once 'CallerService.php';		

		/**
		 * Get required parameters from the web form for the request
		 */
		$firstName =urlencode( $_POST['fname']);
		$lastName =urlencode( $_POST['lname']);
		$creditCardType =urlencode( $_POST['creditCardType']);
		$creditCardNumber = urlencode($_POST['card_number']);
		$expDateMonth =urlencode( $_POST['expDateMonth']);

		// Month must be padded with leading zero
		$padDateMonth = str_pad($expDateMonth, 2, '0', STR_PAD_LEFT);
		
		$expDateYear =urlencode( $_POST['expDateYear']);
		$cvv2Number = urlencode($_POST['cvv']);
		$amount = urlencode("1.00");
		$currencyCode="USD";
		$paymentType =urlencode('Sale');
		
		/* Construct the request string that will be sent to PayPal.
		   The variable $nvpstr contains all the variables and is a
		   name value pair string with & as a delimiter */

		//$nvpstr="&PAYMENTACTION=$paymentType&AMT=$amount&CREDITCARDTYPE=$creditCardType&ACCT=$creditCardNumber&EXPDATE=".         $padDateMonth.$expDateYear."&CVV2=$cvv2Number&FIRSTNAME=$firstName&LASTNAME=$lastName&CURRENCYCODE=$currencyCode";
		
		$nvpstr="&PAYMENTACTION=$paymentType&AMT=$amount&CREDITCARDTYPE=$creditCardType&ACCT=$creditCardNumber&EXPDATE=".         $padDateMonth.$expDateYear."&CVV2=$cvv2Number&FIRSTNAME=$firstName&LASTNAME=$lastName&STREET=$address1&CITY=$city&STATE=$state".
"&ZIP=$zip&COUNTRYCODE=US&CURRENCYCODE=$currencyCode";
		/* Make the API call to PayPal, using API signature.
		   The API response is stored in an associative array called $resArray */
		$resArray=hash_call("doDirectPayment",$nvpstr);
		
		$arr['msg'] = 'payment_success';
		/* Display the API response back to the browser.
		   If the response from PayPal was a success, display the response parameters'
		   If the response was an error, display the errors received using APIError.php.
		   */
		$ack = strtoupper($resArray["ACK"]);
		
		$arr["resArray "]= $resArray;
		if($ack!="SUCCESS")  
		{
			$arr['msg'] = 'payment_error';
			$_SESSION['reshash']=$resArray;			
//			$location = "APIError.php";
//			header("Location: $location");
			$this->load->view('register_message',$arr);
		}else{
			
			$this->load->view('register_message',$arr);
		}
			
			
	}
	
	
	function activeUser()
	{ 		
		$arr['scripts_css'] = array('Styles.css');
		$arr['scripts_js'] = array('validation/register.js');
		
		extract($_REQUEST);
		if(isset($id))
		{
			$login_id = base64_decode($id);
			##function to activate the user.
			$last_id  = $this->register_model->activeUser($login_id);	
			$arr['msg'] = 'register_success';
		}else
		{
			$arr['msg'] = 'register_not_success';
		}
		$this->load->view('register_message',$arr);
	}
	
	function testMail()
	{
		/**  mail functions code start here*/
			//$mail_file = site_url()."phpMailer/class.phpmailer.php";
			
			//include(site_url()."phpMailer/class.phpmailer.php");
			include("phpMailer/class.phpmailer.php");	
			
			ini_set("SMTP", "smtp.net4india.com");
			ini_set("sendmail_from", "mails@aambien.in");
			ini_set("smtp_port", "25");	
			
			$name = 'Laxman Kemase';			
			$email = 'laxman.kemase@gmail.com';
			$password = 'laxman';
			$login_url = site_url();
			
			$mail = new PHPMailer(); // defaults to using php "mail()"

			$body             = '<body>
								<table width="100%" border="0"  style="width:600px;margin:0 auto;height:auto; border:10px solid #87B9D1;">
								  <tr>
									<td style="height:113px;" valign="top" colspan="3">
										
									</td>
								 </tr>
								  <tr>
									<td width="53" style="width:50px;"></td>
									<td style="font-size:18px;" colspan="2">
									  BJP Registration
									</td> 
								 </tr>
								  
								 <tr>
									<td style="width:50px;"></td>
									<td style="font-size:14px;" colspan="2">Dear '.$name.',</td>
								 </tr>
								 
								 <tr>
									<td style="width:50px;"></td>
									<td style="font-size:14px;" colspan="2">Thank you for signing up with us. Your account has been setup and you can now login to our website using the details below. </td>
								 </tr>
								 
								 <tr>
									<td style="width:50px;"></td>
									<td style="font-size:14px;">Email:</td> 
									<td width="360" >'.$email.'</td>
								 </tr>
								  <tr>
									<td style="width:50px;"></td>
									<td style="font-size:14px;">Password:</td> 
									<td width="360" >'.$password.'</td>
								 </tr> 
								 <tr>
									<td style="width:50px;"></td>
									<td style="font-size:14px;" colspan="2">Use above details to BJP login.</td>
								 </tr>
								  <tr>
									<td style="width:50px;"></td>
									<td style="font-size:14px;" colspan="2">click here to login for BJP site: '.$login_url.'</td>
								 </tr>
								 
								 <tr>
									<td  height="20px" colspan="3"></td>
								 </tr>
								 
								<tr>
									<td style="width:50px;"></td>
									<td style="font-size:14px;" colspan="2">Regards,<br /> 
										BJP Team<br />
									   <a href="'.site_url().'">BJP Team</a></td> 
								 </tr>
								 <tr>
									<td height="10px" colspan="3"></td>
								 </tr>
								</table>
								</body>';	
								
			//$body             = $mail->getFile('contents.html');
			
			$body             = eregi_replace("[\]",'',$body);
			
			//$body = 'Test';
			
			$mail->From       = "gigster.info@gmail.com";
			//$mail->From       = "mails@aambien.in";
			$mail->FromName   = "Gigster Info";
			
			$mail->Subject    = "Gigster Info Registration";
			
			//$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!";
									// optional, comment out and test
			
			$mail->MsgHTML($body);
			
			$mail->AddAddress($email, $name); //add address whose to send
			
			$mail->AddAttachment("phpMailer/examples/images/phpmailer.gif");             // attachment if need
			
			if(!$mail->Send()) {
			  echo "Mailer Error: " . $mail->ErrorInfo;
			  //$this->load->view('payment_details',$arr);
			} else {
			  echo "Mail sent! " ;
			}
			
			//$arr['msg'] = 'register_not_success';
			
			//$this->load->view('register_message',$arr);
		/**  mail functions code end here*/
	}
	
	function testGMail()
	{
		//error_reporting(E_ALL);
		error_reporting(E_STRICT);
		
		date_default_timezone_set('America/Toronto');
		
		include("phpMailer/class.phpmailer.php");
		//include("class.smtp.php"); // optional, gets called from within class.phpmailer.php if not already loaded
		
		ini_set("SMTP", "smtp.net4india.com");
		ini_set("sendmail_from", "mails@aambien.in");
		ini_set("smtp_port", "25");
		
		
		$mail             = new PHPMailer();
		
		$body             = $mail->getFile('phpMailer/examples/contents.html');
		$body             = eregi_replace("[\]",'',$body);
		
		$mail->IsSMTP();
		$mail->SMTPAuth   = true;                  // enable SMTP authentication
		$mail->SMTPSecure = "ssl";                 // sets the prefix to the servier
		$mail->Host       = "smtp.gmail.com";      // sets GMAIL as the SMTP server
		$mail->Port       = 465;                   // set the SMTP port for the GMAIL server
		
		$mail->Username   = "laxman.kemase.gc@gmail.com";  // GMAIL username
		$mail->Password   = "laxman123";            // GMAIL password
		
		//$mail->AddReplyTo("laxman.kemase.gc@gmail.com","Testing");
		
		$mail->From       = "gigster.info@gmail.com";
			//$mail->From       = "mails@aambien.in";
		$mail->FromName   = "Gigster Info";
			
		$mail->Subject    = "Gigster Info Registration";
		
		//$mail->Body       = "Hi,<br>This is the HTML BODY<br>";                      //HTML Body
		$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
		$mail->WordWrap   = 50; // set word wrap
		
		$mail->MsgHTML($body);
		
		$mail->AddAddress("laxman.kemase@gmail.com", "Laxman");
		
		$mail->AddAttachment("phpMailer/examples/images/phpmailer.gif");             // attachment
		
		$mail->IsHTML(true); // send as HTML
		
		if(!$mail->Send()) {
		  echo "Mailer Error: " . $mail->ErrorInfo;
		} else {
		  echo "Message sent!";
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
?>