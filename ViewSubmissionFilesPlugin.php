<?php

namespace APP\plugins\generic\viewSubmissionFiles;

use PKP\plugins\GenericPlugin;
use PKP\linkAction\LinkAction;
use PKP\linkAction\request\AjaxModal;
use APP\core\Application;
use PKP\core\JSONMessage;

class ViewSubmissionFilesPlugin extends GenericPlugin
{
    public function register($category, $path, $mainContextId = null)
    {
        $success = parent::register($category, $path);
        return $success;
    }

    public function getDisplayName(): string
    {
        return __('plugins.generic.viewSubmissionFiles.displayName');
    }

    public function getDescription(): string
    {
        return __('plugins.generic.viewSubmissionFiles.description');
    }

    public function getCanEnable()
    {
        return ((bool) Application::get()->getRequest()->getContext());
    }

    public function getCanDisable()
    {
        return ((bool) Application::get()->getRequest()->getContext());
    }

    public function getActions($request, $actionArgs)
    {
        $router = $request->getRouter();
        return array_merge(
            $this->getEnabled() ? [
                new LinkAction(
                    'viewFiles',
                    new AjaxModal($router->url($request, null, null, 'manage', null, array('verb' => 'viewFiles', 'plugin' => $this->getName(), 'category' => 'generic')), $this->getDisplayName()),
                    __('plugins.generic.viewSubmissionFiles.viewFiles'),
                )
            ] : [],
            parent::getActions($request, $actionArgs)
        );
    }

    public function manage($args, $request)
    {
        switch ($request->getUserVar('verb')) {
            case 'viewFiles':
                // Implementa la lógica para mostrar los archivos en el modal
                // Aquí puedes obtener la lista de archivos desde la carpeta, por ejemplo, 'C:/xampp/Revista/journals/1/articles'
                return new JSONMessage(true, 'Archivos listados en el modal...');
            default:
                return parent::manage($verb, $args, $message, $messageParams);
        }
    }
}
