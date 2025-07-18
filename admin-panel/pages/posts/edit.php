<?php
include "../../include/layout/header.php";

if (isset($_GET['id'])) {
    $postId = $_GET['id'];
    $post = $db->prepare('SELECT * FROM posts WHERE id = :id');
    $post->execute(['id' => $postId]);
    $post = $post->fetch();

    $categories = $db->query("SELECT * FROM categories");
}

$invalidInputTitle = '';
$invalidInputAuthor = '';
$invalidInputBody = '';

if (isset($_POST['editPost'])) {

    if (empty(trim($_POST['title']))) {
        $invalidInputTitle = 'Das Feld für den Artikeltitel ist erforderlich.';
    }

    if (empty(trim($_POST['author']))) {
        $invalidInputAuthor = 'Das Feld für den Autor ist erforderlich.';
    }

    if (empty(trim($_POST['body']))) {
        $invalidInputBody = 'Das Textfeld des Artikels ist erforderlich.';
    }

    if (!empty(trim($_POST['title'])) && !empty(trim($_POST['author'])) && !empty(trim($_POST['body']))) {
        $title = $_POST['title'];
        $author = $_POST['author'];
        $body = $_POST['body'];
        $categoryId = $_POST['categoryId'];

        if (!empty(trim($_FILES['image']['name']))) {
            $nameImage = time() . "_" . $_FILES['image']['name'];
            $tmpName = $_FILES['image']['tmp_name'];

            if (move_uploaded_file($tmpName, "../../../uploads/posts/$nameImage")) {
                $postUpdate = $db->prepare("UPDATE posts SET title =:title, author=:author, category_id=:categoryId, body=:body, image=:image WHERE id=:id");
                $postUpdate->execute(['title' => $title, 'author' => $author, 'categoryId' => $categoryId, 'body' => $body, 'id' => $postId, 'image' => $nameImage]);
            } else {
                echo "Fehler beim Hochladen";
            }
        } else {
            $postUpdate = $db->prepare("UPDATE posts SET title =:title, author=:author, category_id=:categoryId, body=:body WHERE id=:id");
            $postUpdate->execute(['title' => $title, 'author' => $author, 'categoryId' => $categoryId, 'body' => $body, 'id' => $postId]);
        }

        header("Location:index.php");
        exit();
    }
}

?>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar Section -->
        <?php
        include "../../include/layout/sidebar.php"
        ?>

        <!-- Main Section -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 mb-5">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="fs-3 fw-bold">Artikel bearbeiten</h1>
            </div>

            <!-- Posts -->
            <div class="mt-4">
                <form method="post" class="row g-4" enctype="multipart/form-data">
                    <div class="col-12 col-sm-6 col-md-4">
                        <label class="form-label">Artikeltitel</label>
                        <input type="text" name="title" class="form-control" value="<?= $post['title'] ?>" />
                        <div class="form-text text-danger"><?= $invalidInputTitle ?></div>
                    </div>

                    <div class="col-12 col-sm-6 col-md-4">
                        <label class="form-label">Autor</label>
                        <input type="text" name="author" class="form-control" value="<?= $post['author'] ?>" />
                        <div class="form-text text-danger"><?= $invalidInputAuthor ?></div>
                    </div>

                    <div class="col-12 col-sm-6 col-md-4">
                        <label class="form-label">Kategorie</label>
                        <select name="categoryId" class="form-select">
                            <?php if ($categories->rowCount() > 0) : ?>
                                <?php foreach ($categories as $category) : ?>
                                    <option <?= ($category['id'] == $post['category_id']) ? 'selected' : '' ?> value="<?= $category['id'] ?>"><?= $category['title'] ?></option>
                                <?php endforeach ?>
                            <?php endif ?>
                        </select>
                    </div>

                    <div class="col-12 col-sm-6 col-md-4">
                        <label for="formFile" class="form-label">Artikelbild</label>
                        <input name="image" class="form-control" type="file" />
                    </div>

                    <div class="col-12">
                        <label for="formFile" class="form-label">Artikeltext</label>
                        <textarea name="body" class="form-control" rows="8"><?= $post['body'] ?></textarea>
                        <div class="form-text text-danger"><?= $invalidInputBody ?></div>
                    </div>

                    <div class="col-12 col-sm-6 col-md-4">
                        <img class="rounded" src="../../../uploads/posts/<?= $post['image'] ?>" width="300" />
                    </div>

                    <div class="col-12">
                        <button name="editPost" type="submit" class="btn btn-dark">
                            Bearbeiten
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</div>

<?php
include "../../include/layout/footer.php"
?>
