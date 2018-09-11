<?php

namespace Dynamic\Elements\Promos\Admin;

use Dynamic\Elements\Promos\Model\PromoObject;
use SilverStripe\Admin\ModelAdmin;

/**
 * Class PromosAdmin
 * @package Dynamic\Elements\Promos\Admin
 */
class PromosAdmin extends ModelAdmin
{
    /**
     * @var array
     */
    private static $managed_models = [
        PromoObject::class => [
            'title' => 'Promos',
        ],
    ];

    /**
     * @var string
     */
    private static $url_segment = 'promos';

    /**
     * @var string
     */
    private static $menu_title = 'Promos';
}
