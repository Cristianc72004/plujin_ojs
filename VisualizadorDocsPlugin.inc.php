<?php

namespace APP\plugins\generic\visualizadorDocsPlugin;

use PKP\plugins\GenericPlugin;
use PKP\plugins\Hook;
use APP\template\TemplateManager;

class VisualizadorDocsPlugin extends GenericPlugin
{
    public function register($category, $path, $mainContextId = null)
    {
        if (!parent::register($category, $path, $mainContextId)) {
            return false;
        }

        // Agregar archivos de idioma
        $this->addLocaleData();

        // Hooks principales
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

    /**
     * Intercepta la carga del handler de la grilla de archivos de envío
     */
    public function handleLoadHandler($hookName, $args)
    {
        $page = $args[0];
        $op = $args[1];
    
        // Interceptar la grilla de archivos de envío
        if ($page === 'grid.files.submission' && $op === 'submission-files-grid') {
            // Reemplaza el handler de OJS por el tuyo personalizado
            $handlerFile = $this->getPluginPath() . '/handlers/SubmissionFileGridHandler.inc.php';
            $handlerClass = 'APP\\plugins\\generic\\visualizadorDocsPlugin\\handlers\\SubmissionFileGridHandler';
    
            require_once($handlerFile);
            $args[3] = new $handlerClass();
            return true;
        }
    
        return false;
    }
    

    /**
     * Registra el handler del plugin para la visualización de documentos
     */
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
