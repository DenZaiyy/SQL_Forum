<?php
// $categories = $result["data"]['categories'];
?>

<h1>List of categories</h1>

<?php
foreach ($categories as $category) {
?>
    <p><?= $category->getLabel() ?></p>
<?php
}
$title = "List of categories";
