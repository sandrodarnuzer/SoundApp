<?php
class Config {
    // General
    const BASE_PATH = '/';
    const AUTH = false;

    const AUTH_USER = '';
    const AUTH_PASSWORD = '';

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
    const DB_PASSWORD = '';
    const DB_NAME = 'soundapp';
}