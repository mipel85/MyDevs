# INCLUDE MENU #
<script>
    // Liste des clubs source FFAM
    jQuery(document).ready(function () {
        jQuery('td[id^="tdb_ffam_"]').click(function () {
            let tdb_ffam = jQuery(this).attr('id');
            jQuery.ajax({
                type: "POST",
                async: true,
                url: '${relative_url(LamdeskUrlBuilder::tdb_ajax())}',
                data: {
                    token: TOKEN,
                    param: tdb_ffam
                },
                dataType: "json",
                success: function (data) {
                    if (tdb_ffam.substring(9) != '00') {
                        jQuery('#liste').html('<br/><span class="title-list">Liste des clubs du département ' + tdb_ffam.substring(9) + ' (source FFAM)</span>');
                    } else {
                        jQuery('#liste').html('<br/><span class="title-list">Liste de tous les clubs (source FFAM)</span>');
                    }

                    jQuery('#liste').append('<table id="t_clubs_ffam"></table>');
                    jQuery('#t_clubs_ffam').append('<thead id="thead_clubs_ffam"></thead>');
                    jQuery('#t_clubs_ffam').append('<tbody id="tbody_clubs_ffam"></tbody>');
                    jQuery('#thead_clubs_ffam').append('<tr><th>Nom du club</th><th>N° FFAM</th><th>Site web</th></tr>');
                    jQuery.each(data, function (index, value) {
                        jQuery.each(value, function (index, nom) {
                            jQuery('#tbody_clubs_ffam').append('<tr><td>' + nom.name + '</td><td>' + nom.ffam_nb + '</td><td><a href="' + nom.website_url + '">' + nom.website_url + '</a></td></tr>');
                        });
                    });
                }
            });
        });

        // Liste des clubs inscrits sur le site
        jQuery('td[id^="tdb_site_"]').click(function () {
            let tdb_site = jQuery(this).attr('id');
            jQuery.ajax({
                type: "POST",
                async: true,
                url: '${relative_url(LamdeskUrlBuilder::tdb_ajax())}',
                data: {
                    token: TOKEN,
                    param: tdb_site
                },
                dataType: "json",
                success: function (data) {
                    if (tdb_site.substring(9) != '00') {
                        jQuery('#liste').html('<br/><span class="title-list">Liste des interlocuteurs du département ' + tdb_site.substring(9) + '</span> (il peut y avoir plusieurs inscrits pour le même club)');
                    } else {
                        jQuery('#liste').html('<br/><span class="title-list">Liste de tous les interlocuteurs de clubs inscrits sur le site</span>');
                    }

                    jQuery('#liste').append('<table id="t_clubs_site"></table>');
                    jQuery('#t_clubs_site').append('<thead id="thead_clubs_site"></thead>');
                    jQuery('#t_clubs_site').append('<tbody id="tbody_clubs_site"></tbody>');
                    jQuery('#thead_clubs_site').append('<tr><th>Nom du club</th><th>Interlocuteur</th><th>Dirigeant</th><th>Ligue</th></tr>');
                    jQuery.each(data, function (index, value) {
                        jQuery.each(value, function (index, nom) {
                            let dirigeant = (nom.f_dirigeant_de_club == "Oui") ? '<img src=" ../lamdesk/templates/images/icons8-ok-16.png">' : '<img src=" ../lamdesk/templates/images/icons8-no-16.png">';
                            let ligue = (nom.user_groups == "1|2" || nom.user_groups == "2") ? '<img src=" ../lamdesk/templates/images/icons8-ok-16.png">' : '<img src=" ../lamdesk/templates/images/icons8-no-16.png">';
                            jQuery('#tbody_clubs_site').append('<tr><td>' + nom.f_votre_club + '</td><td>' + nom.display_name + '</td><td>' + dirigeant + '</td><td>' + ligue + '</td></tr>');
                        });
                    });
                }
            });
        });

        // demandes financières
        jQuery('td[id^="tdb_request_"]').click(function () {
            let tdb_request = jQuery(this).attr('id');
            alert(tdb_request);
            /*
            jQuery.ajax({
                type: "POST",
                async: true,
                url: '${relative_url(LamdeskUrlBuilder::tdb_ajax())}',
                data: {
                    token: TOKEN,
                    param: tdb_request
                },
                dataType: "json",
                success: function (data) {
                    if (tdb_site.substring(9) != '00') {
                        jQuery('#liste').html('<br/><span class="title-list">Liste des interlocuteurs du département ' + tdb_site.substring(9) + '</span> (il peut y avoir plusieurs inscrits pour le même club)');
                    } else {
                        jQuery('#liste').html('<br/><span class="title-list">Liste de tous les interlocuteurs de clubs inscrits sur le site</span>');
                    }

                    jQuery('#liste').append('<table id="t_clubs_site"></table>');
                    jQuery('#t_clubs_site').append('<thead id="thead_clubs_site"></thead>');
                    jQuery('#t_clubs_site').append('<tbody id="tbody_clubs_site"></tbody>');
                    jQuery('#thead_clubs_site').append('<tr><th>Nom du club</th><th>Interlocuteur</th><th>Dirigeant</th><th>Ligue</th></tr>');
                    jQuery.each(data, function (index, value) {
                        jQuery.each(value, function (index, nom) {
                            let dirigeant = (nom.f_dirigeant_de_club == "Oui") ? '<img src=" ../lamdesk/templates/images/icons8-ok-16.png">' : '<img src=" ../templates/images/icons8-no-16.png">';
                            let ligue = (nom.user_groups == "1|2" || nom.user_groups == "2") ? '<img src=" ../templates/images/icons8-ok-16.png">' : '<img src=" ../templates/images/icons8-no-16.png">';
                            jQuery('#tbody_clubs_site').append('<tr><td>' + nom.f_votre_club + '</td><td>' + nom.display_name + '</td><td>' + dirigeant + '</td><td>' + ligue + '</td></tr>');
                        });
                    });
                }
            });
            */
        });
    });

</script>

<div id="tdb">
    <table id="tdb-table">
        <caption>Tableau de bord Ligue - situation des Clubs</caption>
        <colgroup>
            <col class="col-large" />
            <col class="col-large ffam-color" />
            <col>
            <col>
            <col>
        </colgroup>
        <thead class="tdb-thead">
            <tr><th>Dépt.</th><td>Liste FFAM</td><td>Liste site</td><th>Clubs activités</th><th>Clubs finances</th></tr>
        </thead>
        <tbody class="tdb-tbody">
            # START tdb_ffam #
            # START tdb_site #
            # START tdb_request #
            <tr>
                <td>44 - Loire Atlantique</td><td id="tdb_ffam_44" aria-label="Liste des clubs de Loire-Atlantique" class="counter-number">{tdb_ffam.FFAM_44}</td><td id="tdb_site_44">{tdb_site.SITE_44}</td><td>attente</td><td id="tdb_request_49">{tdb_request.REQUEST_44}</td>
            </tr>
            <tr>
                <td>49 - Maine et Loire</td><td id="tdb_ffam_49">{tdb_ffam.FFAM_49}</td><td id="tdb_site_49">{tdb_site.SITE_49}</td><td>attente</td><td id="tdb_request_49">{tdb_request.REQUEST_49}</td>
            </tr>
            <tr>
                <td>53 - Mayenne</td><td id="tdb_ffam_53">{tdb_ffam.FFAM_53}</td><td id="tdb_site_53">{tdb_site.SITE_53}</td><td>attente</td><td id="tdb_request_53">{tdb_request.REQUEST_53}</td>
            </tr>
            <tr>
                <td>72 - Sarthe</td><td id="tdb_ffam_72">{tdb_ffam.FFAM_72}</td><td id="tdb_site_72">{tdb_site.SITE_72}</td><td>attente</td><td id="tdb_request_72">{tdb_request.REQUEST_72}</td>
            </tr>
            <tr>
                <td>85 - Vendée</td><td id="tdb_ffam_85">{tdb_ffam.FFAM_85}</td><td id="tdb_site_85">{tdb_site.SITE_85}</td><td>attente</td><td id="tdb_request_85">{tdb_request.REQUEST_85}</td>
            </tr>
            <tr>
                <td>Total</td><td id="tdb_ffam_00">{tdb_ffam.FFAM_TOTAL}<span aria-label="Détails" alt="voir"></span></td><td id="tdb_site_00">{tdb_site.SITE_TOTAL}</td><td>attente</td><td id="tdb_request_00">{tdb_request.REQUEST_TOTAL}</td>
            </tr>
            # END tdb_site #
            # END tdb_ffam #
            # END tdb_request #

        </tbody>
    </table>
</div>
<div id="liste"></div>