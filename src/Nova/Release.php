<?php

namespace Armincms\MobileApp\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Slug;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Panel;

class Release extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \Armincms\MobileApp\Models\MobileAppRelease::class;

    /**
     * The relationships that should be eager loaded when performing an index query.
     *
     * @var array
     */
    public static $with = [];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make()->sortable(),

            Text::make(__('Release Name'), 'name')
                ->sortable()
                ->required()
                ->rules('required')
                ->help(__('Example: First release')),

            Text::make(__('Package Name'), 'package')
                ->sortable()
                ->help(__('Example: myapp')),

            Text::make(__('Release Version'), 'version')
                ->sortable()
                ->required()
                ->rules('required')
                ->help('Example: v1.0.0'),

            Number::make(__('Version Number'), 'number')
                ->sortable()
                ->help('Example: 12'),

            Slug::make(__('Release Slug'), 'slug')
                ->sortable()
                ->nullable()
                ->from('name')
                ->hideFromIndex()
                ->rules('unique:mobile_app_releases,slug,{{resourceId}}'),

            Boolean::make(__('Force to update'), 'force')->required()->default(true),

            $this->resourceUrls(),

            $this->medialibrary(__('Release APK'), 'apk')
                ->sortable()
                ->required(),

            $this->medialibrary(__('Release Zip'), 'zip')
                ->sortable()
                ->required(),

            Textarea::make(__('Release Summary'), 'summary')->hideFromIndex()->nullable(),

            Panel::make(__('Release Description'), [

                $this->resourceEditor(__('Release change log'), 'content')->nullable(),

                $this->resourceMeta(__('Release Meta'))->nullable(),
            ]),
        ];
    }

    /**
     * Get the actions available on the entity.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [];
    }
}
