<main>
    <h1>Neues Album</h1>
    <form action="create" method="post" enctype="multipart/form-data" name="albumform">
        <label for="albumtitle">Titel</label>
        <br>
        <input type="text" name="albumtitle" id="albumtitle" required>
        <br>
        <label for="albumdescription">Beschreibung</label>
        <br>
        <textarea name="albumdescription" id="albumdescription" cols="30" rows="10" required></textarea>
        <br>
        <label for="albumcover">Album Cover</label>
        <br>
        <input type="file" name="albumcover" id="albumcover" accept=".jpeg, .jpg, .png, .gif" required>
        <br>
        <label for="albumsongs">Musiktitel</label>
        <button type="button" id="addsong">Add</button>
        <br>
        <input type="hidden" name="songsadded" id="songsadded">
        <div class="songfiles">
            
        </div>
        <br>
        <button class="large" type="button" name="createalbum" id="createalbum">Erstellen</button>
    </form>
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
        if (songFiles.childElementCount < 1 || !albumForm.checkValidity()) return;
        document.getElementById('songsadded').value = songsAdded;
        albumForm.submit();
    });
</script>
