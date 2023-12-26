<?php
// check if /classes/ConnectionConfig.class.php exist
if (file_exists('../classes/ConnectionConfig.class.php')) {
    // redirect to root/index.php;
    header('Location: ../index.php?page=home');
}
else {
    // Create connection file
    $config = array(
        "const DB_ADDR" => isset($_POST['host']) ? "'" . $_POST['host'] . "';" : "''",
        "const DB_USER" => isset($_POST['username']) ? "'" . $_POST['username'] . "';" : "''",
        "const DB_PSWD" => isset($_POST['password']) ? "'" . $_POST['password'] . "';" : "''",
        "const DB_NAME" => isset($_POST['database']) ? "'" . $_POST['database'] . "';" : "''"
    );
    
    function writeConfig( $filename, $config ) 
    {
        $fh = fopen($filename, "w");
        fwrite($fh, "<?php\nclass ConnectionConfig\n{\n");
        if (!is_resource($fh)) {
            return false;
        }
        foreach ($config as $key => $value) {
            fwrite($fh, sprintf("\t%s = %s\n", $key, $value));
        }
        fwrite($fh, "}\n?>");
        fclose($fh);
    
        return true;
    }

    function create_database($host, $username, $password, $database, $insert_members)
    {
        try {
            // Create database
            $pdo = new PDO("mysql:host=$host", $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
            $sql = "CREATE DATABASE IF NOT EXISTS $database COLLATE utf8mb4_general_ci;";
            $pdo->exec($sql);

            // Create tables
            $bdd = new PDO("mysql:host=$host;dbname=$database", $username, $password);
            $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Table des journées
            $sql = 'CREATE TABLE IF NOT EXISTS days (
                `id` int PRIMARY KEY NOT NULL AUTO_INCREMENT,
                `date` varchar(11) NOT NULL,
                `active` tinyint(1) DEFAULT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;';
            $bdd->exec($sql);

            // Table des terrains
            $sql = 'CREATE TABLE IF NOT EXISTS fields (
                `id` int PRIMARY KEY NOT NULL AUTO_INCREMENT,
                `day_id` int(11) NOT NULL,
                `field_1` tinyint(1) DEFAULT NULL,
                `field_2` tinyint(1) DEFAULT NULL,
                `field_3` tinyint(1) DEFAULT NULL,
                `field_4` tinyint(1) DEFAULT NULL,
                `field_5` tinyint(1) DEFAULT NULL,
                `field_6` tinyint(1) DEFAULT NULL,
                `field_7` tinyint(1) DEFAULT NULL,
                `field_8` tinyint(1) DEFAULT NULL,
                `field_9` tinyint(1) DEFAULT NULL,
                `field_10` tinyint(1) DEFAULT NULL,
                `field_11` tinyint(1) DEFAULT NULL,
                `field_12` tinyint(1) DEFAULT NULL,
                `field_13` tinyint(1) DEFAULT NULL,
                `field_14` tinyint(1) DEFAULT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;';
            $bdd->exec($sql);

            // Table des matches
            $sql = 'CREATE TABLE IF NOT EXISTS matches (
                `id` int PRIMARY KEY NOT NULL AUTO_INCREMENT,
                `day_id` int(11) NOT NULL,
                `round_id` int(11) NOT NULL,
                `team_1_id` int(11) NOT NULL,
                `team_1_score` int(11) NULL,
                `team_2_id` int(11) NOT NULL,
                `team_2_score` int(11) NULL,
                `field` int(11) NOT NULL,
                `score_status` int(11) NOT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;';
            $bdd->exec($sql);

            // Table des membres
            $sql = 'CREATE TABLE IF NOT EXISTS members (
                `id` int PRIMARY KEY NOT NULL AUTO_INCREMENT,
                `name` varchar(255) NOT NULL,
                `present` tinyint(1) DEFAULT NULL,
                `fav` tinyint(1) DEFAULT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;';
            $bdd->exec($sql);

            // Table des joueurs
            $sql = 'CREATE TABLE IF NOT EXISTS players (
                `id` int PRIMARY KEY NOT NULL AUTO_INCREMENT,
                `day_id` int(11) NOT NULL,
                `round_id` int(11) NOT NULL,
                `match_id` int(11) NOT NULL,
                `score_status` tinyint(1) NOT NULL,
                `member_id` int(11) NOT NULL,
                `member_name` varchar(255) NOT NULL,
                `points_for` int(11) NOT NULL,
                `points_against` int(11) NOT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;';
            $bdd->exec($sql);

            // Table des classements
            $sql = 'CREATE TABLE IF NOT EXISTS rankings (
                `id` int PRIMARY KEY NOT NULL AUTO_INCREMENT,
                `day_id` int(11) NOT NULL,
                `day_date` varchar(11) NOT NULL,
                `member_id` int(11) NOT NULL,
                `member_name` varchar(255) NOT NULL,
                `played` int(11) NOT NULL,
                `victory` int(11) NOT NULL,
                `loss` int(11) NOT NULL,
                `pos_points` int(11) NOT NULL,
                `neg_points` int(11) NOT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;';
            $bdd->exec($sql);

            // Table des parties
            $sql = 'CREATE TABLE IF NOT EXISTS rounds (
                `id` int PRIMARY KEY NOT NULL AUTO_INCREMENT,
                `day_id` int(11) NOT NULL,
                `i_order` int(11) NOT NULL,
                `players_number` int(11) NOT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;';
            $bdd->exec($sql);

            // Table des équipes
            $sql = 'CREATE TABLE IF NOT EXISTS teams (
                `id` int PRIMARY KEY NOT NULL AUTO_INCREMENT,
                `day_id` int(11) NOT NULL,
                `round_id` int(11) NOT NULL,
                `player_1_id` int(11) NOT NULL,
                `player_1_name` varchar(255) NOT NULL,
                `player_2_id` int(11) DEFAULT NULL,
                `player_2_name` varchar(255) DEFAULT NULL,
                `player_3_id` int(11) DEFAULT NULL,
                `player_3_name` varchar(255) DEFAULT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;';
            $bdd->exec($sql);

            if($insert_members) {
                $csvFile = './members.csv';
                if (($handle = fopen($csvFile, 'r')) !== FALSE) {
                    while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
                        $stmt = $bdd->prepare("INSERT INTO members (name) VALUES (?)");
                        $stmt->execute([$data[0]]);
                    }
                    fclose($handle);
                    $success = true;
                } else {
                    echo "Erreur lors de l'ouverture du fichier CSV.";
                }
            }
            $success = true;
    
        } catch (PDOException $e) {
            echo "Erreur de connexion à la base de données : " . $e->getMessage();
        }
    }

    $error = '';
    $success = false;
    $host_class = $database_class = $username_class = $password_class = '';
    $success = false;
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (empty($_POST['host']) || empty($_POST['username']) || empty($_POST['database'])) {
            $error = "Il en manque : ";
            if(empty($_POST['host'])) {
                $error .= '<br>Le serveur';
                $host_class = ' input-error';
            }
            if(empty($_POST['username'])) {
                $error .= '<br>Le nom d\'utilisateur';
                $username_class = ' input-error';
            }
            if(empty($_POST['database'])) {
                $error .= '<br>La base de données';
                $database_class = ' input-error';
            }
        } else {
            writeConfig("../classes/ConnectionConfig.class.php", $config);
            create_database($_POST['host'], $_POST['username'], $_POST['password'], $_POST['database'], $_POST['members']);
            $success = true;
        }
    }

}
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" href="../favicon.ico" />
        <link rel="stylesheet" href="./install.css" type="text/css" media="screen, print" />
        <script src="../theme/js/plugins/jquery.min.js"></script>
        <script src="./install.js"></script>
    <title>Installation de PHPetanque</title>
</head>
<body>
    <header><h1>Installation de PHPetanque</h1></header>
    <main>
        <?php if ($success): ?>
            Installation réussie : <a href="../index.php?page=home">Rejoindre le site</a>
        <?php else: ?>
            <form method="post" action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                <label for="host">
                    <span>Serveur : </span>
                    <input class="<?= $host_class ?>" type="text" name="host" id="host" value="localhost">
                </label>
                <label for="username">
                    <span>Utilisateur : </span>
                    <input class="<?= $username_class ?>" type="text" name="username" id="username" value="">
                </label>
                <label for="password">
                    <span>Mot de passe : </span>
                    <input class="<?= $password_class ?>" type="password" name="password" id="password" value="">
                </label>
                <label for="database">
                    <span>Base de données : </span>
                    <input class="<?= $database_class ?>" type="text" name="database" id="database" value="">
                </label>
                <label for="members">
                    <span>Ajouter la liste des membres<br>(/install/members.csv) : </span>
                    <input class="<?= $database_class ?>" type="checkbox" name="members" id="members" checked>
                </label>
                <div class="align-center">
                    <button id="install-submit" type="submit">Valider</button>
                </div>
                <div class="align-center">
                    <?= $error ?>
                </div>
            </form>
        <?php endif ?>

    </main>
    <footer></footer>
</body>
</html>