<?php

namespace DieSchittigs\ContaoContentApiBundle;

use Contao\ManagerBundle\ContaoManager\Plugin as ManagerBundlePlugin;
use Contao\ManagerBundle\HttpKernel\ContaoCache;
use Contao\ManagerBundle\HttpKernel\ContaoKernel;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Contao\ContentModel;
use Contao\Controller;
use Contao\ModuleNewsReader;

class ReaderHelper
{
    public static function handle($readerClass, $url)
    {
        $urlAlias = Helper::urlToAlias($url);
        $aliasParts = explode('/', $urlAlias);
        $alias = array_pop($aliasParts);
        $readerModel = $readerClass::findOneByAlias($alias);
        if (!$readerModel || !Controller::isVisibleElement($readerModel)) {
            return null;
        }
        $contents = ContentModel::findPublishedByPidAndTable($readerModel->id, $readerClass::getTable(), ['order' => 'sorting ASC']);
        $_reader = Helper::toObj($readerModel);
        if ($contents) {
            foreach ($contents as $content) {
                if (!Controller::isVisibleElement($content)) {
                    continue;
                }
                if ($content->type === 'module') {
                    $content->subModule = ContentElementHelper::module($content, $readerModel->inColumn);
                }
                $_reader->content[] = Helper::toObj($content);
            }
        }
        return $_reader;
    }
}
