<?php
define('CBW_QUIZZ', TRUE);
    /**
     * Created: 27/03/2018 21:05
     */
    require 'base.inc.php';

?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>CBW2016 Quizz</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/fonts.css">
    <link rel="stylesheet" href="css/fontawesome-all.min.css">
    <link rel="stylesheet" href="css/base.css">

    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/bootstrap.bundle.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
</head>
<body>
<!-- START NAV-->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="javascript:;">CBW2016 Quizz</a>
    <button class="navbar-toggler"
            type="button"
            data-toggle="collapse"
            data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent"
            aria-expanded="false"
            aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="#">Home</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Quizz Typ</a>
                <div class="dropdown-menu bg-dark" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="#">WISO</a>
                    <a class="dropdown-item" href="#">KERN 1</a>
                    <a class="dropdown-item" href="#">KERN 2</a>
                </div>
            </li>
            <li class="nav-item disabled">
                <a class="nav-link" href="#">Klassen Quizz</a>
            </li>
        </ul>
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="#">RESET</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Admin</a>
            </li>
        </ul>
    </div>
</nav>
<!--END NAV-->
<!--START CONTENT-->
<main id="main_content" class="container">
    <?php if(!$user->hasUsername() && (isset($_COOKIE) && !isset($_COOKIE["CBW_NO_NAME"]))) {?>
    <!-- START ASK_USER_NAME -->
    <div id="ask_user_name" class="alert alert-primary" role="alert">
        <div class="input-group mt-2 mb-2">
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1">Wie lautet dein Name?</span>
            </div>
            <input type="text" class="form-control" id="username" placeholder="Name" aria-label="Username" aria-describedby="basic-addon1">
            <div class="input-group-append ">
                <span class="input-group-text"><input id="save_name" type="checkbox" class="mr-2" aria-label="Speichern">Merken?</span>
            </div>
        </div>
        <div class="input-group mt-2 mb-2">
            <div class="input-group-prepend mr-auto">
                <button id="save_user_name" class="btn btn-success" type="button">Speichern</button>
            </div>
            <div class="input-group-append">
                <button class="btn btn-danger" type="button">Kein Name speichern</button>
            </div>
        </div>
    </div>
    <!-- END ASK_USER_NAME -->
    <?php } ?>
    <!--START QUIZZ-->
    <div id="quizz" class="row">
        <section id="content" class="col-md-8 col-sm-12">
            <div id="quizz_title" class="col-12">Dies ist ein Titel der Frage</div>
            <div id="quizz_question" class="col-12">Wer ist doof?</div>
            <div id="quizz_answers" class="col-12">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                    <label class="form-check-label" for="defaultCheck1">
                        Antwort 1, dies ist ein langer Text der die Antwort Möglichkeit 1 ist.
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="defaultCheck2">
                    <label class="form-check-label" for="defaultCheck2">
                        Antwort 2, dies ist ein langer Text der die Antwort Möglichkeit 2 ist. Antwort 2, dies ist ein langer Text der die Antwort Möglichkeit 2 ist. Antwort 2, dies ist ein langer Text der die Antwort Möglichkeit 2 ist.
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="defaultCheck3">
                    <label class="form-check-label" for="defaultCheck3">
                        Antwort 3, dies ist ein langer Text der die Antwort Möglichkeit 3 ist.
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="defaultCheck4">
                    <label class="form-check-label" for="defaultCheck4">
                        Antwort 4, dies ist ein langer Text der die Antwort Möglichkeit 4 ist.
                    </label>
                </div>
            </div>
            <div id="quizz_controls" class="col-12">
                <button type="button" id="check_question" class="btn btn-success float-right">Antwort abgeben</button>
                <button type="button" id="check_question" class="btn btn-primary float-right d-none">Nächste Frage</button>
                <button type="button" class="btn btn-info">Hinweis</button>
            </div>
        </section>
        <aside id="stats" class="col-md-4 col-sm-12">Stats</aside>
    </div>
    <!--END QUIZZ-->
</main>
<!--END CONTENT-->
<!--START LOG-->
<div id="toggle_log" class="btn btn-outline-info btn-sm">Log</div>
<pre id="log" class="d-none container"><?php foreach (array_reverse(log::getInstance()->getMessages()) as $msg) { echo $msg; }?></pre>
<!--END LOG-->
<script src="js/cbw.quizz.js"></script>
</body>
</html>