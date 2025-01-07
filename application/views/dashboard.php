
            <div class="container-xxl flex-grow-1 container-p-y">
              <div class="row g-6">
                <div class="col-md-12">

                  <div class="card">
                    <h5 class="card-header">Dashboard de Monitoramento de Casos de COVID-19</h5>
                    <div class="card-body">
                      <div class="mb-4">
                      Este sistema foi desenvolvido para fornecer dados sobre o impacto da pandemia de COVID-19 ao redor do mundo. Aqui você poderá acessar informações detalhadas sobre casos confirmados e mortes relacionadas ao vírus.
                      </div>
                      <div class="mb-4">
                        <select class="form-select" id="country-select" aria-label="Default select example">
                          <option selected disabled>Selecione um país</option>
                          <option value="Brazil">Brazil</option>
                          <option value="Canada">Canada</option>
                          <option value="Australia">Australia</option>
                        </select>
                      </div>
                      <button id="fetch-data" type="button" class="btn btn-outline-primary float-end" onclick="getDados()">
                        <span class="tf-icons bx bx-search-alt-2 bx-18px me-2"></span>Buscar dados
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
                    <h5 class="card-header" id="country-title"></h5>
                    <p id="summary"></p>
                    <div class="table-responsive text-nowrap mb-4">
                      <table class="table" id="state-table" style="display:none;">
                        <thead>
                          <tr>
                            <th>Estado/Província</th>
                            <th>Casos Confirmados</th>
                            <th>Mortes</th>
                          </tr>
                        </thead>
                        <tbody class="table-border-bottom-0"></tbody>
                      </table>
                    </div>

                    <div class="container mb-4">
                      <canvas id="covid_chart"></canvas>
                    </div>

                    <div class="container mb-4">
                      <canvas id="covid_chart_2"></canvas>
                    </div>

                    <footer id="last_access"></footer>
                  </div>
                  
                </div>
              </div>
            </div>
            <!-- / Content -->

  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <script>
    const estados = [];
    const confirmados = [];
    const obitos = [];

  function getDados() {
    const country = document.getElementById('country-select').value;

    $.ajaxSetup({ async: false });
    $.post("<?php echo site_url('dashboard/getDados/');?>", { country: country }, function(response) {
        if (response) {
            const data = JSON.parse(response);
            const countryTitle = document.getElementById('country-title');
            const summary = document.getElementById('summary');
            const table = document.getElementById('state-table');
            const tbody = table.querySelector('tbody');

            countryTitle.textContent = `COVID-19 Data: ${country}`;
            summary.textContent = `Total de casos confirmados: ${formatNumber(data.total_confirmados)} | Total de Óbitos: ${formatNumber(data.total_mortes)}`;

            tbody.innerHTML = '';
            // Limpa os arrays globais
            estados.length = 0; 
            confirmados.length = 0;
            obitos.length = 0;

            data.estados.forEach(state => {
                estados.push(state.ProvinciaEstado);
                confirmados.push(state.Confirmados);
                obitos.push(state.Mortos);

                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${state.ProvinciaEstado}</td>
                    <td>${formatNumber(state.Confirmados)}</td>
                    <td>${formatNumber(state.Mortos)}</td>
                `;
                tbody.appendChild(row);
            });

            graficoBarras(confirmados);
            graficoDoughnut(obitos);

            document.getElementById('card_resultados').style.display = 'block';
            table.style.display = 'table';
            getLastAccess(country);
        }
    });
  }

  function graficoBarras(confirmados) {
    const canvas = document.getElementById('covid_chart').getContext("2d");
    const ctx = Chart.getChart("covid_chart");
    if (ctx != undefined) {
      ctx.destroy();
    }
    new Chart(canvas, {
        type: 'bar',
        data: {
            labels: estados, 
            datasets: [
                {
                  label: 'Casos Confirmados',
                  data: confirmados,
                  borderColor:'rgba(255, 242, 166, 1)',
                  backgroundColor:'rgba(255, 242, 166, 0.5)',
                  borderWidth: 2,
                  borderRadius: 5
                }
            ],
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'Impacto da COVID-19 por Estado', 
                },
            },
            scales: {
              y: {
                title: {
                      display: true,
                      text: 'Casos Confirmados',
                },
              },
              x: {
                  title: {
                      display: true,
                      text: 'Estados',
                  },
              }
            },
        },
    });
  }

  function graficoDoughnut(obitos) {
    const canvas = document.getElementById('covid_chart_2').getContext("2d");
    const ctx = Chart.getChart("covid_chart_2");
    if (ctx != undefined) {
      ctx.destroy();
    }

    const totalObitos = obitos.reduce((total, valor) => total + valor, 0);

    new Chart(canvas, {
      type: 'doughnut',
      data:{
        labels: estados,
        datasets: [{
          data: obitos,
        }]
      },
      options: {
        responsive: true,
        plugins: {
          title: {
              display: true,
              text: 'Comparativo de mortes por COVID-19 em cada estado', // Título do gráfico
          },
          tooltip: {
          callbacks: {
              // Customiza o tooltip para mostrar porcentagens
              label: function(tooltipItem) {
                const value = tooltipItem.raw;
                const percentage = ((value / totalObitos) * 100).toFixed(2); 
                return `${tooltipItem.label}: ${percentage}% (${value} mortes)`;
              }
            },
          },
        },
      },
    });
  }


    // Fetch last access log
    function getLastAccess(country) {
        $.ajaxSetup({ async: false });
        $.post("<?php echo site_url('dashboard/getUltimoAcesso/');?>", {}, function(response) {
            if (response) {
                const json_response = JSON.parse(response);
                document.getElementById('last_access').textContent = `Último Acesso: ${formatDateTime(json_response.data_hora)}  |  País: ${json_response.pais}`;
            }
        });
    };

    function formatDateTime(datetime) {
      if (!datetime || !/\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}/.test(datetime)) {
        console.error("Formato inválido. Use 'YYYY-MM-DD HH:mm:ss'.");
        return null;
      }
      const [data, hora] = datetime.split(' ');
      const [ano, mes, dia] = data.split('-');

      return `${dia}/${mes}/${ano} - ${hora}`;
    }

    function formatNumber(number) {
        if (typeof number === 'undefined' || isNaN(number)) {
            return 0;
        }
        const numberString = Math.floor(number).toString();
        return numberString.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }
</script>