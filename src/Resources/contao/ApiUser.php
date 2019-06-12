<?php

namespace DieSchittigs\ContaoContentApiBundle;

use Contao\Frontend;
use Contao\MemberModel;

/**
 * ApiUser will output the frontend user (member) that is currently logged in.
 * Will return 'null' in case of error.
 */
class ApiUser extends Frontend implements ContaoJsonSerializable
{
    public function __construct()
    {
        $this->import('FrontendUser', 'User');
        parent::__construct();
        define('FE_USER_LOGGED_IN', $this->getLoginStatus('FE_USER_AUTH'));
    }

    public function toJson(): ContaoJson
    {
        if (!$this->User || !$this->User->authenticate()) {
            return new ContaoJson(null);
        }
        $model = MemberModel::findById($this->User->id);
        $model->groups = $this->User->groups;
        $model->roles = $this->User->getRoles();
        $model->password = null;
        $model->session = null;

        return new ContaoJson($model);
    }
}
