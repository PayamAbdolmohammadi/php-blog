<?php
include "../../include/layout/header.php";

if (isset($_GET['id'])) {
    $categoryId = $_GET['id'];

    $category = $db->prepare('SELECT * FROM categories WHERE id = :id');
    $category->execute(['id' => $categoryId]);
    $category = $category->fetch();
}

if (isset($_POST['editCategory'])) {
    if (!empty(trim($_POST['title']))) {
        $title = $_POST['title'];
        $categoryUpdate = $db->prepare("UPDATE categories SET title =:title WHERE id=:id");
        $categoryUpdate->execute(['title' => $title, 'id' => $categoryId]);

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
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="fs-3 fw-bold">Kategorie bearbeiten</h1>
            </div>

            <!-- Posts -->
            <div class="mt-4">
                <form method="post" class="row g-4">
                    <div class="col-12 col-sm-6 col-md-4">
                        <label class="form-label">Kategorietitel</label>
                        <input type="text" name="title" class="form-control" value="<?= $category['title'] ?>" />
                    </div>

                    <div class="col-12">
                        <button name="editCategory" type="submit" class="btn btn-dark">
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
