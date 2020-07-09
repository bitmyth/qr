<?php

namespace Bridge;

// https://sourceforge.net/projects/phpqrcode/files/releases/
require_once __DIR__ . '/../phpqrcode/phpqrcode.php';

class QR
{
    public function generate($file, $data)
    {
        ob_start();
        \QRcode::png($data);
        $qr = ob_get_contents();
        ob_end_clean();

        if ($qr != '') {
            file_put_contents($file, $qr);
        }

        return $qr;
    }

}