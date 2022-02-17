<?php
if (isset($_GET['id'])) {
    $album_id = $_GET['id'];

    $result = Database::query(
        "SELECT title, cover_file, description FROM album WHERE id=?",
        'i',
        $album_id,
    );
    if ($result->num_rows > 0) {
        $album = $result->fetch_assoc();
        $cover_path = get_file_path($album['cover_file'], $album_id);
    
    
        $result = Database::query(
            "SELECT song_file, fid_album FROM songs WHERE fid_album=?",
            'i',
            $album_id,
        );
        $songs = $result->fetch_all(MYSQLI_ASSOC);
        $songs = array_map(function ($song) {
            return get_file_path($song['song_file'], $song['fid_album']);
        }, $songs);
    }
}
?>
<main>

    <?php if (isset($album)): ?>
        <div>
            <h1><?= $album['title'] ?></h1>
            <p><?= $album['description'] ?></p>
            <img src="<?= $cover_path ?>" alt="Cover" height="100px">
            <?php foreach ($songs as $index => $song) : ?>

                <div class="song" data-song="<?=$index + 1?>">
                    <audio>
                        <source src="<?=$song?>" type="audio/mp3">
                        Your browser does not support the audio tag.
                    </audio>
                    <span><?=$index?></span>
                    <button class="button-play">Play</button>
                    <button class="button-stop">Stop</button>
                    <button class="button-queue">Add Queue</button>
                </div>

            <?php endforeach ?>
            <button class="button-all">Play all</button>
        </div>
    <?php else: ?>
        <h1>No album</h1>
    <?php endif ?>
</main>