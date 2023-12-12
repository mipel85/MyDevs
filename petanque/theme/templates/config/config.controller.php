<?php

require_once('./classes/Members.class.php');
require_once('./classes/Parties.class.php');
require_once('./classes/Rounds.class.php');
?>
<section>
    <header class="section-header">
        <h1>Configuration</h1>
    </header>
    <div class="tabs-container">
        <div class="tabs-menu">
            <span data-trigger="members" class="tab-trigger active-tab" onclick="openTab(event, 'members');">Joueurs</span>
            <span data-trigger="parties" class="tab-trigger" onclick="openTab(event, 'parties');">Parties</span>
            <span data-trigger="rounds" class="tab-trigger" onclick="openTab(event, 'rounds');">Manches</span>
            <!-- <a data-trigger="config" class="tab-trigger" onclick="openTab(event, 'config');">Rounds</a> -->
        </div>
        <article id="members" class="tab-content active-tab cell-flex cell-columns-2">
            <?php include './theme/templates/config/config.members.php'; ?>
        </article>
        <article id="parties" class="tab-content cell-flex cell-columns-2">
            <?php include './theme/templates/config/config.parties.php'; ?>
        </article>
        <article id="rounds" class="tab-content cell-flex cell-columns-2">
            <?php include './theme/templates/config/config.rounds.php'; ?>
        </article>
        <!-- <article id="config" class="tab-content cell-flex cell-columns-2">
            <div id="max-round">
                <header>
                    <h3>Limiter le nombre de manches par partie</h3>
                </header>
                <div class="content">
                    <input id="max-round-value" type="text" value="" class="" />
                    <button class="submit button" type="submit" id="delete-all-manches" name="all_games">Valider</button>
                </div>
            </div>
            <div id="playground">
                <header>
                    <h3>Nombre de terrains définis</h3>
                </header>
                <div class="content">
                    <input id="playground-value" type="text" value="" class="" />
                    <button class="submit button" type="submit" id="delete-all-manches" name="all_games">Valider</button>
                </div>
            </div>
        </article> -->
    </div>
</section>

<script></script>

