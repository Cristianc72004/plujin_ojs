<?php

import('lib.pkp.classes.controllers.grid.GridHandler');

class VisualizadorDocsGridHandler extends GridHandler {
    public function authorize($request, &$args, $roleAssignments) {
        import('lib.pkp.classes.security.authorization.SubmissionFileAccessPolicy');
        $this->addPolicy(new SubmissionFileAccessPolicy($request, $args, $roleAssignments));
        return parent::authorize($request, $args, $roleAssignments);
    }

    function initialize($request, $args = null) {
        parent::initialize($request, $args);
    }

    public function viewFile($args, $request) {
        $fileId = (int)$request->getUserVar('fileId');
        $submissionFileDao = DAORegistry::getDAO('SubmissionFileDAO');
        $submissionFile = $submissionFileDao->getLatestRevision($fileId);

        $filePath = $submissionFile->getFilePath();
        $fileMimeType = $submissionFile->getFileType();

        header('Content-type: ' . $fileMimeType);
        readfile($filePath);
        exit();
    }
}
