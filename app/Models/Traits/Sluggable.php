<?php

namespace App\Models\Traits;

use App\Helpers\Minion;

trait Sluggable {

	public static function bootSluggable()
	{
		static::creating(function ($model) {
			$settings = $model->sluggable();
			$variable = $settings['source'];
			$slug = Minion::create_slug($model->$variable, get_class($model));
			$model->slug = $slug;
		});
	}
}