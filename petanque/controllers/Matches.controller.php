<?php
require_once('../classes/Connection.class.php');
require_once('../classes/Fields.class.php');
require_once('../classes/Teams.class.php');

// Build teams list
$selected_teams_list = Teams::round_teams_list($day_id, $round_id);
$teams = [];
foreach ($selected_teams_list as $team)
{
    $teams[] = $team['id'];
}
// Randomize teams order in array
shuffle($teams);

/**
 * Build matches list from the teams list of the created round
 * !! the $day var is not the Days item
 *
 * @param  array $teams | Teams list built for the round
 * @return array
 */
function build_matches($teams) : array
{
    $calendar = [];
    $teams_number = count($teams);

    // Build the calendar of $days
    for ($day = 1; $day < $teams_number; $day++) {
        $calendar[$day] = [];

        // Build each match and add it to the $day list
        for ($i = 0; $i < $teams_number / 2; $i++) {
            $team1 = $teams[$i];
            $team2 = $teams[$teams_number - 1 - $i];

            $calendar[$day][] = [$team1, $team2];
        }

        // Rotate teams for next $day
        $teamDebut = array_shift($teams);
        array_unshift($teams, array_pop($teams));
        array_unshift($teams, $teamDebut);
    }

    return $calendar;
}

/**
 * Define playgrounds list for the round matches
 *
 * @param  array $selected_playgrounds | list of the selected playgrounds for the round
 * @param  array $round_matches | list of the matches of the round
 * @return array
 */
function playgrounds($selected_playgrounds, $round_matches) : array
{
    $playgrounds = $selected_playgrounds;
    shuffle($playgrounds);
    $matches_number = count($round_matches);
    $playgrounds_list = [];
    for ($i=1; $i <= $matches_number; $i++ )
    {
        if (empty($playgrounds)) {
            $playgrounds = $selected_playgrounds;
            shuffle($playgrounds);
        }
        $playgrounds_list[] = array_shift($playgrounds);
    }

    return $playgrounds_list;
}
?>