<?php namespace App\Validators;

class SortedArray
{

    /** проверит правильность сортировки группы моделей (от нуля обязательно)
     *
     * @param $attribute null пофиг
     * @param $value array[] массив моделей (с id-шками) каждая из которых представлена как массив
     * @param $parameters array первым элементом массива нужно передать имя поля по которому идёт сортировка, вторым (НЕ обязателен) элементом можно передать primary key (по умолчанию id)
     * @return bool
     */
    public function validate($attribute, $value, $parameters)
    {
        $fieldName = $parameters[0];
        $idFieldName = isset($parameters[1]) ? $parameters[1] : 'id';

        $sort = [];
        if (!is_array($value)) { return false; }
        foreach ($value as $rowItem) {
            if (!is_array($rowItem) || !isset($rowItem[$fieldName]) || !is_int($rowItem[$fieldName])|| !isset($rowItem[$idFieldName])) { return false; }
            $sort[] = $rowItem[$fieldName];
        }

        asort($sort);

        $ix = 0;
        foreach ($sort as $no) {
            if ($ix != $no) { return false; }
            $ix++;
        }
        return true;
    }
}
