<?php $topic = $result["data"]['topic'];
?>
<div class="card-topic">
    <div class="infos">
        <h4>posted by :</h4>
    </div>
    <div class="preview">
        <p><?= $topic->getTitle() ?></p>
    </div>
    <div class="btns">
        <div class="comments">
            <a href="">
                <i class="fa-solid fa-comment"></i>
                Comments
            </a>
        </div>
        <div class="share">
            <a href="">
                <i class="fa-solid fa-retweet"></i>
                Share
            </a>
        </div>
        <div class="save">
            <a href="">
                <i class="fa-solid fa-bookmark"></i>
                Save
            </a>
        </div>
    </div>
</div>
<?php
$title = "Details topic";
