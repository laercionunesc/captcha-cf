<?php
namespace CaptchaCf\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\Core\Configure;
use Cake\Http\Client;

/**
 * CaptchaCf component
 */
class CaptchaCfComponent extends Component
{

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [
        'sitekey' => '2x00000000000000000000AB',
        'secret' => '2x0000000000000000000000000000000AA',
        'size' => 'flexible',
        'theme' => 'auto',
        'language' => 'en',
        'enable' => true,
        'httpClientOptions' => [],
    ];

    /**
     * initialize
     * @param array $config config
     * @return void
     */
    public function initialize(array $config = [])
    {
        if (empty($config)) {
            $config = Configure::read('CaptchaCf', []);
        }

        $this->setConfig($config);
        $this->_registry->getController()->viewBuilder()->setHelpers(['CaptchaCf.CaptchaCf' => $this->_config]);
    }

    /**
     * verify captcha
     * @return bool
     */
    public function verify()
    {
        if (!$this->_config['enable']) {
            return true;
        }

        $controller = $this->_registry->getController();

        if ($controller->request->getData('cf-turnstile-response')) {
            $response = json_decode($this->apiCall());

            if (isset($response->success) && $response->success === true) {
                return $response->success;
            }
        }

        return false;
    }

    /**
     * Call CAPTCHA API to verify
     *
     * @return string
     * @codeCoverageIgnore
     */
    protected function apiCall()
    {
        $controller = $this->_registry->getController();
        $client = new Client($this->_config['httpClientOptions']);
        return $client->post('https://challenges.cloudflare.com/turnstile/v0/siteverify', [
            'secret' => $this->_config['secret'],
            'response' => $controller->request->getData('cf-turnstile-response'),
            'remoteip' => $controller->request->clientIp(),
        ])->getBody();
    }
}
