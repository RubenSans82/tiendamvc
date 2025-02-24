<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="<?= base_url(); ?>/assets/css/films.css">
    <script src="<?= base_url(); ?>/assets/js/film.js" defer></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link rel="stylesheet" href="<?= base_url(); ?>/assets/css/films.css">

</head>

<body>
    <div class="container">
        <h1 class=""><?php echo $data["mensaje"]; ?></h1>
        <hr>
        <div class="row">
            <?php

            foreach ($data["films"] as $key => $film) { ?>
                <div class="card col-6">
                    <div class=" card-header film">
                        <?php echo $film->title ?>
                    </div>
                    <ul class="actor_list card-body list-group" hidden>
                        <h4 class="h4">Lista de actores</h4>
                        <?php foreach ($film->actors as $key => $actor) { ?>
                            <li class="list-group-item"><?php echo $actor->first_name . ' ' . $actor->last_name ?></li>
                        <?php } ?>
                    </ul>
                </div>

            <?php } ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>

</body>

</html>