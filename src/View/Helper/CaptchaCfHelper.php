<?php
namespace CaptchaCf\View\Helper;

use Cake\View\Helper;
use Cake\View\View;

/**
 * CaptchaCf helper
 */
class CaptchaCfHelper extends Helper
{

    /**
     * Constructor.
     *
     * @param array $config The settings for this helper.
     * @return void
     */
    public function initialize(array $config = [])
    {
        $this->setConfig($config);
    }

    /**
     * Display recaptcha function
     * @return string
     */
    public function display()
    {
        $recaptchacf = $this->getConfig();
        if (!$recaptchacf['enable']) {
            return '';
        }

        return $this->_View->element('CaptchaCf.CaptchaCf', compact('recaptchacf'));
    }

}
