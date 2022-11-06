<?php namespace App\Validators;

class SameForeignKey
{
    /** проверит что в БД у всех моделей значение определенного аттрибута одинаковое (внешний ключ) и что только эти модели принадлежат к этому внешнему ключу
     *
     * @param $attribute null пофиг
     * @param $value array[] массив моделей (с id-шками) каждая из которых представлена как массив
     * @param $parameters array первым элементом массива нужно передать имя поля по которому идёт проверка ---- второй элемент это ::class
     * @return bool
     */
    public function validate($attribute, $value, $parameters)
    {
        $fieldName = array_shift($parameters);
        $className = array_shift($parameters);
        $IDs = array_map(function ($row) { return $row['id']; }, $value);

        if (!$model = $className::whereIn('id', $IDs)->first()) {
            return false;
        }

        return $className::whereIn('id', $IDs)->where($fieldName, $model->$fieldName)->count() == count($value) &&
               $className::where($fieldName, $model->$fieldName)->count() == count($value);
    }
}

