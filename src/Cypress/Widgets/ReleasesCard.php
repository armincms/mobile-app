<?php

namespace Armincms\MobileApp\Cypress\Widgets;

use Armincms\MobileApp\Nova\Release;
use Armincms\MobileApp\Nova\ReleaseCategory;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use PhoenixLib\NovaNestedTreeAttachMany\NestedTreeAttachManyField as CategorySelect;
use Zareismail\Cypress\Http\Requests\CypressRequest;
use Zareismail\Gutenberg\Cacheable;
use Zareismail\Gutenberg\Gutenberg;
use Zareismail\Gutenberg\GutenbergWidget;

class ReleasesCard extends GutenbergWidget implements Cacheable
{
    /**
     * The logical group associated with the widget.
     *
     * @var string
     */
    public static $group = 'MobileApp';

    /**
     * Bootstrap the resource for the given request.
     * 
     * @param  \Zareismail\Cypress\Http\Requests\CypressRequest $request 
     * @param  \Zareismail\Cypress\Layout $layout 
     * @return void                  
     */
    public function boot(CypressRequest $request, $layout)
    {
        parent::boot($request, $layout);
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public static function fields($request)
    {
        return [];
    }

    /**
     * Prepare the resource for JSON serialization.
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return array_merge(parent::jsonSerialize(), [
            'releases' => Release::newModel()->with('media')->latest()->get()->map(function ($release) {
                return [
                    "name" => $release->name,
                    "version" => $release->version,
                    "package" => $release->package,
                    "number" => $release->number,
                    "force" => $release->force,
                    "created_at" => $release->created_at,
                    "zip" => $release->getFirstMediaUrl('zip') ?: null,
                    "apk" => $release->getFirstMediaUrl('apk') ?: null,
                ];
            }),
        ]);
    }

    /**
     * Query related tempaltes.
     * 
     * @param  [type] $request [description]
     * @param  [type] $query   [description]
     * @return [type]          [description]
     */
    public static function relatableTemplates($request, $query)
    {
        return $query->handledBy(
            \Armincms\MobileApp\Gutenberg\Templates\ReleasesCard::class
        );
    }
}
