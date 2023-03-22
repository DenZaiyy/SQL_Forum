<?php

$topics = $result["data"]['topics'];

?>

<h1>List of topics</h1>

<?php
foreach ($topics as $topic) {

?>
    <p><?= $topic->getTitle() ?></p>
<?php
}
$title = "List of topics";
