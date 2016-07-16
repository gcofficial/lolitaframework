<?php
namespace MyProject\LolitaFramework\Widgets;

use \MyProject\LolitaFramework\Core\Loc;
use \MyProject\LolitaFramework\Core\Cls;

class Widgets
{
    /**
     * Loaded data.
     * @var array
     */
    private $data = array();

    /**
     * All loaded widgets
     *
     * @var null
     */
    private $loaded_widgets = null;

    /**
     * Widgets class constructor
     *
     * @author Guriev Eugen <gurievcreative@gmail.com>
     */
    public function __construct()
    {
        $this->data = $this->getAllClasses();
        $this->runBeforeInits();
        add_action('widgets_init', array($this, 'load'));
    }

    /**
     * Get all paths to classes
     *
     * @author Guriev Eugen <gurievcreative@gmail.com>
     * @return array
     */
    public static function getAllClasses()
    {
        $result  = array();
        $folders = (array) glob(dirname(__FILE__) . '/*', GLOB_ONLYDIR);
        foreach ($folders as $folder) {
            $class_name = NS . __NAMESPACE__ . NS . basename($folder) . NS . basename($folder);
            if (class_exists($class_name)) {
                $class_candidate = new \ReflectionClass($class_name);
                if (false === $class_candidate->isAbstract()) {
                    $result[] = $class_name;
                }
            }
        }
        return $result;
    }

    /**
     * Load classes
     *
     * @author Guriev Eugen <gurievcreative@gmail.com>
     */
    public function load()
    {
        foreach ($this->data as $class) {
            register_widget($class);
        }
    }

    /**
     * This function run before widgets_init hook
     *
     * @author Guriev Eugen <gurievcreative@gmail.com>
     * @return void
     */
    public function runBeforeInits()
    {
        foreach ($this->data as $class) {
            if (Cls::isImplements($class, __NAMESPACE__ . NS . 'IHaveBeforeInit')) {
                $class::beforeInit();
            }
        }
    }
}
