<section id="module-financial">
    <header class="section-header">
        <h1>{@financial.statement} - exercice {FISCAL_YEAR}</h1>
    </header>
    <div class="sub-section">
        <div class="chart-container">
            <canvas id="myChart"></canvas>
            <script>
                jQuery(document).ready(function() {
                jQuery('#global-container').css("width", "85%");
                });
                let ctx = document.getElementById("myChart").getContext('2d');
                let data = {
                labels: [ # START budgets # "{budgets.NAME}", # END budgets # ],
                        datasets: [{
                        label: 'Prévu',
                                data: [ # START budgets # "{budgets.ANNUAL_AMOUNT}", # END budgets # ],
                                backgroundColor: '#99b0c8',
                                borderWidth: 1.5,
                                borderRadius: 6
                        }, {
                        label: 'Réalisé',
                                data: [ # START budgets # "{budgets.REAL_AMOUNT}", # END budgets # ],
                                backgroundColor: '#2aba66',
                                borderWidth: 1.5,
                                borderRadius: 6,
                        }]
                };
                let myChart = new Chart(ctx, {
                plugins: [ChartDataLabels],
                        type: 'bar',
                        data: data,
                        options: {
                        plugins: {
                        datalabels: {
                        color: 'blue',
                                labels: {
                                title: {
                                font: {
                                size: 14,
                                        family: 'tahoma',
                                        weight: 'bold',
                                },
                                },
                                }
                        },
                                title: {
                                display: true,
                                        text: "{@financial.chart.budgets.used}",
                                        color: 'blue',
                                        font: {
                                        size: 26,
                                                family: 'tahoma',
                                                weight: 'normal',
                                                style: 'italic'
                                        },
                                        padding: {
                                        bottom: 20
                                        }
                                }
                        },
                                scales: {
                                x: {
                                display: true,
                                        ticks: {
                                        font: {
                                        size: 18,
                                        },
                                                maxRotation: 0,
                                                minRotation: 15,
                                        }
                                },
                                        y: {
                                        display: true,
                                                type: 'logarithmic',
                                        }
                                }
                        },
                });
            </script>
        </div>
    </div>
    <footer></footer>
</section>