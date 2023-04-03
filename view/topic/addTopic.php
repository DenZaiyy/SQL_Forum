<?php
$title = "Add a topic";
?>
<div class="addTopic">
    <h1>add new topic</h1>
    <form method="POST" action="index.php?ctrl=forum&action=addTopic&id=<?= $_GET['id'] ?>">
        <input type="hidden" name="_token" value="<?= $_SESSION['_token'] ?>">
        <div class="title">
            <label for="title">Title</label><input type="text" name="title" required>
        </div>
        <div class="firstMessage">
            <label for="message">Message</label><textarea name="message" required></textarea>
        </div>
        <button type="submit">Add topic</button>
    </form>
</div>