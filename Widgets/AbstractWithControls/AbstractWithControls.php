<?php
namespace zorgboerderij_lenteheuvel_wp\LolitaFramework\Widgets\AbstractWithControls;

use \zorgboerderij_lenteheuvel_wp\LolitaFramework\Core\HelperArray;
use \zorgboerderij_lenteheuvel_wp\LolitaFramework\Core\HelperString;
use \zorgboerderij_lenteheuvel_wp\LolitaFramework\Core\View;
use \zorgboerderij_lenteheuvel_wp\LolitaFramework\Controls\Controls;
use \zorgboerderij_lenteheuvel_wp\LolitaFramework\Widgets\IHaveBeforeInit;
use \zorgboerderij_lenteheuvel_wp\LolitaFramework\Widgets\AbstractWidget\AbstractWidget;

abstract class AbstractWithControls extends AbstractWidget implements IHaveBeforeInit
{
    /**
     * Get controls data
     * @return array data to generate controls.
     */
    public static function getControlsData()
    {
        return array();
    }

    /**
     * This function run before widgets_init hook
     * @return void
     */
    public static function beforeInit()
    {
        Controls::loadScriptsAndStyles(static::getControlsData());
    }

    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param array $instance Previously saved values from database.
     */
    public function form($instance)
    {
        $controls = new Controls;
        $controls_data = static::getControlsData();
        foreach ($controls_data as &$control) {
            $control['small_name'] = $control['name'];
            $control['name'] = $this->get_field_name($control['name']);
        }

        $controls->generateControls($controls_data);

        if ($controls instanceof Controls) {
            foreach ($controls->collection as $control) {
                // ==============================================================
                // Set new value
                // ==============================================================
                $control->setValue(
                    HelperArray::get($instance, $control->parameters['small_name'])
                );
                // ==============================================================
                // Fill new attributes
                // ==============================================================
                $control->parameters = array_merge(
                    $control->parameters,
                    array(
                        'class' => $control->parameters['small_name'] . '-class widefat',
                        'id' => $this->get_field_id($control->getID()),
                    )
                );
            }
            echo $controls->render(
                dirname(__FILE__) . DS . 'views' . DS . 'collection.php',
                dirname(__FILE__) . DS . 'views' . DS . 'row.php'
            );
        } else {
            throw new \Exception('Wrong $controls object');
        }
    }
}
