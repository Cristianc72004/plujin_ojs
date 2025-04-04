<?php

namespace APP\plugins\generic\visualizadorDocsPlugin\handlers;

use PKP\controllers\grid\files\submission\SubmissionFilesGridHandler as PKPSubmissionFilesGridHandler;
use PKP\linkAction\LinkAction;
use PKP\linkAction\request\AjaxModal;
use PKP\core\PKPApplication;
use PKP\facades\PKPRequest;

class SubmissionFileGridHandler extends PKPSubmissionFilesGridHandler {

    public function initialize($request, $args = null) {
        parent::initialize($request, $args);

        // Cargar el idioma del plugin para el botón
        \AppLocale::requireComponents(LOCALE_COMPONENT_PKP_SUBMISSION);

        // Agregar el botón de visualización para cada archivo
        $this->addAction(
            new LinkAction(
                'visualizadorDocs',
                new AjaxModal(
                    $request->getDispatcher()->url(
                        $request,
                        ROUTE_COMPONENT,
                        null,
                        'plugins.generic.visualizadorDocsPlugin.controllers.VisualizadorDocsHandler',
                        'fetch',
                        null,
                        ['fileId' => '__id__']
                    ),
                    __('plugins.generic.visualizadorDocs.displayName'),
                    'modal_view'
                ),
                __('plugins.generic.visualizadorDocs.displayName'),
                'view'
            )
        );
    }
}
