<?php

// check if /classes/ConnectionConfig.class.php exist
if (file_exists('../classes/ConnectionConfig.class.php')) {
    // redirect to root/index.php;
    header('Location: ../index.php?page=home');
} else {
    $success = false;
    // Create connection file
    $config = array(
        "const DB_ADDR" => isset($_POST['host']) ? "'" . $_POST['host'] . "';" : "''",
        "const DB_USER" => isset($_POST['username']) ? "'" . $_POST['username'] . "';" : "''",
        "const DB_PSWD" => isset($_POST['password']) ? "'" . $_POST['password'] . "';" : "''",
        "const DB_NAME" => isset($_POST['database']) ? "'" . $_POST['database'] . "';" : "''",
        "const PREFIX" => isset($_POST['prefix']) ? "'" . $_POST['prefix'] . "';" : "''"
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

    function check_database($host, $username, $password, $database)
    {
        try {
            $pdo = new PDO("mysql:host=$host", $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Check if database exists and drop it
            $check_database = $pdo->query("SHOW DATABASES LIKE '$database'");
            if ($check_database->rowCount() > 0) {
                return true;
            }
            return false;
        } catch (PDOException $e) {
            echo '<div class="lead mt-2 alert alert-danger">Erreur de connexion à la base de données : ' . $e->getMessage() . '</div>';
        }
    }

    function create_database($host, $username, $password, $database, $prefix, $insert_members)
    {
        try {
            // Open connection to sql server
            $pdo = new PDO("mysql:host=$host", $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Check if database exists and drop it
            $check_database = $pdo->query("SHOW DATABASES LIKE '$database'");
            if ($check_database->rowCount() > 0) {
                $pdo->query("DROP DATABASE $database");
            }

            // Create database
            $sql = "CREATE DATABASE IF NOT EXISTS $database COLLATE utf8mb4_general_ci;";
            $pdo->exec($sql);

            // Create tables
            $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            Install::create_days($prefix);
            Install::create_fields($prefix);
            Install::create_matches($prefix);
            Install::create_members($prefix);
            Install::create_players($prefix);
            Install::create_rankings($prefix);
            Install::create_rounds($prefix);
            Install::create_teams($prefix);

            // Insert members list from csv file
            if ($insert_members == 'yes') {
                $file = './members.csv';
                if (($handle = fopen($file, 'r')) !== FALSE) {
                    $column = $prefix . 'members';
                    while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
                        $stmt = $pdo->prepare("INSERT INTO $column (name) VALUES (?)");
                        $stmt->execute([$data[0]]);
                    }
                    fclose($handle);
                } else {
                    echo '<div class="lead mt-2 alert alert-danger">Erreur lors de l\'ouverture du fichier CSV.</div>';
                }
            }
        } catch (PDOException $e) {
            echo '<div class="lead mt-2 alert alert-danger">Erreur de connexion à la base de données : ' . $e->getMessage() . '</div>';
        }
        // Close connection
        $pdo = null;
    }

    $success = false;
    $config_exists = false;
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Create database
        require_once('./Install.class.php');
        create_database($_POST['host'], $_POST['username'], $_POST['password'], $_POST['database'], $_POST['prefix'], $_POST['insert_members']);
        $success = check_database($_POST['host'], $_POST['username'], $_POST['password'], $_POST['database']);
        
        // Check if config file location is writable
        $dir = '../classes/';
        if (!is_writable($dir)) @chmod($dir, 0755);
        
        // Create config file
        $config_file = '../classes/ConnectionConfig.class.php';
        create_config_file($config_file, $config);
        if (file_exists($config_file)) {
            $config_exists = true;
        }
    }
}
?>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../favicon.ico" />
    <link rel="stylesheet" href="../theme/bootstrap/bootstrap.min.css">
    <script src="../theme/js/plugins/jquery.min.js"></script>
    <script src="../theme/bootstrap/bootstrap.bundle.min.js"></script>
    <title>Installation de Petanque</title>
</head>

<body class="container">
    <main class="mx-auto">
        <div class="container col-xl-10 col-xxl-8 px-4 py-5">
            <h1 class="display-3 fw-bold lh-1 text-body-emphasis mb-3 text-center">Petanque</h1>
            <div class="row align-items-top g-lg-5 py-5">
                <div class="col-lg-5 text-center text-lg-start">
                    <h2 class="display-4 mb-2 fw-bold">Installation</h2>
                    <p class="col-lg-10 fs-4">
                        Ce formulaire permet de créer le fichier de configuration et la base de données nécessaires à la gestion du logiciel Petanque.
                    </p>
                </div>
                <div class="col-md-10 mx-auto col-lg-7">
                    <?php if ($config_exists && $success) : ?>
                        <div class="lead alert alert-info">
                            <?php if ($config_exists) : ?>
                                <div class="mb-2">Le fichier de configuration a été créé.</div>
                            <?php endif ?>
                            <?php if ($success) : ?>
                                <p>La base de données a été créée.</p>
                                <a href="../index.php?page=home">Rejoindre le site</a>
                            <?php else : ?>
                                <p>La base de données n'a pas été créée.</p>
                                <a href="./">recommencer l'installation</a>
                            <?php endif ?>
                        </div>
                    <?php else : ?>
                        <form id="main-form" class="p-2 p-md-3 border rounded-3 bg-body-tertiary text-center" method="post" action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                            <small class="text-body-secondary">Les champ marqués * sont obligatoires</small>
                            <div class="form-floating mb-2">
                                <input name="host" type="text" class="form-control ui-autocomplete-input" id="host" placeholder="Serveur" value="localhost" autocomplete="on" required>
                                <label for="host">* Serveur</label>
                            </div>
                            <div class="form-floating mb-2">
                                <input name="username" type="text" class="form-control ui-autocomplete-input" id="username" placeholder="Nom d'utilisateur" autocomplete="on" required>
                                <label for="username">* Nom d'utilisateur</label>
                            </div>
                            <div class="form-floating mb-2">
                                <input type="password" name="password" class="form-control" id="password" placeholder="Mot de passe">
                                <label for="password">Mot de passe</label>
                            </div>
                            <div class="form-floating mb-2">
                                <input name="database" type="text" class="form-control ui-autocomplete-input" id="database" placeholder="Base de données" autocomplete="on" required>
                                <label for="database">* Base de données</label>
                            </div>
                            <div class="form-floating mb-2">
                                <input name="prefix" type="text" class="form-control ui-autocomplete-input" id="prefix" placeholder="Préfixe" value="petanque_" autocomplete="on" required>
                                <label for="prefix">* Préfixe</label>
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input id='members' type='checkbox' value='yes' name='insert_members' checked> Ajouter la liste des membres
                                    <input id='members_hidden' type='hidden' value='no' name='insert_members'>
                                </label>
                                <script>
                                    let form = document.getElementById('main-form');
                                    form.addEventListener('submit', () => {
                                        if(document.getElementById('members').checked) {
                                            document.getElementById('members_hidden').disabled = true;
                                        }
                                    });
                                </script>
                            </div>
                            <div class="mb-3">
                                <small class="text-body-secondary mb-2">(/install/members.csv)</small>
                            </div>
                            <button class="w-100 btn btn-lg btn-primary" type="submit">Valider</button>
                        </form>
                    <?php endif ?>
                </div>
            </div>
        </div>
    </main>
    <footer></footer>
</body>

</html>