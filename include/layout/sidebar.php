<?php

$query = "SELECT * FROM categories";
$categories = $db->query($query);

?>

<!-- Sidebar Section -->
<div class="col-lg-4" dir="ltr">
    <!-- Search Section -->
    <div class="card text-start">
        <div class="card-body">
            <p class="fw-bold fs-6">Suche im Blog</p>
            <form action="search.php" method="GET">
                <div class="input-group mb-3">
                    <input type="text" name="search" class="form-control" placeholder="Suchen ..." />
                    <button class="btn btn-secondary" type="submit">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Categories Section -->
    <div class="card mt-4 text-start">
        <div class="fw-bold fs-6 card-header">Kategorien</div>
        <ul class="list-group list-group-flush p-0">
            <?php if ($categories->rowCount() > 0) : ?>
                <?php foreach ($categories as $category) : ?>
                    <li class="list-group-item">
                        <a class="link-body-emphasis text-decoration-none" href="index.php?category=<?= $category['id'] ?>"><?= $category['title'] ?></a>
                    </li>
                <?php endforeach ?>
            <?php endif ?>
        </ul>
    </div>

    <!-- Subscribe Section -->
    <div class="card mt-4 text-start">
        <div class="card-body">
            <p class="fw-bold fs-6">Newsletter abonnieren</p>

            <?php
            $invalidInputName = '';
            $invalidInputEmail = '';
            $message = '';

            if (isset($_POST['subscribe'])) {
                if (empty(trim($_POST['name']))) {
                    $invalidInputName = 'Name ist erforderlich';
                } elseif (empty(trim($_POST['email']))) {
                    $invalidInputEmail = 'E-Mail ist erforderlich';
                } else {
                    $name = $_POST['name'];
                    $email = $_POST['email'];

                    $subscribeInsert = $db->prepare("INSERT INTO subscribers (name, email) VALUES (:name, :email)");
                    $subscribeInsert->execute(['name' => $name, 'email' => $email]);

                    $message = "Sie haben sich erfolgreich angemeldet.";
                }
            }

            ?>
            <div class="text-success"><?= $message ?></div>
            <form method="POST">
                <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input type="text" name="name" class="form-control" />
                    <div class="form-text text-danger"><?= $invalidInputName ?></div>
                </div>
                <div class="mb-3">
                    <label class="form-label">E-Mail</label>
                    <input type="email" name="email" class="form-control" />
                    <div class="form-text text-danger"><?= $invalidInputEmail ?></div>
                </div>
                <div class="d-grid gap-2">
                    <button type="submit" name="subscribe" class="btn btn-secondary">
                        Absenden
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- About Section -->
    <div class="card mt-4 text-start">
        <div class="card-body">
            <p class="fw-bold fs-6">Über uns</p>
            <p class="text-justify">
                Lorem Ipsum ist ein einfacher Beispieltext der Druck- und Satzindustrie.
                Lorem Ipsum wird seit dem 16. Jahrhundert als Standard verwendet, als ein unbekannter
                Drucker eine Druckfahne mit Schriftproben nahm und sie durcheinanderwürfelte,
                um ein Musterbuch zu erstellen.
            </p>
        </div>
    </div>
</div>
