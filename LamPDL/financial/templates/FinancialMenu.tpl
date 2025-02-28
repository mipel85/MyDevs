<ul id="financial-menu">
    # IF C_CLUB_HAS_REQUESTS #
        # IF NOT C_MY_CLUB_REQUESTS #
            <li><a class="offload d-block align-center pinned bgc link-color" href="{U_MY_CLUB_REQUESTS}">{@financial.button.club}</a></li>
        # ENDIF #
    # ENDIF #
    # IF C_USER_HAS_REQUESTS #
        # IF NOT C_MY_REQUESTS #
            <li><a class="offload d-block align-center pinned bgc link-color" href="{U_MY_REQUESTS}">{@financial.button.member}</a></li>
        # ENDIF #
    # ENDIF #
    # IF NOT C_ALL_REQUESTS #<li><a class="offload d-block align-center pinned bgc link-color" href="{U_ALL_REQUESTS}">{@financial.button.all}</a></li># ENDIF #
    # IF NOT C_HOME #<li><a class="offload d-block align-center pinned bgc link-color" href="{U_HOME}">{@financial.button.home}</a></li># ENDIF #
</ul>

<script>
    const header = document.querySelector('.section-header');
    header.classList.add('flex-between', 'flex-between-large')
    const menu = document.getElementById('financial-menu');
    header.appendChild(menu);
</script>