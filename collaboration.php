<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Collaboration extends CI_Controller 
{
	/*
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, its displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	function __construct()
	{
		parent::__construct();

		if ($this->session->userdata('fname') == '') {
			redirect(site_url() . 'home');

		}
		//$this->load->library('pagination');
		$this->load->model('collaboration_model');
	}
		
	
	/**	 
	 * function to call view page to send mail to client's
	 */	
	public function email_collaboration()
	{
		/*$arr['scripts_css'] = array(
			'left_menu.css',
			'Styles.css',
			'calender/jquery.ui.all.css',
			'calender/demos.css',
			'fancybox/jquery.fancybox-1.3.4.css',
			'alert/alerts_box.css',
			'leaflet/leaflet.css',            

		);
		$arr['scripts_js'] = array(
			'jquery-1.8.3.min.js',
			'jquery.form.js', 
			'drop/common.js',
			'calender/jquery.ui.core.js',
			'calender/jquery.ui.datepicker.js',
			'fancybox/jquery.fancybox-1.3.4.js',
			'validation/compose_email.js',
			'leaflet/leaflet.js',    
			'auoto_generate/jquery.js',        
		);    
		*/


		$arr['scripts_css'] = array(
			'left_menu.css',
			'calender/jquery.ui.all.css', 
			'calender/demos.css',
			'Styles.css',
			'fancybox/jquery.fancybox-1.3.4.css',
		);
		$arr['scripts_js'] = array(
			'jquery-1.8.3.min.js', 
			'jquery.form.js', 
			'drop/common.js',
			'validation/compose_email.js',
			'auoto_generate/jquery.js',
			'fancybox/jquery.fancybox-1.3.4.js',
		);
		
		$arr['msg_email_exist'] = '';

		$a_receiver = array();
		$i_user = $this->session->userdata('login_id');
		$a_receivers = $this->collaboration_model->user_receivers($i_user);

		foreach($a_receivers as $key => $a_value) {
			$a_receiver[] = $a_value->mrc_s_email_id;
		}

		$arr['i_count_contact'] = $this->collaboration_model->getAllContactsCount($i_user);

		$arr['sort'] = 'msg_i_id';
		$arr['order_by'] = 'desc';
		$sort = 'msg_i_id';
		$order_by = 'desc';
		
		if(isset($no_of_records) && $no_of_records!='')
		{
			$arr['no_of_records'] = $no_of_records;//$no_of_records
			$arr['selected'] = "Selected";
			$cp_page['per_page'] = $no_of_records;
		}
		else
		{
			$arr['no_of_records'] = 250;
			$arr['selected'] = "";
			$cp_page['per_page'] = 250;
		}
		
		$per_page = isset($_REQUEST['per_page']) ? $_REQUEST['per_page'] : '0';
		$cur_page = $per_page / $no_of_records ;
		
		$login_id = $this->session->userdata('login_id');
		$s_email_id = $this->session->userdata('email');

		//3 for colaborate message
		$i_message_type = 2;
		$cnt = $this->collaboration_model->getArtistMessagesCount($login_id, $i_message_type,$s_email_id);
		
		$query_str = "?no_of_records=".$no_of_records;
		
		$arr['query_str']=$query_str;
		$cp_page['num_links']= '5';
		
		$cp_page['base_url'] = base_url().'collaboration/get_collaborate_messages'.$query_str;
		$cp_page['total_rows'] = $cnt;
		$cp_page['cur_page'] = $cur_page * $no_of_records;
					
		$this->pagination->initialize($cp_page);
		$arr['a_msg']=$this->collaboration_model->getArtistMessages($cp_page['per_page'],(int)$per_page,$sort,$order_by, $login_id, $i_message_type, $s_email_id);

		$arr['a_receiver'] = $a_receiver;
		$this->load->view('collaboration',$arr);	
	}

	/**	 
	 * function to call view page to send mail to client's
	 */	
	public function create_email()
	{
		$arr['scripts_css'] = array('left_menu.css','calender/jquery.ui.all.css', 'calender/demos.css','Styles.css');
		$arr['scripts_js'] = array('jquery-1.8.3.min.js', 'jquery.form.js', 'drop/common.js','validation/compose_email.js','auoto_generate/jquery.js');
		
		$arr['msg_email_exist'] = '';

		$a_receiver = array();
		$i_user = $this->session->userdata('login_id');
		$a_receivers = $this->collaboration_model->user_receivers($i_user);

		foreach($a_receivers as $key => $a_value) {
			$a_receiver[] = $a_value->mrc_s_email_id;
		}
		$arr['a_receiver'] = $a_receiver;
		$this->load->view('create_email',$arr);	
	}


	/**	 
	 * function to save contacts
	 */	
	public function save_contact()
	{	
		try {

			// echo '<pre>';
			// print_r($_REQUEST);
			// die;
			
			if( empty($_REQUEST['s_name']) )
				throw new Exception('Contact name is required.');
			if( empty($_REQUEST['s_email_id']) )
				throw new Exception('Contact email id is required.');					
			if(!preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/',$_REQUEST['s_email_id']))
				throw new Exception('Invalid email ID.');
			
			$login_id = $this->session->userdata('login_id');

			//check contact is already present or not.
			$arr['a_contact'] = array(			
				'i_user'		=> $login_id,
				's_email'		=> addslashes($_REQUEST['s_email_id']),
			);
			$b_exist		= $this->collaboration_model->check_contact_existence($arr['a_contact']);			
			
			if($b_exist != '0')
				throw new Exception('Contact already exist.');

			//code to add record
			$arr['data'] = array(			
				'cntusr_i_user_id'		=> $login_id,
				'cnt_s_email_id'		=> addslashes($_REQUEST['s_email_id']),
				'cnt_s_name'			=> addslashes($_REQUEST['s_name']),
				'cnt_d_created'			=> date('Y-m-d H:i:s'),
				'cnt_d_updated'			=> date('Y-m-d H:i:s')
			);
			$arr['s_table'] = 'cnt_contacts';

			$i_message_id	= $this->collaboration_model->add_record($arr);

			$response['s_status']  = 'success';
			$response['data']	  = '';           

		} catch (Exception $e) {
			$response['s_status']  = 'error';
			$response['data'] = $e->getMessage();
		}
		die( json_encode($response) );
	}


	/**	 
	 * function to save messages
	 */	
	public function save_message()
	{	
		try {
			extract($_REQUEST);
			extract($_FILES);
			
			//$arr['scripts_css'] = array('left_menu.css','calender/demos.css','Styles.css');
			//$arr['scripts_js'] = array('jquery-1.8.3.min.js', 'jquery.form.js', 'drop/admin_common.js','validation/compose_email.js','auoto_generate/jquery.js');

			$files  = '';

			if( strlen($_REQUEST['message']) > 3000 )
				throw new Exception('Message length exceeds.');

			$s_attach_path = 'uploaded/mail/';

			if(!is_dir($s_attach_path) && !file_exists($s_attach_path))
			{
				mkdir($s_attach_path, 0755, TRUE);
			}

			if($this->input->post('hidCnt') > 0)
			{
				for($i=0; $i< $this->input->post('hidCnt'); $i++)
				{
				  if($_FILES['a_attach_file']['name'][$i]!='')
				  {
					$_FILES['userfile']['name']  = $file   = time(). $i .'__'.str_replace(" ","_",$_FILES['a_attach_file']['name'][$i]);
					$_FILES['userfile']['type']     = $_FILES['a_attach_file']['type'][$i];
					$_FILES['userfile']['tmp_name'] = $_FILES['a_attach_file']['tmp_name'][$i];
					$_FILES['userfile']['error']    = $_FILES['a_attach_file']['error'][$i];
					$_FILES['userfile']['size']     = $_FILES['a_attach_file']['size'][$i];
					
					if($i == 0)
						$files  = $file;
					else
						$files  .= ','.$file;
										
					$config['upload_path'] ='uploaded/mail';
					$config['allowed_types'] = '*';
							 
					$this->upload->initialize($config);
					if($this->upload->do_upload())
					{
							  $data = array('upload_data'=>$this->upload->data());
							  
							  $config['image_library'] = 'gd2';
							  $config['source_image'] ='uploaded/mail/'.$data['upload_data']['file_name'];
							  $config['maintain_ratio'] = TRUE;
							  
							  $this->load->library('image_lib',$config);
							  $this->image_lib->resize();
							  $this->image_lib->clear();
							  $this->image_lib->initialize($config);
					}  

					$fileatt = "uploaded/mail/".$file; // Path to the file
					$attachment =  $fileatt; 
				 }	
				}//for($i=0; $i< $this->input->post('hidCnt'); $i++)
				
			}//if($this->input->post('hidCnt')>0)

			$mail_id = explode(',',$_REQUEST['email_to']);
			
			$login_id = $this->session->userdata('login_id');
			$arr['data'] = array(			
				'msgusr_i_user_id'		=> $login_id,
				'msg_b_message_type' 	=> 1,	//0 for sent , 1 for saved message
				'msg_s_subject'			=> addslashes($_REQUEST['subject']),
				'msg_s_message'			=> addslashes($_REQUEST['message']),
				'msg_s_attachment '		=> addslashes($files),
				'msg_d_created'			=> date('Y-m-d H:i:s'),
				'msg_d_updated'			=> date('Y-m-d H:i:s')
			);

			if($_REQUEST['i_msg'] > 0) {
				$i_message_id	= $_REQUEST['i_msg'];
				$this->collaboration_model->delete_reciever($_REQUEST['i_msg']);
				$this->collaboration_model->update_mail($arr['data'],$_REQUEST['i_msg']);
			} else {
				$i_message_id	= $this->collaboration_model->insertEmail($arr['data']);	
			}

			// $i_message_id	= $this->collaboration_model->update_mail($arr['data']);
			// $i_message_id	= $this->collaboration_model->insertEmail($arr['data']);

			for($i=0; $i < count($mail_id); $i++)
			{
				$s_reciever = trim($mail_id[$i]);
				$arr['data'] = array(			
					'mrcmsg_i_id'		=> $i_message_id,
					'mrc_s_email_id'	=> addslashes($s_reciever),
				);

				$i_receiver_id	= $this->collaboration_model->addReceiver($arr['data']);
			}

			$response['s_status']  = 'success';			
			$response['data']	  = $_REQUEST['email_to'];

		} catch (Exception $e) {
			$response['s_status']  = 'error';
			$response['data'] = $e->getMessage();
		}
		die( json_encode($response) );
	}
	
	/**	 
	 * function to send mail functionality to client's
	 */	
	public function actionEmail()
	{	
		try {
			extract($_REQUEST);
			extract($_FILES);
						
			if ($this->session->userdata('fname') == ""){  // check admin login
				$this->session->set_flashdata('user_flash', 'Your session has been expired please Login again!!!');
				redirect('home');
			}

			$arr['scripts_css'] = array('left_menu.css','calender/demos.css','Styles.css');
			$arr['scripts_js'] = array('jquery-1.8.3.min.js', 'jquery.form.js', 'drop/admin_common.js','validation/compose_email.js','auoto_generate/jquery.js');

			$files  = '';

			if( strlen($_REQUEST['message']) > 3000 )
				throw new Exception('Message length exceeds.');


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
			<title>Gigster Mailer</title>
			</head><body><table style="width:600px;margin:0 auto;height:auto; border:10px solid #FFBC03; padding: 5px;">

			 <tr>
				<td style="font-size:14px;" colspan="2">'. $message .'</td>
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
				
				$this->email->from('gigster.info@gmail.com', 'Gigster Info');
				//$this->email->to($email);
				$this->email->subject($_REQUEST['subject']);
				$this->email->message($message);
				
				$mail_id = explode(',',$_REQUEST['email_to']);
				$this->email->to($_REQUEST['email_to']);

				for($i=0; $i < count($mail_id); $i++)
				{
					$to = trim($mail_id[$i]);
					//$this->email->to($to);				
				}

				//$this->email->send();
		
				/*include("phpMailer/class.phpmailer.php");
				$mail = new PHPMailer(); // defaults to using php "mail()"			
				//$body             = preg_replace("[\]",'',$message);
				$body             = $message;
				$mail->From       = "mails@aambien.in";
				$mail->FromName   = "Aambien";
				$mail->Subject    = $subject;
				//$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!";
				$mail->MsgHTML($body);
				
				$mail_id = explode(',',$email_to);

				for($i=0; $i < count($mail_id); $i++)
				{
					$to = trim($mail_id[$i]);
					$mail->AddAddress($to, 'Aambien User'); //add address whose to send
				}*/

							
			$s_attach_path = 'uploaded/mail/';

			if(!is_dir($s_attach_path) && !file_exists($s_attach_path))
			{
				mkdir($s_attach_path, 0755, TRUE);
			}

			if($this->input->post('hidCnt')>0)
			{
				for($i=0; $i< $this->input->post('hidCnt'); $i++)
				{
				  if($_FILES['a_attach_file']['name'][$i]!='')
				  {
					$_FILES['userfile']['name']  = $file   = time(). $i .'__'.str_replace(" ","_",$_FILES['a_attach_file']['name'][$i]);
					$_FILES['userfile']['type']     = $_FILES['a_attach_file']['type'][$i];
					$_FILES['userfile']['tmp_name'] = $_FILES['a_attach_file']['tmp_name'][$i];
					$_FILES['userfile']['error']    = $_FILES['a_attach_file']['error'][$i];
					$_FILES['userfile']['size']     = $_FILES['a_attach_file']['size'][$i];
					
					if($i == 0)
						$files  = $file;
					else
						$files  .= ','.$file;
										
					$config['upload_path'] ='uploaded/mail';
					$config['allowed_types'] = '*';
							 
					$this->upload->initialize($config);
					if($this->upload->do_upload())
					{
							  $data = array('upload_data'=>$this->upload->data());
							  
							  $config['image_library'] = 'gd2';
							  $config['source_image'] ='uploaded/mail/'.$data['upload_data']['file_name'];
							  $config['maintain_ratio'] = TRUE;
							  
							  $this->load->library('image_lib',$config);
							  $this->image_lib->resize();
							  $this->image_lib->clear();
							  $this->image_lib->initialize($config);
					}  
					//echo '  '.$_FILES['a_attach_file']['name'][$i].'  '.$file;
					$fileatt = "uploaded/mail/".$file; // Path to the file
					$attachment =  $fileatt; 
					
					#### code to attach files or images here to email
					//$mail->AddAttachment($attachment);             // attachment if need
					
					$this->email->attach($attachment);
				 }	
				}//for($i=0; $i< $this->input->post('hidCnt'); $i++)
				
			}//if($this->input->post('hidCnt')>0)
					
			### code to send mail
			//$mail->Send();		
			$this->email->send();
			
			$login_id = $this->session->userdata('login_id');
			$arr['data'] = array(			
				'msgusr_i_user_id'		=> $login_id,
				'msg_b_message_type' 	=> 0,
				'msg_s_subject'			=> addslashes($_REQUEST['subject']),
				'msg_s_message'			=> addslashes($_REQUEST['message']),
				'msg_s_attachment '		=> addslashes($files),
				'msg_d_created'			=> date('Y-m-d H:i:s'),
				'msg_d_updated'			=> date('Y-m-d H:i:s')
			);

			/*if($_REQUEST['i_msg'] > 0) {
				$arr['data'] = array(			
					'msg_b_message_type' 	=> 0,	//0 for sent , 1 for saved message
					'msg_s_subject'			=> addslashes($_REQUEST['subject']),
					'msg_s_message'			=> addslashes($_REQUEST['message']),
					'msg_s_attachment '		=> addslashes($files),
					'msg_d_updated'			=> date('Y-m-d H:i:s')
				);

				$i_message_id	= $_REQUEST['i_msg'];
				$this->collaboration_model->delete_reciever($_REQUEST['i_msg']);
				$this->collaboration_model->update_mail($arr['data'],$_REQUEST['i_msg']);
			} else {*/
				$i_message_id	= $this->collaboration_model->insertEmail($arr['data']);	
			/*}*/

			for($i=0; $i < count($mail_id); $i++)
			{
				$s_reciever = trim($mail_id[$i]);
				$arr['data'] = array(			
					'mrcmsg_i_id'		=> $i_message_id,
					'mrc_s_email_id'	=> addslashes($s_reciever),
				);
				$i_receiver_id	= $this->collaboration_model->addReceiver($arr['data']);
			}

			
			//$message = $this->load->view('email_data', $arr['data'], true);	
				
			//$this->session->set_flashdata('flash','Mail sent Successfully.');
			
			//redirect(site_url().'manage_emails');
			$response['s_status']  = 'success';
			$response['data']	  = $_REQUEST['email_to'];

		} catch (Exception $e) {
			$response['s_status']  = 'error';
			$response['data'] = $e->getMessage();
		}
		die( json_encode($response) );
	}
	
	/**	 
	 * function to get saved messages of all client
	 */	
	public function get_saved_messages()
	{	
		if ($this->session->userdata('fname') == "") // check admin login
		{
			$this->session->set_flashdata('user_flash', 'Your session has been expired please Login again!!!');
			redirect('home');
		} else {  
			
			$no_of_records = isset($_REQUEST['no_of_records']) ? $_REQUEST['no_of_records'] : '250';
			// $btnclear=isset($_REQUEST['btnclear'])?$_REQUEST['btnclear']:'';
						
			$arr['sort'] = 'msg_i_id';
			$arr['order_by'] = 'desc';
			$sort = 'msg_i_id';
			$order_by = 'desc';
			
			if(isset($no_of_records) && $no_of_records!='')
			{
				$arr['no_of_records'] = $no_of_records;//$no_of_records
				$arr['selected'] = "Selected";
				$cp_page['per_page'] = $no_of_records;
			}
			else
			{
				$arr['no_of_records'] = 250;
				$arr['selected'] = "";
				$cp_page['per_page'] = 250;
			}
			
			$per_page = isset($_REQUEST['per_page']) ? $_REQUEST['per_page'] : '0';
			$cur_page = $per_page / $no_of_records ;
			
			$login_id = $this->session->userdata('login_id');
			$i_message_type = 1;
			$cnt = $this->collaboration_model->getAllMessagesCount($login_id, $i_message_type);
			
			$query_str = "?no_of_records=".$no_of_records;
			
			$arr['query_str']=$query_str;
			$cp_page['num_links']= '5';
			
			$cp_page['base_url'] = base_url().'collaboration/get_saved_messages'.$query_str;
			$cp_page['total_rows'] = $cnt;
			$cp_page['cur_page'] = $cur_page * $no_of_records;
			
			//echo $cp_page['per_page']=$per_page;
			
			$this->pagination->initialize($cp_page);
			$arr['data']=$this->collaboration_model->getAllMessages($cp_page['per_page'],(int)$per_page,$sort,$order_by, $login_id, $i_message_type);
			
			$this->load->view('get_saved_messages',$arr);			
		}
	}

	public function delete_messages()
	{
		try {

			if(isset($_REQUEST['chk_saved_msg']))
				$s_ids = implode(', ', $_REQUEST['chk_saved_msg']);
			if(isset($_REQUEST['chk_sent_msg']))
				$s_ids = implode(', ', $_REQUEST['chk_sent_msg']);
			
			$this->collaboration_model->delete_messages($s_ids);
			
			$response['s_status']  = 'success';
			$response['data']	   = 'Message deleted successfully.';           

		} catch (Exception $e) {
			$response['s_status']  = 'error';
			$response['data'] = $e->getMessage();
		}
		die( json_encode($response) );
	}
/*
	public function delete_saved_messages()
	{
		try {

			$s_ids = implode(', ', $_REQUEST['chk_saved_msg']);
			$this->collaboration_model->delete_messages($s_ids);
			
			$response['s_status']  = 'success';
			$response['data']	   = 'Message deleted successfully.';           

		} catch (Exception $e) {
			$response['s_status']  = 'error';
			$response['data'] = $e->getMessage();
		}
		die( json_encode($response) );
	}

	public function delete_sent_messages()
	{
		try {

			$s_ids = implode(', ', $_REQUEST['chk_sent_msg']);
			$this->collaboration_model->delete_messages($s_ids);

			$response['s_status']  = 'success';
			$response['data']	   = 'Message deleted successfully.';           

		} catch (Exception $e) {
			$response['s_status']  = 'error';
			$response['data'] = $e->getMessage();
		}
		die( json_encode($response) );
	}
*/
	public function delete_contacts()
	{
		try {

			$s_ids = implode(', ', $_REQUEST['chk_contact']);
			$this->collaboration_model->delete_contacts($s_ids);

			$response['s_status']  = 'success';
			$response['data']	   = 'Contacts deleted successfully.';           

		} catch (Exception $e) {
			$response['s_status']  = 'error';
			$response['data'] = $e->getMessage();
		}
		die( json_encode($response) );
	}
	
	/**	 
	 * function to get saved messages of all client
	 */	
	public function get_sent_messages()
	{
		// $arr['scripts_css'] = array('left_menu.css','design.css');
		// $arr['scripts_js'] = array('common.js','commonJs.js','runOnLoad.js','cjs.js');
	 //    extract($_REQUEST);
		
		if ($this->session->userdata('fname') == "") // check admin login
		{
			$this->session->set_flashdata('user_flash', 'Your session has been expired please Login again!!!');
			redirect('home');
		} else {  
			
			$no_of_records = isset($_REQUEST['no_of_records']) ? $_REQUEST['no_of_records'] : '250';
			// $btnclear=isset($_REQUEST['btnclear'])?$_REQUEST['btnclear']:'';
						
			$arr['sort'] = 'msg_i_id';
			$arr['order_by'] = 'desc';
			$sort = 'msg_i_id';
			$order_by = 'desc';
			
			if(isset($no_of_records) && $no_of_records!='')
			{
				$arr['no_of_records'] = $no_of_records;//$no_of_records
				$arr['selected'] = "Selected";
				$cp_page['per_page'] = $no_of_records;
			}
			else
			{
				$arr['no_of_records'] = 250;
				$arr['selected'] = "";
				$cp_page['per_page'] = 250;
			}
			
			$per_page = isset($_REQUEST['per_page']) ? $_REQUEST['per_page'] : '0';
			$cur_page = $per_page / $no_of_records ;
			
			$login_id = $this->session->userdata('login_id');
			$i_message_type = 0;
			$cnt = $this->collaboration_model->getAllMessagesCount($login_id, $i_message_type);
			
			$query_str = "?no_of_records=".$no_of_records;
			
			$arr['query_str']=$query_str;
			$cp_page['num_links']= '5';
			
			$cp_page['base_url'] = base_url().'collaboration/get_sent_messages'.$query_str;
			$cp_page['total_rows'] = $cnt;
			$cp_page['cur_page'] = $cur_page * $no_of_records;
			
			//echo $cp_page['per_page']=$per_page;
			
			$this->pagination->initialize($cp_page);
			$arr['data']=$this->collaboration_model->getAllMessages($cp_page['per_page'],(int)$per_page,$sort,$order_by, $login_id, $i_message_type);
			
			$this->load->view('get_sent_messages',$arr);
			
			// ob_start();
	  //       $val = $this->load->view('get_messages',$arr);
	  //       $s_html = ob_get_contents();
	  //       ob_end_clean();

	  //       $a_response['s_status'] = 'success';
	  //       $a_response['s_html'] = $s_html;
	  //       die( json_encode($a_response) );
		}
	}

	/**	 
	 * function to get contacts of client
	 */	
	public function get_contacts()
	{	
		if ($this->session->userdata('fname') == "") // check admin login
		{
			$this->session->set_flashdata('user_flash', 'Your session has been expired please Login again!!!');
			redirect('home');
		} else {  
			
			$no_of_records = isset($_REQUEST['no_of_records']) ? $_REQUEST['no_of_records'] : '500';
			// $btnclear=isset($_REQUEST['btnclear'])?$_REQUEST['btnclear']:'';
						
			$arr['sort'] = 'cnt_i_id';
			$arr['order_by'] = 'desc';
			$sort = 'cnt_i_id';
			$order_by = 'desc';
			
			if(isset($no_of_records) && $no_of_records!='')
			{
				$arr['no_of_records'] = $no_of_records;//$no_of_records
				$arr['selected'] = "Selected";
				$cp_page['per_page'] = $no_of_records;
			}
			else
			{
				$arr['no_of_records'] = 500;
				$arr['selected'] = "";
				$cp_page['per_page'] = 500;
			}
			
			$per_page = isset($_REQUEST['per_page']) ? $_REQUEST['per_page'] : '0';
			$cur_page = $per_page / $no_of_records ;
			
			$login_id = $this->session->userdata('login_id');
			$cnt = $this->collaboration_model->getAllContactsCount($login_id);
			
			$query_str = "?no_of_records=".$no_of_records;
			
			$arr['query_str']=$query_str;
			$cp_page['num_links']= '5';
			
			$cp_page['base_url'] = base_url().'collaboration/get_contacts'.$query_str;
			$cp_page['total_rows'] = $cnt;
			$cp_page['cur_page'] = $cur_page * $no_of_records;
			
			//echo $cp_page['per_page']=$per_page;
			
			$this->pagination->initialize($cp_page);
			$arr['data']=$this->collaboration_model->getAllContacts($cp_page['per_page'],(int)$per_page,$sort,$order_by, $login_id);
			
			$this->load->view('get_contacts',$arr);
			
		}
	}
	
	/**	 
	 * function to get message detail to sent mail
	 */	
	public function get_message_detail()
	{		
		if ($this->session->userdata('fname') == "") // check admin login
		{
			$this->session->set_flashdata('user_flash', 'Your session has been expired please Login again!!!');
			redirect('home');
		} else {  
			
			//$login_id = $this->session->userdata('login_id');
			
			$arr['data'] = $this->collaboration_model->get_message_detail($_REQUEST['i_msg_id']);
			$a_receiver = array();
			foreach($arr['data'] as $key => $a_row) {
				$a_row = (array)$a_row;
				$b_message_type = $a_row['msg_b_message_type']; 
				$s_sender = $a_row['email']; 
				$a_receiver[] = $a_row['mrc_s_email_id']; 
				$s_message = $a_row['msg_s_message']; 
				$s_subject= $a_row['msg_s_subject']; 
				$i_id= $a_row['msg_i_id']; 
				$s_attachment= $a_row['msg_s_attachment']; 				
			}

			$a_response['data'] = array(
				'i_id' 			 => $i_id, 
				'b_message_type' => $b_message_type , 
				's_sender' 		=> $s_sender,
				's_receiver' 	=> implode(', ', $a_receiver), 
				's_subject' 	=> $s_subject, 
				's_message' 	=> $s_message, 
				's_attachment' 	=> $s_attachment, 
			);

			$a_response['s_status'] = 'success';
			die( json_encode($a_response) );
		}
	}

	/**	 
	 * function to get message detail to view
	 */	
	public function get_artist_message()
	{
		if ($this->session->userdata('fname') == "") // check admin login
		{
			$this->session->set_flashdata('user_flash', 'Your session has been expired please Login again!!!');
			redirect('home');
		} else {  
			
			//$login_id = $this->session->userdata('login_id');
			
			$arr['data'] = $this->collaboration_model->get_message_detail($_REQUEST['i_msg_id']);
			$a_receiver = array();
			foreach($arr['data'] as $key => $a_row) {
				$a_row = (array)$a_row;
				$s_sender = $a_row['email']; 
				$a_receiver[] = $a_row['mrc_s_email_id']; 
				$s_message = $a_row['msg_s_message']; 
				$s_subject= $a_row['msg_s_subject']; 
				$i_id= $a_row['msg_i_id']; 
				$s_attachment= $a_row['msg_s_attachment']; 				
			}

			$arr['a_message'] = array(
				'i_id' 			=> $i_id, 
				's_sender' 		=> $s_sender,
				's_receiver' 	=> implode(', ', $a_receiver), 
				's_subject' 	=> $s_subject, 
				's_message' 	=> $s_message, 
				's_attachment' 	=> $s_attachment, 
			);
// echo '<pre>';
// print_r($arr['a_message']['s_sender']);

			ob_start();
			$val = $this->load->view('artist_messages_view', $arr);
			$html = ob_get_contents();
			ob_end_clean();

			$a_response['s_status'] = 'success';
			$a_response['data']    = $html;

			// $a_response['s_status'] = 'success';
			die( json_encode($a_response) );
		}
	}

//get all contacts of user
	function show_contacts()
	{   /* 
		$arr['scripts_css'] = array(
			// 'left_menu.css',
			// 'Styles.css',
			// 'calender/jquery.ui.all.css',
			// 'calender/demos.css',
			'fancybox/jquery.fancybox-1.3.4.css',
			'alert/alerts_box.css',
			// 'leaflet/leaflet.css',            

		);
		$arr['scripts_js'] = array(
   //          'jquery-1.8.3.min.js',
   //          'drop/common.js',
			// 'calender/jquery.ui.core.js',
			// 'calender/jquery.ui.datepicker.js',
			'fancybox/jquery.fancybox-1.3.4.js',
			// 'validation/event_registration.js',
			// 'leaflet/leaflet.js',            
		);    */
		try {
			if ($this->session->userdata('fname') == "") // check admin login
			{
				$this->session->set_flashdata('user_flash', 'Your session has been expired please Login again!!!');
				redirect('home');
			} else {  

				// echo '<pre>';
				// print_r($_REQUEST);
				// die;
				
				$no_of_records = isset($_REQUEST['no_of_records']) ? $_REQUEST['no_of_records'] : '500';
							
				$login_id = $_REQUEST['i_user_id'];
				$arr['sort'] = 'cnt_i_id';
				$arr['order_by'] = 'desc';
				$sort = 'cnt_i_id';
				$order_by = 'desc';
				
				if(isset($no_of_records) && $no_of_records!='')
				{
					$arr['no_of_records'] = $no_of_records;//$no_of_records
					$arr['selected'] = "Selected";
					$cp_page['per_page'] = $no_of_records;
				}
				else
				{
					$arr['no_of_records'] = 500;
					$arr['selected'] = "";
					$cp_page['per_page'] = 500;
				}
				
				$per_page = isset($_REQUEST['per_page']) ? $_REQUEST['per_page'] : '0';
				$cur_page = $per_page / $no_of_records ;
				
				// $login_id = $this->session->userdata('login_id');
				$cnt = $this->collaboration_model->getAllContactsCount($login_id);
				
				$query_str = "?no_of_records=".$no_of_records;
				
				$arr['query_str']=$query_str;
				$cp_page['num_links']= '5';
				
				$cp_page['base_url'] = base_url().'collaboration/get_contacts'.$query_str;
				$cp_page['total_rows'] = $cnt;
				$cp_page['cur_page'] = $cur_page * $no_of_records;
				
				//echo $cp_page['per_page']=$per_page;
				
				$this->pagination->initialize($cp_page);
				$arr['data']=$this->collaboration_model->getAllContacts($cp_page['per_page'],(int)$per_page,$sort,$order_by, $login_id);
							
				ob_start();
				$val = $this->load->view('user_contacts', $arr);
				$html = ob_get_contents();
				ob_end_clean();

				$a_response['s_status'] = 'success';
				$a_response['data']    = $html;
			}
		}
		catch( Exception $e ) {
			$a_response['s_status'] = 'error';
			$a_response['data']     = $e->getMessage();
		}
		echo json_encode($a_response);
		die();        
	}

	/**	 
	 * function to get artist collaborate inbox messages of all client
	 */	
	public function get_collaborate_messages()
	{
		// $arr['scripts_css'] = array('left_menu.css','design.css');
		// $arr['scripts_js'] = array('common.js','commonJs.js','runOnLoad.js','cjs.js');
	 	//    extract($_REQUEST);
		
		if ($this->session->userdata('fname') == "") // check admin login
		{
			$this->session->set_flashdata('user_flash', 'Your session has been expired please Login again!!!');
			redirect('home');
		} else {  
			
			$no_of_records = isset($_REQUEST['no_of_records']) ? $_REQUEST['no_of_records'] : '250';
			// $btnclear=isset($_REQUEST['btnclear'])?$_REQUEST['btnclear']:'';
						
			$arr['sort'] = 'msg_i_id';
			$arr['order_by'] = 'desc';
			$sort = 'msg_i_id';
			$order_by = 'desc';
			
			if(isset($no_of_records) && $no_of_records!='')
			{
				$arr['no_of_records'] = $no_of_records;//$no_of_records
				$arr['selected'] = "Selected";
				$cp_page['per_page'] = $no_of_records;
			}
			else
			{
				$arr['no_of_records'] = 250;
				$arr['selected'] = "";
				$cp_page['per_page'] = 250;
			}
			
			$per_page = isset($_REQUEST['per_page']) ? $_REQUEST['per_page'] : '0';
			$cur_page = $per_page / $no_of_records ;
			
			$login_id = $this->session->userdata('login_id');
			$s_email_id = $this->session->userdata('email');

			//3 for colaborate message
			$i_message_type = $_REQUEST['i_message_type'];
			if($i_message_type == 2)
				$s_view = 'artist_messages';						
			else
				$s_view = 'collaborate_messages';
				

			$cnt = $this->collaboration_model->getArtistMessagesCount($login_id, $i_message_type,$s_email_id);
			
			$query_str = "?no_of_records=".$no_of_records;
			
			$arr['query_str']=$query_str;
			$cp_page['num_links']= '5';
			
			$cp_page['base_url'] = base_url().'collaboration/get_collaborate_messages'.$query_str;
			$cp_page['total_rows'] = $cnt;
			$cp_page['cur_page'] = $cur_page * $no_of_records;
						
			$this->pagination->initialize($cp_page);
			$arr['a_msg']=$this->collaboration_model->getArtistMessages($cp_page['per_page'],(int)$per_page,$sort,$order_by, $login_id, $i_message_type, $s_email_id);
			
			$this->load->view($s_view, $arr);			
		}
	}
	
}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
