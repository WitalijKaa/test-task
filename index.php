<?php

// find amount of numbers where sum of first 3 digits == sum of last 3 digits
// but sum must be 1 digit long, so for example try 4+5+6 = 15 catch 1+5 = 6 finally 4+5+6 = 6

$current = validate($_GET['start'] ?? null);
$end = validate($_GET['end'] ?? null);

if (!$current || !$end) {
    echo 0; exit;
}

list ($numbers, $sums) = prepareCache();

$response = 0;
while ($current <= $end) {
    $split = splitNumber($current);

    $leftSum = $numbers[$split['left']];
    if (array_key_exists($leftSum, $sums) && in_array($split['right'], $sums[$leftSum])) {
        $response++;
    }

    $current++;
}

echo $response; exit;




function getSum(string $num) : int {
    $sum = array_sum(str_split($num));
    return $sum > 9 ? getSum((string)$sum) : $sum;
}

function prepareCache(int $min = 1, int $max = 999) : array {
    $numbers = [];
    $sums = [];
    for ($i = $min; $i <= $max; $i++) {
        $num = str_pad($i, 3, '0', STR_PAD_LEFT);
        $sum = getSum((string)$i);

        $numbers[$num] = $sum;
        $sums[$sum][] = $num;
    }
    return [$numbers, $sums];
}

function validate($input) : ?int {
    if (!$input) {
        return null;
    }

    $input = preg_replace('/[^0-9]/', '', $input);
    $input = str_pad($input, 6, '0', STR_PAD_LEFT);

    return strlen($input) == 6 ? (int)$input : null;
}

function splitNumber(int $num) : array {
    $num = str_pad($num, 6, '0', STR_PAD_LEFT);
    $left = substr($num, 0, 3);
    $right = substr($num, 3, 3);

    return [
        'left' => $left,
        'right' => $right,
    ];
}
