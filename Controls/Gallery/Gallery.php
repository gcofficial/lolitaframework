<?php
namespace zorgboerderij_lenteheuvel_wp\LolitaFramework\Controls\Gallery;

use \zorgboerderij_lenteheuvel_wp\LolitaFramework\Controls\Control;
use \zorgboerderij_lenteheuvel_wp\LolitaFramework\Controls\IHaveAdminEnqueue;
use \zorgboerderij_lenteheuvel_wp\LolitaFramework\Core\HelperImage;
use \zorgboerderij_lenteheuvel_wp\LolitaFramework\Core\HelperArray;
use \zorgboerderij_lenteheuvel_wp\LolitaFramework\Core\HelperString;
use \zorgboerderij_lenteheuvel_wp\LolitaFramework\Core\View;
use \zorgboerderij_lenteheuvel_wp\LolitaFramework as LolitaFramework;

class Gallery extends Control implements iHaveAdminEnqueue
{
    /**
     * Control constructor
     * @param array $parameters control parameters.
     */
    public function __construct(array $parameters)
    {
        parent::__construct($parameters);
        $this->parameters['ID'] = $this->getID();
    }

    /**
     * Add scripts and styles
     */
    public static function adminEnqueue()
    {
        // ==============================================================
        // Styles
        // ==============================================================
        wp_enqueue_style(
            'lolita-gallery-control',
            LolitaFramework::getURLByDirectory(__DIR__) . '/assets/css/gallery.css'
        );
        wp_enqueue_style(
            'lolita-controls',
            self::getURL() . '/assets/css/controls.css'
        );

        // ==============================================================
        // Scripts
        // ==============================================================
        wp_enqueue_media();
        wp_enqueue_script('jquery');
        wp_enqueue_script('underscore');
        wp_enqueue_script(
            'lolita-gallery-control',
            LolitaFramework::getURLByDirectory(__DIR__) . '/assets/js/gallery.js',
            array('jquery', 'underscore'),
            false,
            true
        );
    }

    /**
     * Render our control
     * @return string HTML control code.
     */
    public function render()
    {
        $values = $this->getValue();
        $this->parameters['value'] = '';
        $this->parameters['items'] = $this->getItems($values);
        $this->parameters['template'] = base64_encode(
            View::make(
                __DIR__ . DS . 'views' . DS . 'template.php',
                $this->parameters
            )
        );
        return parent::render();
    }

    /**
     * All gallery items
     * @return array all items.
     */
    public function getItems($values)
    {
        $result = array();
        if (is_array($values)) {
            foreach ($values as $key => $value) {
                $p = get_post((int) $value);
                if (null !== $p) {
                    $p->src = HelperImage::getURL($p->ID);
                    array_push($result, $p);
                }
            }
        }
        return $result;
    }
}
