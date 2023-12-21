<?php

require_once ('../classes/Connection.class.php');
require_once ('../classes/Members.class.php');
require_once ('../classes/Days.class.php');
require_once ('../classes/Rounds.class.php');
require_once ('../classes/Teams.class.php');
require_once ('../classes/Matches.class.php');
require_once ('../classes/Rankings.class.php');
require_once ('../controllers/Days.controller.php');
require_once ('../controllers/Players.controller.php');

$actions = $_POST['action'];
switch($actions)
{
    case 'update_rankings':
        foreach ($update as $rank) {
            $add = new Rankings();
            $add->update_player(
                $rank['day_id'],
                $rank['member_id'],
                $rank['played'],
                $rank['victory'],
                $rank['loss'],
                $rank['pos_points'],
                $rank['neg_points'],
            );
        }
        break;

    default:
        break;
}
?>