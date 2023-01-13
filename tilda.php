<?php


//Задача 1: лесенка
//Нужно вывести лесенкой числа от 1 до 100.
//1
//2 3
//4 5 6
//...
function ladder(int $start, int $stop)
{
    if ($start > $stop) {
        throw new Exception("$stop must be greater than $start");
    }

    $buff = '';
    $step = 1;
    $cursor = 1;

    for ($i = $start; $i <= $stop; $i++) {
        $buff .= " $i";

        if ($step == $cursor || $i == $stop) {
            echo $buff.PHP_EOL;

            $buff = '';
            $step = 1;
            $cursor++;
        } else {
            $step++;
        }
    }
}

ladder(1, 100);


//Задача 2: массивы
//Нужно заполнить массив 5 на 7 случайными уникальными числами от 1 до 1000.
//Вывести получившийся массив и суммы по строкам и по столбцам.

function gen_uniq(int $from, int $to, int $setAttempts = 1000)
{
    static $uniqIndexes = [];

    return function () use (&$uniqIndexes, $from, $to, $setAttempts) {
        $attempts = 0;

        do {
            $int = mt_rand($from, $to);
            $attempts++;

            if ($attempts > $setAttempts) {
                $to = $to << 1;
                $attempts = 0;
            }
        } while (isset($uniqIndexes[$int]) and $attempts <= $setAttempts);

        $uniqIndexes[$int] = 1;

        return $int;
    };
}


function random_array(int $rows, int $cols, int $randFrom, int $randTo)
{
    $array = [];

    $gen_uniq = gen_uniq($randFrom, $randTo);

    for ($i = 1; $i <= $rows; $i++) {
        $buff = [];

        for ($j = 1; $j <= $cols; $j++) {
            $buff[] = $gen_uniq();
        }

        $array[] = $buff;
    }

    //render array
    $colSumm = [];
    foreach ($array as $items) {
        echo implode(' - ', $items).' ROW SUMM:'.array_sum($items).PHP_EOL;
        foreach ($items as $key => $val) {
            $colSumm[$key] = isset($colSumm[$key]) ? $colSumm[$key] + $val : $val;
        }
    }

    echo 'COLL SUMM'.PHP_EOL.implode(' - ', $colSumm);
}

random_array(5, 7, 1, 1000);
