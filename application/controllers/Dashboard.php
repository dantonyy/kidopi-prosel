<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('dashboard_model');
    }

	// Carregar pagina inicial
	public function index() {
		$this->load->view('html_header');
		$this->load->view('html_footer');
	}

	// Carregar pagina de monitoramento
	public function monitoramento() {
		$this->load->view('html_header');
		$this->load->view('dashboard');
		$this->load->view('html_footer');
	}

	// Carregar pagina comparativo entre países
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

	public function setUltimoAcesso() {
		$country = $this->input->post('country');
		return $this->dashboard_model->setUltimoAcesso($country);
	}

// ================================================================================================
// ========================================= -- GET -- ============================================

	// Método que recebe o país e retorna para a view os dados daquele país presentes na API-Covid-19
	public function getDados() {
		$country = $this->input->post('country');
		$dados = $this->dashboard_model->getDados($country);
		$this->output->set_output(json_encode($dados));
	}

	// Método que retorna as informações referentes ao ultimo acesso da API
	public function getUltimoAcesso() {
		$log = $this->dashboard_model->getUltimoAcesso();
		$this->output->set_output(json_encode($log));
	}

	// Método que recebe dois países e retorna para a view as diferenças de taxa de mortalidade entre eles
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
