<nav id="admin-quick-menu">
    <ul>
        <li>
            <a href="${PATH_TO_ROOT}/admin/errors/list" class="quick-link">Erreurs</a>
        </li>
        <li>
            <a href="${relative_url(ReviewUrlBuilder::home())}" class="quick-link">{@common.home}</a>
        </li>
        <li>
            <a href="${relative_url(DatabaseUrlBuilder::documentation())}" class="quick-link">{@form.documentation}</a>
        </li>
    </ul>
</nav>

<section id="admin-contents">
    {MODULE_NAME}

    # INCLUDE REVIEW_COUNTERS #
    <footer></footer>
</section>

<script src="{PATH_TO_ROOT}/review/templates/DataTables/js/jquery.dataTables.min.js"></script>

