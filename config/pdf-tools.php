<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Binary Executables
    |--------------------------------------------------------------------------
    */

    'soffice' => env('PDF_TOOLS_SOFFICE', '/usr/bin/soffice'),

    'gs' => env('PDF_TOOLS_GS', '/usr/bin/gs'),

    /*
    |--------------------------------------------------------------------------
    | Limits
    |--------------------------------------------------------------------------
    */

    'max_size_kb' => env('PDF_TOOLS_MAX_SIZE_KB', 10240), // 10MB

    'max_files' => env('PDF_TOOLS_MAX_FILES', 10),

    'max_pages' => env('PDF_TOOLS_MAX_PAGES', 200),

    'max_images' => env('PDF_TOOLS_MAX_IMAGES', 20),

    'process_timeout' => env('PDF_TOOLS_TIMEOUT', 300),

    /*
    |--------------------------------------------------------------------------
    | Tools
    |--------------------------------------------------------------------------
    */

    'tools' => [
        'word-to-pdf' => [
            'label' => 'Word ke PDF',
            'description' => 'Konversi dokumen DOC, DOCX, ODT, RTF, dan TXT menjadi PDF berkualitas tinggi.',
            'multiple' => false,
            'accept' => '.doc,.docx,.odt,.rtf,.txt',
            'mimes' => 'doc,docx,odt,rtf,txt',
        ],
        'merge' => [
            'label' => 'Gabung PDF',
            'description' => 'Gabungkan beberapa file PDF menjadi satu dokumen dengan urutan sesuai keinginan.',
            'multiple' => true,
            'accept' => '.pdf',
            'mimes' => 'pdf',
        ],
        'split' => [
            'label' => 'Pisah PDF',
            'description' => 'Ekstrak halaman tertentu dari PDF, misalnya halaman 1-3, 5, dan 8.',
            'multiple' => false,
            'accept' => '.pdf',
            'mimes' => 'pdf',
        ],
        'compress' => [
            'label' => 'Kompres PDF',
            'description' => 'Perkecil ukuran file PDF agar lebih mudah dibagikan, tanpa merusak kualitas.',
            'multiple' => false,
            'accept' => '.pdf',
            'mimes' => 'pdf',
        ],
        'pdf-to-images' => [
            'label' => 'PDF ke Gambar',
            'description' => 'Ubah setiap halaman PDF menjadi gambar JPG atau PNG, dikemas dalam ZIP.',
            'multiple' => false,
            'accept' => '.pdf',
            'mimes' => 'pdf',
        ],
        'images-to-pdf' => [
            'label' => 'Gambar ke PDF',
            'description' => 'Gabungkan gambar JPG dan PNG menjadi satu file PDF.',
            'multiple' => true,
            'accept' => '.jpg,.jpeg,.png',
            'mimes' => 'jpg,jpeg,png',
        ],
        'rotate' => [
            'label' => 'Putar PDF',
            'description' => 'Putar halaman PDF sebesar 90, 180, atau 270 derajat.',
            'multiple' => false,
            'accept' => '.pdf',
            'mimes' => 'pdf',
        ],
    ],

];
