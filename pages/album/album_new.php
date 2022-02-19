<main>
    <div class="center">
        <form action="create" method="post" enctype="multipart/form-data" name="albumform">
            <div class="form-container">
    
                <div class="form-item">
                    <label for="albumtitle">Titel</label>
                    <input type="text" name="albumtitle" id="albumtitle" required>
                </div>
                <div class="form-item">
                    <label for="albumdescription">Beschreibung</label>
                    <textarea name="albumdescription" id="albumdescription" cols="30" rows="10" required></textarea>
                </div>
                <div class="form-item">
                    <label for="albumcover">Album Cover</label>
                    <input type="file" name="albumcover" id="albumcover" accept=".jpeg, .jpg, .png, .gif" required>
                </div>
                <div class="form-item">
                    <label for="albumsongs">Musiktitel</label>
                    <button type="button" id="addsong">Add</button>
                    <input type="hidden" name="songsadded" id="songsadded">
                </div>
                <div class="songfiles"></div>
                <div class="form-item">
                    <button class="large" type="button" name="createalbum" id="createalbum">Erstellen</button>
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
    const buttonCreateAlbum = document.getElementById('createalbum');
    const albumForm = document.forms['albumform'];

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
    
    buttonCreateAlbum.addEventListener('click', () => {
        if (songFiles.childElementCount < 1 || !albumForm.checkValidity()) {
            document.getElementById('error-message').innerText = "Formular nicht korrekt ausgefüllt";
            return;
        }
        document.getElementById('songsadded').value = songsAdded;
        albumForm.submit();
    });
</script>
