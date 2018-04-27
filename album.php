<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Album extends CI_Controller
{
	function __construct(){
		parent::__construct();
		if($this->session->userdata('fname')=='')
		{
			redirect(site_url().'login');
		}
		$this->load->model('music_model');
		$this->load->model('collaboration_model');
	}

	function add_album()
	{
		$arr['scripts_css'] = array('left_menu.css','calender/jquery.ui.all.css','calender/demos.css','Styles.css');
		$arr['scripts_js'] = array(
			'jquery-1.8.3.min.js',
			'jquery.form.js',
			'drop/common.js',
			'validation/album.js',
		);
		$arr['msg'] = '';
		if($this->session->userdata('fname')=="") // check admin login
		{
			$this->session->set_flashdata('user_flash', 'Your session has been expired please Login again!!!');
			redirect('login');
		}
		else
		{
			$login_id = $this->session->userdata('login_id');
			## code to set blank data to add new album.
			$arr['data'] = array(
				'album_id'=>'',
				's_title'=>'',
				's_artist'=>'',
				's_genre'=>'',
				's_year'=>'',
				's_photo'=>'',
				's_email'=>'',
			);
			$arr['s_status'] = '';
			$arr['s_message'] = '';
			$this->load->view('add_album',$arr);
		}
	}
	/*
	 * edit album with its track
	 */
	function edit_album()
	{
		$arr['scripts_css'] = array('left_menu.css','calender/jquery.ui.all.css','calender/demos.css','Styles.css');
		$arr['scripts_js'] = array(	'jquery-1.8.3.min.js',	'jquery.form.js','drop/common.js','validation/album.js');
		$arr['msg'] = '';
		if($this->session->userdata('fname') == "") // check admin login
		{
			$this->session->set_flashdata('user_flash', 'Your session has been expired please Login again!!!');
			redirect('login');
		}
		else
		{
			$arr['data']=$this->music_model->get_album_detail($_REQUEST['album_id']);
			$arr['a_tracks']=$this->music_model->get_album_tracks($_REQUEST['album_id']);
			## code to set data to edit album.
			$arr['data'] = array(
				'album_id'  => $arr['data'][0]['msa_i_id'],
				's_title'  => $arr['data'][0]['msa_s_title'],
				's_artist'  => $arr['data'][0]['msa_s_artist'],
				's_genre'   => $arr['data'][0]['msa_s_genre'],
				's_year'    => $arr['data'][0]['msa_s_year'],
				's_photo'   => $arr['data'][0]['msa_s_album_photo'],
				's_email'   => $arr['data'][0]['msa_s_email'],
			);
			$arr['tracks'] = array();
			## code to set data to edit album tracks.
			foreach($arr['a_tracks'] as $a_track ) {
				$arr['tracks'][] = array(
					'i_track_id'    => $a_track['abt_i_id'],
					's_title'       => $a_track['abt_s_title'],
					's_artist'       => $a_track['abt_s_artist'],
					's_url'         => $a_track['abt_s_url'],
				);
			}
			$this->load->view('add_album',$arr);
		}
	}
	/*
	 * edit album with its track
	 */
	function delete_track()
	{
		///remove the file from storeage
		$arr['a_track']=$this->music_model->get_track_detail($_REQUEST['i_track']);
		@unlink( $arr['a_track'][0]['abt_s_url'] );
		$arr['bool']=$this->music_model->delete_track($_REQUEST['i_track']);
		$a_response['s_status'] = 'success';
		die( $a_response );
	}

	/* * edit album with its track
	 */
	function delete_album()
	{
		$arr['scripts_js'] = array('jquery-1.8.3.min.js','jquery.form.js',	'drop/common.js','validation/album.js'	);
		$arr['scripts_css'] = array('left_menu.css','calender/jquery.ui.all.css','calender/demos.css','Styles.css');
		extract($_REQUEST);

		foreach($_REQUEST['chkmsg'] as $i_id) {
			$arr['data']=$this->music_model->get_album_detail( $i_id );
			$arr['a_tracks']=$this->music_model->get_album_tracks( $i_id );
			//remove the album file from storage
			@unlink( $arr['data'][0]['msa_s_album_photo'] );
			## code to set data to edit album tracks.
			foreach($arr['a_tracks'] as $a_track ) {
				//remove the album tracks from storage
				@unlink( $a_track['abt_s_url'] );
			}
		}
		foreach($_REQUEST['chkmsg'] as $i_id) {
			//delete album from database
			$arr['bool']=$this->music_model->delete_album($i_id);
		}

		$this->session->set_flashdata('flash', 'Album(s) deleted successfully.');
		redirect(site_url().'album/manage_album');
	}

	/**
	 * function to adding or eding process of album
	 */
	function action_album()
	{
		$arr['scripts_js'] = array('common.js','jquery-1.8.3.min.js','jquery.form.js','calender/jquery.ui.core.js','calender/jquery.ui.datepicker.js');
		$arr['scripts_css'] = array('left_menu.css','design.css','calender/jquery.ui.all.css','calender/demos.css');
		extract($_REQUEST);

		if($_REQUEST['step'] == 'add')
		{
			if($this->input->post('hidCnt') > 0)
			{
				$s_album_name = '';
				if( isset($_FILES["s_photo"]['name']) && !empty($_FILES["s_photo"]['name']) ) {
					$s_album_path = 'uploaded/album/';
					if(!is_dir($s_album_path) && !file_exists($s_album_path))
					{
						mkdir($s_album_path, 0777, TRUE);
					}
					$s_album = $_FILES["s_photo"]["name"];
					$i_random_digit = rand( 0000,9999 );
					$s_album_name = date('ymdhis').$i_random_digit.'.'.pathinfo($s_album, PATHINFO_EXTENSION);
					$s_album_path = 'uploaded/album/'.$s_album_name;
					move_uploaded_file( $_FILES["s_photo"]["tmp_name"], $s_album_path );
					chmod($s_album_path, 0777);
				}

				## code to add album.
				$arr['album'] = array(
					'msa_s_title'       =>stripslashes(trim($_REQUEST['s_title'])),
					'msa_s_artist'      =>stripslashes(trim($_REQUEST['s_artist'])),
					'msa_s_genre'       =>stripslashes(trim($_REQUEST['s_genre'])),
					'msa_s_year'        =>stripslashes(trim($_REQUEST['s_year'])),
					'msa_s_album_photo' =>stripslashes(trim($s_album_name) ),
					'msausr_i_user_id'  => $this->session->userdata('login_id'),
					'msa_s_email'       => stripslashes(trim($_REQUEST['s_email'])),
				);

				$i_album_id = $this->music_model->add_album( $arr['album'] );
				$s_track_path = 'uploaded/track/';
				if(!is_dir($s_track_path) && !file_exists($s_track_path))
				{
					mkdir($s_track_path, 0777, TRUE);
				}

				for($i=0,$j=1; $i < $this->input->post('hidCnt'); $i++,$j++){
					$s_track = $_FILES["a_track"]["name"][$i];
					$s_title = substr($s_track, 0, strrpos($s_track,'.') );
					$i_random_digit = rand( 0000,9999 );
					$s_track_name = date('ymdhis').$i_random_digit.'.'.pathinfo($s_track, PATHINFO_EXTENSION);
					$s_track_path = 'uploaded/track/'.$s_track_name;
					move_uploaded_file( $_FILES["a_track"]["tmp_name"][$i], $s_track_path );
					chmod($s_track_path, 0777);
					## code to add album tracks.
					$arr['track'] = array(
						'abtmsa_i_id'   =>stripslashes(trim($i_album_id)),
						'abt_s_title'   =>stripslashes(trim($s_title)),
						'abt_s_artist'  =>stripslashes(trim($a_artist[$i])),
						'abt_s_url'     =>stripslashes(trim( $s_track_name )),

					);
					$i_track_id = $this->music_model->add_track( $arr['track'] );
				}	//for loop
			}

			$this->session->set_flashdata('flash','Album Added Successfully.');
			redirect(site_url().'album/manage_album');
		}

		if( $_REQUEST['step'] == 'edit'){

			$s_album_name = '';
			if( isset($_FILES["s_photo"]['name']) && !empty($_FILES["s_photo"]['name']) ) {
				@unlink($_REQUEST['s_photo_url']);
				$s_album_path = 'uploaded/album/';
				if(!is_dir($s_album_path) && !file_exists($s_album_path))
				{
					mkdir($s_album_path, 0777, TRUE);
				}
				$s_album = $_FILES["s_photo"]["name"];
				$i_random_digit = rand( 0000,9999 );
				$s_album_name = date('ymdhis').$i_random_digit.'.'.pathinfo($s_album, PATHINFO_EXTENSION);
				$s_album_path = 'uploaded/album/'.$s_album_name;
				move_uploaded_file( $_FILES["s_photo"]["tmp_name"], $s_album_path );
				chmod($s_album_path, 0777);
			} else {
				$s_album_name = $_REQUEST['s_photo_url'];
			}
			
			## code to add album.

			$arr['album'] = array(
				'msa_s_title'       => stripslashes(trim($_REQUEST['s_title'])),
				'msa_s_artist'      => stripslashes(trim($_REQUEST['s_artist'])),
				'msa_s_genre'       => stripslashes(trim($_REQUEST['s_genre'])),
				'msa_s_year'        =>  stripslashes(trim($_REQUEST['s_year'])),
				'msa_s_album_photo' => stripslashes(trim($s_album_name) ),
				'msa_s_email'       => stripslashes(trim($_REQUEST['s_email'])),
			);
			$i_album_id = $this->music_model->update_album( $arr['album'], $_REQUEST['album_id'] );
			if($this->input->post('hidCnt') > 0)
			{
				$s_track_path = 'uploaded/track/';
				if(!is_dir($s_track_path) && !file_exists($s_track_path))
				{
					mkdir($s_track_path, 0777, TRUE);
				}

				for($i=0,$j=1; $i < $this->input->post('hidCnt'); $i++,$j++)
				{
					$s_track = $_FILES["a_track"]["name"][$i];
					$s_title = substr($s_track, 0, strrpos($s_track,'.') );
					$i_random_digit = rand( 0000,9999 );
					$s_track_name = date('ymdhis').$i_random_digit.'.'.pathinfo($s_track, PATHINFO_EXTENSION);
					$s_track_path = 'uploaded/track/'.$s_track_name;
					move_uploaded_file( $_FILES["a_track"]["tmp_name"][$i], $s_track_path );
					chmod($s_track_path, 0777);

					## code to add album tracks.
					$arr['track'] = array(
						'abtmsa_i_id'   =>stripslashes(trim($i_album_id)),
						'abt_s_title'   =>stripslashes(trim($s_title)),
						'abt_s_artist'  =>stripslashes(trim($a_artist[$i])),
						'abt_s_url'     =>stripslashes(trim( $s_track_name )),
					);
					$i_track_id = $this->music_model->add_track( $arr['track'] );
				}	//for loop
			}
			$this->session->set_flashdata('flash','Album updated Successfully.');
			redirect(site_url().'album/manage_album');
		}
	}
	
	/*
	 * manage album with its track
	 */
	public function manage_album()
	{
		$arr['scripts_css'] = array('left_menu.css','calender/jquery.ui.all.css','calender/demos.css',	'Styles.css');
		$arr['scripts_js'] = array('drop/common.js','jquery-1.8.3.min.js','jquery.form.js','calender/jquery.ui.core.js','calender/jquery.ui.datepicker.js');

		$s_title = isset($_REQUEST['s_title']) ? trim($_REQUEST['s_title']) : '';
		$s_artist = isset($_REQUEST['s_artist']) ? trim($_REQUEST['s_artist']) : '';
		$i_artist = isset($_REQUEST['i_artist']) ? trim($_REQUEST['i_artist']) : '';
		$s_genre = isset($_REQUEST['s_genre']) ? trim($_REQUEST['s_genre']) : '';
		$s_year = isset($_REQUEST['s_year']) ? trim($_REQUEST['s_year']) : '';
		$btnclear=isset($_REQUEST['btnclear'])?$_REQUEST['btnclear']:'';

		if($btnclear=='Clear'){
			$s_title = '';
			$s_artist = '';
			$i_artist = '';
			$s_genre = '';
			$s_year = '';
		}

		$arr['s_title'] = $s_title;
		$arr['s_artist'] = $s_artist;
		$arr['i_artist'] = $i_artist;
		$arr['s_genre'] = $s_genre;
		$arr['s_year']=$s_year;
		$no_of_records=isset($_REQUEST['no_of_records']) ? $_REQUEST['no_of_records'] : '4';
		if(isset($_REQUEST['sort']))
		{
			$sort=trim($_REQUEST['sort']);
		}
		else
		{
			$sort="msa_i_id";	//CHANGE THE FIELD id TO BE SORT BY
		}
		$order_by = 'desc';
		$arr['sort'] = $sort;
		$arr['order_by'] = $order_by;
		if(isset($no_of_records) && $no_of_records != '')
		{
			$arr['no_of_records'] = $no_of_records;//$no_of_records
			$arr['selected'] = "Selected";
			$album['per_page'] = $no_of_records;
		}
		else
		{
			$arr['no_of_records'] = 4;
			$arr['selected']="";
			$album['per_page'] = 4;
		}

		$per_page = isset($_REQUEST['per_page']) ? $_REQUEST['per_page'] : '0';
		$cur_page = $per_page / $no_of_records;
		## GET ALL THE albums
		$cnt = $this->music_model->getAllAlbumDetailCount($s_title, $s_artist, $s_genre, $s_year, $i_artist);
		$arr['a_data'] = $this->music_model->getAllAlbumDetail($album['per_page'],(int)$per_page, $s_title, $s_artist, $s_genre, $s_year, $sort, $order_by, $i_artist );
		foreach($arr['a_data'] as $a_row) {
			$arr['a_artist'][] = $this->music_model->get_track_artist($a_row->msa_i_id);
		}

		$a_artist = array();
		foreach($arr['a_artist'] as $i_key => $a_rows) {
			$a_artist[$i_key] = array();
			foreach($a_rows as $a_row) {
				if(!empty($a_row->abt_s_artist) && !in_array($a_row->abt_s_artist, $a_artist[$i_key]))
					$a_artist[$i_key][] = $a_row->abt_s_artist;
			}

		}

		$arr['a_artist'] = $a_artist;
		$query_str="?s_title=".$s_title."&s_artist=".$s_artist."&i_artist=".$i_artist."&s_genre=".$s_genre."&s_year=".$s_year."&no_of_records=".$no_of_records;
		$arr['query_str']=$query_str;
		$album['base_url'] = base_url().'album/manage_album'.$query_str;
		$album['total_rows'] = $cnt;
		$album['num_links']= '3';
		$album['cur_page']= $cur_page * $no_of_records;
		$this->pagination->initialize($album);
		$this->load->view('album_search',$arr);
	}

	/*
	 * view album with its track	 */
	function view_album()
	{
		$arr['scripts_css'] = array('left_menu.css','Styles.css',	'fancybox/jquery.fancybox-1.3.4.css',	'alert/alerts_box.css',	'pickle_player/basic_audio_player/_stylesheet.css'	);
		$arr['scripts_js']  = array('drop/common.js','jquery-1.8.3.min.js','jquery.form.js','fancybox/jquery.fancybox-1.3.4.js','validation/manage_calendar.js','pickle.js');
		$arr['msg'] = '';
		if($this->session->userdata('fname') == "") // check admin login
		{
			$this->session->set_flashdata('user_flash', 'Your session has been expired please Login again!!!');
			redirect('login');
		}
		else
		{
			require_once('library/read_mp3/getid3/getid3.php');
			$getID3 = new getID3;
			$arr['a_purchase']=$this->music_model->get_user_tracks( $this->session->userdata('login_id') );
			$arr['data'] = $this->music_model->get_album_detail($_REQUEST['album_id']);
			$arr['a_tracks']=$this->music_model->get_album_tracks($_REQUEST['album_id']);
			$arr['session_id']  = $this->session->userdata('login_id');
			$arr['a_purchased'] = array();
			## code to set data to edit album tracks.
			foreach($arr['a_purchase'] as $a_purchase ) {
				$arr['a_purchased'][] = $a_purchase['ptkabt_i_id'];
			}
			$arr['tracks'] = array();
			## code to set data to edit album tracks.
			foreach($arr['a_tracks'] as $a_track ) {
				// Analyze file and store returned data in $ThisFileInfo
				$s_url      = 'uploaded/track/'.$a_track['abt_s_url'];
				$a_file_info = $getID3->analyze($s_url);
				$arr['tracks'][] = array(
					'i_track_id'        => $a_track['abt_i_id'],
					's_title'           => $a_track['abt_s_title'],
					'songs_amt'         => $a_track['songs_amt'],
					'i_duration'        => @$a_file_info['playtime_string'],
					's_track_title'     => @$a_file_info['tags']['id3v2']['title'],
					's_album'           => @$a_file_info['tags']['id3v2']['album'][0],
					's_track_number'    => @$a_file_info['tags']['id3v2']['track_number'][0],
					's_artist'          => @$a_file_info['tags']['id3v2']['artist'][0],
					's_genre'           => @$a_file_info['tags']['id3v2']['genre'][0],
					's_year'            => @$a_file_info['tags']['id3v2']['year'][0],
					's_url'             => $a_track['abt_s_url'],
				);
			}

			## code to set data to edit album.

			$arr['data'] = array(
				'album_id'      => $arr['data'][0]['msa_i_id'],
				'user_id'      => $arr['data'][0]['msausr_i_user_id'],
				's_title'      => $arr['data'][0]['msa_s_title'],
				's_artist'      => $arr['data'][0]['msa_s_artist'],
				's_genre'       => $arr['data'][0]['msa_s_genre'],
				's_year'        => $arr['data'][0]['msa_s_year'],
				's_photo'       => $arr['data'][0]['msa_s_album_photo'],
				'i_track_total' => sizeof($arr['tracks']),

			);

			$this->load->view('view_album',$arr);
		}
	}

	function show_player()
	{
		// include getID3() library (can be in a different directory if full path is specified)
		require_once('library/read_mp3/getid3/getid3.php');

//        // Initialize getID3 engine
//        $getID3 = new getID3;
		$s_temp_path = 'temp/';
		if(!is_dir($s_temp_path) && !file_exists($s_temp_path))	{
			mkdir($s_temp_path, 0755, TRUE);
		}

		$arr['a_track']=$this->music_model->get_track_detail($_REQUEST['i_track_id']);
		//@unlink( $arr['a_track'][0]['abt_s_url'] );
		ob_start();
		$val = $this->load->view('get_player',$arr);
		$s_html = ob_get_contents();
		ob_end_clean();
		$a_response['s_status'] = 'success';
		$a_response['s_html'] = $s_html;
		die( json_encode($a_response) );
	}

	function show_player_full_song()
	{
		// include getID3() library (can be in a different directory if full path is specified)
		
		require_once('library/read_mp3/getid3/getid3.php');
		$arr['a_track']=$this->music_model->get_track_detail($_REQUEST['i_track_id']);
		ob_start();
		$val = $this->load->view('get_player_full_song',$arr);
		$s_html = ob_get_contents();
		ob_end_clean();

		$a_response['s_status'] = 'success';
		$a_response['s_html'] = $s_html;
		die( json_encode($a_response) );
	}


	function get_payment_details()
	{
		ini_set('display_error','0');
		ini_set('display_error','0');
		$arr['data'] = $this->music_model->get_account_details( $this->session->userdata('login_id') );
		$arr['track_amt'] = $this->music_model->get_track_amt( $_REQUEST['i_track_id'] );
                             // print($arr['track_amt']);


		if( isset($arr['data']) && sizeof($arr['data']) > 0 ) {
			$arr['a_account'] = array(
				'i_track_id'    => $_REQUEST['i_track_id'],
				'songs_amt'     => $arr['track_amt'][0]['songs_amt'],
				'i_id'          => $arr['data'][0]['acdusr_i_id'],
				's_fname'       => '',
				's_lname'       => '',
				's_card_type'   => '',
				's_card_number' => '',
				'i_month'       => '',
				'i_year'        => '',
				's_cvv'         => ''
			);
		} else {
			$arr['a_account'] = array(
				'i_track_id'    => $_REQUEST['i_track_id'],
				'songs_amt'     => $arr['track_amt'][0]['songs_amt'],
				'i_id'          => '',
				's_fname'       => '',
				's_lname'       => '',
				's_card_type'   => '',
				's_card_number' => '',
				'i_month'       => '',
				'i_year'        => '',
				's_cvv'         => ''
			);
		}
		$arr['a_account']["payment_type"] = $_REQUEST['s_type'];

		ob_start();
		$val = $this->load->view('get_payment',$arr);
		$s_html = ob_get_contents();
		ob_end_clean();

		$a_response['s_status'] = 'success';
		$a_response['s_html'] = $s_html;
		die( json_encode($a_response) );
	}

	function payment_process()
	{
		try {
			ini_set('display_error','0');
			ini_set('display_error','0');
			require_once('library/paypal/config.php');
			$s_fname = trim($_REQUEST['fname']);
			$s_lname = trim($_REQUEST['lname']);
			$s_ctype = trim($_REQUEST['creditCardType']);
			$s_number = trim($_REQUEST['card_number']);
			$s_month = trim($_REQUEST['expDateMonth']);
			$s_year = trim($_REQUEST['expDateYear']);
			$s_cvv = trim($_REQUEST['cvv']);
			$songs_amt = trim($_REQUEST['songs_amt']);
			$arr['track_detail'] = $this->music_model->get_track_amt( $_REQUEST['i_track_id'] );
			$req_count = $arr['track_detail'][0]['req_count'] + 1;
			$donate_amt = $arr['track_detail'][0]['donate_amt'] + $songs_amt;		
			if( empty($s_fname) ) throw new Exception('First name is required.');
			if( empty($s_lname) ) throw new Exception('Last name is required.');
			if( empty($s_ctype) ) throw new Exception('Card type is required.');
			if( empty($s_number) ) throw new Exception('Card number is required.');
			if( !is_numeric($s_number) || ( strlen($s_number) != 16 ) ) throw new Exception('Enter valid card number.');
			if( empty($s_month) ) throw new Exception('Expiration month is required.');
			if( empty($s_year) ) throw new Exception('Expiration year is required.');
			if( empty($s_cvv) ) throw new Exception('Verification Number is required.');
			if( !is_numeric($s_cvv) || ( strlen($s_cvv) != 3 ) ) throw new Exception('Enter valid eerification number.');
			// Store request params in an array
			$a_request_params = array(
				'METHOD'            => 'DoDirectPayment',
				'USER'              => API_USERNEME,
				'PWD'               => API_PASSWORD,
				'SIGNATURE'         => API_SIGNATURE,
				'VERSION'           => API_VERSION,
				'PAYMENTACTION'     => 'Sale',
				'IPADDRESS'         => $_SERVER['REMOTE_ADDR'],
				'CREDITCARDTYPE'    => $s_ctype,
				'ACCT'              => $s_number,	//'4379060087541792',
				'EXPDATE'           => $s_month.$s_year,	//'102017',
				'CVV2'              => $s_cvv,	//'345',
				'FIRSTNAME'         => $s_fname,
				'LASTNAME'          => $s_lname,
				'AMT'               => $songs_amt ,//1.29
				'CURRENCYCODE'      => 'USD',
			);
			// Loop through $a_request_params array to generate the NVP string.
			$nvp_string = '';
			foreach($a_request_params as $var=>$val)
			{
				$nvp_string .= '&'.$var.'='.urlencode($val);
			}
			// Send NVP string to PayPal and store response

			$curl = curl_init();
			curl_setopt($curl, CURLOPT_VERBOSE, 1);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
			curl_setopt($curl, CURLOPT_TIMEOUT, 30);
			curl_setopt($curl, CURLOPT_URL, API_ENDPOINT);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $nvp_string);
			$a_result = curl_exec($curl);
			//echo $result.'<br /><br />';
			curl_close($curl);
			// Parse the API response
			$a_paypal_response = NVPToArray($a_result);
			$s_acknoledge = strtoupper($a_paypal_response["ACK"]);
			$arr['msg'] = 'payment_success';
			$arr["resArray"]= $a_paypal_response;	

			if( $s_acknoledge == "SUCCESS" )		{

				throw new Exception($a_paypal_response['L_LONGMESSAGE0']);
			} else {



				## code to add purchased track.



				$arr['purchase'] = array(



					'ptkusr_i_id'           => $this->session->userdata('login_id'),



					'ptkabt_i_id'           => trim($_REQUEST['i_track_id']),



				);







				$i_purchased_id = $this->music_model->add_purchsed_track( $arr['purchase'] );







				## code to add album.



				$arr['account'] = array(



					'acdusr_i_id'       => $this->session->userdata('login_id'),



					'acd_s_fname'       => md5(stripslashes(trim($_REQUEST['fname']))),



					'acd_s_lname'       => md5(stripslashes(trim($_REQUEST['lname']))),



					'acd_s_card_type'   =>  md5(stripslashes(trim($_REQUEST['creditCardType']))),



					'acd_s_card_number' =>  md5(stripslashes(trim($_REQUEST['card_number']))),



					'acd_i_month'       =>  md5(stripslashes(trim($_REQUEST['expDateMonth']))),



					'acd_i_year'        =>  md5(stripslashes(trim($_REQUEST['expDateYear']))),



					'acd_s_cvv'         =>  md5(stripslashes(trim($_REQUEST['cvv']))),

					

					

					

				);







				if( !empty($_REQUEST['i_id']) ) {



					## code to update account detailos.



					$i_account_id = $this->music_model->update_account_details( $arr['account'], $_REQUEST['i_id'] );



				} else {



					## code to add account detailos.



					$i_account_id = $this->music_model->add_account_details( $arr['account'] );



				}



			

				$arr['update_track'] = array(



					'abt_i_id'       => $_REQUEST['i_track_id'],



					'req_count'       => stripslashes(trim($req_count)),



					'donate_amt'       => stripslashes(trim($donate_amt)),

					

				);





				$this->music_model->update_track_amt( $arr['update_track'] , $_REQUEST['i_track_id']);



				$response['s_status']  = 'success';



				$response['data']	  = '';



			}



		} catch (Exception $e){



			$response['s_status']  = 'error';



			$response['data'] = $e->getMessage();



		}



		die( json_encode($response) );



	}







	public function manage_purchased_track()

	{



		$arr['scripts_css'] = array(



			'left_menu.css',



			'Styles.css',



			'fancybox/jquery.fancybox-1.3.4.css',



			'alert/alerts_box.css',



			'pickle_player/basic_audio_player/_stylesheet.css',



		);



		$arr['scripts_js']  = array(



			'drop/common.js',



			'jquery-1.8.3.min.js',



			'jquery.form.js',



			//'jquery-1.8.3.min.js',



			'fancybox/jquery.fancybox-1.3.4.js',



			'validation/manage_calendar.js',



			'pickle.js',



		);







		// include getID3() library (can be in a different directory if full path is specified)



		require_once('library/read_mp3/getid3/getid3.php');







		// Initialize getID3 engine



		$getID3 = new getID3;







		$s_title = isset($_REQUEST['s_title']) ? trim($_REQUEST['s_title']) : '';



		$s_artist = isset($_REQUEST['s_artist']) ? trim($_REQUEST['s_artist']) : '';



		$s_genre = isset($_REQUEST['s_genre']) ? trim($_REQUEST['s_genre']) : '';



		$s_year = isset($_REQUEST['s_year']) ? trim($_REQUEST['s_year']) : '';



		$btnclear=isset($_REQUEST['btnclear'])?$_REQUEST['btnclear']:'';



		if($btnclear=='Clear')



		{



			$s_title = '';



			$s_artist = '';



			$s_genre = '';



			$s_year = '';



		}







		$arr['s_title'] = $s_title;



		$arr['s_artist'] = $s_artist;



		$arr['s_genre'] = $s_genre;



		$arr['s_year']=$s_year;







		$no_of_records=isset($_REQUEST['no_of_records']) ? $_REQUEST['no_of_records'] : '10';



		$sort="	ptk_d_purchased_date";	//CHANGE THE FIELD id TO BE SORT BY



		$order_by  = 'desc';







		if(isset($no_of_records) && $no_of_records!='')



		{



			$arr['no_of_records'] = $no_of_records;//$no_of_records



			$arr['selected'] = "Selected";



			$track['per_page'] = $no_of_records;



		}



		else



		{



			$arr['no_of_records']=10;



			$arr['selected']="";



			$track['per_page'] = 10;



		}







		$arr['sort'] = $sort;



		$arr['order_by'] = $order_by;



		$per_page = isset($_REQUEST['per_page']) ? $_REQUEST['per_page'] : '0';



		$cur_page = $per_page / $no_of_records;







		## get all purchased tracks of logged in user



		$i_account = $this->session->userdata('login_id');



		$cnt                = $this->music_model->get_purchased_tracks_count($s_title, $s_artist, $s_genre, $s_year, $i_account);



		$arr['a_tracks']    = $this->music_model->get_purchased_tracks($track['per_page'],(int)$per_page, $s_title, $s_artist, $s_genre, $s_year, $i_account, $sort, $order_by );







		$arr['tracks'] = array();







		## code to set data to edit album tracks.



		foreach($arr['a_tracks'] as $a_track ) {



			// Analyze file and store returned data in $ThisFileInfo



			$s_url      = 'uploaded/track/'.$a_track->abt_s_url;



			$a_file_info = $getID3->analyze($s_url);







			$arr['tracks'][] = array(



				'i_track_id'        => $a_track->abt_i_id,



				//'s_album_title'     => $a_track->abt_s_title,



				's_title'           => $a_track->abt_s_title,



				'i_duration'        => @$a_file_info['playtime_string'],



				's_track_title'     => @$a_file_info['tags']['id3v2']['title'],



				's_album'           => @$a_file_info['tags']['id3v2']['album'][0],



				's_track_number'    => @$a_file_info['tags']['id3v2']['track_number'][0],



				's_artist'          => @$a_file_info['tags']['id3v2']['artist'][0],



				's_genre'           => @$a_file_info['tags']['id3v2']['genre'][0],



				's_year'            => @$a_file_info['tags']['id3v2']['year'][0],



				's_url'             => $a_track->abt_s_url,



			);



		}







		$query_str="?s_title=".$s_title."s_artist=".$s_artist."&s_genre=".$s_genre."&s_year=".$s_year."&no_of_records=".$no_of_records;







		$arr['query_str']=$query_str;







		$track['base_url'] = base_url().'album/manage_purchased_track'.$query_str;



		$track['total_rows'] = $cnt;



		$track['num_links']= '3';



		$track['cur_page']= $cur_page * $no_of_records;







		$this->pagination->initialize($track);



		$this->load->view('view_purchased_track',$arr);



	}



	function send_album_message () {

		try {

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



			$i_message_type = $_REQUEST['i_message_type'];

			

			ini_set("SMTP", SMTP);

			ini_set("sendmail_from", FROM);

			ini_set("smtp_port", PORT);

			

			//gets the user details as sender

			$arr['a_sender'] = $this->music_model->get_user_details( $this->session->userdata('login_id') );



			//gets the user details as reciever

			$arr['a_receiver'] = $this->music_model->get_user_details( $_REQUEST['i_user_id'] );



			//gets the album details

			$arr['a_album']=$this->music_model->get_album_detail($_REQUEST['i_album_id']);

	

			## code to set data to use in mail

			$s_sender = $arr['a_sender'][0]['email'];

			$s_sender_name = ucwords($arr['a_sender'][0]['fname']) . ' ' . ucwords($arr['a_sender'][0]['lname']);

			$s_receiver = $arr['a_receiver'][0]['email'];

			$s_receiver_name = ucwords($arr['a_receiver'][0]['fname']) . ' ' . ucwords($arr['a_receiver'][0]['lname']);

			$s_album_title = $arr['a_album'][0]['msa_s_title'];



			$s_message = "Dear {$s_receiver_name},</br> </br> 

				We'd like you to tell about your album collaboration in gigster site. 

				{$s_sender_name} has sent the message to you for the <b>'{$s_album_title}'</b> album.</br> </br> 

				

				You will contact to {$s_sender_name} by using the following email id:</br> </br> 

				{$s_sender}";



			$message = '<html>

			<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

			<title>Gigster Mailer</title>

			</head><body>

			<table style="width:600px;margin:0 auto;height:auto; border:10px solid #FFBC03; padding: 5px;">

			 <tr>

				<td style="font-size:14px;" colspan="2">

				'. $s_message . '

				</td>

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



			$s_db_message = "Dear {$s_receiver_name},

				We'd like you to tell about your album collaboration in gigster site. 

				{$s_sender_name} has sent the message to you for the '{$s_album_title}' album.

				

				You will contact to {$s_sender_name} by using the following email id:

				{$s_sender}";

				

			$this->email->from($s_sender, 'Gigster Info');

			//$this->email->to($email);

			$this->email->subject('Gigster Album Collaboration');

			$this->email->message($message);

			

			// $mail_id = explode(',',$_REQUEST['email_to']);

			$this->email->to($s_receiver);

			

			### code to send mail

			$this->email->send();



			$login_id = $this->session->userdata('login_id');

			$arr['data'] = array(			

				'msgusr_i_user_id'		=> $login_id,

				'msg_b_message_type' 	=> $i_message_type,

				'msg_s_subject'			=> 'Gigster Album Collaboration',

				'msg_s_message'			=> stripslashes($s_db_message),

				'msg_s_attachment '		=> '',

				'msg_d_created'			=> date('Y-m-d H:i:s'),

				'msg_d_updated'			=> date('Y-m-d H:i:s')

			);

			

			$i_message_id	= $this->collaboration_model->insertEmail($arr['data']);	



			//code to add receiver id of collaboration

			$arr['data'] = array(

				'mrcmsg_i_id'		=> $i_message_id,

				'mrc_s_email_id'	=> addslashes($s_receiver),

			);



			$i_receiver_id	= $this->collaboration_model->addReceiver($arr['data']);	



			$a_response['s_status'] = 'success';

			$a_response['data']    = '';

			

		}

		catch( Exception $e ) {

			$a_response['s_status'] = 'error';

			$a_response['data']     = $e->getMessage();

		}

		echo json_encode($a_response);

		die(); 

	}	

	

	function download_track($file='') {

		if($file){

			header ("Content-type: application/octet-stream"); 

			header ("Content-disposition: attachment; filename=".$file.";"); 

			header ("Content-Length: ".filesize($file)); 

			readfile('uploaded/track/'.$file); 

			exit;

		}

	}

}



/* End of file welcome.php */



/* Location: ./application/controllers/welcome.php */



