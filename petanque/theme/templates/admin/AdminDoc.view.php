<section>
    <header class="section-header"><h4><?= $lang['doc.lexicon.title'] ?></h4></header>
    <article><?= $lang['doc.lexicon.content'] ?></article>
    <footer></footer>
</section>

<section class="day-course">
    <header class="section-header"><h2><?= $lang['doc.day.title'] ?></h2></header>
    <div id="day-course" class="cell-flex cell-columns-2">
        <article class="course-item" data-course="1">
            <header class="flex-between-center">
                <h4><?= $lang['doc.members.title'] ?></h4>
            </header>
            <div class="content"><?= $lang['doc.members.content'] ?></div>
        </article>
        
        <article class="course-item" data-course="2">
            <header class="flex-between-center">
                <h4><?= $lang['doc.init.title'] ?></h4>
            </header>
            <div class="content"><?= $lang['doc.init.content'] ?></div>
        </article>
        
        <article class="course-item" data-course="3">
            <header class="flex-between-center">
                <h4><?= $lang['doc.round.title'] ?></h4>
            </header>
            <div class="content"><?= $lang['doc.round.content'] ?></div>
        </article>
        
        <article class="course-item" data-course="4">
            <header class="flex-between-center">
                <h4><?= $lang['doc.scores.title'] ?></h4>
            </header>
            <div class="content"><?= $lang['doc.scores.content'] ?></div>
        </article>
        
        <article class="course-item" data-course="5">
            <header class="flex-between-center">
                <h4><?= $lang['doc.rankings.title'] ?></h4>
            </header>
            <div class="content"><?= $lang['doc.rankings.content'] ?></div>
        </article>
    </div>
    <footer></footer>
    <script>$(document).ready(function() { rowtocolumn('#day-course', '.course-item', 'row-col', 2); });</script>
</section>
