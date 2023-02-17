<?php

namespace Mostafaznv\Larupload\Concerns;


use Illuminate\Database\Eloquent\SoftDeletingScope;

trait LaruploadObservers
{
    protected static function boot(): void
    {
        parent::boot();

        static::saved(function($model) {
            $shouldSave = false;

            foreach ($model->attachments as $attachment) {
                if (!$attachment->isUploaded()) {
                    $shouldSave = true;

                    $model = $attachment->saved($model);
                }
            }

            if ($shouldSave) {
                $model->save();
            }
        });

        static::deleted(function($model) {
            if (!$model->hasGlobalScope(SoftDeletingScope::class) or $model->isForceDeleting()) {
                foreach ($model->attachments as $attachment) {
                    $attachment->deleted($model);
                }
            }
        });

        static::retrieved(function($model) {
            foreach ($model->attachments as $attachment) {
                $attachment->setOutput($model);
            }
        });
    }
}
