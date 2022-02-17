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

    <?php if (isset($album)): ?>
        <div>
            <h1><?= $album['title'] ?></h1>
            <p><?= $album['description'] ?></p>
            <img src="<?= $cover_path ?>" alt="Cover" class="album-cover">
            <?php foreach ($songs as $index => $song) : ?>

                <div class="song" data-song="<?=$index + 1?>">
                    <audio>
                        <source src="<?=$song['file']?>" type="audio/mp3">
                        Your browser does not support the audio tag.
                    </audio>
                    <span><?=$song['name']?></span>
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
<script>
    const songs = document.querySelectorAll(".song");
    let queue = [];

    document.querySelector(".button-all").addEventListener("click" , () => {
        for (let i = 1; i <= songs.length; i++) {
            queue.push(i);
        }
        playNext();
    });

    let currentSong;

    songs.forEach(song => {
        const songNr = parseInt(song.dataset.song);
        const buttonPlay = song.querySelector(".button-play");
        const buttonStop = song.querySelector(".button-stop");
        const buttonQueue = song.querySelector(".button-queue");
        const audio = song.querySelector("audio");
        buttonStop.disabled = true;

        buttonPlay.addEventListener("click", () => {
            queue.unshift(songNr);
            playNext();
        });

        buttonStop.addEventListener("click", () => stopSong(songNr));

        buttonQueue.addEventListener("click", () => queue.push(songNr));

        audio.addEventListener("ended", () => {
            stopSong(songNr);
            if (queue.length) playNext();
        });
    });

    function playNext() {
        playSong(queue.shift());
    }

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