<?php
include "../../include/layout/header.php";

// تبدیل اعداد فارسی به انگلیسی
function toEnglishNumbers($string) {
    $persian = ['۰','۱','۲','۳','۴','۵','۶','۷','۸','۹'];
    $english = ['0','1','2','3','4','5','6','7','8','9'];
    return str_replace($persian, $english, $string);
}

$categories = $db->query("SELECT * FROM categories ORDER BY id DESC");

if (isset($_GET['action']) && isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = $db->prepare('DELETE FROM categories WHERE id = :id');

    $query->execute(['id' => $id]);

    header("Location:index.php");
    exit();
}
?>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar Section -->
        <?php include "../../include/layout/sidebar.php" ?>

        <!-- Main Section -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="fs-3 fw-bold">Kategorien</h1>

                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="./create.php" class="btn btn-sm btn-dark">
                        Kategorie erstellen
                    </a>
                </div>
            </div>

            <!-- Categories -->
            <div class="mt-4">
                <?php if ($categories->rowCount() > 0) : ?>
                    <div class="table-responsive small">
                        <table class="table table-hover align-middle">
                            <thead>
                                <tr>
                                    <th>id</th>
                                    <th>Titel</th>
                                    <th>Aktionen</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($categories as $category) : ?>
                                    <tr>
                                        <th class="ltr"><?= toEnglishNumbers($category['id']) ?></th>
                                        <td><?= $category['title'] ?></td>
                                        <td>
                                            <a href="./edit.php?id=<?= $category['id'] ?>" class="btn btn-sm btn-outline-dark">Bearbeiten</a>
                                            <a href="index.php?action=delete&id=<?= $category['id'] ?>" class="btn btn-sm btn-outline-danger">Löschen</a>
                                        </td>
                                    </tr>
                                <?php endforeach ?>
                                
                            </tbody>
                        </table>
                    </div>
                <?php else : ?>
                    <div class="col">
                        <div class="alert alert-danger">
                            Keine Kategorien gefunden ...
                        </div>
                    </div>
                <?php endif ?>
            </div>
        </main>
    </div>
</div>

<?php include "../../include/layout/footer.php" ?>

?>
