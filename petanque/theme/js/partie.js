$(document).ready(function() {
    // $('#add_partie').DataTable(
    //     {
    //         dom: 'lfrip<t>B',
    //         buttons: [
    //             'print'
    //         ],
    //         language: {
    //             url: './js/lib/language.json'
    //         },
    //         "aLengthMenu": [10, 20, 30, 50],
    //         "paginationType": "simple_numbers",
    //         "pageLength": 10,
    //         "fixedHeader": true,
    //         "paging": true,
    //         "columns": [
    //             {type: "num"},
    //             {type: "text"},
    //             {orderable: false}
    //         ]
    //     }
    // );

//  affichage liste des joueurs enregistrés
    // function view_joueurs_presents() {
    //     $.ajax({
    //         url: './ajax/actions.php',
    //         type: 'POST',
    //         data: {
    //             action: 'liste-joueurs'
    //         },
    //         success: function(data) {
    //             $('#table_joueurs_connus').html(data);
    //         }
    //     });
    // }

// Insertion de nouveaux enregistrements
    $('#add_partie').on('click', function() {
        var date_partie = $('#date_partie').val();
        // if (nom_joueur !== ''){
            $.ajax({
                url: './ajax/partie.php',
                type: 'POST',
                data: {
                    action: 'insert',
                    date_partie: date_partie
                },
                success: function(r) {
                    $('#partie_ajoutee').addClass('floatting_notif');
                    $('#add_partie').attr('disabled');
                }
            });
        // }else{
        //     alert('Le nom du joueur doit être renseigné');
        //     $('#nom_joueur').focus();
        //     $('#nom_joueur').addClass('is_empty');
        // }
    });
});


