<?php
function processDir($dir) {
    $files = scandir($dir);
    foreach ($files as $file) {
        if ($file === '.' || $file === '..') continue;
        $path = $dir . DIRECTORY_SEPARATOR . $file;
        if (is_dir($path)) {
            // we skip the api folder itself to avoid renaming comments in the api folder files unless needed
            // wait, we can just process all files, since str_replace targets `../api/admin/admin_` which only appears in frontend
            if (basename($path) !== '.git' && basename($path) !== 'vendor') {
                 processDir($path);
            }
        } else {
            $ext = pathinfo($path, PATHINFO_EXTENSION);
            if (in_array($ext, ['php', 'js'])) {
                $content = file_get_contents($path);
                $originalContent = $content;
                
                // Replace admin
                $content = str_replace('../api/admin/admin_', '../api/admin/admin_', $content);
                // Replace staff
                $content = str_replace('../api/staff/staff_', '../api/staff/staff_', $content);
                
                if ($content !== $originalContent) {
                    file_put_contents($path, $content);
                    echo "Updated: $path\n";
                }
            }
        }
    }
}

// Start from root directory
processDir(__DIR__);
echo "Done.\n";

