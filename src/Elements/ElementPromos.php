<?php

namespace Dynamic\Elements\Promos\Elements;

use DNADesign\Elemental\Models\BaseElement;
use Dynamic\Elements\Promos\Model\PromoObject;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\GridField\GridFieldAddExistingAutocompleter;
use SilverStripe\ORM\FieldType\DBField;
use SilverStripe\ORM\FieldType\DBHTMLText;
use SilverStripe\Versioned\GridFieldArchiveAction;
use Symbiote\GridFieldExtensions\GridFieldAddExistingSearchButton;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;

/**
 * Class ElementPromos
 * @package Dynamic\Elements\Promos\Elements
 *
 * @property string $Content
 *
 * @method \SilverStripe\ORM\ManyManyList Promos()
 */
class ElementPromos extends BaseElement
{
    /**
     * @var string
     */
    private static $icon = 'font-icon-block-banner';

    /**
     * @return string
     */
    private static $singular_name = 'Promos Element';

    /**
     * @return string
     */
    private static $plural_name = 'Promos Elements';

    /**
     * @var string
     */
    private static $table_name = 'ElementPromos';

    /**
     * @var array
     */
    private static $styles = array();

    /**
     * @var array
     */
    private static $db = [
        'Content' => DBHTMLText::class,
    ];

    /**
     * @var array
     */
    private static $many_many = array(
        'Promos' => PromoObject::class,
    );

    /**
     * @var array
     */
    private static $many_many_extraFields = array(
        'Promos' => array(
            'SortOrder' => 'Int',
        ),
    );

    /**
     * Set to false to prevent an in-line edit form from showing in an elemental area. Instead the element will be
     * clickable and a GridFieldDetailForm will be used.
     *
     * @config
     * @var bool
     */
    private static $inline_editable = false;

    /**
     * @return FieldList
     */
    public function getCMSFields()
    {
        $this->beforeUpdateCMSFields(function (FieldList $fields) {
            $fields->dataFieldByName('Content')
                ->setRows(8);

            if ($this->ID) {
                /** @var \SilverStripe\Forms\GridField\GridField $promoField */
                $promoField = $fields->dataFieldByName('Promos');
                $config = $promoField->getConfig();
                $config->removeComponentsByType([
                    GridFieldAddExistingAutocompleter::class,
                    GridFieldDeleteAction::class,
                    GridFieldArchiveAction::class,
                ])->addComponents(
                    new GridFieldOrderableRows('SortOrder'),
                    new GridFieldAddExistingSearchButton()
                );

                $fields->addFieldsToTab('Root.Promos', array(
                    $promoField,
                ));
            }
        });

        return parent::getCMSFields();
    }

    /**
     * @return mixed
     */
    public function getPromoList()
    {
        return $this->Promos()->sort('SortOrder');
    }

    /**
     * @return DBHTMLText
     */
    public function getSummary()
    {
        if ($this->Promos()->count() == 1) {
            $label = ' promo';
        } else {
            $label = ' promos';
        }
        return DBField::create_field('HTMLText', $this->Promos()->count() . $label)->Summary(20);
    }

    /**
     * @return array
     */
    protected function provideBlockSchema()
    {
        $blockSchema = parent::provideBlockSchema();
        $blockSchema['content'] = $this->getSummary();
        return $blockSchema;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return _t(__CLASS__.'.BlockType', 'Promos');
    }
}
