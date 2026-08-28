<?php

// Ensure compiled views directory exists on Vercel (serverless /tmp)
if (!is_dir('/tmp/views')) {
    mkdir('/tmp/views', 0755, true);
}

// Ensure cache directory exists
if (!is_dir('/tmp/cache')) {
    mkdir('/tmp/cache', 0755, true);
}

require __DIR__ . '/../public/index.php';
