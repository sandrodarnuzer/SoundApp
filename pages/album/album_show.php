<?php
if (isset($_GET['id'])) {
    $album_id = $_GET['id'];

    $result = Database::query(
        "SELECT id, title, cover_file, description FROM album WHERE id=?",
        'i',
        $album_id,
    );
    if ($result->num_rows > 0) {
        $album = $result->fetch_assoc();
        $cover_path = get_file_path($album['cover_file'], $album_id);
    
    
        $result = Database::query(
            "SELECT name, song_file, fid_album FROM songs WHERE fid_album=?",
            'i',
            $album_id,
        );
        $songs = $result->fetch_all(MYSQLI_ASSOC);
        $songs = array_map(function ($song) {
            return array(
                'name' => $song['name'],
                'file' => get_file_path($song['song_file'], $song['fid_album']),
            );
        }, $songs);
    }
}
?>
<main>
    <div class="center">
        <?php if (isset($album)): ?>
            <div class="album flex-column">
                <?php
                    $album_id = $album['id'];
                    $cover_path = get_file_path($album['cover_file'], $album_id);
                ?>
                <img src="<?=$cover_path?>" alt="" class="album-cover large-cover">
                
                <div class="album-info">
                    <h2><?=$album['title']?></h2>
                    <?php
                        $result = Database::query(
                            "SELECT id, name, song_file, fid_album FROM songs WHERE fid_album=?",
                            'i',
                            $album_id,
                        );
                        if ($result->num_rows > 0) {
                            $songs = $result->fetch_all(MYSQLI_ASSOC);
                            $songs = array_map(function ($song) {
                                return array(
                                    'name' => $song['name'],
                                    'file' => get_file_path($song['song_file'], $song['fid_album']),
                                    'album' => $song['fid_album'],
                                    'id' => $song['id'],
                                );
                            }, $songs);
                        }
                    ?>
                    <?php if (isset($songs)): ?>
                        <div class="songs">
                            <?php foreach ($songs as $index_song => $song): ?>
                                <div class="song" data-song="<?=$index_song + 1?>">
                                    <audio>
                                        <source src="<?=$song['file']?>" type="audio/mp3">
                                        Your browser does not support the audio tag.
                                    </audio>
                                    <span class="song-title"><?=$song['name']?></span>
                                    <div class="song-buttons right">
                                        <button class="button-play control-buttons"><img src="assets/img/play.png" alt=""></button>
                                        <button class="button-queue control-buttons"><img src="assets/img/add-list.png" alt=""></button>
                                        <a href="<?=path_to("/song/delete?id=${song['id']}&album=${song['album']}")?>"><button class="control-buttons button-delete"><img src="assets/img/trash.png" alt=""></button></a>
                                    </div>
                                </div>
                            <?php endforeach ?>
                            <div class="song-buttons center">
                                <button class="control-buttons" id="button-stop" disabled><img src="assets/img/stop.png" alt=""></button>
                                <button class="control-buttons" id="button-play-pause"><img id="icon-play-pause" src="assets/img/play.png" alt=""></button>
                                <button class="control-buttons" id="button-next"><img src="assets/img/fast-forward.png" alt=""></button>
                            </div>
                        </div>
                        <?php else: ?>
                            <h3>Keine Songs vorhanden</h3>
                            <?php endif ?>
                            <a href="<?=path_to("/delete?id=${album_id}")?>" class="delete-link">Album Löschen</a>
                </div>
            </div>

        <?php else: ?>
            <h1>No album</h1>
        <?php endif ?>
    </div>
</main>
<script>
    const songs = document.querySelectorAll(".song");
    const buttonPlayPause = document.getElementById('button-play-pause');
    const iconPlayPause = document.getElementById('icon-play-pause');
    const buttonNext = document.getElementById('button-next');
    const buttonStop = document.getElementById('button-stop');

    let queue = [];
    let isPlaying = false;
    let currentSong;

    buttonPlayPause.addEventListener('click' , () => {
        if (currentSong) {
            if (isPlaying) stopSong(currentSong, true);
            else playSong(currentSong);
        } else {
            for (let i = 1; i <= songs.length; i++) {
                queue.push(i);
            }
            playNext();
        }
    });

    buttonNext.addEventListener('click', () => {
        if (queue.length) playNext();
    });

    buttonStop.addEventListener('click', () => {
        if (currentSong) {
            stopSong(currentSong);
        }
        isPlaying = false;
        queue = [];
        iconPlayPause.src = "assets/img/play.png";
        buttonStop.disabled = true;
    });


    songs.forEach(song => {
        const songNr = parseInt(song.dataset.song);
        const buttonPlay = song.querySelector(".song-buttons .button-play");
        const buttonQueue = song.querySelector(".song-buttons .button-queue");
        const audio = song.querySelector("audio");

        buttonPlay.addEventListener('click', () => {
            queue.unshift(songNr);
            playNext();
        });

        buttonQueue.addEventListener('click', () => queue.push(songNr));

        audio.addEventListener('ended', () => {
            if (queue.length) playNext();
        });
    });

    function playNext() {
        playSong(queue.shift());
    }

    function playSong(songNr) {
        if (currentSong && currentSong != songNr) stopSong(currentSong);
        const audio = document.querySelector("[data-song='" + songNr + "'] audio");
        const buttonPlay = document.querySelector("[data-song='" + songNr + "'] .button-play");
        buttonPlay.disabled = true;
        buttonStop.disabled = false;
        audio.play();
        currentSong = songNr;
        togglePlayPause();
    }

    function stopSong(songNr, pause = false) {
        const audio = document.querySelector("[data-song='" + songNr + "'] audio");
        const buttonPlay = document.querySelector("[data-song='" + songNr + "'] .button-play");
        audio.pause();
        if (!pause) {
            buttonPlay.disabled = false;
            audio.currentTime = 0;
            currentSong = null;
        }
        togglePlayPause();
    }

    function togglePlayPause() {
        if (!currentSong) return;
        if (isPlaying) iconPlayPause.src = "assets/img/play.png";
        else iconPlayPause.src = "assets/img/pause.png";
        isPlaying = !isPlaying;
    }
</script>