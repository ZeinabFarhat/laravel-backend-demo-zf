<?php

namespace App\Models\Traits;

use App\Helpers\Minion;

trait Sluggable {

	public static function bootSluggable()
	{
		static::creating(function ($model) {
			$slug = Minion::create_slug($model->first_name . '-'. $model->last_name, get_class($model));
			$model->slug = $slug;
		});
	}
}