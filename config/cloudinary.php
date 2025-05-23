<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Cloudinary\Cloudinary;
use Cloudinary\Configuration\Configuration;

// Configurar Cloudinary
$cloudinary = new Cloudinary(
    Configuration::instance([
        'cloud' => [
            'cloud_name' => 'do1h4wifw',
            'api_key'    => '421816253859537',
            'api_secret' => '1vx__5xZPaF6ql2wva5Buq3pV9A'
        ]
    ])
);

return $cloudinary;