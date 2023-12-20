
<?php

require_once ('../classes/Connection.class.php');
require_once ('../classes/Members.class.php');
require_once ('../classes/Rounds.class.php');
require_once ('../classes/Days.class.php');
require_once ('../classes/Matches.class.php');
require_once ('../classes/Teams.class.php');
require_once ('../classes/Rankings.class.php');
require_once ('../controllers/Days.controller.php');

echo 'Liste des id de membre déjà dans le classement du jour: <br>';
var_dump(Rankings::rankings_members_id_list($day_id))
?>
<table>
    <thead>
        <tr>
            <th>day_id | </th>
            <th>round_id | </th>
            <th>match_id | </th>
            <th>member_id | </th>
            <th>member_name | </th>
            <th>points_for | </th>
            <th>points_against | </th>
        </tr>
    </thead>
    <tbody>
        <?php foreach (Matches::matches_list() as $match): ?>
            <?php if ( $match['day_id'] == $day_id): ?>
                <?php foreach (Teams::get_team_members($match['team_1_id']) as $player): ?>
                    <tr>
                        <td><?= $day_id ?></td>
                        <td><?= $match['round_id'] ?></td>
                        <td><?= $match['id'] ?></td>
                        <td><?= $player[0] ?></td>
                        <td><?= $player[1] ?></td>
                        <td><?= $match['team_1_score'] ?></td>
                        <td><?= $match['team_2_score'] ?></td>
                    </tr>
                    <tr>
                        <td><?= $day_id ?></td>
                        <td><?= $match['round_id'] ?></td>
                        <td><?= $match['id'] ?></td>
                        <td><?= $player[2] ?></td>
                        <td><?= $player[3] ?></td>
                        <td><?= $match['team_1_score'] ?></td>
                        <td><?= $match['team_2_score'] ?></td>
                    </tr>
                    <?php if ( $player[4]): ?>
                        <tr>
                            <td><?= $day_id ?></td>
                            <td><?= $match['round_id'] ?></td>
                            <td><?= $match['id'] ?></td>
                            <td><?= $player[4] ?></td>
                            <td><?= $player[5] ?></td>
                            <td><?= $match['team_1_score'] ?></td>
                            <td><?= $match['team_2_score'] ?></td>
                        </tr>
                    <?php endif ?>
                <?php endforeach ?>
                <?php foreach (Teams::get_team_members($match['team_2_id']) as $player): ?>
                    <tr>
                        <td><?= $day_id ?></td>
                        <td><?= $match['round_id'] ?></td>
                        <td><?= $match['id'] ?></td>
                        <td><?= $player[0] ?></td>
                        <td><?= $player[1] ?></td>
                        <td><?= $match['team_2_score'] ?></td>
                        <td><?= $match['team_1_score'] ?></td>
                    </tr>
                    <tr>
                        <td><?= $day_id ?></td>
                        <td><?= $match['round_id'] ?></td>
                        <td><?= $match['id'] ?></td>
                        <td><?= $player[2] ?></td>
                        <td><?= $player[3] ?></td>
                        <td><?= $match['team_2_score'] ?></td>
                        <td><?= $match['team_1_score'] ?></td>
                    </tr>
                    <?php if ( $player[4]): ?>
                        <tr>
                            <td><?= $day_id ?></td>
                            <td><?= $match['round_id'] ?></td>
                            <td><?= $match['id'] ?></td>
                            <td><?= $player[4] ?></td>
                            <td><?= $player[5] ?></td>
                            <td><?= $match['team_2_score'] ?></td>
                            <td><?= $match['team_1_score'] ?></td>
                        </tr>
                    <?php endif ?>
                <?php endforeach ?>
            <?php endif ?>
        <?php endforeach ?>
    </tbody>
</table>

<?php
// Liste de tous les matchs
    // foreach (Matches::matches_list() as $match) {
    //     if ( $day_id == $day_id) {
    //         foreach (Teams::get_team_members($match['team_1_id']) as $player) {
    //             echo 'day_id: ' . $day_id .  ' | round_id: ' . $match['round_id'] . ' | match: ' . $match['id'] . 
    //                 ' | member_id: ' . $player[0] . ' | member_name: ' . $player[1] . ' | points_for: ' . $match['team_1_score'] . ' | points_against: ' . $match['team_2_score'];
    //             echo '<br>day_id: ' . $day_id .  ' | round_id: ' . $match['round_id'] . ' | match: ' . $match['id'] . 
    //                 ' | member_id: ' . $player[2] . ' | member_name: ' . $player[3] . ' | points_for: ' . $match['team_1_score'] . ' | points_against: ' . $match['team_2_score'];
    //             if($player[4]) {
    //                 echo '<br>day_id: ' . $day_id .  ' | round_id: ' . $match['round_id'] . ' | match: ' . $match['id'] . 
    //                 ' | member_id: ' . $player[4] . ' | member_name: ' . $player[5] . ' | points_for: ' . $match['team_1_score'] . ' | points_against: ' . $match['team_2_score'];
    //             }
    //             echo '<br>';
    //         }
    //         foreach (Teams::get_team_members($match['team_2_id']) as $player) {
    //             echo 'day_id: ' . $day_id .  ' | round_id: ' . $match['round_id'] . ' | match: ' . $match['id'] . 
    //                 ' | member_id: ' . $player[0] . ' | member_name: ' . $player[1] . ' | points_for: ' . $match['team_2_score'] . ' | points_against: ' . $match['team_1_score'];
    //             echo '<br>day_id: ' . $day_id .  ' | round_id: ' . $match['round_id'] . ' | match: ' . $match['id'] . 
    //                 ' | member_id: ' . $player[2] . ' | member_name: ' . $player[3] . ' | points_for: ' . $match['team_2_score'] . ' | points_against: ' . $match['team_1_score'];
    //             if($player[4]) {
    //                 echo '<br>day_id: ' . $day_id .  ' | round_id: ' . $match['round_id'] . ' | match: ' . $match['id'] . 
    //                 ' | member_id: ' . $player[4] . ' | member_name: ' . $player[5] . ' | points_for: ' . $match['team_2_score'] . ' | points_against: ' . $match['team_1_score'];
    //             }
    //             echo '<br>';
    //         }
    //         echo '<br>';
    //     }
    // }
?>