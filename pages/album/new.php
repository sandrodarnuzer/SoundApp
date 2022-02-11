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
        <input type="file" name="albumsongs[]" id="albumsongs" multiple>
        <br>
        <button type="submit" name="createalbum">Hinzufügen</button>
    </form>
</main>
