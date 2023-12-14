<?php

require_once('./classes/Members.class.php');
require_once('./classes/Days.class.php');
require_once('./classes/Rounds.class.php');
?>
<section>
    <header class="section-header">
        <h1>Configuration</h1>
    </header>
    <div class="tabs-container">
        <div class="tabs-menu flex-between">
            <div class="tabs-menu-left">
                <span data-trigger="members" class="tab-trigger active-tab" onclick="openTab(event, 'members');">Membres</span>
                <span data-trigger="days" class="tab-trigger" onclick="openTab(event, 'days');">Journées</span>
                <span data-trigger="rounds" class="tab-trigger" onclick="openTab(event, 'rounds');">Parties</span>
            </div>
            <div class="tabs-menu-right">
                <span data-trigger="doc" class="tab-trigger" onclick="openTab(event, 'doc');">Documentation interne</span>
            </div>
        </div>
        <article id="members" class="tab-content active-tab cell-flex cell-columns-2">
            <?php include './theme/templates/config/ConfigMembers.view.php'; ?>
        </article>
        <article id="days" class="tab-content">
            <?php include './theme/templates/config/ConfigDays.view.php'; ?>
        </article>
        <article id="rounds" class="tab-content">
            <?php include './theme/templates/config/ConfigRounds.view.php'; ?>
        </article>
        <article id="doc" class="tab-content">
            <?php include './Documentation/InternalDoc.html'; ?>
        </article>
    </div>
</section>

<script></script>

