<?php namespace App\Rules;

use App\Validators\SortedArray;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Contracts\Validation\Rule;

class SortedAttribute implements Rule
{
    private $models;
    private $id;

    public function __construct(Collection $models, ?Model $model = null) {
        $this->models = $models;
        $this->id = $model ? $model->id : 0;
    }

    /** если аттрибут сортировочный (по принципу от 0 до бесконечности). то есть по нему некая группа моделей сортируется в БД, то для POST PUT запросов нужно провалидировать корректность его значения
     *
     * @param $attribute string имя поля по которому идёт сортировка
     * @param $value int значение поля для новой модели (POST) или для редактируемой (PUT)
     * @param $parameters array первый элемент это id модели (==false значение если нов модель) ---- второй элемент это ::class ---- остальные элементы для where вот в таком синтаксисе field_name:123 чтоб вытащить из БД запросом группу моделей внутри которой происходит сортировка
     * @return bool
     */

    public function passes($attribute, $value)
    {
        $rows = $this->models->toArray();

        $modelFound = false;
        foreach ($rows as $ix => $row) {
            if (!isset($row, $attribute)) { return false; }

            if ($row['id'] == $this->id) {
                $rows[$ix][$attribute] = (int)$value;
                $modelFound = true; // а здесь не надо ставить break потому что этот валидатор применяется для mass update
            }
        }

        if (!$modelFound) { // это происходит когда мы редактируем-создаём одну модель, и это либо новая модель, либо ей добавляется идентификатор группы (то есть она еще не сохранена-в-БД внутри проверяемой группы, но будет)
            $rows[] = [
                'id' => $this->id ?: -1,
                $attribute => $value,
            ];
        }

        return (new SortedArray())->validate(null, $rows, [$attribute]);
    }

    public function message()
    {
        return 'Нарушит порядок сортировки для :attribute';
    }
}
