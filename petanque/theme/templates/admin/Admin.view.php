<section>
    <header class="section-header">
        <h1><?= $lang['admin.title'] ?></h1>
    </header>
    <div class="tabs-container">
        <div class="tabs-menu flex-between">
            <div class="tabs-menu-left">
                <span data-trigger="members" class="tab-trigger active-tab" onclick="openTab(event, 'members');"><?= $lang['admin.tab.members'] ?></span>
                <span data-trigger="days" class="tab-trigger" onclick="openTab(event, 'days');"><?= $lang['admin.tab.days'] ?></span>
            </div>
            <div class="tabs-menu-right">
                <span data-trigger="doc" class="tab-trigger" onclick="openTab(event, 'doc');">Documentation</span>
            </div>
        </div>
        <article id="members" class="tab-content active-tab">
            <?php include './theme/templates/admin/AdminMembers.view.php'; ?>
        </article>
        <article id="days" class="tab-content cell-flex cell-columns-2">
            <?php include './theme/templates/admin/AdminDays.view.php'; ?>
        </article>
        <article id="doc" class="tab-content">
            <?php include './theme/templates/admin/AdminDoc.view.php'; ?>
        </article>
    </div>
</section>

