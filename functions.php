<?php
function render(string $page) {
    include $_SERVER['DOCUMENT_ROOT'] . rtrim(Config::BASE_PATH, '/') . '/components/' . 'header.php';
    include $_SERVER['DOCUMENT_ROOT'] . rtrim(Config::BASE_PATH, '/') . '/pages/' . $page . '.php';
    include $_SERVER['DOCUMENT_ROOT'] . rtrim(Config::BASE_PATH, '/') . '/components/' . 'footer.php';
}

function pre($content) {
    echo "<pre>";
    print_r($content);
    echo "</pre>";
}

function redirect(string $path) {
    $path = rtrim(Config::BASE_PATH, '/') . $path;
    header("Location: ${path}");
    exit();
}

function path_to($destination) {
    return rtrim(Config::BASE_PATH, '/') . $destination;
}

function get_mime_type(string $file_path): string {
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    return $finfo->file($file_path);
}

function check_file_types(array $files, array $file_types) {
    foreach ($files as $file) {
        if (!in_array(get_mime_type($file['file']), $file_types)) return false;
    }
    return true;
}

function check_file_type(array $file, array $file_types) {
    if (!in_array(get_mime_type($file['tmp_name']), $file_types)) return false;
    return true;
}

function get_files(array $files, array $data) {
    for ($i = 0; $i < $data['songsadded']; $i++) {
        if (isset($files["albumsongfile-${i}"]) && isset($data["albumsongname-${i}"])) {
            yield array(
                'name' => $data["albumsongname-${i}"],
                'file' => $files["albumsongfile-${i}"]['tmp_name'],
                'file_name' => $files["albumsongfile-${i}"]['name'],
            );
        }
    }
}

function get_file_path($cover_file, $album_id) {
    return rtrim(Config::BASE_PATH, '/') . '/files/' . $album_id . '/' . $cover_file; 
}

function delete_folder($folder) {
    if (is_dir($folder)) { 
        $files = scandir($folder);
        foreach ($files as $file) { 
            if ($file != "." && $file != "..") { 
                unlink($folder. DIRECTORY_SEPARATOR .$file); 
            }
        }
        rmdir($folder); 
    }
}

function square_image($image_path, $type) {

    switch ($type) {
        case 'jpeg':
        case 'jpg':
            $image = imagecreatefromjpeg($image_path);
            break;
        case 'png':
            $image = imagecreatefrompng($image_path);
            break;
        case 'gif':
            $image = imagecreatefromgif($image_path);
            break;
    }

    if (imagesx($image) === imagesy($image)) return imagedestroy($image);
    $size = min(imagesx($image), imagesy($image));
    $cropped = imagecrop($image, ['x' => 0, 'y' => 0, 'width' => $size, 'height' => $size]);
    if ($cropped !== FALSE) {
        switch ($type) {
            case 'jpeg':
            case 'jpg':
                imagejpeg($cropped, $image_path);
                break;
            case 'png':
                imagepng($cropped, $image_path);
                break;
            case 'gif':
                imagegif($cropped, $image_path);
                break;
        }
        imagedestroy($cropped);
    }
    imagedestroy($image);
}