<?php
//check if user is connected
if (!App\Session::getUser()) {
    header('Location: index.php?ctrl=security&action=loginForm');
} else {
    $title = "Edit a topic";
    $topic = $result['data']['topic'];
    $firstMessage = $result['data']['firstMessage'];
?>
    <div class="addTopic">
        <h1>Edit topic</h1>
        <form action="index.php?ctrl=forum&action=editTopic&id=<?= $_GET['id'] ?>" method="post">
            <div class="category">
                <label for="category">Category</label>
                <select name="category">
                    <?php
                    foreach ($_SESSION['categories'] as $category) {
                        if ($category->getId() == $topic->getCategory()->getId()) {
                            echo "<option value='" . $category->getId() . "' selected>" . $category->getLabel() . "</option>";
                        } else {
                            echo "<option value='" . $category->getId() . "'>" . $category->getLabel() . "</option>";
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="title" style="margin-top: 10px;">
                <label for="title">Title</label><input type="text" name="title" value="<?= $topic->getTitle() ?>" required>
            </div>
            <div class="firstMessage">
                <label for="message">Message</label><textarea name="message" required><?= $firstMessage->getMessage() ?></textarea>
            </div>
            <button type="submit">Edit topic</button>
        </form>
    </div>
<?php } ?>