<?php

if (isset($_GET['id'])) {
    $album_id = $_GET['id'];

    $result = Database::query(
        'SELECT id FROM album WHERE id=?',
        'i',
        $album_id,
    );

    if ($result->num_rows > 0) {
        Database::query(
            'DELETE FROM album WHERE id=?',
            'i',
            $album_id,
        );
        Database::query(
            'DELETE FROM songs WHERE fid_album=?',
            'i',
            $album_id,
        );

        $folder_path = $_SERVER['DOCUMENT_ROOT'] . rtrim(Config::BASE_PATH, '/') . '/files/' . $album_id;
        delete_folder($folder_path);
    }
    
}


redirect('/');