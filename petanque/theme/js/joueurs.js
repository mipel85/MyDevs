$(document).ready(function() {
    $('#nom_joueur').focus();
    $('#nom_joueur').removeClass('is_empty');
    $('#table_joueurs_connus').DataTable(
        {
            dom: 'lfrip<t>B',
            buttons: [
                'print'
            ],
            language: {
                url: './js/lib/language.json'
            },
            "aLengthMenu": [10, 20, 30, 50],
            "paginationType": "simple_numbers",
            "pageLength": 10,
            "fixedHeader": true,
            "paging": true,
            "columns": [
                {type: "num"},
                {type: "text"},
                {orderable: false}
            ]
        }
    );

//  affichage liste des joueurs enregistrés
    function view_joueurs_presents() {
        $.ajax({
            url: './ajax/actions.php',
            type: 'POST',
            data: {
                action: 'liste-joueurs'
            },
            success: function(data) {
                $('#table_joueurs_connus').html(data);
            }
        });
    }

// Insertion de nouveaux enregistrements
    $('#btn_ajout').on('click', function() {
        var nom_joueur = $('#nom_joueur').val();
        if (nom_joueur !== ''){
            $.ajax({
                url: './ajax/actions.php',
                type: 'POST',
                data: {
                    action: 'insert',
                    nom_joueur: nom_joueur
                },
                success: function(r) {
                    if (r.erreur){
                        alert(r.erreur);
                    }else{
                        $('#nom_joueur').val('');
                        $('#nom_joueur').removeClass('is_empty');
                        location.reload(true);
                        $('#nom_joueur').focus();
                    }
                }
            });
        }else{
            alert('Le nom du joueur doit être renseigné');
            $('#nom_joueur').focus();
            $('#nom_joueur').addClass('is_empty');
        }
    });

// suppression de joueur
    $("#table_joueurs_connus").on('click', "input.btn-sup-joueur", function() {
        var id = $(this).attr('id');
        $.ajax({
            url: './ajax/actions.php',
            type: 'POST',
            data: {
                action: 'sup',
                id: id
            },
            success: function(r) {
                if (r.erreur){
                    alert(r.erreur);
                }else{
                    location.reload(true);
                }
            }
        });
    });
});


