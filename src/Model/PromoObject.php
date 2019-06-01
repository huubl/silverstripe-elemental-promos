<?php

namespace Dynamic\Elements\Promos\Model;

use Dynamic\BaseObject\Model\BaseElementObject;
use Dynamic\Elements\Promos\Elements\ElementPromos;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldConfig_RecordViewer;

/**
 * Class PromoObject
 * @package Dynamic\Elements\Promos\Model
 *
 * @method \SilverStripe\ORM\ManyManyList ElementPromos()
 */
class PromoObject extends BaseElementObject
{
    /**
     * @return string
     */
    private static $singular_name = 'Promo';

    /**
     * @return string
     */
    private static $plural_name = 'Promos';

    /**
     * @var array
     */
    private static $belongs_many_many = array(
        'ElementPromos' => ElementPromos::class,
    );

    /**
     * @var string
     */
    private static $table_name = 'PromoObject';

    /**
     * @var array
     */
    private static $summary_fields = [
        'Summary',
    ];

    /**
     * @return FieldList
     *
     * @throws \Exception
     */
    public function getCMSFields()
    {
        $this->beforeUpdateCMSFields(function (FieldList $fields) {
            $fields->removeByName('ElementPromos');

            $config = GridFieldConfig_RecordViewer::create();
            $fields->addFieldToTab(
                'Root.Elements',
                GridField::create(
                    'ElementPromos',
                    'Elements',
                    $this->ElementPromos(),
                    $config
                )
            );

            $fields->dataFieldByName('Image')
                ->setFolderName('Uploads/Elements/Promos');
        });

        return parent::getCMSFields();
    }

    /**
     * @return mixed
     */
    public function getSummary()
    {
        return $this->dbObject('Content')->Summary(20);
    }
}
