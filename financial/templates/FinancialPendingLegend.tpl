<div class="sub-section">
    <div class="content-container">
        <div class="content">
            <h2>{@financial.legend}</h2>
            <div class="cell-flex cell-columns-2">
                <div class="cell">
                    {@H|financial.pending.legend.user}
                </div>
                # IF C_MONITORING #
                    <div class="cell">
                        {@H|financial.pending.legend.monitoring}
                    </div>
                # ENDIF #
            </div>
        </div>
    </div>
</div>