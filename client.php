<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Client extends CI_Controller
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
		error_reporting(0);
		parent::__construct();
		
		
		
		
		if ($this->session->userdata('fname') == '') {
			redirect(site_url() . 'home');

		
		}
		
		
		
		$this->load->library('pagination');
		$this->load->model('client_model');
		$this->load->model('music_model');
	}
	
	function get_payment_details()
	{

		ini_set('display_error','0');

		ini_set('display_error','0');

		$arr['data'] = $this->music_model->get_account_details( $this->session->userdata('login_id') );
		
		$price = $this->client_model->get_ticket_price(intval($_REQUEST['i_ticket_id']));

		// if($price == false) {
		
		// $a_response['s_status'] = 'error';
		// $a_response['s_html'] = 'This event cannot be viewed live!<br/><input type="button" name="btnCancel" id="btnCancel" value="Close" class="Button_css">';
		// die( json_encode($a_response) );

		
		// }
		
		
		## code to set data to show account details.

		if( isset($arr['data']) && sizeof($arr['data']) > 0 ) {

			$arr['a_account'] = array(

				'i_ticket_id'    => intval($_REQUEST['i_ticket_id']),
				
				// 'registration_id'    => intval($_REQUEST['registration_id']),
				
				's_ticket_price' => $price,

				'i_id'          => $arr['data'][0]['acdusr_i_id'],

				's_fname'       => $arr['data'][0]['acd_s_fname'],

				's_lname'       => $arr['data'][0]['acd_s_lname'],

				's_card_type'   => $arr['data'][0]['acd_s_card_type'],

				's_card_number' => $arr['data'][0]['acd_s_card_number'],

				'i_month'       => $arr['data'][0]['acd_i_month'],

				'i_year'        => $arr['data'][0]['acd_i_year'],

				's_cvv'         => $arr['data'][0]['acd_s_cvv'],

//                's_address'     => $arr['data'][0]['acd_s_cvv'],

//                's_city'        => $arr['data'][0]['acd_s_cvv'],

//                's_state'       => $arr['data'][0]['acd_s_cvv'],

//                'i_zipcode'     => $arr['data'][0]['acd_s_cvv'],

			);

		} else {

			$arr['a_account'] = array(

				'i_ticket_id'    => intval($_REQUEST['i_ticket_id']),
				
				's_ticket_price' => $price,

				'i_id'          => '',

				's_fname'       => '',

				's_lname'       => '',

				's_card_type'   => '',

				's_card_number' => '',

				'i_month'       => '',

				'i_year'        => '',

				's_cvv'         => '',

//                's_address'     => '',

//                's_city'        => '',

//                's_state'       => '',

//                'i_zipcode'     => '',

			);

		}



		ob_start();
		$val = $this->load->view('get_ticket_payment',$arr);
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



			require_once('file:///C|/Users/Bohemian Hacker/AppData/Local/Temp/Temp1_before gym.zip/application/controllers/library/paypal/config.php');

			//$this->load->library('paypal');



			$s_fname = trim($_REQUEST['fname']);

			$s_lname = trim($_REQUEST['lname']);

			$s_ctype = trim($_REQUEST['creditCardType']);

			$s_number = trim($_REQUEST['card_number']);

			$s_month = trim($_REQUEST['expDateMonth']);

			$s_year = trim($_REQUEST['expDateYear']);

			$s_cvv = trim($_REQUEST['cvv']);
			
			
			$ticket_id = intval(trim($_REQUEST['i_ticket_id']));


			$price = $this->client_model->get_ticket_price($ticket_id);

			if($price == false) {
		
			// echo "This event cannot be viewed live!";
			// die();
		
			}
		
			//$i_card_number = substr($_REQUEST['card_number'], 12);



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

			$a_request_params = array

			(

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

//            'STREET' => trim($_POST['fname']),

//            'CITY' => trim($_POST['fname']),

//            'STATE' => trim($_POST['fname']),

//            'COUNTRYCODE' => 'US',

//            'ZIP' => trim($_POST['zip']),

				'AMT'               => $price,//1.29

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



			if( $s_acknoledge != "SUCCESS" )

			{

				throw new Exception($a_paypal_response['L_LONGMESSAGE0']);

			} else {

				## code to add purchased track.

				$arr['purchase'] = array(

					'ptkusr_i_id'           => $this->session->userdata('login_id'),

					'ptkevent_i_id'           => trim($_REQUEST['registration_id'])
					
					// 'registration_id'           => trim($_REQUEST['registration_id']),

				);



				$i_purchased_id = $this->client_model->add_purchsed_ticket( $arr['purchase'] );



				## code to add album.

				$arr['account'] = array(

					'acdusr_i_id'       => $this->session->userdata('login_id'),

					'acd_s_fname'       => stripslashes(trim($_REQUEST['fname'])),

					'acd_s_lname'       => stripslashes(trim($_REQUEST['lname'])),

					'acd_s_card_type'   =>  stripslashes(trim($_REQUEST['creditCardType'])),

					'acd_s_card_number' =>  stripslashes(trim($_REQUEST['card_number'])),

					'acd_i_month'       =>  stripslashes(trim($_REQUEST['expDateMonth'])),

					'acd_i_year'        =>  stripslashes(trim($_REQUEST['expDateYear'])),

					'acd_s_cvv'         =>  stripslashes(trim($_REQUEST['cvv'])),

//                'acd_s_address'     =>  stripslashes(trim($_REQUEST['cvv'])),

//                'acd_s_city'        =>  stripslashes(trim($_REQUEST['cvv'])),

//                'acd_s_state'       =>  stripslashes(trim($_REQUEST['cvv'])),

//                'acd_i_zipcode'     =>  stripslashes(trim($_REQUEST['cvv'])),

				);



				// if( !empty($_REQUEST['i_id']) ) {

					// ## code to update account detailos.

					// $i_account_id = $this->music_model->update_account_details( $arr['account'], $_REQUEST['i_id'] );

				// } else {

					// ## code to add account detailos.

					// $i_account_id = $this->music_model->add_account_details( $arr['account'] );

				// }



				$response['s_status']  = 'success';

				$response['data']	  = '';

			}

		} catch (Exception $e){

			$response['s_status']  = 'error';

			$response['data'] = $e->getMessage();

		}

		die( json_encode($response) );

	}

	function event_booking()
	{

		$arr['scripts_css'] = array('left_menu.css', 'calender/jquery.ui.all.css',
			'calender/demos.css', 'Styles.css');
		$arr['scripts_js'] = array(
            'jquery-1.8.3.min.js',
            'drop/common.js',
            'validation/event_booking.js',
			'calender/jquery.ui.core.js',
            'calender/jquery.ui.datepicker.js'
        );

		$arr['msg'] = '';
		if ($this->session->userdata('fname') == "") // check admin login
		{
			$this->session->set_flashdata('user_flash',
				'Your session has been expired please Login again!!!');
			redirect('home');
		} else {
			$login_id = $this->session->userdata('login_id');
			
		
			## code to set blank data to add new booking.
			$arr['data'] = array(
				'email' => '',
				'city' => '',
				'state' => '',
				'zipcode' => '',
				'date_from' => '',
				'date_to' => '',
				'category' => '',
				'genre' => '',
				'artist' => '',
				'active_year' => '',
				'price' => '',
				'description' => ''
			);
			$this->load->view('event_booking', $arr);
		}
	}

	function booking_process()
	{
	$arr['scripts_css'] = array('left_menu.css', 'calender/jquery.ui.all.css', 'calender/demos.css', 'Styles.css');

        $arr['scripts_js'] = array(
            'jquery-1.8.3.min.js',
            'drop/common.js',
            'validation/event_booking.js',
            'calender/jquery.ui.core.js',
            'calender/jquery.ui.datepicker.js'
        );
		$arr['msg'] = '';
		if (isset($_REQUEST['Submit'])) {
			extract($_REQUEST);
						
		} else {	
			$login_id = $this->session->userdata('login_id');
			
	

			## code to set blank data to add new booking.
			$arr['data'] = array(

				'login_id' => (trim($login_id)),

				'email' => stripslashes(trim($email)),

				'city' => stripslashes(trim($city)),

				'state' => stripslashes(trim($state)),

				'zipcode' => stripslashes(trim($zipcode)),

				'date_from' => stripslashes(trim($date_from)),

				'date_to' => stripslashes(trim($date_to)),

				'category' => stripslashes(trim($category)),

				'genre' => stripslashes(trim($genre)),

				'artist' => stripslashes(trim($artist)),

				'active_year' => stripslashes(trim($active_year)),

				'price' => stripslashes(trim($price)),

				'description' => stripslashes(trim($description)),

				'created_date' => date('Y-m-d H:m:s')

			);

			$res['bool'] = $this->client_model->insertBooking($arr['data']);
			if ($res['bool'] > 0) {
				$arr['msg'] = 'Booking added successfully.';
			} else {
				$arr['msg'] = 'Problem occured while booking.';
			}
		}
		$this->load->view('event_booking', $arr);
	}

	public function manage_booking()
	{
		$arr['scripts_css'] = array('left_menu.css',
			'calender/jquery.ui.all.css',
			'calender/demos.css',
			'Styles.css',
			//'fancybox/jquery.fancybox-1.3.4.css',
			//'alert/alerts_box.css',
			'alert/jquery.modal.css',
		);
		$arr['scripts_js'] = array(
            'jquery-1.8.3.min.js',
            'drop/common.js',
			'calender/jquery.ui.core.js',
			'calender/jquery.ui.datepicker.js',
			'fancybox/jquery.fancybox-1.3.4.js',
			'alert/jquery.modal.js',
			'validation/event_booking.js',
		);
		
		

		extract($_REQUEST);
		$intLoginId = $this->session->userdata('login_id');
		$state = isset($_REQUEST['state']) ? trim($_REQUEST['state']) : '';
		$city = isset($_REQUEST['city']) ? trim($_REQUEST['city']) : '';
		$date_from = isset($_REQUEST['date_from']) ? trim($_REQUEST['date_from']) : '';
		$date_to = isset($_REQUEST['date_to']) ? trim($_REQUEST['date_to']) : '';
		$genre = isset($_REQUEST['genre']) ? trim($_REQUEST['genre']) : '';
		$artist = isset($_REQUEST['artist']) ? trim($_REQUEST['artist']) : '';
		$category = isset($_REQUEST['category']) ? trim($_REQUEST['category']) : '';
		$btnclear = isset($_REQUEST['btnclear']) ? $_REQUEST['btnclear'] : '';
		if ($btnclear == 'Clear') {
			$state = '';
			$city = '';
			$date_to = '';
			$date_from = '';
			$genre = '';
			$artist = '';
			$category = '';
		}

		$arr['state'] = $state;
		$arr['city'] = $city;
		$arr['date_from'] = $date_from;
		$arr['date_to'] = $date_to;
		$arr['genre'] = $genre;
		$arr['artist'] = $artist;
		$arr['category'] = $category;

		$no_of_records = isset($_REQUEST['no_of_records']) ?
			$_REQUEST['no_of_records'] : '4';

		if (isset($_REQUEST['sort'])) {
			$sort = trim($_REQUEST['sort']);
		} else {
			$sort = "date_to"; //CHANGE THE FIELD id TO BE SORT BY
		}
		if (isset($_REQUEST['order_by'])) {
			if (trim($_REQUEST['order_by']) == "asc") {
				$order_by = "desc";
				$Image = "arrow-up.png";
			} else {
				$order_by = "asc";
				$Image = "arrow-down.png";
			}
		} else {
			$order_by = "desc";
			$Image = "arrow-up.png";
		}

		if ($sort == 'email') {
			$arr['Firstrow'] = "<img src='" . ADMIN_IMAGES . $Image . "' border='0' align='absmiddle'>";
		} elseif ($sort == 'city') {
			$arr['Secondrow'] = "<img src='" . ADMIN_IMAGES . $Image . "' border='0' align='absmiddle'>";
		} elseif ($sort == 'date_to') {
			$arr['Thirdrow'] = "<img src='" . ADMIN_IMAGES . $Image . "' border='0' align='absmiddle'>";
		} elseif ($sort == 'genre') {
			$arr['Forthrow'] = "<img src='" . ADMIN_IMAGES . $Image . "' border='0' align='absmiddle'>";
		} elseif ($sort == 'artist') {
			$arr['Fifthrow'] = "<img src='" . ADMIN_IMAGES . $Image . "' border='0' align='absmiddle'>";
		} elseif ($sort == 'category') {
			$arr['Sixthrow'] = "<img src='" . ADMIN_IMAGES . $Image . "' border='0' align='absmiddle'>";
		} else {
			$arr['Firstrow'] = "<img src='" . ADMIN_IMAGES . $Image . "' border='0' align='absmiddle'>";
		}
		$arr['sort'] = $sort;
		$arr['order_by'] = $order_by;


		if (isset($no_of_records) && $no_of_records != '') {
			$arr['no_of_records'] = $no_of_records; //$no_of_records
			$arr['selected'] = "Selected";
			$booking['per_page'] = $no_of_records;
		} else {
			$arr['no_of_records'] = 4;
			$arr['selected'] = "";
			$booking['per_page'] = 4;
		}

		$per_page = isset($_REQUEST['per_page']) ? $_REQUEST['per_page'] : '0';
		$cur_page = $per_page / $no_of_records;

		## GET ALL THE booking
		$cnt = $this->client_model->getAllBookingCount($state, $city, $date_from, $date_to, $genre, $artist, $category);
		$arr['data'] = $this->client_model->getAllBooking($booking['per_page'], (int)$per_page, $state, $city, $date_from, $date_to, $genre, $artist, $category, $sort, $order_by);
		$arrContacts = $this->client_model->getUserContacts($intLoginId);
		$arrContactList = array();
		foreach ($arrContacts as $key => $arrValue) {
			$arrContactList[] = $arrValue->booking_id;
		}

		$query_str = "?state=" . $state . "&city=" . $city . "&date_to=" . $date_to . "&genre=" . $genre . "&artist=" . $artist . "&category=" . $category . "&no_of_records=" . $no_of_records . "&date_from=" . $date_from;

		$arr['query_str'] = $query_str;
		$arr['arrContactList'] = $arrContactList;

		$booking['base_url'] = base_url() . 'client/manage_booking' . $query_str;
		$booking['total_rows'] = $cnt;
		$booking['num_links'] = '3';
		$booking['cur_page'] = $cur_page * $no_of_records;

		$this->pagination->initialize($booking);

		$this->load->view('booking_search', $arr);

	}

	function event_registration()
	{
		$arr['scripts_css'] = array('left_menu.css', 'calender/jquery.ui.all.css', 'calender/demos.css', 'Styles.css');

		$arr['scripts_js'] = array('jquery-1.8.3.min.js', 'drop/common.js', 'validation/event_registration.js', 'calender/jquery.ui.core.js', 'calender/jquery.ui.datepicker.js');

		$arr['msg'] = '';

		if ($this->session->userdata('fname') == "") // check admin login
		{

			$this->session->set_flashdata('user_flash', 'Your session has been expired please Login again!!!');

			redirect('home');

		} else {

			$login_id = $this->session->userdata('login_id');
			



		
			## code to set blank data to add new booking.

			$arr['data'] = array(

				'address' => '',

				'city' => '',

				'state' => '',

				'zipcode' => '',

				'date' => '',

				'time' => '',

				'category' => '',

				'venue' => '',
				
				'scategory' => '',

				'artist' => '',

				'genre' => '',

				'age' => '',

				

				'price' => '',
								
				'phone_no' => '',

			);

			$this->load->view('event_registration', $arr);
		}
	}


	function registration_process()
	{
		$arr['scripts_css'] = array('left_menu.css', 'calender/jquery.ui.all.css', 'calender/demos.css', 'Styles.css');

		$arr['scripts_js'] = array('jquery-1.8.3.min.js','drop/common.js', 'validation/album.js', 'validation/event_registration.js',  'calender/jquery.ui.core.js', 'calender/jquery.ui.datepicker.js');
		$arr['msg'] = '';
		if (isset($_REQUEST['Submit'])) {
			extract($_REQUEST);

			} else {	
			$login_id = $this->session->userdata('login_id');
			
			}

				
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

					chmod("uploaded/album/", 755);
					move_uploaded_file( $_FILES["s_photo"]["tmp_name"], $s_album_path );
					chmod($s_album_path, 0777);
				} else {
				$s_album_name = $_REQUEST['s_photo_url'];
			}

			## code to set blank data to add new booking.

			$arr['data'] = array(

				'login_id' => (trim($login_id)),

				'address' => stripslashes(trim($address)),

				'city' => stripslashes(trim($city)),

				'state' => stripslashes(trim($state)),

				'zipcode' => stripslashes(trim($zipcode)),

				'date' => stripslashes(trim($date)),

				'time' => stripslashes(trim($time)),

				'category' => stripslashes(trim($category)),

				'venue' => stripslashes(trim($venue)),
				
				'scategory' => stripslashes(trim($scategory)),

				'artist' => stripslashes(trim($artist)),

				'genre' => stripslashes(trim($genre)),

				'age' => stripslashes(trim($age)),

				'price' => stripslashes(trim($price)),

				
												
				'price_online' => '',

				'phone_no' => stripslashes(trim($phone_no)),

				'created_date' => date('Y-m-d H:m:s')

			);
						
			$res['bool'] = $this->client_model->insertRegistration($arr['data']);
								
			if($this->input->post('hidCnt') > 0)
			{

			if ($res['bool'] > 0) {

				$arr['msg'] = 'Registration added successfully.';

			} else {

				$arr['msg'] = 'Problem occured while Registration.';

			}
		}
		
			
		$this->load->view('event_registration', $arr);
		
	}


	public function manage_registration() {
		$arr['scripts_css'] = array(
			'left_menu.css',
			'Styles.css',
			'calender/jquery.ui.all.css',
			'calender/demos.css',
			'fancybox/jquery.fancybox-1.3.4.css',
			'alert/alerts_box.css',
			'leaflet/leaflet.css',     
			'alert/jquery.modal.css'
		);
		$arr['scripts_js'] = array(
            'jquery-1.8.3.min.js',
            'drop/common.js',
			'alert/jquery.modal.js',
			'calender/jquery.ui.core.js',
			'calender/jquery.ui.datepicker.js',
			'fancybox/jquery.fancybox-1.3.4.js',
			'validation/event_registration.js',
			'jquery.form.js',
			'leaflet/leaflet.js', 
			'validation/manage_calendar.js',
			'pickle.js'			
		);
		extract($_REQUEST);
		if ($_SERVER['REQUEST_METHOD'] === 'GET') {
			$state = isset($_GET['state'])  ? trim($_GET['state'])  : '' ;
			$city  = isset($_GET['city'])   ? trim($_GET['city'])   : '' ;
			$date  = isset($_GET['date'])   ? trim($_GET['date'])   : '' ;
			$genre = isset($_GET['genre'])  ? trim($_GET['genre'])  : '' ;
			$artist= isset($_GET['artist']) ? trim($_GET['artist']) : '' ;
			$venue = isset($_GET['venue'])  ? trim($_GET['venue'])  : '' ;
			$btnclear = isset($_GET['btnclear']) ? $_GET['btnclear'] : '';
			$per_page = isset($_GET['per_page']) ? $_GET['per_page'] : '0';
		}
		elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$state = isset($_POST['state'])  ? trim($_POST['state'])  : '' ;
			$city  = isset($_POST['city'])   ? trim($_POST['city'])   : '' ;
			$date  = isset($_POST['date'])   ? trim($_POST['date'])   : '' ;
			$genre = isset($_POST['genre'])  ? trim($_POST['genre'])  : '' ;
			$artist= isset($_POST['artist']) ? trim($_POST['artist']) : '' ;
			$venue = isset($_POST['venue'])  ? trim($_POST['venue'])  : '' ;
			$btnclear = isset($_POST['btnclear']) ? $_POST['btnclear'] : '';
			$per_page = isset($_POST['per_page']) ? $_POST['per_page'] : '0';
		}
		if ($btnclear == 'Clear') { 
			$state = ''; $city = ''; $date = ''; $genre = ''; $artist = ''; $venue = ''; 
		}
		$arr['state'] = $state;
		$arr['city'] = $city;
		$arr['date'] = $date;
		$arr['genre'] = $genre;
		$arr['artist'] = $artist;
		$arr['venue'] = $venue;

		$no_of_records = isset($_REQUEST['no_of_records']) ? $_REQUEST['no_of_records'] : '4';
		if (isset($_REQUEST['sort'])) {
			$sort = trim($_REQUEST['sort']);
		} else {
			$sort = "created_date"; //CHANGE THE FIELD id TO BE SORT BY
		}
		if (isset($_REQUEST['order_by'])) {
			if (trim($_REQUEST['order_by']) == "asc") {
				$order_by = "desc";
				$Image = "arrow-up.png";
			} else {
				$order_by = "desc";
				$Image = "arrow-down.png";
			}
		} else {
			$order_by = "desc";
			$Image = "arrow-up.png";
		}

		if ($sort == 'address') {
			$arr['Firstrow'] = "<img src='" . ADMIN_IMAGES . $Image . "' border='0' align='absmiddle'>";
		} elseif ($sort == 'city') {
			$arr['Secondrow'] = "<img src='" . ADMIN_IMAGES . $Image . "' border='0' align='absmiddle'>";
		} elseif ($sort == 'created_date') {
			$arr['Thirdrow'] = "<img src='" . ADMIN_IMAGES . $Image . "' border='0' align='absmiddle'>";
		} elseif ($sort == 'genre') {
			$arr['Forthrow'] = "<img src='" . ADMIN_IMAGES . $Image . "' border='0' align='absmiddle'>";
		} elseif ($sort == 'artist') {
			$arr['Fifthrow'] = "<img src='" . ADMIN_IMAGES . $Image . "' border='0' align='absmiddle'>";
		} elseif ($sort == 'venue') {
			$arr['Sixthrow'] = "<img src='" . ADMIN_IMAGES . $Image . "' border='0' align='absmiddle'>";
		} else {
			$arr['Firstrow'] = "<img src='" . ADMIN_IMAGES . $Image . "' border='0' align='absmiddle'>";
		}

		$arr['sort'] = $sort;
		$arr['order_by'] = $order_by;

		if (isset($no_of_records) && $no_of_records != '') {
			$arr['no_of_records'] = $no_of_records; //$no_of_records
			$arr['selected'] = "Selected";
			$booking['per_page'] = $no_of_records;
		} else {
			$arr['no_of_records'] = 4;
			$arr['selected'] = "";
			$booking['per_page'] = 4;
		}

		// $cur_page = $per_page / $no_of_records;


		## GET ALL THE booking
		$cnt = $this->client_model->getAllRegistrationCount($state, $city, $date, $genre, $artist, $venue);
		$arr['data'] = $this->client_model->getAllRegistration(
			4,
			(int)$per_page,
			$state, $city, $date, $genre, $artist, $venue, $sort, $order_by);
			
		
		
		
		$intLoginId = $this->session->userdata('login_id');
		$arrEvents = $this->client_model->getUserCalendar($intLoginId);
		$arrEventsList = array();
		foreach ($arrEvents as $key => $arrValue) {
			$arrEventsList[] = $arrValue->registration_id;
		}
		$arr['arrEventsList'] = $arrEventsList;
		$arr['a_purchase']=$this->client_model->get_user_tickets( $this->session->userdata('login_id') );
		$arr['a_purchased'] = array();
		## code to set data to edit album tracks.
		foreach($arr['a_purchase'] as $a_purchase ) {
			$arr['a_purchased'][] = $a_purchase['ptkevent_i_id'];
		}
		foreach($arr['data'] as $_data) {
			$res = $this->music_model->get_albums_by_user($_data->login_id,$_data->artist);	
			if(!empty($res)) {
				$_data->album_list = 1;
			}
				}
		
		$query_str = "?state="  . $state  . 
		             "&city="   . $city   . 
		             "&date="   . $date   . 
		             "&genre="  . $genre  . 
		             "&artist=" . $artist .
		             "&venue="  . $venue  . 
		             "&no_of_records=" . $no_of_records;
		$arr['query_str'] = $query_str;
		$booking['page_query_string'] = True;
		$booking['base_url'] = base_url() . 'client/manage_registration' . $query_str;
		$booking['total_rows'] = $cnt;
		$booking['num_links'] = '3';
		$booking['per_page'] = 4;
		// $booking['cur_page'] = $cur_page * $no_of_records;
		$this->pagination->initialize($booking);
		$this->load->view('registration_search', $arr);
		
	}


	function change_password()
	{

		$arr['scripts_css'] = array('left_menu.css', 'calender/demos.css', 'Styles.css');

		$arr['scripts_js'] = array('jquery-1.8.3.min.js', 'drop/common.js', 'validation/change_password.js', );
		extract($_REQUEST);

		if ($this->session->userdata('fname') == "") // check admin login
		{
			$this->session->set_flashdata('user_flash', 'Your session has been expired please Login again!!!');

			redirect('home');
		} else {
			$login_id = $this->session->userdata('login_id');

			$arr['data'] = array(
				'password' => '');

			$arr['msg'] = '';


			$this->load->view('change_password', $arr);

		}

	}


	function update_password()
	{
		$arr['scripts_css'] = array('left_menu.css', 'calender/demos.css', 'Styles.css');

        $arr['scripts_js'] = array('jquery-1.8.3.min.js', 'drop/common.js', 'validation/change_password.js', );

		$arr['msg'] = '';

		if (isset($_REQUEST['Submit'])) {
			extract($_REQUEST);

			$login_id = $this->session->userdata('login_id');

			$email = $this->session->userdata('email');

			$current_date = date('Y-m-d H:m:s');

			##function to check passwordis correct or not.

			$chkpass = $this->client_model->chkPasswordwithid($email, $password, $login_id);

			if (empty($chkpass)) {
				$arr['msg'] = 'error';

				$this->load->view('change_password', $arr);

			} else {
				$last_id = $this->client_model->update_password($new_password, $login_id);

				$arr['msg'] = 'success';

				$this->load->view('change_password', $arr);
			}
		}
		$this->load->view('change_password', $arr);
	}


	function show_map()
	{

		$arr['scripts_css'] = array(
			'Styles.css',
			'leaflet.css',
		);
		$arr['scripts_js'] = array(
			'jquery-1.8.3.min.js',
			'leaflet.js',
		);

		extract($_REQUEST);

		$arr['cur_address'] = $cur_address;
		$this->load->view('google_map', $arr);

	}

	function getMap()
	{
		$arr['scripts_css'] = array('Styles.css');
		//$arr['scripts_js'] = array('validation/change_password.js','jquery-1.8.3.min.js');

		$arr['cur_address'] = $_REQUEST['strAddress'];
		ob_start();
		$val = $this->load->view('google_map', $arr);
		$html = ob_get_contents();
		ob_end_clean();

		echo json_encode(array(
			'success' => true,
			'html' => $html,
		));
	}

	public function addContact()
	{
		$intBookingId = isset($_REQUEST['intBookingId']) ?
			$_REQUEST['intBookingId'] : 0;
		$intLoginId = $this->session->userdata('login_id');
		$arr['arrData'] = array(
			'booking_id' => $intBookingId,
			'login_id' => $intLoginId,
		);
		$last_id = $this->client_model->addBookingContact($arr['arrData']);
		echo json_encode(array(
				'success' => true,
			)
		);
	}

	public function addEvent()
	{
		$intRegnId = isset($_REQUEST['intRegnId']) ?
			$_REQUEST['intRegnId'] : 0;
		$intLoginId = $this->session->userdata('login_id');
		$arr['arrData'] = array(
			'registration_id' => $intRegnId,
			'login_id' => $intLoginId,
		);
		$last_id = $this->client_model->addEventCalendar($arr['arrData']);
		echo json_encode(array(
				'success' => true,
			)
		);
	}

	public function manage_contact()
	{
		$arr['scripts_css'] = array('left_menu.css',
			'Styles.css',
			'alert/jquery.modal.css',
		);
		$arr['scripts_js'] = array(
            'jquery-1.8.3.min.js',
            'drop/common.js',
			'validation/contact_search.js',
			'alert/jquery.modal.js',
			'validation/event_booking.js',
		);
		if($this->session->userdata('user_type') != 1 && $this->session->userdata('user_type') != 2 && $this->session->userdata('user_type') != 3 && $this->session->userdata('user_type') != 4)
		{
            		redirect(site_url().'home');
		}
		extract($_REQUEST);

		$strSearch = isset($_REQUEST['strSearch']) ? trim($_REQUEST['strSearch']) : '';
		$btnclear = isset($_REQUEST['btnclear']) ? $_REQUEST['btnclear'] : '';
		if ($btnclear == 'Clear') {
			$strSearch = '';
		}

		$arr['strSearch'] = $strSearch;

		$no_of_records = isset($_REQUEST['no_of_records']) ? $_REQUEST['no_of_records'] : '4';

		if (isset($_REQUEST['sort'])) {
			$sort = trim($_REQUEST['sort']);
		} else {
			$sort = "contact_id"; //CHANGE THE FIELD id TO BE SORT BY
		}
		if (isset($_REQUEST['order_by'])) {
			if (trim($_REQUEST['order_by']) == "asc") {
				$order_by = "desc";
				$Image = "arrow-up.png";
			} else {
				$order_by = "asc";
				$Image = "arrow-down.png";
			}
		} else {
			$order_by = "desc";
			$Image = "arrow-up.png";
		}

		if ($sort == 'email') {
			$arr['Firstrow'] = "<img src='" . ADMIN_IMAGES . $Image . "' border='0' align='absmiddle'>";
		} elseif ($sort == 'city') {
			$arr['Secondrow'] = "<img src='" . ADMIN_IMAGES . $Image . "' border='0' align='absmiddle'>";
		} elseif ($sort == 'state') {
			$arr['Thirdrow'] = "<img src='" . ADMIN_IMAGES . $Image . "' border='0' align='absmiddle'>";
		} elseif ($sort == 'genre') {
			$arr['Fourthrow'] = "<img src='" . ADMIN_IMAGES . $Image . "' border='0' align='absmiddle'>";
		} elseif ($sort == 'artist') {
			$arr['Fifthrow'] = "<img src='" . ADMIN_IMAGES . $Image . "' border='0' align='absmiddle'>";
		} else {
			$arr['Firstrow'] = "<img src='" . ADMIN_IMAGES . $Image . "' border='0' align='absmiddle'>";
		}
		$arr['sort'] = $sort;
		$arr['order_by'] = $order_by;


		if (isset($no_of_records) && $no_of_records != '') {
			$arr['no_of_records'] = $no_of_records; //$no_of_records
			$arr['selected'] = "Selected";
			$contact['per_page'] = $no_of_records;
		} else {
			$arr['no_of_records'] = 4;
			$arr['selected'] = "";
			$contact['per_page'] = 4;
		}

		$per_page = isset($_REQUEST['per_page']) ? $_REQUEST['per_page'] : '0';
		$cur_page = $per_page / $no_of_records;

		## GET ALL THE contact
		$cnt = $this->client_model->getAllContactsCount($strSearch);
		$arr['data'] = $this->client_model->getAllContacts($contact['per_page'],
			(int)$per_page, $strSearch, $sort, $order_by);

		$query_str = "?strSearch=" . $strSearch;

		$arr['query_str'] = $query_str;

		$contact['base_url'] = base_url() . 'client/manage_contact' . $query_str;
		$contact['total_rows'] = $cnt;
		$contact['num_links'] = '3';
		$contact['cur_page'] = $cur_page * $no_of_records;

		$this->pagination->initialize($contact);

		$this->load->view('contact_search', $arr);
	}

	function delete_contact()
	{
		$intContactId = isset($_REQUEST['intContactId']) ?
			$_REQUEST['intContactId'] : 0;
		$arr['arrData'] = array($intContactId);
		$last_id = $this->client_model->deleteContact($arr['arrData']);
		echo json_encode(array(
				'success' => true,
			)
		);

	}

	public function manage_calendar()
	{
		$arr['scripts_css'] = array(
			'left_menu.css',
			'Styles.css',
			'fancybox/jquery.fancybox-1.3.4.css',
			'alert/alerts_box.css',
		);
		$arr['scripts_js'] = array(
            'jquery-1.8.3.min.js',
            'drop/common.js',
			'fancybox/jquery.fancybox-1.3.4.js',
			'validation/manage_calendar.js',
		);
		
		extract($_REQUEST);

		$strMonth = isset($_REQUEST['strMonth']) ? trim($_REQUEST['strMonth']) : date('m');
		$strYear = isset($_REQUEST['strYear']) ? trim($_REQUEST['strYear']) : date('Y');
		$btnclear = isset($_REQUEST['btnclear']) ? $_REQUEST['btnclear'] : '';
		if ($btnclear == 'Clear') {
			$strMonth = date('m');
			$strYear = date('Y');
		}

		$arr['strMonth'] = $strMonth;
		$arr['strYear'] = $strYear;

		## GET ALL THE events
		$cnt = $this->client_model->getAllEventsCount($strMonth, $strYear);

		$arr['data'] = $this->client_model->getAllEvents($strMonth, $strYear);

		$query_str = "?strMonth=" . $strMonth . "&strYear=" . $strYear;

		$arr['query_str'] = $query_str;

		$contact['base_url'] = base_url() . 'client/manage_calendar' . $query_str;
		$contact['total_rows'] = $cnt;

		/* draw table */
		$calendar = '<table cellpadding="0" cellspacing="0" class="calendar">';

		/* table headings */
		$headings = array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');
		$calendar .= '<tr class="calendar-row"><td class="calendar-day-head">' . implode('</td><td class="calendar-day-head">', $headings) . '</td></tr>';

		$month = $strMonth;
		$year = $strYear;
		/* days and weeks vars now ... */
		$running_day = date('w', mktime(0, 0, 0, $month, 1, $year));
		$days_in_month = date('t', mktime(0, 0, 0, $month, 1, $year));
		$days_in_this_week = 1;
		$day_counter = 0;
		$dates_array = array();

		/* row for week one */
		$calendar .= '<tr class="calendar-row">';

		/* print "blank" days until the first of the current week */
		for ($x = 0; $x < $running_day; $x++):
			$calendar .= '<td class="calendar-day-np">&nbsp;</td>';
			$days_in_this_week++;
		endfor;

		/* keep going with days.... */
		for ($list_day = 1; $list_day <= $days_in_month; $list_day++):
			$calendar .= '<td class="calendar-day">';

			/* add in the day number */
			$calendar .= '<div class="day-number">' . $list_day . '</div>';
			$calendar .= '<div class="dayTd">';
			/** QUERY THE DATABASE FOR AN ENTRY FOR THIS DAY !!  IF MATCHES FOUND, PRINT THEM !! **/
			$dayOfMonth = $strYear . '-' . $strMonth . '-' . $list_day;
			$arrEvents = $this->client_model->getAllDayEvents($dayOfMonth);
			if (count($arrEvents) > 0) {
				$intCnt = 0;
				foreach ($arrEvents as $key => $arrRow) {
					$intCnt++;
					if ($intCnt > 5) break;
					$calendar .= '<a href="javascript:{};" class="viewEvent" id="' . $arrRow->registration_id . '">';
					$calendar .= $arrRow->category;
					$calendar .= '</a>';
				}
			}
			$calendar .= '</div>';
			$calendar .= '</td>';
			if ($running_day == 6):
				$calendar .= '</tr>';
				if (($day_counter + 1) != $days_in_month):
					$calendar .= '<tr class="calendar-row">';
				endif;
				$running_day = -1;
				$days_in_this_week = 0;
			endif;
			$days_in_this_week++;
			$running_day++;
			$day_counter++;
		endfor;

		/* finish the rest of the days in the week */
		if ($days_in_this_week < 8):
			for ($x = 1; $x <= (8 - $days_in_this_week); $x++):
				$calendar .= '<td class="calendar-day-np">&nbsp;</td>';
			endfor;
		endif;

		/* final row */
		$calendar .= '</tr>';

		/* end the table */
		$calendar .= '</table>';

		$arr['calendar'] = $calendar;

		$this->load->view('manage_calendar', $arr);
	}

	function viewEventDetails()
	{
		$arr['data'] = $this->client_model->getRegistrationDetail($_REQUEST['intEventId']);
		ob_start();
		$val = $this->load->view('event_data', $arr);
		$html = ob_get_contents();
		ob_end_clean();

		echo json_encode(array('html' => $html, 'success' => true));
	}
	
		function delete_calendar()
    {
        $intRegnId   = $_REQUEST['intEventId'];
        $arr['arrData'] = array( $intRegnId );
        $last_id     = $this->client_model->deleteEventCalendar( $arr['arrData'] );
        echo json_encode( array(
                'success'=>true,
            )
        );

    }

	function viewMap()
	{    
		$arr['scripts_css'] = array(
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
            'drop/common.js',
			'calender/jquery.ui.core.js',
			'calender/jquery.ui.datepicker.js',
			'fancybox/jquery.fancybox-1.3.4.js',
			'validation/event_registration.js',
			'leaflet/leaflet.js',            
		);    
		try {
			$s_address = $_REQUEST['s_address'];
			$s_event = $_REQUEST['s_event'];

			$myaddress = urlencode($s_address);

			//$url = "http://maps.google.com/maps/api/geocode/json?address=UK+Hull&sensor=false&region=England";
			$url = "http://maps.googleapis.com/maps/api/geocode/json?address=$myaddress&sensor=false";
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
			$response = curl_exec($ch);
			curl_close($ch);

			$response = json_decode($response);
		   
			$lattitude = $response->results[0]->geometry->location->lat;
			$longitude = $response->results[0]->geometry->location->lng;  

			$arr['lattitude'] = $lattitude;
			$arr['longitude'] = $longitude;
			$arr['s_address'] = $s_address;
			$arr['s_city'] = $_REQUEST['s_city'];
			$arr['s_state'] = $_REQUEST['s_state'];
			$arr['s_zipcode'] = $_REQUEST['s_zipcode'];
			//$arr['s_address'] = $s_address. '-'.$lattitude. '-'.$longitude;
			$arr['s_event']   = $s_event;
			//107 S. Adams St., Anaheim 
			//33.831192,-117.932128		

			/*$key = "ABQIAAAAmZIxqdYLvCjuvWLcB4T3DRSgV0AuV7g7MkPFI_XS2jQLDwPUqBReqoF8HP3MG709AMu7R9GqQ1I3_A";
			//$url = "http://maps.google.com/maps/api/geocode/json?address=UK+Hull&sensor=false&region=England";
			//$url = "http://maps.googleapis.com/maps/api/geocode/json?address=$myaddress&sensor=false&key=" . $key;
			$url = "http://maps.google.com/maps/geo?q=" . $myaddress . "&output=json&key=" . $key;
					
			$curl = curl_init();
			curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
			curl_setopt($curl, CURLOPT_URL, $url);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			$geo_json = json_decode(curl_exec($curl));
			
			$latitude = $geo_json['Placemark'][0]['Point']['coordinates'][0];
			$longitude = $geo_json['Placemark'][0]['Point']['coordinates'][1];
			
			$arr['lattitude'] = $latitude;
			$arr['longitude'] = $longitude;
			$arr['s_address'] = $s_address;
			//$arr['s_address'] = $s_address. '-'.$lattitude. '-'.$longitude;
			$arr['s_event']   = $s_event;
			echo '<pre>';
			print_r($arr);
			die;*/
			
			ob_start();
			$val = $this->load->view('event_map', $arr);
			$html = ob_get_contents();
			ob_end_clean();

			$a_response['s_status'] = 'success';
			$a_response['data']    = $html;
		}
		catch( Exception $e ) {
			$a_response['s_status'] = 'error';
			$a_response['data']     = $e->getMessage();
		}
		echo json_encode($a_response);
		die();        
	}

	public function live_event($page_name)
	{
		$arr['scripts_css'] = array('left_menu.css', 'calender/jquery.ui.all.css', 'calender/demos.css', 'Styles.css');
		$arr['scripts_js'] = array('jquery-1.8.3.min.js', 'drop/common.js', 'calender/jquery.ui.core.js', 'calender/jquery.ui.datepicker.js');


		extract($_REQUEST);
		
		if ($this->session->userdata('fname') == "") // check admin login
		{
			$this->session->set_flashdata('user_flash', 'Your session has been expired please Login again!!!');
			redirect('home');
		} else {			 			
			$this->load->view($page_name, $arr);
			
		}
	}	


}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
