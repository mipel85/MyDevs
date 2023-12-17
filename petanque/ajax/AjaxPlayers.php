<?php

include '../classes/Connection.class.php';
include '../classes/Members.class.php';
$displays = $_POST['display'];
switch($displays)
{
    case 'selected_players':
        $req = 'SELECT name FROM members WHERE present = 1';
        if ($result = Connection::query($req)) {
            foreach ($result as $value) {
                $data[] = $value;
            }
            echo json_encode(array('selected_player' => $data));
        }
        break;

    default:
        break;
}
?>