<?php

namespace APP\plugins\generic\visualizadorDocsPlugin\handlers;

use PKP\controllers\grid\files\submission\SubmissionFilesGridHandler as PKPSubmissionFilesGridHandler;
use PKP\core\PKPApplication;
use PKP\linkAction\LinkAction;
use PKP\linkAction\request\AjaxModal;
use PKP\facades\PKPRequest;
use APP\template\TemplateManager;

class SubmissionFileGridHandler extends PKPSubmissionFilesGridHandler
{
    /**
     * Inicializa el handler extendido
     */
    public function initialize($request, $args = null)
    {
        parent::initialize($request, $args);

        // Esto asegura que las cadenas del plugin estén disponibles
        \AppLocale::requireComponents(LOCALE_COMPONENT_APP_SUBMISSION, LOCALE_COMPONENT_PKP_SUBMISSION);

        // Recorre las filas y agrega el botón en cada una
        foreach ($this->_data as $categoryData) {
            foreach ($categoryData as $rowData) {
                $fileId = $rowData->getId();

                $viewUrl = $request->getDispatcher()->url(
                    $request,
                    PKPApplication::ROUTE_COMPONENT,
                    null,
                    'plugins.generic.visualizadorDocsPlugin.controllers.VisualizadorDocsHandler',
                    'fetch',
                    null,
                    ['fileId' => $fileId]
                );

                // Botón de acción
                $rowData->setData('actions', array_merge(
                    $rowData->getData('actions') ?? [],
                    [
                        new LinkAction(
                            'visualizadorDocs',
                            new AjaxModal(
                                $viewUrl,
                                __('plugins.generic.visualizadorDocs.displayName'),
                                'modal_view'
                            ),
                            __('plugins.generic.visualizadorDocs.displayName'),
                            'view'
                        )
                    ]
                ));
            }
        }
    }
}
