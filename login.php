<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller 
{
	 
	function __construct()
	{
		parent::__construct();
		$this->load->model('login_model');
		$this->load->model('client_model');
	}

	 public function index()
	 {
	 	 $arr['scripts_css'] = array('Styles.css');
		 $arr['scripts_js'] = array('jquery-1.7.1.js');
		
		 extract($_REQUEST);
		 $arr['data'] = array(
		'username'=>'',
		'password'=>'');
		 $arr['msg'] = '';
		 
		 $array_unset = array('login_id' => '', 'fname' => '','lname' =>'', 'email' => '');
		$this->session->unset_userdata($array_unset);	
		//$arr['page_name']='login';	
		 $this->load->view('index',$arr);
         
	 }
	 
	 function logout()
	{
			session_start();
			session_destroy();
			 $array_unset = array('login_id' => '', 'fname' => '','lname' =>'', 'email' => '');
			$this->session->unset_userdata($array_unset);		
			$this->session->set_flashdata('user_flash', 'You are logged out successfully.');	
			error_reporting(0);
			$arr['msg'] = '';
			redirect(site_url().'home');
		
	}

    function home()
    {
        #created array toinclude js and css

        $arr['scripts_css'] = array('left_menu.css','Styles.css');

        $arr['scripts_js'] = array('drop/common.js','dropdown/jquery.min.js');



        extract($_REQUEST);



        if($this->session->userdata('login_id')!='')
        {

            $this->load->view('user_landing',$arr);

        }
        else
        {
            $arr['msg'] = '';
            if( isset($_REQUEST['Submit'] ) )
            {

                $data=array('username'=>stripslashes(trim($username)),'password'=>stripslashes(trim($password)));

                ## checking email and password with database.

                $found=$this->login_model->chkUserAuth($data);



                if($found)
                {

                    if($found[0]->status == 'a')

                    {

                        $newdata = array(

                            'login_id'  => $found[0]->login_id,

                            'fname'  => $found[0]->fname,

                            'lname' => $found[0]->lname,

                            'last_login' => $found[0]->last_login,

                            'email' => $found[0]->email,
                            
                            'user_type' => $found[0]->user_type

                        );



                        $this->session->set_userdata($newdata);



                        $last_login = stripslashes(trim(date('Y-m-d H:i:s')));


                        
                        $res['bool'] = $this->client_model->updateClient($last_login, $username, $password);



                        $this->load->view('user_landing',$arr);

                    }else{

                        $arr['msg'] = 'Your account is not activated.';

                        $this->load->view('index',$arr);

                    }
                    
                }else

                {

                    $arr['msg'] = 'Credential do not match!!! Try again';

                    $this->load->view('index',$arr);

                }
            } else {
                $this->load->view('index',$arr);
            }

        }

    }

    function forgot_password()
    {

        #created array toinclude js and css

        $arr['scripts_css'] = array('Styles.css');

        $arr['scripts_js'] = array('jquery-1.7.1.js');



        $arr['msg']='';

        $arr['msg_email_not_exist'] = '';



        $this->load->view('forgot_password',$arr);

    }



    function password_recovery()
    {

        #created array toinclude js and css

        $arr['scripts_css'] = array('Styles.css');

        $arr['scripts_js'] = array('common.js');

        $arr['msg']='';

        $arr['msg_email_not_exist'] = '';

        if( isset($_REQUEST['Submit'] ) )
        {
            $email = isset($_REQUEST['email']) ? trim($_REQUEST['email']) : '';

            $data['chk']=$this->client_model->chk_email($email);
            if($data['chk'])
            {
                $password = $data['chk'][0]['password'];

                $login_url = site_url().'login';

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

                $message = '<html xmlns="http://www.w3.org/1999/xhtml">

                <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

                <title>Password Recovery</title>

                </head><body><table style="width:600px;margin:0 auto;height:auto; border:10px solid #FFBC03; padding:5px;">

                <tr>

                <td style="background-image:url('.site_url().'images/header.jpg); width:570px;" valign="top" colspan="2"></td>

                </tr>

                <tr>

                <td style="font-size:18px;" colspan="2">

                Gigster Login Details

                </td>

                </tr>

                <tr>

                <td width="67" style="font-size:14px;">Email:</td>

                <td width="503" >'.$email.'</td>

                </tr>

                <tr>

                <td style="font-size:14px;">Password:</td>

                <td width="503" >'.$password.'</td>

                </tr>

                <tr>

                <td style="font-size:14px;" colspan="2">Use above details to login into gigstreamer.com</td>

                </tr>

                <tr>

                <td style="font-size:14px;" colspan="2">click here to login for gigstreamer.com: '.$login_url.'</td>

                </tr>

                <tr>

                <td  height="20px" colspan="2"></td>

                </tr>



                <tr>

                <td style="font-size:14px;" colspan="2">Regards,<br />

                Gigstreamer Team<br />

                <a href="http://www.gigstreamer.com">www.gigstreamer.com</a></td>

                </tr>

                </table></body></html>';



//                include("phpMailer/class.phpmailer.php");
//
//                $mail = new PHPMailer(); // defaults to using php "mail()"
//
//                $body             = eregi_replace("[\]",'',$message);
//
//                $mail->From       = "gigster.info@gmail.com";
//
//                $mail->FromName   = "Gigster Info";
//
//                $mail->Subject    = "Gigster Password Recovery";
//
//                $mail->MsgHTML($body);
//
//                $mail->AddAddress($email, 'Gigster User'); //add address whose to send
//
//                $mail->Send();



                            $this->email->from('system@gigstreamer.com', 'Gigstreamer.com');

                            $this->email->to($email);

                            $this->email->subject("Gigstreamer Password Recovery");

                            $this->email->message($message);



                            $this->email->send();





                $arr['msg']='Password successfully sent on your email id.';



            }
            else
            {
                $arr['msg']='Please enter correct email id.';
            }
        }
        $this->load->view('forgot_password',$arr);
    }
		
}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
