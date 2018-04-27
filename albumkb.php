<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Album extends CI_Controller
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
        ini_set('display_error','0');
        ini_set('display_error','0');
        parent::__construct();

        if($this->session->userdata('fname')=='')
        {
            redirect(site_url().'login');

        }
        $this->load->model('music_model');;
    }

    /*
     * manage album with its track
     */
    public function manage_album()
    {
        $arr['scripts_css'] = array('left_menu.css',
            'calender/jquery.ui.all.css',
            'calender/demos.css',
            'Styles.css',
            //'fancybox/jquery.fancybox-1.3.4.css',
            //'alert/alerts_box.css',
            //'alert/jquery.modal.css',
        );
        $arr['scripts_js'] = array('drop/common.js',
            'jquery-1.8.3.min.js',
            'calender/jquery.ui.core.js',
            'calender/jquery.ui.datepicker.js',
            //'fancybox/jquery.fancybox-1.3.4.js',
            //'alert/jquery.modal.js',
            //'validation/event_booking.js',
        );

        $s_artist = isset($_REQUEST['s_artist']) ? trim($_REQUEST['s_artist']) : '';
        $s_genre = isset($_REQUEST['s_genre']) ? trim($_REQUEST['s_genre']) : '';
        $s_year = isset($_REQUEST['s_year']) ? trim($_REQUEST['s_year']) : '';
        $btnclear=isset($_REQUEST['btnclear'])?$_REQUEST['btnclear']:'';
        if($btnclear=='Clear')
        {
            $s_artist = '';
            $s_genre = '';
            $s_year = '';
        }

        $arr['s_artist'] = $s_artist;
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
        $cnt            = $this->music_model->getAllAlbumDetailCount($s_artist, $s_genre, $s_year);
        $arr['a_data']    = $this->music_model->getAllAlbumDetail($album['per_page'],(int)$per_page,$s_artist, $s_genre, $s_year, $sort, $order_by );

        $query_str="?s_artist=".$s_artist."&s_genre=".$s_genre."&s_year=".$s_year."&no_of_records=".$no_of_records;

        $arr['query_str']=$query_str;

        $album['base_url'] = base_url().'album/manage_album'.$query_str;
        $album['total_rows'] = $cnt;
        $album['num_links']= '3';
        $album['cur_page']= $cur_page * $no_of_records;

        $this->pagination->initialize($album);

        $this->load->view('album_search',$arr);
    }


    /*
     * view album with its track
     */
    function view_album()
    {
        $arr['scripts_css'] = array(
            'left_menu.css',
            'Styles.css',
            'fancybox/jquery.fancybox-1.3.4.css',
            'alert/alerts_box.css',
        );
        $arr['scripts_js']  = array(
            'drop/common.js',
            'jquery-1.8.3.min.js',
            'fancybox/jquery.fancybox-1.3.4.js',
            'validation/manage_calendar.js',
        );

        $arr['msg'] = '';

        if($this->session->userdata('fname') == "") // check admin login
        {
            $this->session->set_flashdata('user_flash', 'Your session has been expired please Login again!!!');
            redirect('login');
        }
        else
        {
            //$this->load->library('mp3file');
            //include("includes/mp3file.php");

            // include getID3() library (can be in a different directory if full path is specified)
            require_once('library/read_mp3/getid3/getid3.php');

            // Initialize getID3 engine
            $getID3 = new getID3;

            $arr['data']=$this->music_model->get_album_detail($_REQUEST['album_id']);
            $arr['a_tracks']=$this->music_model->get_album_tracks($_REQUEST['album_id']);

            $arr['tracks'] = array();
            ## code to set data to edit album tracks.
            foreach($arr['a_tracks'] as $a_track ) {
                // Analyze file and store returned data in $ThisFileInfo
                $s_url      = 'uploaded/track/'.$a_track['abt_s_url'];
                $a_file_info = $getID3->analyze($s_url);
//                echo '<pre>';
//                print_r(@$a_file_info['tags']['id3v2']['album'][0]);
//die;
                $arr['tracks'][] = array(
                    'i_track_id'        => $a_track['abt_i_id'],
                    's_title'           => $a_track['abt_s_title'],
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
                's_artist'      => $arr['data'][0]['msa_s_artist'],
                's_genre'       => $arr['data'][0]['msa_s_genre'],
                's_year'        => $arr['data'][0]['msa_s_year'],
                's_photo'       => $arr['data'][0]['msa_s_album_photo'],
                'i_track_total' => sizeof($arr['tracks']),
            );

            $this->load->view('view_album',$arr);
        }
    }

    function get_payment_details()
    {
        //if($this->session->userdata('fname') == "")
        $arr['data'] = $this->music_model->get_account_details( $this->session->userdata('login_id') );

        ## code to set data to show account details.
        $arr['a_account'] = array(
            'i_id'        => $arr['data'][0]['acdusr_i_id'],
            's_fname'       => $arr['data'][0]['acd_s_fname'],
            's_lname'       => $arr['data'][0]['acd_s_lname'],
            's_card_type'   => $arr['data'][0]['acd_s_card_type'],
            's_card_number' => $arr['data'][0]['acd_s_card_number'],
            'i_month'       => $arr['data'][0]['acd_i_month'],
            'i_year'        => $arr['data'][0]['acd_i_year'],
            's_cvv'         => $arr['data'][0]['acd_s_cvv'],
            's_address'         => $arr['data'][0]['acd_s_cvv'],
            's_city'         => $arr['data'][0]['acd_s_cvv'],
            's_state'         => $arr['data'][0]['acd_s_cvv'],
            'i_zipcode'         => $arr['data'][0]['acd_s_cvv'],
        );

        ob_start();
        $val = $this->load->view('get_payment',$arr);
        $s_html = ob_get_contents();
        ob_end_clean();

        $a_response['s_status'] = 'succcess';
        $a_response['s_html'] = $s_html;
        die( json_encode($a_response) );
    }

    // Function to convert NTP string to an array
    function NVPToArray($NVPString)
    {
        $proArray = array();
        while(strlen($NVPString))
        {
            // name
            $keypos= strpos($NVPString,'=');
            $keyval = substr($NVPString,0,$keypos);
            // value
            $valuepos = strpos($NVPString,'&') ? strpos($NVPString,'&'): strlen($NVPString);
            $valval = substr($NVPString,$keypos+1,$valuepos-$keypos-1);
            // decoding the respose
            $proArray[$keyval] = urldecode($valval);
            $NVPString = substr($NVPString,$valuepos+1,strlen($NVPString));
        }
        return $proArray;
    }

    function payment_process()
    {
        try {

            require_once('library/paypal/config.php');

            $s_fname = trim($_REQUEST['fname']);
            $s_lname = trim($_REQUEST['lname']);
            $s_ctype = trim($_REQUEST['creditCardType']);
            $s_number = trim($_REQUEST['card_number']);
            $s_month = trim($_REQUEST['expDateMonth']);
            $s_year = trim($_REQUEST['expDateYear']);
            $s_cvv = trim($_REQUEST['cvv']);

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
                'AMT'               => '1.29',
                'CURRENCYCODE'      => 'USD',
            );

//            $this->load->library('paypal');
//            $a_result = $this->paypal->process( $a_request_params );

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
            $a_paypal_response = $this->NVPToArray($a_result);

            $s_acknoledge = strtoupper($a_paypal_response["ACK"]);

            $arr['msg'] = 'payment_success';

            $arr["resArray"]= $a_paypal_response;

            if( $s_acknoledge != "SUCCESS" )
            {
                throw new Exception($a_paypal_response['L_LONGMESSAGE0']);
            } else {

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

                ## code to add purchased track.
                $arr['purchase'] = array(
                    'ptkusr_i_id'           => $this->session->userdata('login_id'),
                    'ptkabt_i_id'           => stripslashes(trim($_REQUEST['i_id'])),
                    //'ptk_d_purchased_date'  => stripslashes(trim($_REQUEST['lname'])),
                );

                $i_purchased_id = $this->music_model->add_purchsed_track( $arr['purchase'] );

                if( !empty($_REQUEST['i_id']) ) {
                    ## code to update account detailos.
                    $i_account_id = $this->music_model->update_account_details( $arr['account'], $_REQUEST['i_id'] );
                } else {
                    ## code to add account detailos.
                    $i_account_id = $this->music_model->add_account_details( $arr['account'] );
                }

                $response['s_status']  = 'success';
                $response['data']	  = '';
            }
        } catch (Exception $e){
            $response['s_status']  = 'error';
            $response['data'] = $e->getMessage();
        }
        die( json_encode($response) );
    }

    function payment_process1()
    {
        session_start();

        $arr['scripts_css'] = array('Styles.css');
        $arr['scripts_js'] = array('validation/payment.js');

        extract($_REQUEST);

        try {

            //require_once 'CallerService.php';

            /**
             * Get required parameters from the web form for the request
             */
//echo '<pre>';
//            print_r($_REQUEST);
//            throw new Exception('First ssdfds.');
////die;
            if( empty($_REQUEST['fname']) )
                throw new Exception('First ssdfds.');

            ## code to add album.
            $arr['account'] = array(
                'acdusr_i_id'      => $this->session->userdata('login_id'),
                'acd_s_fname'       => stripslashes(trim($_REQUEST['fname'])),
                'acd_s_lname'       => stripslashes(trim($_REQUEST['lname'])),
                'acd_s_card_type'        =>  stripslashes(trim($_REQUEST['creditCardType'])),
                'acd_s_card_number'        =>  stripslashes(trim($_REQUEST['card_number'])),
                'acd_i_month'        =>  stripslashes(trim($_REQUEST['expDateMonth'])),
                'acd_i_year'        =>  stripslashes(trim($_REQUEST['expDateYear'])),
                'acd_s_cvv'        =>  stripslashes(trim($_REQUEST['cvv'])),
            );

            if( !empty($_REQUEST['i_id']) ) {
                ## code to update account detailos.
                $i_account_id = $this->music_model->update_account_details( $arr['account'], $_REQUEST['i_id'] );
            } else {
                ## code to add account detailos.
                $i_account_id = $this->music_model->add_account_details( $arr['account'] );
            }



//            $firstName =urlencode( $_POST['fname']);
//            $lastName =urlencode( $_POST['lname']);
//            $creditCardType =urlencode( $_POST['creditCardType']);
//            $creditCardNumber = urlencode($_POST['card_number']);
//            $expDateMonth =urlencode( $_POST['expDateMonth']);
//
//            // Month must be padded with leading zero
//            $padDateMonth = str_pad($expDateMonth, 2, '0', STR_PAD_LEFT);
//
//            $expDateYear =urlencode( $_POST['expDateYear']);
//            $cvv2Number = urlencode($_POST['cvv']);
//            $amount = urlencode("1.00");
//            $currencyCode="USD";
//            $paymentType =urlencode('Sale');
//
//            /* Construct the request string that will be sent to PayPal.
//               The variable $nvpstr contains all the variables and is a
//               name value pair string with & as a delimiter */
//
//            //$nvpstr="&PAYMENTACTION=$paymentType&AMT=$amount&CREDITCARDTYPE=$creditCardType&ACCT=$creditCardNumber&EXPDATE=".         $padDateMonth.$expDateYear."&CVV2=$cvv2Number&FIRSTNAME=$firstName&LASTNAME=$lastName&CURRENCYCODE=$currencyCode";
//
//            $nvpstr="&PAYMENTACTION=$paymentType&AMT=$amount&CREDITCARDTYPE=$creditCardType&ACCT=$creditCardNumber&EXPDATE=".
//                $padDateMonth.$expDateYear."&CVV2=$cvv2Number&FIRSTNAME=$firstName&LASTNAME=$lastName&STREET=$address1&CITY=$city&STATE=$state".
//                "&ZIP=$zip&COUNTRYCODE=US&CURRENCYCODE=$currencyCode";
//
//            /* Make the API call to PayPal, using API signature.
//               The API response is stored in an associative array called $resArray */
//            $resArray=hash_call("doDirectPayment",$nvpstr);
//
//            $arr['msg'] = 'payment_success';
//            /* Display the API response back to the browser.
//               If the response from PayPal was a success, display the response parameters'
//               If the response was an error, display the errors received using APIError.php.
//               */
//            $ack = strtoupper($resArray["ACK"]);
//
//            $arr["resArray "]= $resArray;
//            if($ack!="SUCCESS")
//            {
//                $arr['msg'] = 'payment_error';
//                $_SESSION['reshash']=$resArray;
////			$location = "APIError.php";
////			header("Location: $location");
//                $this->load->view('register_message',$arr);
//            }else{
//
//                $this->load->view('register_message',$arr);
//            }
//

            $response['s_status']  = 'success';
            $response['data']	  = '';
        } catch (Exception $e){
            $response['s_status']  = 'error';
            $response['data'] = $e->getMessage();
        }

        die( json_encode($response) );
    }

}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
