<?php

namespace App\Services\PdfTools;

use setasign\Fpdi\Fpdi;

class RotatedFpdi extends Fpdi
{
    protected float $angle = 0;

    public function Rotate($angle, $x = -1, $y = -1): void
    {
        if ($x == -1) {
            $x = $this->x;
        }

        if ($y == -1) {
            $y = $this->y;
        }

        if ($this->angle != 0) {
            $this->_out('Q');
        }

        $this->angle = $angle;

        if ($angle != 0) {
            $angle *= M_PI / 180;
            $c = cos($angle);
            $s = sin($angle);
            $cx = $x * $this->k;
            $cy = ($this->h - $y) * $this->k;
            $this->_out(sprintf('q %.5F %.5F %.5F %.5F %.5F %.5F cm', $c, $s, -$s, $c, $cx, $cy));
        }
    }

    public function _endpage(): void
    {
        if ($this->angle != 0) {
            $this->angle = 0;
            $this->_out('Q');
        }

        parent::_endpage();
    }
}
