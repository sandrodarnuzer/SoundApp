<?php
if (isset($_POST['createalbum'])) {
    $title = $_POST['albumtitle'];
    $description = $_POST['albumdescription'];

    $cover_file = $_FILES['albumcover'];
    $song_files = iterator_to_array(get_files($_FILES, $_POST));
    pre($song_files);


    if (check_file_type($cover_file, Config::IMAGE_TYPES) && check_file_types($song_files, Config::AUDIO_TYPES)) {

        $cover_file_name = uniqid().'.jpg';

        Database::query(
            "INSERT INTO album (title, description, cover_file) VALUES (?, ?, ?)",
            'sss',
            $title, $description, $cover_file_name,
        );

        $album_id = Database::$insert_id;

        $folder_path = $_SERVER['DOCUMENT_ROOT'] . rtrim(Config::BASE_PATH) . '/files/' . $album_id;
        $cover_file_path = $folder_path . '/' . $cover_file_name;


        if (!file_exists($folder_path)) {
            mkdir($folder_path, 0777, true);
        }

        move_uploaded_file($cover_file['tmp_name'], $cover_file_path);

        foreach ($song_files as $song_file) {
            $song_file_name = uniqid(). '.mp3';
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
}
redirect('/');