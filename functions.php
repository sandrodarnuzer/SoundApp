<?php
function render(string $page) {
    include $_SERVER['DOCUMENT_ROOT'] . '/' . Config::BASE_PATH . 'components/' . 'header.php';
    include $_SERVER['DOCUMENT_ROOT'] . '/' . Config::BASE_PATH . 'pages/' . $page . '.php';
    include $_SERVER['DOCUMENT_ROOT'] . '/' . Config::BASE_PATH . 'components/' . 'footer.php';
}

function pre($content) {
    echo "<pre>";
    print_r($content);
    echo "</pre>";
}

function redirect(string $path) {
    $path = '/' . rtrim(Config::BASE_PATH, '/') . $path;
    header("Location: ${path}");
    exit();
}

function get_mime_type(string $file_path): string {
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    return $finfo->file($file_path);
}

function check_file_types(array $files, array $file_types) {
    foreach ($files as $file) {
        if (!in_array(get_mime_type($file['tmp_name']), $file_types)) return false;
    }
    return true;
}

function check_file_type(array $file, array $file_types) {
    if (!in_array(get_mime_type($file['tmp_name']), $file_types)) return false;
    return true;
}

function get_files($files) {
    for ($i = 0; $i < count($files['name']); $i++) {
        yield array(
            'name' => $files['name'][$i],
            'type' => $files['type'][$i],
            'tmp_name' => $files['tmp_name'][$i],
        );
    }
}