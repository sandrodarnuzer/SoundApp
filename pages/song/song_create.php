<?php
if (isset($_POST['songsadded'])) {
    $song_files = iterator_to_array(get_files($_FILES, $_POST));
    $album_id = $_POST['album'];

    if (check_file_types($song_files, Config::AUDIO_TYPES)) {

        $folder_path = $_SERVER['DOCUMENT_ROOT'] . rtrim(Config::BASE_PATH, '/') . '/files/' . $album_id;

        foreach ($song_files as $song_file) {
            $song_file_type = pathinfo($song_file['file_name'], PATHINFO_EXTENSION);
            $song_file_name = uniqid().'.'.$song_file_type;
            $song_name = $song_file['name'];
            
            Database::query(
                "INSERT INTO songs (fid_album, song_file, name) VALUES (?, ?, ?)",
                'iss',
                $album_id, $song_file_name, $song_name
            );

            $song_file_path = $folder_path . '/' . $song_file_name;
            move_uploaded_file($song_file['file'], $song_file_path);
        }
    }
    redirect("/show?id=${album_id}");
}
redirect("/");