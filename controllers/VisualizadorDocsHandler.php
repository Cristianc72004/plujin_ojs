<?php

namespace APP\plugins\generic\visualizadorDocsPlugin\controllers;

use PKP\handler\APIHandler;
use APP\facades\Repo;

class VisualizadorDocsHandler extends APIHandler {

    public function fetch($slimRequest, $response, $args) {
        $request = $this->getRequest();
        $fileId = (int) $request->getUserVar('fileId');

        $submissionFile = Repo::submissionFile()->get($fileId);
        if (!$submissionFile) {
            header('HTTP/1.0 404 Not Found');
            echo __('plugins.generic.visualizadorDocs.fileNotFound');
            exit;
        }

        $filePath = $submissionFile->getFilePath();
        $fileType = $submissionFile->getFileType();

        header('Content-Type: ' . $fileType);
        header('Content-Disposition: inline; filename="' . basename($filePath) . '"');
        readfile($filePath);
        exit;
    }
}
