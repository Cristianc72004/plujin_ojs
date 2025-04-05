<?php

namespace APP\plugins\generic\visualizadorDocsPlugin;

use PKP\plugins\GenericPlugin;
use PKP\plugins\Hook;
use PKP\linkAction\LinkAction;
use PKP\linkAction\request\RedirectAction;

class VisualizadorDocsPlugin extends GenericPlugin {

    public function register($category, $path, $mainContextId = null) {
        if (parent::register($category, $path, $mainContextId)) {
            Hook::add('LoadComponentHandler', [$this, 'setupHandler']);
            Hook::add('FileView::display::submissionFileActions', [$this, 'addButtonToGridRow']);
            return true;
        }
        return false;
    }

    public function getDisplayName() {
        return __('plugins.generic.visualizadorDocs.displayName');
    }

    public function getDescription() {
        return __('plugins.generic.visualizadorDocs.description');
    }

    public function setupHandler($hookName, $args) {
        $component =& $args[0];
        if ($component === 'plugins.generic.visualizadorDocsPlugin.controllers.VisualizadorDocsHandler') {
            require_once($this->getPluginPath() . '/controllers/VisualizadorDocsHandler.php');
            return true;
        }
        return false;
    }

    public function addButtonToGridRow($hookName, $args) {
        $submissionFile = $args[0]; // objeto SubmissionFile
        $actions =& $args[1];       // array de acciones existentes

        $fileType = strtolower($submissionFile->getFileType());
        if (!in_array($fileType, ['application/pdf', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'])) {
            return;
        }

        $request = \Application::get()->getRequest();
        $dispatcher = $request->getDispatcher();

        $url = $dispatcher->url(
            $request,
            \PKP\core\PKPApplication::ROUTE_COMPONENT,
            null,
            'plugins.generic.visualizadorDocsPlugin.controllers.VisualizadorDocsHandler',
            'fetch',
            null,
            ['fileId' => $submissionFile->getId()]
        );

        $actions[] = new LinkAction(
            'visualizarDoc',
            new RedirectAction($url),
            __('plugins.generic.visualizadorDocs.view'),
            'view'
        );

        return false;
    }
}
