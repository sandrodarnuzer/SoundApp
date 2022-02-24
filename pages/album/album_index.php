<?php

$result = Database::query("SELECT id, title, cover_file, description FROM album");

if ($result->num_rows > 0) {
    $albums = $result->fetch_all(MYSQLI_ASSOC);
}

?>
<main>
    <?php if (isset($albums)): ?>
        <div class="album-container">
            <?php foreach ($albums as $index_album => $album): ?>
                <div class="album hover">
                    <?php
                    $album_id = $album['id'];
                        $cover_path = get_file_path($album['cover_file'], $album_id);
                    ?>
                    <img src="<?=$cover_path?>" alt="" class="album-cover">
                    <div class="album-info">
                        <h2><?=$album['title']?></h2>
                        <?php
                            $result = Database::query(
                                "SELECT name, song_file, fid_album FROM songs WHERE fid_album=? LIMIT 3",
                                'i',
                                $album_id,
                            );
                            if ($result->num_rows > 0) {
                                $songs = $result->fetch_all(MYSQLI_ASSOC);
                                $songs = array_map(function ($song) {
                                    return array(
                                        'name' => $song['name'],
                                        'file' => get_file_path($song['song_file'], $song['fid_album']),
                                    );
                                }, $songs);
                            }
                        ?>
                        <?php if (isset($songs)): ?>
                            <div class="songs">
                                <?php foreach ($songs as $index_song => $song): ?>
                                    <div class="song" data-song="<?=$index_album + 1 . $index_song + 1?>">
                                        <audio>
                                            <source src="<?=$song['file']?>" type="audio/mp3">
                                            Your browser does not support the audio tag.
                                        </audio>
                                        <span class="song-title"><?=$song['name']?></span>
                                        <div class="song-buttons right">
                                            <button class="button-play control-buttons"><img src="assets/img/play.png" alt=""></button>
                                            <button class="button-stop control-buttons" disabled><img src="assets/img/stop.png" alt=""></button>
                                        </div>
                                    </div>
                                <?php endforeach ?>
                            </div>
                            <a href="<?=path_to("/show?id=${album_id}")?>" class="song-link">Album anzeigen</a>
                        <?php else: ?>
                            <h3>Keine Songs vorhanden</h3>
                            <div>
                                <a href="<?=path_to("/show?id=${album_id}")?>" class="song-link">Album anzeigen</a>
                            </div>
                        <?php endif ?>
                    </div>
                </div>
            <?php endforeach ?>
        </div>
    <?php else: ?>
        <h1>Keine Alben verhanden</h1>
    <?php endif ?>
</main>
<script>
    const songs = document.querySelectorAll(".song");

    let currentSong;

    songs.forEach(song => {
        const songNr = parseInt(song.dataset.song);
        const buttonPlay = song.querySelector(".song-buttons .button-play");
        const buttonStop = song.querySelector(".song-buttons .button-stop");
        const audio = song.querySelector("audio");
        buttonStop.disabled = true;

        buttonPlay.addEventListener("click", () => {
            playSong(songNr);
        });

        buttonStop.addEventListener("click", () => stopSong(songNr));
    });

    function playSong(songNr) {
        if (currentSong) stopSong(currentSong);
        const audio = document.querySelector("[data-song='" + songNr + "'] audio");
        const buttonStop = document.querySelector("[data-song='" + songNr + "'] .button-stop");
        buttonStop.disabled = false,
        audio.play();
        currentSong = songNr;
    }

    function stopSong(songNr) {
        const audio = document.querySelector("[data-song='" + songNr + "'] audio");
        const buttonStop = document.querySelector("[data-song='" + songNr + "'] .button-stop");
        buttonStop.disabled = true,
        audio.pause();
        audio.currentTime = 0;
        currentSong = null;
    }
</script>