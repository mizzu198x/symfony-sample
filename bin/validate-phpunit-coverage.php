<?php

declare(strict_types=1);

if ($contents = file_get_contents('php://stdin')) {
    preg_match('/^\s+Lines:\s+([0-9.]+)%\s+.*$/m', $contents, $totalOutput);
    $coverage = floatval($totalOutput[1]);
    if (100.00 === $coverage) {
        exit(0);
    }
}

exit(1);
