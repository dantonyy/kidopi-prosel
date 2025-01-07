<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('dashboard_model');
    }

	public function index() {
		$this->load->view('html_header');
		$this->load->view('dashboard');
		$this->load->view('html_footer');
	}
// ================================================================================================
// ========================================= -- SET -- ============================================

// ================================================================================================
// ========================================= -- GET -- ============================================

	public function getDados() {
		$country = $this->input->post('country');
		$dados = $this->dashboard_model->get_covid_data($country);
		$this->output->set_output(json_encode($dados));
	}

	public function getUltimoAcesso() {
		$log = $this->dashboard_model->get_last_access();
		$this->output->set_output(json_encode($log));
	}
// ================================================================================================
// ========================================= -- UPDATE -- =========================================

// ================================================================================================
// ========================================= -- DELETE -- =========================================

// ================================================================================================
// ========================================= -- OUTRAS -- =========================================

}

?>
