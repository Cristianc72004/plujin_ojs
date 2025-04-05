<?php

namespace APP\plugins\generic\visualizadorDocsPlugin;

use PKP\plugins\GenericPlugin;
use PKP\plugins\Hook;

class VisualizadorDocsPlugin extends GenericPlugin {

    public function register($category, $path, $mainContextId = null) {
        if (parent::register($category, $path, $mainContextId)) {
            Hook::add('LoadComponentHandler', [$this, 'setupHandler']);
            Hook::add('TemplateManager::fetch', [$this, 'addViewButton']);
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

    public function addViewButton($hookName, $params) {
        $templateMgr = $params[0];
        $template = $params[1];
    
        // Seguridad extra: prevenir error si no hay output
        $args = func_get_args();
        if (!isset($args[2])) return false;
    
        $output =& $args[2];
    
        if ($template !== 'controllers/grid/gridRow.tpl') return;
    
        $row = $templateMgr->getTemplateVars('row');
        if (!$row || !method_exists($row, 'getData')) return;
    
        $data = $row->getData();
        if (!isset($data['submissionFile'])) return;
    
        $submissionFile = $data['submissionFile'];
        $mimeType = strtolower($submissionFile->getData('mimetype'));
    
        if (!in_array($mimeType, ['application/pdf', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'])) return;
    
        $templateMgr->assign([
            'fileId' => $submissionFile->getId(),
        ]);
    
        $output .= $templateMgr->fetch($this->getTemplateResource('visualizadorButton.tpl'));
        return false;
    }
    
}
