<?php require 'View/includes/header.php'?>

<?php // Use any data loaded in the controller here ?>

    <section>
        <h1><?= $article->title ?></h1>
        <p><?= $article->formatPublishDate() ?></p>
        <p><?= $article->description ?></p>
        <?= $article->getImage() ?>
        <br>

        <?php // TODO: links to next and previous ?>
        <a href="index.php?page=detail&id=<?= $previd ?>">Previous article</a>
        <a href="index.php?page=detail&id=<?= $nextid ?>">Next article</a>
    </section>

<?php require 'View/includes/footer.php'?>