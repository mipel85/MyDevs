<?php

$error = null;
$username = '$2y$12$Xmf8YNC6fRg9I4qvTk3mausdqESdTpDaov/c2BwdzRx3MYpKoclg2';
$password = '$2y$12$Xmf8YNC6fRg9I4qvTk3mausdqESdTpDaov/c2BwdzRx3MYpKoclg2';
if (!empty($_POST['username']) && !empty($_POST['password'])) {
    if (password_verify($_POST['password'], $username) && password_verify($_POST['password'], $password)) {
        session_start();
        $_SESSION['connected'] = 1;
        header('Location: ./index.php?page=home');
        exit();
    } else {
        $error = 'Identifiants inccorects';
    }
}

// check if user is connected
require_once('./app/db/auth.php');
if (is_connected()) {
    header('Location: ./index.php?page=home');
}
?>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="./favicon.ico" />
    <link rel="stylesheet" href="./theme/bootstrap/bootstrap.min.css">
    <script src="./theme/js/plugins/jquery.min.js"></script>
    <script src="./theme/bootstrap/bootstrap.bundle.min.js"></script>
    <title>Connexion</title>
</head>

<body class="container">
    <?php if ($error): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif ?>
    <main class="mx-auto">
        <div class="container col-xl-10 col-xxl-8 px-4 py-5">
            <h1 class="display-3 fw-bold lh-1 text-body-emphasis mb-3 text-center">Petanque</h1>
            <div class="row align-items-top g-lg-5 py-5">
                <div class="col-lg-5 text-center text-lg-start">
                    <h2 class="display-4 mb-2 fw-bold">Formulaire de connexion</h2>
                </div>
                <div class="col-md-10 mx-auto col-lg-7">
                        <form id="main-form" class="p-2 p-md-3 border rounded-3 bg-body-tertiary text-center" method="post" action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                            <small class="text-body-secondary">Les champ marqués * sont obligatoires</small>
                            <div class="form-floating mb-2">
                                <input name="username" type="text" class="form-control ui-autocomplete-input" id="username" placeholder="Nom d'utilisateur" autocomplete="on" required>
                                <label for="username">* Nom d'utilisateur</label>
                            </div>
                            <div class="form-floating mb-2">
                                <input type="password" name="password" class="form-control" id="password" placeholder="Mot de passe">
                                <label for="password">Mot de passe</label>
                            </div>
                            <button class="w-100 btn btn-lg btn-primary" type="submit">Valider</button>
                        </form>
                </div>
            </div>
        </div>
    </main>
    <footer></footer>
</body>

</html>