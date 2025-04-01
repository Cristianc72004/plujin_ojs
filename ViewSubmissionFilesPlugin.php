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
                ),
                // Agregar enlace para visualizar el archivo
                new LinkAction(
                    'visualizarArchivo',
                    new AjaxModal($router->url($request, null, null, 'manage', null, array('verb' => 'visualizarArchivo', 'plugin' => $this->getName(), 'category' => 'generic')), $this->getDisplayName()),
                    __('plugins.generic.viewSubmissionFiles.visualizeFile'),
                )
            ] : [],
            parent::getActions($request, $actionArgs)
        );
    }

    public function manage($args, $request)
    {
        switch ($request->getUserVar('verb')) {
            case 'viewFiles':
                return new JSONMessage(true, 'Archivos listados en el modal...');
            case 'visualizarArchivo':
                // Aquí debes manejar la lógica para abrir y mostrar el archivo
                $fileUrl = $request->getUserVar('fileUrl'); // Recibir la URL del archivo a visualizar
                return new JSONMessage(true, 'Visualizando archivo: ' . $fileUrl);
            default:
                return parent::manage($verb, $args, $message, $messageParams);
        }
    }
}
