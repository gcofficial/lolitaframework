<?php
namespace MyProject\LolitaFramework\Configuration\Modules;

use \MyProject\LolitaFramework\Core\Str;
use \MyProject\LolitaFramework\Configuration\Init;
use \MyProject\LolitaFramework\Configuration\Configuration;
use \MyProject\LolitaFramework\Configuration\IModule;

class Languages extends Init implements IModule
{
    /**
     * Languages class constructor
     *
     * @author Guriev Eugen <gurievcreative@gmail.com>
     * @param array $data engine data.
     */
    public function __construct($data = null)
    {
        $this->data        = (array) $data;
        $this->init_action = 'after_setup_theme';
        $this->init();
    }

    /**
     * Run by the 'init' hook.
     * Execute the "add_theme_support" function from WordPress.
     *
     * @author Guriev Eugen <gurievcreative@gmail.com>
     * @return void
     */
    public function install()
    {
        if (is_array($this->data) && ! empty($this->data)) {
            foreach ($this->data as $domain => $path) {
                /*
                 * Make theme available for translation.
                 * Translations can be filed in the /languages/ directory.
                 */
                load_theme_textdomain($domain, Str::compileVariables($path));
            }
        }
    }

    /**
     * Module priority
     *
     * @author Guriev Eugen <gurievcreative@gmail.com>
     * @return [int] priority, the smaller number the faster boot.
     */
    public static function getPriority()
    {
        return Configuration::DEFAULT_PRIORITY;
    }
}
