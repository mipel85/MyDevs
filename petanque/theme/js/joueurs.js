$(document).ready(function() {
    $('#nom_joueur').focus();
    $('#nom_joueur').removeClass('is_empty');

    // DataTable
    $('#table_joueurs_connus').DataTable(
        {
            dom: 'lfrip<t>B',
            buttons: [
                'print'
            ],
            language: {
                url: './theme/js/lib/language.json'
            },
            "aLengthMenu": [10, 20, 30, 50],
            "paginationType": "simple_numbers",
            "pageLength": 10,
            "fixedHeader": true,
            "paging": true,
            "columns": [
                {type: "num"},
                {type: "text"},
                {type: "text"},
                {orderable: false}
            ]
        }
    );

    // Select/unselect players as favourite
    $('#table_joueurs_connus').on('change', "input.btn-fav-joueur", function() {
        var id = $(this).attr('data-id');
        if ((this.checked)){
            $.ajax({
                url: './ajax/AjaxJoueurs.php',
                type: 'POST',
                data: {
                    action: 'favory',
                    id: id
                },
                success: function() {}
            });
        }else{
            $.ajax({
                url: './ajax/AjaxJoueurs.php',
                type: 'POST',
                data: {
                    action: 'anonyme',
                    id: id
                },
                success: function() {}
            });
        }
    });

    // désélectionner tous les favoris
    $('#btn_reset_favs').on('click', function() {
        $.ajax({
            url: './ajax/AjaxJoueurs.php',
            type: 'POST',
            data: {
                action: 'reset_all_favs'
            },
            success: function(data) {
                $('input[type=checkbox]').each(function() {
                    this.checked = false;
                });
                $('#table_joueurs_presents').html('');
            }
        });
    });

    // Add new player
    $('#btn_ajout').on('click', function() {
        var nom_joueur = $('#nom_joueur').val();
        if (nom_joueur !== ''){
            $.ajax({
                url: './ajax/AjaxJoueurs.php',
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

    // Remove player
    $("#table_joueurs_connus").on('click', "input.btn-sup-joueur", function() {
        var id = $(this).attr('id');
        $.ajax({
            url: './ajax/AjaxJoueurs.php',
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


