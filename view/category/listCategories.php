<h1>List of categories</h1>
<div class="categories">
    <?php
    foreach ($_SESSION['categories'] as $category) {
    ?>
        <a href="index.php?ctrl=forum&action=detailCategory&id=<?= $category->getId() ?>">
            <div class="category">
                <p><?= $category->getLabel() ?></p>
            </div>
        </a>
    <?php
    }
    $title = "List of categories";
    ?>
</div>