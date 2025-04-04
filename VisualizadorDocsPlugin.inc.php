<?php

namespace APP\plugins\generic\visualizadorDocsPlugin;

use PKP\plugins\GenericPlugin;
use PKP\plugins\Hook;

class VisualizadorDocsPlugin extends GenericPlugin {

    public function register($category, $path, $mainContextId = null) {
        if (parent::register($category, $path, $mainContextId)) {
            Hook::add('Template::Submission::SubmissionFiles::FileActions', [$this, 'addVisualizadorButton']);
            Hook::add('LoadComponentHandler', [$this, 'setupHandler']);
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

    public function addVisualizadorButton($hookName, $args) {
        $smarty =& $args[1];
        $output =& $args[2];
        $submissionFile = $smarty->getTemplateVars('submissionFile');
    
        $templateMgr = \APP\template\TemplateManager::getManager();
        $templateMgr->assign('fileId', $submissionFile->getId());
    
        $visualizadorButton = $templateMgr->fetch($this->getTemplateResource('visualizador.tpl'));
        $output .= $visualizadorButton;
        return false;
    }
    

    public function setupHandler($hookName, $args) {
        $component =& $args[0];
        if ($component === 'plugins.generic.visualizadorDocsPlugin.controllers.VisualizadorDocsHandler') {
            require_once($this->getPluginPath() . '/controllers/VisualizadorDocsHandler.php');
            return true;
        }
        return false;
    }
}
