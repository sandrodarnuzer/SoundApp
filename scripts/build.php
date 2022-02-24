<?php

$items = array(
    'assets',
    'components',
    'db',
    'pages',
    'functions.php',
    '.htaccess',
    'index.php',
    'index.php',
    'router.php',
);

$environments = array(
    'production',
    'test',
    'uk',
);

$output_folder = 'dist';

if ($argc <= 1) {
    echo "Too few arguments\n";
    return;
}

$environment = $argv[1];
if (!in_array($environment, $environments)) {
    echo "Unvalid environment\n";
    return;
}

$current_dir = getcwd();
if (!file_exists($current_dir.DIRECTORY_SEPARATOR.'index.php')) {
    echo "No Index file found\n";
    return;
}

$output_path = $current_dir.DIRECTORY_SEPARATOR.$output_folder;
if (file_exists($output_path)) exec("rm -rf ${output_path}");
// mkdir($output_path);
mkdir($output_path.DIRECTORY_SEPARATOR.'config', 0777, true);

$config_source = $current_dir.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config_'.$environment.'.php';
$config_destination = $output_path.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php';
copy($config_source, $config_destination);
foreach ($items as $item) {
    $item_source = $current_dir.DIRECTORY_SEPARATOR.$item;
    exec("cp -R ${item_source} ${output_path}");
}