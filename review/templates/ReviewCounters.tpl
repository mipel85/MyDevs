<header>
    <h2>{@review.module.title}</h2>
</header>
<article class="cell-tile">
    <div class="cell-flex cell-columns-2">
        <div class="cell">
            <div class="cell-header">
                <h5 class="cell-name">{@review.counters.files.status}</h5>
            </div>
            <div class="cell-list">
                <ul>
                    <li class="li-stretch">
                        <span>{@review.counters.title.files.on.server}</span>
                        <a class="button bgc-full question text-strong small" href="{U_FILES_ON_SERVER}">{NB_FILES_ON_SERVER}</a>
                    </li>
                    <li class="li-stretch">
                        <span>{@review.counters.title.files.in.upload}</span>
                        <a class="button bgc-full question text-strong small" href="{U_FILES_IN_UPLOAD}">{NB_FILES_IN_UPLOAD}</a>
                    </li>
                    <li class="li-stretch">
                        <span>{@review.counters.title.files.in.content}</span>
                        <div class="counter-area-helper">
                            <span class="counter-helper-small" data-tooltip-class="tooltip-large" aria-label="{@review.help.unique.used.files}"><i class="fa fa-question" aria-hidden="true"></i></span>
                            <a class="button bgc-full question text-strong small" href="{U_FILES_IN_CONTENT}">{NB_FILES_IN_CONTENT}</a>
                        </div>
                    </li>
                    <li class="li-stretch">
                        <span>{@review.counters.title.all.unused.files}</span>
                        <div class="counter-area-helper">
                            <span class="counter-helper-small" data-tooltip-class="tooltip-large" aria-label="{@review.help.all.unused.files}"><i class="fa fa-question" aria-hidden="true"></i></span>
                            <a class="button bgc-full question text-strong small" href="{U_ALL_UNUSED_FILES}">{NB_ALL_UNUSED_FILES}</a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

        <div class="cell">
            <div class="cell-header">
                <h5 class="cell-name">{@review.counters.title.all.errors.lists}</h5>
            </div>
            <div class="cell-list">
                <ul>
                    <li class="li-stretch">
                        <span>{@review.counters.used.files.no.server}</span>
                        <a class="button bgc-full question text-strong small" href="{U_USED_FILES_NOT_ON_SERVER}">{NB_USED_FILES_NOT_ON_SERVER}</a>
                    </li>
                    <li class="li-stretch">
                        <span>{@review.counters.unused.files.users}</span>
                        <a class="button bgc-full question text-strong small" href="{U_UNUSED_FILES_USER}">{NB_UNUSED_FILES_USER}</a>
                    </li>
                    <li class="li-stretch">
                        <span>{@review.counters.orphan.files}</span>
                        <a class="button bgc-full question text-strong small" href="{U_ORPHAN_FILES}">{NB_ORPHAN_FILES}</a>
                    </li>
                    <li class="li-stretch">
                        <span>{@review.counters.all.errors}</span>
                        <span class="button no-style counter-nolink">{NB_TOTAL_DISCARDED_FILES}</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!--- Gallery files -->
    <div class="cell-flex cell-columns-2">
        <div class="cell">
            <div class="cell-header">
                <h5 class="cell-name">{@review.counters.files.status.gallery}</h5>
                # IF NOT C_GALLERY #
                <p class="alert-very-high-priority">{@review.no.gallery}</h5>
                # ENDIF #
            </div>
            <div class="cell-list">
                <ul>
                    <li class="li-stretch">
                        <span>{@review.counters.title.files.in.gallery.folder}</span>
                        <a class="button bgc-full question text-strong small" href="{U_FILES_IN_GALLERY_FOLDER}">{NB_FILES_IN_GALLERY_FOLDER}</a>
                    </li>
                    <li class="li-stretch">
                        <span>{@review.counters.title.files.in.gallery.table}</span>
                        <a class="button bgc-full question text-strong small" href="{U_FILES_IN_GALLERY_TABLE}"# IF NOT C_GALLERY # aria-label="{@review.no.gallery}"# ENDIF #>
                            # IF C_GALLERY #{NB_FILES_IN_GALLERY_TABLE}# ELSE #?# ENDIF #
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="cell">
            <div class="cell-header">
                <h5 class="cell-name">{@review.counters.title.all.errors.lists.gallery}</h5>
            </div>
            <div class="cell-list">
                <ul>
                    <li class="li-stretch">
                        <span>{@review.counters.files.no.gallery.folder}</span>
                        <a class="button bgc-full question text-strong small" href="{U_FILES_NOT_IN_GALLERY_FOLDER}"# IF NOT C_GALLERY # aria-label="{@review.no.gallery}"# ENDIF #>
                            # IF C_GALLERY #{NB_FILES_NOT_IN_GALLERY_FOLDER}# ELSE #?# ENDIF #
                        </a>
                    </li>
                    <li class="li-stretch">
                        <span>{@review.counters.files.no.gallery.table}</span>
                        <a class="button bgc-full question text-strong small" href="{U_FILES_NOT_IN_GALLERY_TABLE}"# IF NOT C_GALLERY # aria-label="{@review.no.gallery}"# ENDIF #>
                            # IF C_GALLERY #{NB_FILES_NOT_IN_GALLERY_TABLE}# ELSE #?# ENDIF #
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</article>
<script type="text/javascript" src="{PATH_TO_ROOT}/review/templates/DataTables/js/jquery.dataTables.min.js"></script>