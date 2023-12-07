<?php
    $startYear = '2023';
    $currentDate = new DateTime();
    $currentYear = $currentDate->format('Y');
    if ($startYear == $currentYear) $year = $startYear;
    else $year = $startYear . ' - ' . $currentYear;
?>
        </main>
        <footer id="footer">&copy; PLSF <?= $year ?></footer>
    </body>
</html>