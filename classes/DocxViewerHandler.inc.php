<?php
import('classes.handler.Handler');
import('lib.pkp.classes.file.PrivateFileManager');

use APP\facades\Repo;
use PKP\security\authorization\ContextAccessPolicy;

class DocxViewerHandler extends Handler {
    public function authorize($request, &$args, $roleAssignments) {
        import('lib.pkp.classes.security.authorization.WorkflowStageAccessPolicy');

        $stageId = (int) $request->getUserVar('stageId');
        $submissionId = (int) $request->getUserVar('submissionId');

        $this->addPolicy(new WorkflowStageAccessPolicy(
            $request,
            $args,
            $roleAssignments,
            'submissionId',
            $stageId
        ));
        return parent::authorize($request, $args, $roleAssignments);
    }

    public function view($args, $request) {
        $submissionFileId = (int) $request->getUserVar('submissionFileId');
        $submissionId = (int) $request->getUserVar('submissionId');

        $submissionFile = Repo::submissionFile()->get($submissionFileId);
        if (!$submissionFile || $submissionFile->getData('submissionId') !== $submissionId) {
            die('Archivo no encontrado o no autorizado');
        }

        $fileManager = new PrivateFileManager();
        $filePath = $fileManager->getBasePath() . DIRECTORY_SEPARATOR . $submissionFile->getData('path');

        if (!file_exists($filePath)) {
            die('Archivo no disponible en el servidor');
        }

        header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
        header('Content-Disposition: inline; filename="' . basename($filePath) . '"');
        header('Content-Length: ' . filesize($filePath));
        readfile($filePath);
        exit;
    }
}
