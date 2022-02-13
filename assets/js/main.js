const songs = document.querySelectorAll(".song");

if (songs) (() => {
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
}).call();

