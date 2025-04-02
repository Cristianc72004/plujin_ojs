<?php

import('classes.handler.Handler');
import('lib.pkp.classes.file.PrivateFileManager');

use APP\facades\Repo;
use PKP\submissionFile\SubmissionFile;

class DocxViewerHandler extends Handler {
    function authorize($request, &$args, $roleAssignments) {
        import('lib.pkp.classes.security.authorization.WorkflowStageAccessPolicy');
        $this->addPolicy(new WorkflowStageAccessPolicy(
            $request,
            $args,
            $roleAssignments,
            'submissionId',
            (int) $request->getUserVar('stageId')
        ));
        return parent::authorize($request, $args, $roleAssignments);
    }

    function view($args, $request) {
        $submissionFileId = (int) $request->getUserVar('submissionFileId');
        $submissionId = (int) $request->getUserVar('submissionId');

        // Usar el repositorio moderno para obtener el archivo
        $submissionFile = Repo::submissionFile()->get($submissionFileId);

        // Validar que el archivo existe y pertenece al envío
        if (!$submissionFile || $submissionFile->getData('submissionId') !== $submissionId) {
            die('Archivo no encontrado o no autorizado');
        }

        $fileManager = new PrivateFileManager();
        $filePath = $fileManager->getBasePath() . DIRECTORY_SEPARATOR . $submissionFile->getData('path');

        if (!file_exists($filePath)) {
            die('Archivo no disponible en el servidor');
        }

        // Enviar archivo .docx al navegador
        header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
        header('Content-Disposition: inline; filename="' . basename($filePath) . '"');
        header('Content-Length: ' . filesize($filePath));
        readfile($filePath);
        exit;
    }
}
