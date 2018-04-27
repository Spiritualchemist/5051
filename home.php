<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller
{

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     *        http://example.com/index.php/welcome
     *    - or -
     *        http://example.com/index.php/welcome/index
     *    - or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see http://codeigniter.com/user_guide/general/urls.html
     */
    function __construct()
    {
        parent::__construct();

    }

    public function index()
    {
        $arr['scripts_css'] = array('Styles.css');
        $arr['scripts_js'] = array('jquery-1.7.1.js');

        extract($_REQUEST);
        $arr['data'] = array(
            'username' => '',
            'password' => '');
        $arr['msg'] = '';

//        $array_unset = array('login_id' => '', 'fname' => '', 'lname' => '', 'email' => '');
//        $this->session->unset_userdata($array_unset);

        //$arr['page_name']='login';
        $this->load->view('home', $arr);
    }

    public function login()
    {

        $arr['scripts_css'] = array('Styles.css');
        $arr['scripts_js'] = array('jquery-1.7.1.js');

        extract($_REQUEST);
        $arr['data'] = array(
            'username' => '',
            'password' => '');
        $arr['msg'] = '';

        $array_unset = array('login_id' => '', 'fname' => '', 'lname' => '', 'email' => '');
        $this->session->unset_userdata($array_unset);
        //$arr['page_name']='login';
        $this->load->view('index', $arr);


    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */