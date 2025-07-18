<?php
include "../../include/layout/header.php";

$categories = $db->query("SELECT * FROM categories");

$invalidInputTitle = '';
$invalidInputAuthor = '';
$invalidInputImage = '';
$invalidInputBody = '';

if (isset($_POST['addPost'])) {

    if (empty(trim($_POST['title']))) {
        $invalidInputTitle = 'Das Feld für den Artikeltitel ist erforderlich.';
    }

    if (empty(trim($_POST['author']))) {
        $invalidInputAuthor = 'Das Feld für den Autor ist erforderlich.';
    }

    if (empty(trim($_FILES['image']['name']))) {
        $invalidInputImage = 'Das Bildfeld ist erforderlich.';
    }

    if (empty(trim($_POST['body']))) {
        $invalidInputBody = 'Das Textfeld des Artikels ist erforderlich.';
    }

    if (!empty(trim($_POST['title'])) && !empty(trim($_POST['author'])) && !empty(trim($_FILES['image']['name'])) && !empty(trim($_POST['body']))) {
        $title = $_POST['title'];
        $author = $_POST['author'];
        $body = $_POST['body'];
        $categoryId = $_POST['categoryId'];

        $nameImage = time() . "_" . $_FILES['image']['name'];
        $tmpName = $_FILES['image']['tmp_name'];

        if (move_uploaded_file($tmpName, "../../../uploads/posts/$nameImage")) {
            $postInsert = $db->prepare("INSERT INTO posts (title, author, category_id, body, image) VALUES (:title, :author, :category_id, :body, :image)");
            $postInsert->execute(['title' => $title, 'author' => $author, 'category_id' => $categoryId, 'body' => $body, 'image' => $nameImage]);

            header("Location:index.php");
            exit();
        } else {
            echo "Fehler beim Hochladen";
        }
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
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="fs-3 fw-bold">Artikel erstellen</h1>
            </div>

            <!-- Create Post -->
            <div class="mt-4">
                <form method="post" class="row g-4" enctype="multipart/form-data">
                    <div class="col-12 col-sm-6 col-md-4">
                        <label class="form-label">Artikeltitel</label>
                        <input type="text" name="title" class="form-control" />
                        <div class="form-text text-danger"><?= $invalidInputTitle ?></div>
                    </div>

                    <div class="col-12 col-sm-6 col-md-4">
                        <label class="form-label">Autor</label>
                        <input type="text" name="author" class="form-control" />
                        <div class="form-text text-danger"><?= $invalidInputAuthor ?></div>
                    </div>

                    <div class="col-12 col-sm-6 col-md-4">
                        <label class="form-label">Kategorie</label>
                        <select name="categoryId" class="form-select">
                            <?php if ($categories->rowCount() > 0) : ?>
                                <?php foreach ($categories as $category) : ?>
                                    <option value="<?= $category['id'] ?>"><?= $category['title'] ?></option>
                                <?php endforeach ?>
                            <?php endif ?>
                        </select>
                    </div>

                    <div class="col-12 col-sm-6 col-md-4">
                        <label for="formFile" class="form-label">Artikelbild</label>
                        <input class="form-control" name="image" type="file" />
                        <div class="form-text text-danger"><?= $invalidInputImage ?></div>
                    </div>

                    <div class="col-12">
                        <label for="formFile" class="form-label">Artikeltext</label>
                        <textarea class="form-control" name="body" rows="6"></textarea>
                        <div class="form-text text-danger"><?= $invalidInputBody ?></div>
                    </div>

                    <div class="col-12">
                        <button type="submit" name="addPost" class="btn btn-dark">
                            Erstellen
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
