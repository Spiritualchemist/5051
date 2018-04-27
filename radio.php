<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Radio extends CI_Controller 
{ 

	function __construct()
	{
		ini_set('display_error','0');

		ini_set('display_error','0');

		error_reporting(0);

		parent::__construct();

		if($this->session->userdata('fname')=='')
		{
			redirect(site_url().'login');
		}
		$this->load->model('music_model');
		$this->load->model('collaboration_model');
	}

	function collection()
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

			$arr['genre_album'] = $this->music_model->get_user_genre_albums( $this->session->userdata('login_id') );

			foreach ($arr['genre_album'] as $item) {
				$genre_album [] = $item['playlist_genre'];
			}

			$arr['a_tracks']=$this->music_model->get_radio_tracks($genre_album );


		

			$arr['a_requested']=$this->music_model->get_requested_tracks( $this->session->userdata('login_id') );
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
				$a_url      = '/uploaded/album/'.$a_track['msa_s_album_photo'];
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
					
					'd_hours_frame'      => $a_track['abt_d_hours_frame'],
					'd_week_frame'       => $a_track['abt_d_week_frame'],
					'i_requests_limit'   => $a_track['abt_i_requests_limit'],
					'i_req_count'        => $a_track['req_count'],
					's_photo'        => $a_url,
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




			$this->load->view('collection',$arr);
		}

    }
	
	function display_radio($album_id)
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

			$this->load->view('display_radio',$arr);
		}
	
	}
	
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
		$album['base_url'] = base_url().'radio/filter'.$query_str;
		$album['total_rows'] = $cnt;
		$album['num_links']= '3';
		$album['cur_page']= $cur_page * $no_of_records;
		$this->pagination->initialize($album);
		$this->load->view('album_search',$arr);
	}
	
	function filter()
	{
		
		$arr['scripts_css'] = array('left_menu.css','calender/jquery.ui.all.css','calender/demos.css','Styles.css' , 'fancybox/jquery.fancybox-1.3.4.css',	'alert/alerts_box.css',	'pickle_player/basic_audio_player/_stylesheet.css');

        $arr['scripts_js'] = array('drop/admin_common.js','validation/album_booking.js','jquery-1.8.3.min.js','calender/jquery.ui.core.js','calender/jquery.ui.datepicker.js','drop/common.js','jquery.form.js','fancybox/jquery.fancybox-1.3.4.js','validation/manage_calendar.js','pickle.js');
		
        extract($_REQUEST);				
		
		$a_selected_genre = $this->music_model->get_select_genre_detail($this->session->userdata('login_id'));

		$a_selected_genres = array();
		foreach($a_selected_genre as $i_key => $a_rows) {
			$a_selected_genres[] = $a_rows["playlist_genre"];
		}

		$arr['a_selected_genre'] = $a_selected_genres;
		$arr['genre'] = $this->music_model->get_genre_detail();
		$this->load->view('filter',$arr);
	}
	
	function filter_genre()
	{
		$arr['scripts_css'] = array('left_menu.css','calender/jquery.ui.all.css','calender/demos.css','Styles.css' , 'fancybox/jquery.fancybox-1.3.4.css',	'alert/alerts_box.css',	'pickle_player/basic_audio_player/_stylesheet.css');

        $arr['scripts_js'] = array('drop/admin_common.js','validation/album_booking.js','jquery-1.8.3.min.js','calender/jquery.ui.core.js','calender/jquery.ui.datepicker.js','drop/common.js','jquery.form.js','fancybox/jquery.fancybox-1.3.4.js','validation/manage_calendar.js','pickle.js');
		
        extract($_REQUEST);

		
		

		// $imp_chkmsg = implode(",", $_REQUEST['chkmsg']);
		$arr['insert_genre'] = $this->music_model->insert_genre_detail($_REQUEST,$_REQUEST['user_id']);
		
		$arr['select_genre'] = $this->music_model->get_select_genre_detail($this->session->userdata('login_id'));



		redirect(site_url().'radio/filter');
	
	}
	
	function display_album()
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

			$this->load->view('display_album',$arr);
		}	
	
	}
	
	function play()
	{
		$arr['scripts_css'] = array('left_menu.css','Styles.css',	'fancybox/jquery.fancybox-1.3.4.css',	'alert/alerts_box.css',	'pickle_player/basic_audio_player/_stylesheet.css'	);
		$arr['scripts_js']  = array('drop/common.js','jquery-1.8.3.min.js','jquery.form.js','fancybox/jquery.fancybox-1.3.4.js','validation/manage_calendar.js','pickle.js');		
		
		$this->load->view('play',$arr);
	}
	
	function playerlist()
	{
		$this->load->view('playerlist',$arr);
	
	}
	
	function requested()
	{
		$music_id = $this->input->post('id');
		$session_id = $this->session->userdata('login_id');
		$arr['request'] = array(
			'request_song_id'       => $music_id,
			'user_id' => $session_id,
			'abt_i_id' => $music_id
			);
				
		$arr['track_detail'] = $this->music_model->get_track_amt( $music_id );
		$req_count = $arr['track_detail'][0]['req_count'] ;
		
			$arr['update_track'] = array(
					'abt_i_id'       => $music_id,

					'req_count'       => stripslashes(trim($req_count))
				);
				
			$this->music_model->update_track_amt( $arr['update_track'] , $music_id);
						
			echo $this->music_model->request_status($session_id,$arr['request']);
		
	
	}

	/**
	 *
	 */
	public function stream_radio(){

		$arr['scripts_css'] = array('left_menu.css','Styles.css',	'fancybox/jquery.fancybox-1.3.4.css',	'alert/alerts_box.css',		);
		$arr['scripts_js']  = array('drop/common.js','jquery-1.8.3.min.js','jquery.form.js','fancybox/jquery.fancybox-1.3.4.js','validation/manage_calendar.js','pickle.js');

		$this->load->view('stream_radio',$arr);
	}

}	