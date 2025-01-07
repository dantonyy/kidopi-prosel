<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_model extends CI_Model {

// ================================================================================================
// ========================================= -- SET -- ============================================

// ================================================================================================
// ========================================= -- GET -- ============================================
    public function get_covid_data($country) {
        $url = "https://dev.kidopilabs.com.br/exercicio/covid.php?pais={$country}";
        $data = json_decode(file_get_contents($url), true);

        $this->db->insert('api_access_log', [
            'pais' => $country,
            'data_hora' => date('Y-m-d H:i:s')
        ]);

        $response = [
            'total_confirmados' => array_sum(array_column($data, 'Confirmados')),
            'total_mortes' => array_sum(array_column($data, 'Mortos')),
            'estados' => $data
        ];

        return $response;
    }

    public function get_last_access() {
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