<?php

namespace Armincms\MobileApp\Models;

use Armincms\Contract\Concerns\Authorizable;
use Armincms\Contract\Concerns\HasHits;
use Armincms\Contract\Concerns\InteractsWithFragments;
use Armincms\Contract\Concerns\InteractsWithMedia;
use Armincms\Contract\Concerns\InteractsWithMeta;
use Armincms\Contract\Concerns\InteractsWithUri;
use Armincms\Contract\Concerns\InteractsWithWidgets;
use Armincms\Contract\Concerns\Sluggable;
use Armincms\Contract\Contracts\Authenticatable;
use Armincms\Contract\Contracts\HasMedia;
use Armincms\Contract\Contracts\HasMeta;
use Armincms\Contract\Contracts\Hitsable;
use Armincms\Orderable\Contracts\Salable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MobileAppRelease extends Model implements HasMedia, Hitsable, Authenticatable, HasMeta
{
    use Authorizable;
    use HasHits;
    use InteractsWithFragments;
    use InteractsWithMedia;
    use InteractsWithMeta;
    use InteractsWithUri;
    use InteractsWithWidgets;
    use SoftDeletes;
    use Sluggable;

    /**
     * Get the corresponding cypress fragment.
     *
     * @return
     */
    public function cypressFragment(): string
    {
        return \Armincms\Coursera\Cypress\Fragments\CourseDetail::class;
    }

    /**
     * Serialize the model to pass into the client view for single item.
     *
     * @param Zareismail\Cypress\Request\CypressRequest
     * @return array
     */
    public function serializeForDetailWidget($request)
    {
        return array_merge($this->serializeForIndexWidget($request), [
            'subscription' => $this->getSubscription($request->user()),
            'subscribed' => $this->subscribed($request->user()),
            'content'   => $this->content,
            'episodes'  => $this->episodes->map->serializeForWidget($request)->toArray(),
        ]);
    }

    /**
     * Serialize the model to pass into the client view for collection of items.
     *
     * @param Zareismail\Cypress\Request\CypressRequest
     * @return array
     */
    public function serializeForIndexWidget($request)
    {
        return [
            'id'        => $this->getKey(),
            'name'      => $this->name,
            'price'     => $this->price,
            'summary'   => $this->summary,
            'url'       => $this->getUrl($request),
            'hits'      => $this->hits,
            'images'    => $this->getFirstMediasWithConversions()->get('image'),
            'category'  => (array) optional($this->category)->serializeForIndexWidget(
                $request
            ),
        ];
    }

    /**
     * Get the available media collections.
     * 
     * @return array
     */
    public function getMediaCollections(): array
    {
        return [
            'zip' => [
                'conversions' => [],
                'multiple'  => false,
                'disk'      => 'file',
                'limit'     => 1, // count of files
                'accepts'   => ['application/zip'],
            ],
            'apk' => [
                'conversions' => [],
                'multiple'  => false,
                'disk'      => 'file',
                'limit'     => 1, // count of files
                'accepts'   => ['application/vnd.android.package-archive', 'application/java-archive',],
            ],
        ];
    }
}
