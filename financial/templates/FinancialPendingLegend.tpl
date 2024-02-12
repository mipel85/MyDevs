<div class="sub-section">
    <div class="content-container">
        <div class="content">
            <h2>{@financial.legend}</h2>
            <div class="cell-flex # IF C_MONITORING #cell-columns-2# ENDIF #">
                <div class="cell">
                    <div class="cell-list">
                        <li class="cell-content">{@H|financial.legend.user.pending}</li>
                        <li class="cell-content">{@H|financial.legend.user.archived}</li>
                    </div>
                    <div class="cell-header">
                        <div class="cell-name">{@H|financial.legend.user.file}</div>
                    </div>
                    <div class="cell-body">
                        <div class="cell-list">
                            <ul>
                                <li>{@H|financial.legend.user.none}</li>
                                <li>{@H|financial.legend.user.warning}</li>
                                <li>{@H|financial.legend.user.error}</li>
                                <li>{@H|financial.legend.user.estimate}</li>
                                <li>{@H|financial.legend.user.invoice}</li>
                            </ul>
                        </div>
                    </div>
                    <div class="cell-header">
                        <div class="cell-name">{@H|financial.legend.user.controls}</div>
                    </div>
                    <div class="cell-body">
                        <div class="cell-list">
                            <ul>
                                <li>{@H|financial.legend.user.edit}</li>
                                <li>{@H|financial.legend.user.delete}</li>
                            </ul>
                        </div>
                    </div>
                </div>
                # IF C_MONITORING #
                    <div class="cell">
                        <div class="cell-header">{@H|financial.legend.monitoring.input}</div>
                        <div class="cell-body">
                            <div class="cell-list">
                                <ul>
                                    <li>{@H|financial.legend.monitoring.input.disabled}</li>
                                    <li>{@H|financial.legend.monitoring.input.enabled}</li>
                                </ul>
                            </div>
                        </div>
                        <div class="cell-header">{@H|financial.legend.monitoring.buttons}</div>
                        <div class="cell-body">
                            <div class="cell-list">
                                <ul>
                                    <li>{@H|financial.legend.monitoring.button.payment}</li>
                                    <li>{@H|financial.legend.monitoring.button.ongoing}</li>
                                    <li>{@H|financial.legend.monitoring.button.reject}</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                # ENDIF #
            </div>
        </div>
    </div>
</div>

# IF C_MONITORING #
    <script>
        jQuery('.monitoring-input').each(function() {
            let amount = jQuery(this).val(),
                target = jQuery(this).siblings('.payment-button'),
                href = target.attr('href');
            target.attr('href', href + amount);
            jQuery(this).on('change',function() {
                amount = jQuery(this).val();
                parts = href.split('/');
                parts[parts.length - 1] = amount;
                let new_href = parts.join('/');
                target.attr('href', new_href);
            });
        });
    </script>
# ENDIF #