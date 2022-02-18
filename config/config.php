<?php
class Config {
    // General
    const BASE_PATH = '/soundapp';
    const AUTH = false;

    const AUTH_USER = 'soundapp';
    const AUTH_PASSWORD = 'ananas';

    // Filetypes
    const IMAGE_TYPES = array(
        'image/jpeg',
        'image/jpg',
        'image/png',
        'image/gif',
    );
    const AUDIO_TYPES = array(
        'audio/mpeg',
        'audio/ogg',
    );

    // Database
    const DB_HOST = 'localhost';
    const DB_USER = 'root';
    const DB_PASSWORD = 'root';
    const DB_NAME = 'soundapp';
}