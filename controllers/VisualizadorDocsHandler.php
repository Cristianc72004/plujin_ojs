<?php

namespace APP\plugins\generic\visualizadorDocsPlugin\controllers;

use PKP\handler\APIHandler;
use APP\facades\Repo;
use PKP\core\JSONMessage;

class VisualizadorDocsHandler extends APIHandler {
    
    public function fetch($slimRequest, $response, $args) {
        $request = $this->getRequest();
        $fileId = (int) $request->getUserVar('fileId');

        $submissionFile = Repo::submissionFile()->get($fileId);
        if (!$submissionFile) {
            return $response->withJson([
                'status' => false,
                'content' => __('plugins.generic.visualizadorDocs.fileNotFound')
            ], 404);
        }

        $filePath = $submissionFile->getFilePath();
        $fileType = $submissionFile->getFileType();

        header('Content-Type: ' . $fileType);
        header('Content-Disposition: inline; filename="' . basename($filePath) . '"');
        readfile($filePath);
        exit;
    }
}
