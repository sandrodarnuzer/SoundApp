<?php

if (isset($_GET['id']) && isset($_GET['album'])) {
    $song_id = $_GET['id'];
    $album_id = $_GET['album'];

    $result = Database::query(
        'SELECT song_file FROM songs WHERE id=?',
        'i',
        $song_id,
    );

    if ($result->num_rows > 0) {
        $song = $result->fetch_assoc();
        $song_file = $song['song_file'];
        Database::query(
            'DELETE FROM songs WHERE id=?',
            'i',
            $song_id,
        );

        $file_path = $_SERVER['DOCUMENT_ROOT'] . rtrim(Config::BASE_PATH, '/') . '/files/' . $album_id . '/' . $song_file;
        unlink($file_path);
    }
    
}

redirect('/show?id='.$album_id);