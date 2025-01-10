<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_model extends CI_Model {

// ================================================================================================
// ========================================= -- SET -- ============================================

    public function setUltimoAcesso($country) {
        // Adiciona à tabela api_acess_log as informações referentes a busca que estás sendo feita
        return $this->db->insert('api_access_log', [
            'pais' => $country,
            'data_hora' => date('Y-m-d H:i:s')
        ]);
    }

// ================================================================================================
// ========================================= -- GET -- ============================================
    public function getDados($country) {
        $url = "https://dev.kidopilabs.com.br/exercicio/covid.php?pais={$country}";
        $data = json_decode(file_get_contents($url), true);

        // monta o array com todas informações necessárias para a view mostrar as informações relacionadas ao país informado
        $response = [
            'total_confirmados' => array_sum(array_column($data, 'Confirmados')),
            'total_mortes' => array_sum(array_column($data, 'Mortos')),
            'estados' => $data
        ];

        return $response;
    }

    public function getDadosComparativo($pais1, $pais2) {
        // Busca as informações do prmieiro país
        $url_pais1 = "https://dev.kidopilabs.com.br/exercicio/covid.php?pais={$pais1}";
        $dados_pais1 = json_decode(file_get_contents($url_pais1), true);
        $pais1_confirmados = array_sum(array_column($dados_pais1, 'Confirmados'));
        $pais1_obitos = array_sum(array_column($dados_pais1, 'Mortos'));

        // Busca as informações do segundo país
        $url_pais2 = "https://dev.kidopilabs.com.br/exercicio/covid.php?pais={$pais2}";
        $dados_pais2 = json_decode(file_get_contents($url_pais2), true);
        $pais2_confirmados = array_sum(array_column($dados_pais2, 'Confirmados'));
        $pais2_obitos = array_sum(array_column($dados_pais2, 'Mortos'));

        // Faz o calculo da taxa de morte entre os dois países
        $taxa_morte_pais1 = $pais1_obitos / $pais1_confirmados;
        $taxa_morte_pais2 = $pais2_obitos/ $pais2_confirmados;
        
        // Monta o array que retorna os dados sobre os dois paises buscados pelo usuario
        $dados = array(
            $pais1 => array(
                'confirmados' => $pais1_confirmados,
                'obitos' => $pais1_obitos,
                'taxa_morte' => $taxa_morte_pais1,
            ),
            $pais2 => array(
                'confirmados' => $pais2_confirmados,
                'obitos' => $pais2_obitos,
                'taxa_morte' => $taxa_morte_pais2,
            )
        );        
        
        return $dados;
    }

    // Organiza os dados da tabela api_acess_log em ordem decrescente e retorna a ultima linha inserida
    public function getUltimoAcesso() {
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get('api_access_log', 1);
        return $query->row_array();
    }
// ================================================================================================
// ========================================= -- UPDATE -- =========================================

// ================================================================================================
// ========================================= -- DELETE -- =========================================

// ================================================================================================
// ========================================= -- OUTRAS -- ========================================

}