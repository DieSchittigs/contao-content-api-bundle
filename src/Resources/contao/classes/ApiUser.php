<?php

namespace DieSchittigs\ContaoContentApiBundle;

use Contao\Frontend;
use Contao\Config;

class ApiUser extends Frontend
{
    public function __construct()
    {
        $this->import('FrontendUser', 'User');
        parent::__construct();
        define('FE_USER_LOGGED_IN', $this->getLoginStatus('FE_USER_AUTH'));
        Config::set('debugMode', false);
    }
    public function getUser()
    {
        if (!$this->User || !$this->User->authenticate()) {
            return null;
        }
        return $this->User;
    }
}
