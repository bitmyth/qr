<?php

namespace Bridge;

use Symfony\Component\Console\Formatter\OutputFormatter;

require_once __DIR__ . '/../phpqrcode/phpqrcode.php';

/**
 * @see  http://phpqrcode.sourceforge.net/examples/index.php
 * Class QR
 * @package Bridge
 */
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

    public function text($data)
    {
        $text = \QRcode::text($data);

        // Add borders
        $size = strlen($text[0]);
        array_unshift($text, str_repeat('0', $size));
        $text[] = str_repeat('0', $size);
        $text = array_map(function ($i) {
            return "0{$i}0";
        }, $text);

        $raw = join(PHP_EOL, $text);

        $formatter = new OutputFormatter(true);

        $raw = strtr($raw, array(
            '0' => $formatter->format('<bg=white>  </>'),
            '1' => $formatter->format('<bg=black>  </>'),
        ));

        return $raw;
    }

}