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
        <div class="tabs-menu">
            <span data-trigger="members" class="tab-trigger active-tab" onclick="openTab(event, 'members');">Joueurs</span>
            <span data-trigger="days" class="tab-trigger" onclick="openTab(event, 'days');">Journées</span>
            <span data-trigger="rounds" class="tab-trigger" onclick="openTab(event, 'rounds');">Parties</span>
        </div>
        <article id="members" class="tab-content active-tab cell-flex cell-columns-2">
            <?php include './theme/templates/config/config.members.view.php'; ?>
        </article>
        <article id="days" class="tab-content">
            <?php include './theme/templates/config/config.days.view.php'; ?>
        </article>
        <article id="rounds" class="tab-content">
            <?php include './theme/templates/config/config.rounds.view.php'; ?>
        </article>
    </div>
</section>

<script></script>

