<?php

import('lib.pkp.classes.plugins.GenericPlugin');

class VisualizadorDocsPlugin extends GenericPlugin {

    public function register($category, $path, $mainContextId = NULL) {
        if (parent::register($category, $path, $mainContextId)) {
            if ($this->getEnabled()) {
                HookRegistry::register('TemplateManager::fetch', [$this, 'addVisualizarButton']);
                HookRegistry::register('LoadHandler', [$this, 'setupHandler']);
            }
            return true;
        }
        return false;
    }
    
    public function setupHandler($hookName, $args) {
        $page =& $args[0];
        $op =& $args[1];
    
        if ($page === 'visualizadorDocsGridHandler') {
            $this->import('controllers.grid.files.VisualizadorDocsGridHandler');
            define('HANDLER_CLASS', 'VisualizadorDocsGridHandler');
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

    public function addVisualizarButton($hookName, $params) {
        $templateMgr = $params[0];
        $template = $params[1];
    
        if ($template !== 'controllers/grid/gridRow.tpl') {
            return false;
        }
    
        $row = $templateMgr->getTemplateVars('row');
        if (!$row) return false;
    
        $data = $row->getData();
        if (!isset($data['submissionFile'])) return false;
    
        $submissionFile = $data['submissionFile'];
        $mimeType = strtolower($submissionFile->getData('mimetype'));
    
        // Permitir DOCX y PDF
        $allowedMimeTypes = [
            'application/pdf',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
        ];
    
        if (!in_array($mimeType, $allowedMimeTypes)) {
            return false;
        }
    
        $request = Application::get()->getRequest();
        $router = $request->getRouter();
    
        import('lib.pkp.classes.linkAction.request.AjaxModal');
    
        $url = $router->url($request, null, 'visualizadorDocsGridHandler', 'viewFile', null, [
            'fileId' => $submissionFile->getFileId()
        ]);
    
        $action = new LinkAction(
            'visualizarDocumento',
            new AjaxModal($url, __('plugins.generic.visualizadorDocs.visualizarDocumento')),
            __('plugins.generic.visualizadorDocs.visualizarDocumento'),
            'modal_view'
        );
    
        $actions = $row->getActions();
        $actions[] = $action;
        $row->setActions($actions);
    }
    
}
