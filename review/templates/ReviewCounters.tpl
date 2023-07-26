<article class="cell-tile">
    <div class="cell-flex cell-columns-2">
        <div class="cell">
            <div class="cell-header">
                <h5 class="cell-name">{@review.files.status.upload}</h5>
            </div>
            <div class="cell-list">
                <ul>
                    <li class="li-stretch">
                        <span>{@review.upload.folder.files}</span>
                        <a class="button bgc-full question preloader-button text-strong small" href="{U_FILES_ON_SERVER}">{NB_FILES_ON_SERVER}</a>
                    </li>
                    <li class="li-stretch">
                        <span>{@review.upload.table.files}</span>
                        <a class="button bgc-full question preloader-button text-strong small" href="{U_FILES_IN_UPLOAD}">{NB_FILES_IN_UPLOAD}</a>
                    </li>
                    <li class="li-stretch">
                        <span>{@review.content.files}</span>
                        <div class="counter-area-helper">
                            <span class="counter-helper-small" data-tooltip-class="tooltip-large" aria-label="{@review.help.unique.used.files}"><i class="fa fa-question" aria-hidden="true"></i></span>
                            <a class="button bgc-full question preloader-button text-strong small" href="{U_FILES_IN_CONTENT}">{NB_FILES_IN_CONTENT}</a>
                        </div>
                    </li>
                    <li class="li-stretch">
                        <span>{@review.upload.folder.unsued.files}</span>
                        <div class="counter-area-helper">
                            <span class="counter-helper-small" data-tooltip-class="tooltip-large" aria-label="{@review.help.all.unused.files}"><i class="fa fa-question" aria-hidden="true"></i></span>
                            <a class="button bgc-full question preloader-button text-strong small" href="{U_ALL_UNUSED_FILES}">{NB_ALL_UNUSED_FILES}</a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

        <div class="cell">
            <div class="cell-header">
                <h5 class="cell-name">{@review.anomalies.lists.upload}</h5>
            </div>
            <div class="cell-list">
                <ul>
                    <li class="li-stretch">
                        <span>{@review.missing.used.files}</span>
                        <a class="button bgc-full question preloader-button text-strong small" href="{U_USED_FILES_NOT_ON_SERVER}">{NB_USED_FILES_NOT_ON_SERVER}</a>
                    </li>
                    <li class="li-stretch">
                        <span>{@review.upload.table.unsued.files}</span>
                        <a class="button bgc-full question preloader-button text-strong small" href="{U_UNUSED_FILES_USER}">{NB_UNUSED_FILES_USER}</a>
                    </li>
                    <li class="li-stretch">
                        <span>{@review.orphans.files}</span>
                        <a class="button bgc-full question preloader-button text-strong small" href="{U_ORPHAN_FILES}">{NB_ORPHAN_FILES}</a>
                    </li>
                    <li class="li-stretch">
                        <span>{@review.total.anomalies}</span>
                        <span class="button no-style counter-nolink">{NB_TOTAL_DISCARDED_FILES}</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!--- Gallery files -->
    # IF C_GALLERY_FOLDER #
        <div class="cell-flex cell-columns-2">
            <div class="cell">
                <div class="cell-header">
                    <h5 class="cell-name">{@review.files.status.gallery}</h5>
                    # IF NOT C_GALLERY_DISPLAYED #<span class="message-helper bgc error small">{@review.no.gallery}</span># ENDIF #
                </div>
                <div class="cell-list">
                    <ul>
                        <li class="li-stretch">
                            <span>{@review.files.in.gallery.folder}</span>
                            <a class="button bgc-full question preloader-button text-strong small" href="{U_FILES_IN_GALLERY_FOLDER}">
                                {NB_FILES_IN_GALLERY_FOLDER}
                            </a>
                        </li>
                        <li class="li-stretch">
                            <span>{@review.files.in.gallery.table}</span>
                            <a class="button bgc-full question preloader-button text-strong small" href="{U_FILES_IN_GALLERY_TABLE}"# IF NOT C_GALLERY # aria-label="{@review.no.gallery}"# ENDIF #>
                                # IF C_GALLERY_DISPLAYED #{NB_FILES_IN_GALLERY_TABLE}# ELSE #?# ENDIF #
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="cell">
                <div class="cell-header">
                    <h5 class="cell-name">{@review.anomalies.lists.gallery}</h5>
                </div>
                <div class="cell-list">
                    <ul>
                        <li class="li-stretch">
                            <span>{@review.counters.files.no.gallery.folder}</span>
                            <a class="button bgc-full question preloader-button text-strong small" href="{U_FILES_NOT_IN_GALLERY_FOLDER}"# IF NOT C_GALLERY # aria-label="{@review.no.gallery}"# ENDIF #>
                                # IF C_GALLERY_DISPLAYED #{NB_FILES_NOT_IN_GALLERY_FOLDER}# ELSE #?# ENDIF #
                            </a>
                        </li>
                        <li class="li-stretch">
                            <span>{@review.counters.files.no.gallery.table}</span>
                            <a class="button bgc-full question preloader-button text-strong small" href="{U_FILES_NOT_IN_GALLERY_TABLE}"# IF NOT C_GALLERY # aria-label="{@review.no.gallery}"# ENDIF #>
                                # IF C_GALLERY_DISPLAYED #{NB_FILES_NOT_IN_GALLERY_TABLE}# ELSE #?# ENDIF #
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    # ENDIF #
</article>
<script src="{PATH_TO_ROOT}/review/templates/DataTables/js/jquery.dataTables.min.js"></script>
<script>
    jQuery('a.button').each(function() {
        let button = jQuery(this).attr('href').split('/')
            selectedButton = button[button.length - 2];
        if(window.location.href.indexOf(selectedButton) > -1)
            jQuery(this).addClass('bgc').removeClass('bgc-full');            
    });
</script>