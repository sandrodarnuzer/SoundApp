<main>
    <h1>Neues Album</h1>
    <form action="create" method="post" enctype="multipart/form-data">
        <label for="albumtitle">Titel</label>
        <br>
        <input type="text" name="albumtitle" id="albumtitle">
        <br>
        <label for="albumdescription">Beschreibung</label>
        <br>
        <textarea name="albumdescription" id="albumdescription" cols="30" rows="10"></textarea>
        <br>
        <label for="albumcover">Album Cover</label>
        <br>
        <input type="file" name="albumcover" id="albumcover" accept=".jpeg, .jpg, .png, .gif">
        <br>
        <label for="albumsongs">Musiktitel</label>
        <br>
        <div class="songfiles">
            
        </div>
        <button type="button" id="addsong">Add</button>
        <br>
        <button type="submit" name="createalbum">Hinzufügen</button>
    </form>
</main>
<script>
    let songsAdded = 0;
    const songFiles = document.querySelector('.songfiles');
    const buttonAddSong = document.getElementById('addsong');

    buttonAddSong.addEventListener('click', () => {
        songsAdded++;
        const songFile = document.createElement('div');
        songFile.setAttribute('id', `songfile-${songsAdded}`);
        songFile.innerHTML = `
            <button type="button" id="button-remove-${songsAdded}" data-songfile="${songsAdded}">Remove</button>
            <input type="text" name="albumsongname-${songsAdded}" id="albumsongname-${songsAdded}">
            <input type="file" name="albumsongfile-${songsAdded}" id="albumsongfile-${songsAdded}" multiple accept=".mp3, .ogg">
        `;
        songFiles.append(songFile);
        document.getElementById(`button-remove-${songsAdded}`).addEventListener('click', e => {
            const songNr = e.target.dataset.songfile;
            document.getElementById(`songfile-${songNr}`).remove();
        });
    });
</script>
