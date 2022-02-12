<?php
if (isset($_GET['id'])) {
    $album_id = $_GET['id'];

    $result = Database::query(
        "SELECT title, cover_file, description FROM album WHERE id=?",
        'i',
        $album_id,
    );
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
?>
<main>

    <div>
        <h1><?= $album['title'] ?></h1>
        <p><?= $album['description'] ?></p>
        <img src="<?= $cover_path ?>" alt="Cover" height="100px">
        <?php foreach ($songs as $song) : ?>
            <div>
                <audio controls>
                    <source src="<?=$song?>" type="audio/mp3">
                    Your browser does not support the audio tag.
                </audio>
            </div>
        <?php endforeach ?>
    </div>

</main>