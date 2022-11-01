<?php

class Controller {

    // SOLID result
    public function actionEmailAlpha() {

        // DEPENDENCY INVERSION client relies on interface
        /** @var IDataProvider $provider */
        $provider = /* App::service->getDataProvider() or... */ new ProviderDB();
        /** @var IDataFormatter $formatter */
        $formatter = /* App::service->getFormatter() or... */ new FormatterEmail();

        $items = $provider->getForChannelAlpha();
        return $formatter->format($items);

        // SINGLE RESPONSIBILITY
        // OPEN CLOSED
        // LISKOV SUBSTITUTION
        // INTERFACE SEGREGATION
        // DEPENDENCY INVERSION

        // look down here...
    }
}

interface IDataProvider {
    /** @return Collection|OutsideItem[] */
    public function getForChannelAlpha() : Collection;
    /** @return Collection|OutsideItem[] */
    public function getForChannelBeta() : Collection;
}

interface IDataFormatter {
    /** @param Collection|OutsideItem[] $items
     * @return string
     */
    public function format(Collection $items) : string;
}

interface IToOutsideItem {
    public function toOutsideArray() : array;
}

interface ICountWords {
    public function countWordsByField(string $fieldName = 'text') : int;
}

// SINGLE RESPONSIBILITY simple collection
class Collection implements Iterator {

    private $items = [];

    public function __construct(array $models) {
        $this->items[] = $models;
    }

    public function current() { return $this->items[0]; }
    public function next() { return $this->items[0]; }
    public function key() { return 0; }
    public function valid() { return true; }
    public function rewind() { }
}

// OPEN CLOSED open to inheritance (example OutsideItemIgnorer)
class OutsideItem implements ICountWords {

    use TCountWords;

    public $text;
    public $section;
    public $author;
    public $tip;

    public function __construct(IToOutsideItem $model) {
        $arr = $model->toOutsideArray();
        // SINGLE RESPONSIBILITY models knows their fields, OutsideItem knows outside-content fields
        foreach ($this as $fieldName => $val) {
            if (isset($arr[$fieldName])) {
                $this->$fieldName = $arr[$fieldName];
            }
        }
    }
}

class OutsideItemIgnorer extends OutsideItem {

    // LISKOV SUBSTITUTION does not change contract from OutsideItem (its method of TCountWords <--> ICountWords)
    public function countWordsByField(string $fieldName = 'text') : int {
        return 10;
    }
}

// INTERFACE SEGREGATION models do not implement this method, because JustInfo does not have text field to count words (but OutsideItem always has)
trait TCountWords {
    public function countWordsByField(string $fieldName = 'text') : int {
        if (!$this->$fieldName) {
            return 0;
        }
        return count(explode(' ', $this->$fieldName));
    }
}

// DEPENDENCY INVERSION realization relies on interface
class ProviderDB implements IDataProvider {

    // SINGLE RESPONSIBILITY controller for db or files or etc. any similar class will return the collection because of IDataProvider
    public function getForChannelAlpha() : Collection {
        return new Collection([] /* DB::Table->where($query)->get(); */);
    }

    public function getForChannelBeta() : Collection {
        return new Collection([] /* DB::Table->where($query)->get(); */);
    }
}

// DEPENDENCY INVERSION realization relies on interface
class FormatterEmail implements IDataFormatter {
    
    public function format(Collection $items) : string {
        $result = '';
        foreach ($items as $item) {
            /** @var OutsideItem $item */
            $text = $item->text;

            // OPEN CLOSED closed for changes (counting words is in OutsideItem, so we do not need to change this class on adding OutsideItemIgnorer logic)
            if ($item->countWordsByField() > 100) {
                // continue; // not SINGLE RESPONSIBILITY it is filtering and formatting

                $text = substr($text, 0, 100500); // now it is not a filter
            }

            // SINGLE RESPONSIBILITY creates content string using standard data contract
            $result .= '<some_tag>' . $text . '</some_tag>';
        }
        return $result;
    }
}


/** !!!! here are MODELs !!!! */

/**
 * @property integer $id
 * @property string|null $text
 * @property string|null $description
 * @property string|null $creator
 */
class FunnyStory implements IToOutsideItem {

    protected $attributes = ['id', 'text', 'description', 'creator'];

    // SINGLE RESPONSIBILITY models knows their fields, OutsideItem knows outside-content fields
    public function toOutsideArray() : array {
        return [
            'text' => $this->text ?? '',
            'section' => 'SOME_CONSTANT',
            'author' => $this->creator,
            'tip' => $this->description ?? '',
        ];
        // KISS yes we can create some factory to transform db-model-to-outside-model,
        //      but in these case we can easily replace-change the model...
        //      I mean changes in FunnyStory will not affect SeriousPost JustInfo
    }

    public function toLogArray() {
        return [
            'log' => $this->toOutsideArray(), // I think its KISS example
            'project' => 'SOME_CONSTANT',
        ];
    }
}

/**
 * @property integer $id
 * @property string $post
 * @property string $title
 * @property array $author
 */
class SeriousPost implements IToOutsideItem {

    protected $attributes = ['id', 'post', 'title', 'author'];

    // SINGLE RESPONSIBILITY models knows their fields, OutsideItem knows outside-content fields
    public function toOutsideArray() : array {
        return [
            'text' => $this->title . $this->post,
            'section' => $this->author['section'],
            'author' => $this->author['name'],
            'tip' => $this->title,
        ];
    }
}

/**
 * @property integer $id
 * @property string $note
 */
class JustInfo implements IToOutsideItem {

    protected $attributes = ['id', 'note'];

    // SINGLE RESPONSIBILITY models knows their fields, OutsideItem knows outside-content fields
    public function toOutsideArray() : array {
        return [
            'section' => 'SOME_CONSTANT',
            'tip' => $this->note,
        ];
    }
}