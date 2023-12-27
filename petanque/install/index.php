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
    
    function create_config_file($filename, $config)
    {
        $fh = fopen($filename, "w");
        fwrite($fh, "<?php\n\nclass ConnectionConfig\n{\n");
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
            // Open connection to sql server
            $pdo = new PDO("mysql:host=$host", $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Check if database exists and drop it
            $check_database = $pdo->query("SHOW DATABASES LIKE '$database'");
            if($check_database->rowCount() > 0) {
                $pdo->query("DROP DATABASE $database");
            }

            // Create database
            $sql = "CREATE DATABASE IF NOT EXISTS $database COLLATE utf8mb4_general_ci;";
            $pdo->exec($sql);

            // Create tables
            $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            Install::create_days();
            Install::create_fields();
            Install::create_matches();
            Install::create_members();
            Install::create_players();
            Install::create_rankings();
            Install::create_rounds();
            Install::create_teams();

            // Insert members list from csv file
            if($insert_members) {
                $file = './members.csv';
                if (($handle = fopen($file, 'r')) !== FALSE) {
                    while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
                        $stmt = $pdo->prepare("INSERT INTO members (name) VALUES (?)");
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
        // Close connection
        $pdo = null;
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
                $host_class = 'input-error';
            }
            if(empty($_POST['username'])) {
                $error .= '<br>Le nom d\'utilisateur';
                $username_class = 'input-error';
            }
            if(empty($_POST['database'])) {
                $error .= '<br>La base de données';
                $database_class = 'input-error';
            }
        } else {
            create_config_file("../classes/ConnectionConfig.class.php", $config);
            require_once('./Install.class.php');
            create_database($_POST['host'], $_POST['username'], $_POST['password'], $_POST['database'], $_POST['insert_members']);
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
                    <input class="<?= $database_class ?>" type="checkbox" name="insert_members" id="members" checked>
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