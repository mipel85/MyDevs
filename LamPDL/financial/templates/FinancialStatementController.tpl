<section id="module-financial">
    <header class="section-header">
        <h1>{@financial.statement}</h1>
    </header>
    <div class="sub-section">
        <div class="chart-container">
            <nav id="financial_charts">
                <ul>
                    <li>
                        <a class="offload button visitor bgc-full" href="{U_CHART}" aria-label="{@financial.chart.budgets.used}">
                            <span>{@financial.chart.budgets.used}</span>
                        </a>
                    </li>
                    <li>
                        <a class="offload button visitor bgc-full" href="{U_STATEMENT}" aria-label="{@financial.budgets.statement}">
                            <span>{@financial.budgets.statement}</span>
                        </a>
                    </li>
                </ul>
            </nav>
            # IF C_CHART #
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
                # ENDIF #

            </script>
            # IF C_STATEMENT #
            <h2 class ="statement_title">{@financial.budgets.statement} --- {TOTAL_EXPENSES}€</h2>
            <div class = "responsive-table">
                <table id ="statement_view">
                    <thead>
                        <tr>
                            <th>Domaine</th><th>Type</th><th>N° FFAM</th><th>Club</th><th>Montant versé</th><th>Détails</th>
                        </tr>
                    </thead>
                    <tbody>
                        # START statement # 
                        <tr class ="align-left">
                            <td>{statement.DOMAIN}</td>
                            <td>{statement.TYPE}</td>
                            <td>{statement.FFAM_NUM}</td>
                            <td>{statement.CLUB}</td>
                            <td>{statement.AMOUNT_PAID}€</td>
                            <td class="modal-container">
                                <span data-modal="" data-target="target-panel-{statement.ID}"><i class="fa fa-square-plus"></i></i></span>
                                <div id="target-panel-{statement.ID}"class="modal modal-animation">
                                    <div class="close-modal" aria-label="{@common.close}"></div>
                                    <div class="content-panel">
                                        <div class="align-right"><a href="#" class="error big hide-modal" aria-label="{@common.close}"><i class="far fa-circle-xmark"                                               aria-hidden="true"></i></a></div>
                                        <table>
                                            <thead>
                                                <tr>
                                            <span class="span-modal-title">{statement.CLUB}</span> --- {statement.DOMAIN} / {statement.TYPE}
                                            </tr>
                                            <th>Suivi par</th><th>Date demande</th><th>Date activité</th></th><th>Description</th>
                                            <th>Budget prévu</th></th><th>Budget dépensé</th><th>Budget restant</th><th>Devis</th><th>Facture</th>
                                            </tr>
                                            </thead>
                                            <tr>
                                                <td>{statement.AUTHOR}</td>
                                                <td>{statement.CREATION_DATE}</td>
                                                <td>{statement.EVENT_DATE}</td>
                                                <td class="description-width">{statement.DESCRIPTION}</td>
                                                <td>{statement.BUDGET_PLANNED}€</td>
                                                <td>{statement.BUDGET_ACHIEVED}€</td>
                                                <td>{statement.BUDGET_REMAINING}€</td>
                                                <td># IF statement.C_ESTIMATE_LINK #<a href="{statement.ESTIMATE_LINK}"><i class="far fa-lg fa-file-lines"></i>
                                                    </a># ENDIF #</td>
                                                <td># IF statement.C_INVOICE_LINK #<a href="{statement.INVOICE_LINK}"><i class="fa fa-lg fa-file-contract"></i>
                                                    </a># ENDIF #</td>
                                            </tr>
                                        </table>       

                                    </div>
                                </div>
                            </td>
                        </tr>
                        # END statement # 
                    </tbody>
                </table>
            </div>
            # ENDIF #
        </div>
    </div>
    <footer></footer>
</section>