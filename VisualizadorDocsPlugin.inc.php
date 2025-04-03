<?php

import('lib.pkp.classes.plugins.GenericPlugin');

class VisualizadorDocsPlugin extends GenericPlugin {

    public function register($category, $path, $mainContextId = NULL) {
        if (parent::register($category, $path, $mainContextId)) {
            if ($this->getEnabled()) {
                HookRegistry::register('Templates::Workflow::submissionFilesGrid::Cell::SubmissionFiles::Actions', [$this, 'addVisualizarButton']);
            }
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

    public function addVisualizarButton($hookName, $args) {
        $row = $args[0];
        $actions =& $args[2];
        $submissionFile = $row->getData();
        
        $request = Application::get()->getRequest();
        $router = $request->getRouter();

        import('lib.pkp.classes.linkAction.request.AjaxModal');
        
        $url = $router->url($request, null, 'grid.files.VisualizadorDocsGridHandler', 'viewFile', null, ['fileId' => $submissionFile->getFileId()]);
        $action = new LinkAction('visualizar', new AjaxModal($url, __('plugins.generic.visualizadorDocs.visualizarDocumento')), __('plugins.generic.visualizadorDocs.visualizarDocumento'), 'modal_information');

        array_push($actions, $action);
    }
}
