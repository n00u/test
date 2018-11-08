<?php


/**
 * Функция меняет местами элемент на позиции $num и элемент на 0 позиции
 * @param array $arr массив
 * @param int $num позиция заменяемого элемента
 * @return void
 */
function array_swap(array &$arr, int $num)
{
	list($arr[0], $arr[$num]) = [$arr[$num], $arr[0]];
}

$array = [4, 5, 8, 9, 1, 7, 2];

print_r($array) . PHP_EOL;

$cnt = count($array);
for($i = 1; $i < $cnt; $i++){	
	foreach ($array as $key => $val) {
		if ($array[0] < $val && $key <= $cnt - $i) {
			array_swap($array, $key);
        }
    }
	array_swap($array, $cnt - $i);
}

print_r($array) . PHP_EOL;
