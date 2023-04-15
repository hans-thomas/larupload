<?php

use Mostafaznv\Larupload\Test\Support\Models\LaruploadHeavyTestModel;
use Mostafaznv\Larupload\Test\Support\Models\LaruploadLightTestModel;


it('will show larupload columns in toArray response', function(LaruploadHeavyTestModel|LaruploadLightTestModel $model) {
    config()->set('larupload.hide-table-columns', false);

    $model = $model::class;
    $model = save(new $model, jpg());
    $array = $model->toArray();

    expect(isset($array['main_file_file_name']))
        ->toBeTrue();

})->with('models');

it('will hide larupload columns from toArray response', function(LaruploadHeavyTestModel|LaruploadLightTestModel $model) {
    config()->set('larupload.hide-table-columns', true);

    $model = $model::class;
    $model = save(new $model, jpg());
    $array = $model->toArray();

    foreach ($this->metaKeys as $meta) {
        expect(isset($array["main_file_file_$meta"]))
            ->toBeFalse();
    }

})->with('models');
