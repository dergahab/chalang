<?php
$data = json_decode(file_get_contents('scratch.json'), true);
echo array_key_exists('global_settings', $data['props']) ? 'YES' : 'NO';
