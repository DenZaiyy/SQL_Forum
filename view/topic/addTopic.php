<?php
$title = "Add a topic";
?>
<div class="addTopic">
    <h1>add new topic</h1>
    <form action="index.php?ctrl=forum&action=addTopic&id=<?= $_GET['id'] ?>" method="post">
        <div class="title">
            <label for="title">Title</label><input type="text" name="title" required>
        </div>
        <div class="firstMessage">
            <label for="message">Message</label><textarea name="message" required></textarea>
        </div>
        <button type="submit">Add topic</button>
    </form>
</div>