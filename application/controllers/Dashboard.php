<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('dashboard_model');
    }

	public function index() {
		$this->load->view('html_header');
		$this->load->view('html_footer');
	}

	public function monitoramento() {
		$this->load->view('html_header');
		$this->load->view('dashboard');
		$this->load->view('html_footer');
	}

	public function comparativo() {
		// Acessar lista de paises
		$url = "https://dev.kidopilabs.com.br/exercicio/covid.php?listar_paises=1";
		$data['paises'] = json_decode(file_get_contents($url), true);

		$this->load->view('html_header');
        $this->load->view('comparativo', $data);
        $this->load->view('html_footer');
	}
// ================================================================================================
// ========================================= -- SET -- ============================================

// ================================================================================================
// ========================================= -- GET -- ============================================

	public function getDados() {
		$country = $this->input->post('country');
		$dados = $this->dashboard_model->getDados($country);
		$this->output->set_output(json_encode($dados));
	}

	public function getUltimoAcesso() {
		$log = $this->dashboard_model->getUltimoAcesso();
		$this->output->set_output(json_encode($log));
	}

	public function getDadosComparativo() {
		$pais1 = $this->input->post('pais1');
        $pais2 = $this->input->post('pais2');
        $dados = $this->dashboard_model->getDadosComparativo($pais1, $pais2);
        $this->output->set_output(json_encode($dados));
	}

// ================================================================================================
// ========================================= -- UPDATE -- =========================================

// ================================================================================================
// ========================================= -- DELETE -- =========================================

// ================================================================================================
// ========================================= -- OUTRAS -- =========================================

}

?>
