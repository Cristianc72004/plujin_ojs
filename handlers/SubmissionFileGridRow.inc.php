<?php

namespace APP\plugins\generic\visualizadorDocsPlugin\handlers;

use PKP\controllers\grid\files\submission\SubmissionFilesGridRow as PKPSubmissionFilesGridRow;
use PKP\linkAction\LinkAction;
use PKP\linkAction\request\AjaxModal;
use PKP\core\PKPApplication;

class SubmissionFileGridRow extends PKPSubmissionFilesGridRow
{
    protected function initialize($request)
    {
        parent::initialize($request);

        $submissionFile = $this->getData();
        if (!$submissionFile) {
            return;
        }

        $fileType = $submissionFile->getFileType();
        if (!in_array($fileType, ['application/pdf', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'])) {
            return;
        }

        $fileId = $submissionFile->getId();

        $viewUrl = $request->getDispatcher()->url(
            $request,
            PKPApplication::ROUTE_COMPONENT,
            null,
            'plugins.generic.visualizadorDocsPlugin.controllers.VisualizadorDocsHandler',
            'fetch',
            null,
            ['fileId' => $fileId]
        );

        $this->addAction(new LinkAction(
            'visualizadorDocs',
            new AjaxModal(
                $viewUrl,
                __('plugins.generic.visualizadorDocs.displayName'),
                'modal_view'
            ),
            __('plugins.generic.visualizadorDocs.displayName'),
            'view'
        ));
    }
}
