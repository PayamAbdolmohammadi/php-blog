<?php
include "./include/layout/header.php";

if (isset($_GET['post'])) {
    $postId = $_GET['post'];

    $post = $db->prepare('SELECT * FROM posts WHERE id = :id');
    $post->execute(['id' => $postId]);
    $post = $post->fetch();
}
?>

<main>
    <!-- Content -->
    <section class="mt-4">
        <div class="row">
            <!-- Posts & Comments Content -->
            <?php if (empty($post)) : ?>
                <div class="col-lg-8">
                    <div class="alert alert-danger">
                        Kein Artikel gefunden...
                    </div>
                </div>
            <?php else : ?>
                <div class="col-lg-8">
                    <div class="row justify-content-center">
                        <?php
                        $categoryId = $post['category_id'];
                        $postCategory = $db->query("SELECT * FROM categories WHERE id = $categoryId")->fetch();
                        ?>

                        <!-- Post Section -->
                        <div class="col">
                            <div class="card">
                                <img src="./uploads/posts/<?= $post['image'] ?>" class="card-img-top" alt="post-image" />
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <h5 class="card-title fw-bold">
                                            <?= htmlspecialchars($post['title']) ?>
                                        </h5>
                                        <div>
                                            <span class="badge text-bg-secondary"><?= htmlspecialchars($postCategory['title']) ?></span>
                                        </div>
                                    </div>
                                    <p class="card-text text-secondary text-justify pt-3">
                                        <?= $post['body'] ?>
                                    </p>
                                    <div>
                                        <p class="fs-6 mt-5 mb-0">
                                            Autor: <?= htmlspecialchars($post['author']) ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr class="mt-4" />

                        <!-- Comment Section -->
                        <div class="col">
                            <?php
                            $invalidInputName = '';
                            $invalidInputComment = '';
                            $message = '';

                            if (isset($_POST['postComment'])) {
                                if (empty(trim($_POST['name']))) {
                                    $invalidInputName = 'Das Namensfeld ist erforderlich.';
                                } elseif (empty(trim($_POST['comment']))) {
                                    $invalidInputComment = 'Das Kommentarfeld ist erforderlich.';
                                } else {
                                    $name = $_POST['name'];
                                    $comment = $_POST['comment'];

                                    $commentInsert = $db->prepare("INSERT INTO comments (name, comment, post_id, status) VALUES (:name , :comment , :post_id , 0)");
                                    $commentInsert->execute(['name' => $name, 'comment' => $comment, 'post_id' => $post['id']]);

                                    $message = "Ihr Kommentar wurde erfolgreich gespeichert und wird nach Freigabe angezeigt.";
                                }
                            }
                            ?>
                            <!-- Comment Form -->
                            <div class="card">
                                <div class="card-body">
                                    <p class="fw-bold fs-5">
                                        Kommentar schreiben
                                    </p>

                                    <form method="POST">
                                        <div class="text-success"><?= $message ?></div>
                                        <div class="mb-3">
                                            <label class="form-label">Name</label>
                                            <input type="text" name="name" class="form-control" />
                                            <div class="form-text text-danger"><?= $invalidInputName ?></div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Kommentartext</label>
                                            <textarea class="form-control" name="comment" rows="3"></textarea>
                                            <div class="form-text text-danger"><?= $invalidInputComment ?></div>
                                        </div>
                                        <button type="submit" name="postComment" class="btn btn-dark">
                                            Senden
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <hr class="mt-4" />
                            <!-- Comment Content -->
                            <?php
                            $postId = $post['id'];
                            $comments = $db->prepare("SELECT * FROM comments WHERE post_id = :id AND status = '1' ");
                            $comments->execute(['id' => $postId]);
                            ?>
                            <p class="fw-bold fs-6">Anzahl der Kommentare: <?= $comments->rowCount() ?></p>
                            <?php if ($comments->rowCount() > 0) : ?>
                                <?php foreach ($comments as $comment) : ?>
                                    <div class="card bg-light-subtle mb-3">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center">
                                                <img src="./assets/images/profile.png" width="45" height="45" alt="user-profile" />

                                                <h5 class="card-title me-2 mb-0">
                                                    <?= htmlspecialchars($comment['name']) ?>
                                                </h5>
                                            </div>

                                            <p class="card-text pt-3 pr-3">
                                                <?= htmlspecialchars($comment['comment']) ?>
                                            </p>
                                        </div>
                                    </div>
                                <?php endforeach ?>
                            <?php else : ?>
                                <div class="alert alert-danger" role="alert">
                                    Es wurden noch keine Kommentare zu diesem Artikel abgegeben.
                                </div>
                            <?php endif ?>
                        </div>
                    </div>
                </div>
            <?php endif ?>

            <?php
            include "./include/layout/sidebar.php";
            ?>
        </div>
    </section>
</main>

<?php
include "./include/layout/footer.php";
?>
