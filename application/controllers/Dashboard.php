<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function __construct() {
        parent::__construct();
    }

	public function index()
	{
		$this->load->view('html_header');
		$this->load->view('dashboard');
		$this->load->view('html_footer');
	}
}

?>