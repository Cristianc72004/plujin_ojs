<?php

namespace APP\plugins\generic\visualizadorDocsPlugin;

use PKP\plugins\GenericPlugin;
use PKP\plugins\Hook;

class VisualizadorDocsPlugin extends GenericPlugin
{
    public function register($category, $path, $mainContextId = null)
    {
        if (!parent::register($category, $path, $mainContextId)) {
            return false;
        }

        $this->addLocaleData();

        Hook::add('LoadHandler', [$this, 'handleLoadHandler']);
        Hook::add('LoadComponentHandler', [$this, 'setupHandler']);

        return true;
    }

    public function getDisplayName()
    {
        return __('plugins.generic.visualizadorDocs.displayName');
    }

    public function getDescription()
    {
        return __('plugins.generic.visualizadorDocs.description');
    }

    public function handleLoadHandler($hookName, $args)
    {
        $page = $args[0];
        $op = $args[1];

        if ($page === 'grid.files.submission' && $op === 'submission-files-grid') {
            $handlerFile = $this->getPluginPath() . '/handlers/SubmissionFileGridHandler.inc.php';
            $handlerClass = 'APP\\plugins\\generic\\visualizadorDocsPlugin\\handlers\\SubmissionFileGridHandler';

            require_once($handlerFile);
            $args[3] = new $handlerClass();
            return true;
        }

        return false;
    }

    public function setupHandler($hookName, $args)
    {
        $component =& $args[0];
        if ($component === 'plugins.generic.visualizadorDocsPlugin.controllers.VisualizadorDocsHandler') {
            require_once($this->getPluginPath() . '/controllers/VisualizadorDocsHandler.php');
            return true;
        }
        return false;
    }
}
