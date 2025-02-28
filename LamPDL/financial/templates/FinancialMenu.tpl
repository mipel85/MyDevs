<ul id="financial-menu">
    # IF C_CLUB_HAS_REQUESTS #
        # IF NOT C_MY_CLUB_REQUESTS #
            <li><a class="offload pinned bgc-full member" href="{U_MY_CLUB_REQUESTS}">Voir les demandes de mon club</a></li>
        # ENDIF #
    # ENDIF #
    # IF C_USER_HAS_REQUESTS #
        # IF NOT C_MY_REQUESTS #
            <li><a class="offload pinned bgc-full member" href="{U_MY_REQUESTS}">Voir mes demandes</a></li>
        # ENDIF #
    # ENDIF #
    # IF NOT C_ALL_REQUESTS #<li><a class="offload  pinned bgc-full moderator" href="{U_ALL_REQUESTS}">Voir toutes les demandes</a></li># ENDIF #
    # IF NOT C_HOME #<li><a class="offload pinned bgc-full link-color" href="{U_HOME}">Faire une nouvelle demande</a></li># ENDIF #
</ul>

<script>
    const header = document.querySelector('.section-header');
    header.classList.add('flex-between', 'flex-between-large')
    const menu = document.getElementById('financial-menu');
    header.appendChild(menu);
</script>