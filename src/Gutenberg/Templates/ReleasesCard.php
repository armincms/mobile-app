<?php

namespace Armincms\MobileApp\Gutenberg\Templates;

use Zareismail\Gutenberg\Variable;

class ReleasesCard extends Template
{
    /**
     * Register the given variables.
     * 
     * @return array
     */
    public static function variables(): array
    {
        return [
            Variable::make('id', __('Release Id')),
            Variable::make('name', __('Release Name')),
            Variable::make('package', __('Package Name')),
            Variable::make('version', __('Release Version')),
            Variable::make('number', __('Release Number')),
            Variable::make('force', __('Force to update')),
            Variable::make('zip', __('Release ZIP file')),
            Variable::make('apk', __('Release APK file')),
            Variable::make('creation_date', __('Release Creation Date')),
            Variable::make('last_update', __('Release Update Date')),
        ];
    }
}
