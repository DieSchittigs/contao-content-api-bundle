<?php

namespace DieSchittigs\ContaoContentApiBundle;

use Contao\UserModel;

/**
 * ApiContentElement augments ArticleModel for the API.
 */
class Author extends AugmentedContaoModel
{
    /**
     * constructor.
     *
     * @param int $id id of the author/user
     */
    public function __construct($id)
    {
        $this->model = UserModel::findById($id, ['disable'], ['']);
        if (!$this->model) $this->model = null;
    }

    public function toJson(): ContaoJson
    {
        if (!$this->model) {
            return parent::toJson();
        }
        $author = $this->model->row();
        unset($author['id']);
        unset($author['tstamp']);
        unset($author['backendTheme']);
        unset($author['themes']);
        unset($author['imageSizes']);
        unset($author['fullscreen']);
        unset($author['uploader']);
        unset($author['showHelp']);
        unset($author['thumbnails']);
        unset($author['useRTE']);
        unset($author['useCE']);
        unset($author['password']);
        unset($author['pwChange']);
        unset($author['admin']);
        unset($author['groups']);
        unset($author['inherit']);
        unset($author['modules']);
        unset($author['pagemounts']);
        unset($author['alpty']);
        unset($author['filemounts']);
        unset($author['fop']);
        unset($author['forms']);
        unset($author['formp']);
        unset($author['amg']);
        unset($author['disable']);
        unset($author['start']);
        unset($author['stop']);
        unset($author['session']);
        unset($author['new_records']);
        unset($author['tl_page_tree']);
        unset($author['tl_page_node']);
        unset($author['fieldset_states']);
        unset($author['tl_image_size']);
        unset($author['tl_page']);
        unset($author['tl_user']);
        unset($author['tl_settings']);
        unset($author['tl_news_archive']);
        unset($author['tl_article_tl_page_tree']);
        unset($author['filetree']);
        unset($author['dateAdded']);
        unset($author['secret']);
        unset($author['useTwoFactor']);
        unset($author['lastLogin']);
        unset($author['currentLogin']);
        unset($author['locked']);
        unset($author['news']);
        unset($author['newp']);
        unset($author['newsfeeds']);
        unset($author['newsfeedp']);
        unset($author['trustedTokenVersion']);
        unset($author['backupCodes']);
        unset($author['loginAttempts']);
        unset($author['fields']);
        unset($author['elements']);
        return new ContaoJson($author);
    }
}
