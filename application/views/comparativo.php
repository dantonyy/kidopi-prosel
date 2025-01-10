
            <div class="container-xxl flex-grow-1 container-p-y">
              <div class="row g-6">
                <div class="col-md-12">

                  <div class="card">
                    <h5 class="card-header">Comparativo do impacto da COVID-19 entre países</h5>
                    <div class="card-body">
                      <div class="mb-4">
                        Escolha dois sistemas da lista abaixo para exibir os comparativos entre eles.
                      </div>

                      <!-- Linha para os selects -->
                      <div class="row mb-4">
                        <div class="col-md-6">
                          <select class="form-select" id="country-select-1" aria-label="Selecione o País 1">
                            <option selected disabled>Selecione o País 1</option>
                            <?php
                            foreach ($paises as $pais) {
                              echo "<option value='{$pais}'>{$pais}</option>";
                            }
                            ?>
                          </select>
                        </div>
                        <div class="col-md-6">
                          <select class="form-select" id="country-select-2" aria-label="Selecione o País 2">
                            <option selected disabled>Selecione o País 2</option>
                            <?php
                            foreach ($paises as $pais) {
                              echo "<option value='{$pais}'>{$pais}</option>";
                            }
                            ?>
                          </select>
                        </div>
                      </div>

                      <button id="fetch-data" type="button" class="btn btn-outline-primary float-end" onclick="getDadosComparativo()">
                        <span class="tf-icons bx bxs-send bx-18px me-2"></span>Comparar países
                      </button>
                    </div>
                  </div>

                </div>
              </div>
            </div>

            <div class="container-xxl flex-grow-1 container-p-y">
              <div class="row g-6">
                <div class="col-md-12">

                  <div class="card" id="card_resultados" style="display:none; padding:5px;">
                    <div class="table-responsive text-nowrap mb-4">
                      <table class="table table-striped" id="state-table" style="display:none;">
                        <thead>
                          <tr>
                            <th></th>
                            <th id="nome_pais1"></th>
                            <th id="nome_pais2"></th>
                          </tr>
                        </thead>
                        <tbody class="table-border-bottom-0"></tbody>
                      </table>
                    </div>

                  </div>
                  
                </div>
              </div>
            </div>
            <!-- / Content -->

  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <script>

  function getDadosComparativo() {
    // Quando o método é chamado, busca o nome dos países que o usuário deseja comparar
    var pais1 = document.getElementById('country-select-1').value;
    var pais2 = document.getElementById('country-select-2').value;

    // Faz a comunicação com o Controller para obter os dados dos dois países e exibir a comparação para o usuário
    $.ajaxSetup({ async: false });
    $.post("<?php echo site_url('dashboard/getDadosComparativo/');?>", { pais1: pais1, pais2: pais2 }, function(response) {
        if (response) {
          // Caso tenha uma resposta, transforma os dados em um JSON e pega os elementos que serão trabalhados no método
          var data = JSON.parse(response);
          var table = document.getElementById('state-table');
          var tbody = table.querySelector('tbody');

          // Adiciona o nome dos países à tabela
          document.getElementById('nome_pais1').innerHTML = pais1;
          document.getElementById('nome_pais2').innerHTML = pais2;

          // Cria a primeira linha da tabela, referente aos casos confirmados de ambos os países
          var row1 = document.createElement('tr');
          row1.innerHTML = '<td><strong>Casos confirmados</strong></td><td>'+ formatNumber(data[pais1]['confirmados']) + '</td><td>'+ formatNumber(data[pais2]['confirmados']) + '</td>';
          // Cria a segunda linha da tabela, referente aos óbitos de cada país
          var row2 = document.createElement('tr');
          row2.innerHTML = '<td><strong>Óbitos</strong></td><td>'+ formatNumber(data[pais1]['obitos']) + '</td><td>'+ formatNumber(data[pais2]['obitos']) + '</td>';
          // Cria a terceira linha da tabela, referente a taxa de morte (em porcentagem) de ambos os países
          var row3 = document.createElement('tr');
          row3.innerHTML = '<td><strong>Taxa de morte</strong></td><td>'+ (data[pais1]['taxa_morte'] * 100).toFixed(3) + '%</td><td>'+ (data[pais2]['taxa_morte'] * 100).toFixed(3) + '%</td>';
          // Cria a quarta e ultima linha da tabela, referente a diferença da taxa de morte de ambos os países
          var row4 = document.createElement('tr');
          var diferenca_taxa = (Math.abs(data[pais1]['taxa_morte'] - data[pais2]['taxa_morte'])*100).toFixed(5) + '%';
          row4.innerHTML = '<td><strong>Diferença da taxa de morte</strong></td><td>' + diferenca_taxa + '</td>';

          // Adiciona todas as linhas a tabela
          tbody.appendChild(row1);
          tbody.appendChild(row2);
          tbody.appendChild(row3);
          tbody.appendChild(row4);

          // Após todo o processo, torna visivel os elementos trabalhados
          document.getElementById('card_resultados').style.display = 'block';
          table.style.display = 'table';
        }
    });
  }

  // Método responsável por formatar o DateTIme que vem do banco de dados, para melhor visualização dos dados na View
  function formatDateTime(datetime) {
    if (!datetime || !/\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}/.test(datetime)) {
      console.error("Formato inválido. Use 'YYYY-MM-DD HH:mm:ss'.");
      return null;
    }
    const [data, hora] = datetime.split(' ');
    const [ano, mes, dia] = data.split('-');

    return `${dia}/${mes}/${ano} - ${hora}`;
  }

  // Método que formata os números garantindo que será exibido corretamente a casa dos milhares
  function formatNumber(number) {
      if (typeof number === 'undefined' || isNaN(number)) {
          return 0;
      }
      const numberString = Math.floor(number).toString();
      return numberString.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
  }
</script>