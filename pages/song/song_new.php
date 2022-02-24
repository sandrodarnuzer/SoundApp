<?php
    if (!isset($_GET['album'])) redirect('/');
    $album_id = $_GET['album'];

    $result = Database::query(
        'SELECT id, title FROM album WHERE id=?',
        'i',
        $album_id,
    );

    if ($result->num_rows < 1) redirect('/');
    $album = $result->fetch_assoc();
?>
<main>
    <div class="center">
        <form action="<?=path_to('/song/create')?>" method="post" enctype="multipart/form-data" name="songform">
            <div class="form-container">
    
                <h2>Songs hinzufügen</h2>
                <h3><?=$album['title']?></h3>
                <input type="hidden" name="album" value="<?=$album_id?>">
                <div class="form-item">
                    <label for="albumsongs">Musiktitel</label>
                    <button type="button" id="addsong">Add</button>
                    <input type="hidden" name="songsadded" id="songsadded">
                </div>
                <div class="songfiles"></div>
                <div class="form-item">
                    <button class="large" type="button" name="createsongs" id="createsongs">Hinzufügen</button>
                </div>
                <span id="error-message"></span>
            </div>
        </form>
    </div>
</main>
<script>
    let songsAdded = 0;
    const songFiles = document.querySelector('.songfiles');
    const buttonAddSong = document.getElementById('addsong');
    const buttonCreateSongs = document.getElementById('createsongs');
    const songForm = document.forms['songform'];

    buttonAddSong.addEventListener('click', () => {
        const songFile = document.createElement('div');
        songFile.setAttribute('id', `songfile-${songsAdded}`);
        songFile.setAttribute('class', 'songfile');
        songFile.innerHTML = `
            <button class="button-remove" type="button" id="button-remove-${songsAdded}" data-songfile="${songsAdded}" tabindex="-1">&minus;</button>
            <input type="text" name="albumsongname-${songsAdded}" required>
            <input type="file" name="albumsongfile-${songsAdded}" accept=".mp3, .ogg" required>
        `;
        songFiles.append(songFile);

        document.getElementById(`button-remove-${songsAdded}`).addEventListener('click', e => {
            const songNr = e.target.dataset.songfile;
            document.getElementById(`songfile-${songNr}`).remove();
        });
        songsAdded++;
    });
    
    buttonCreateSongs.addEventListener('click', () => {
        if (songFiles.childElementCount < 1 || !songForm.checkValidity()) {
            document.getElementById('error-message').innerText = "Formular nicht korrekt ausgefüllt";
            return;
        }
        document.getElementById('songsadded').value = songsAdded;
        songForm.submit();
    });
</script>
