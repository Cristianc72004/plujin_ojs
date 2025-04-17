<?php

namespace APP\plugins\generic\docxViewer;

import('lib.pkp.classes.handler.PKPHandler');
import('classes.template.TemplateManager');

use APP\facades\Repo;
use PKP\file\PrivateFileManager;

class DocxViewerHandler extends \PKPHandler {
    public static $pluginInstance;

    public function view($args, $request) {
        $user = $request->getUser();
        if (!$user) {
            die('Acceso no autorizado');
        }

        $submissionFileId = (int) $request->getUserVar('submissionFileId');
        $submissionFile = Repo::submissionFile()->get($submissionFileId);

        if (!$submissionFile) {
            die('Archivo no encontrado');
        }

        $fileManager = new \PKP\file\PrivateFileManager();
        $privatePath = $fileManager->getBasePath() . DIRECTORY_SEPARATOR . $submissionFile->getData('path');

        if (!file_exists($privatePath)) {
            die('Archivo no disponible en el servidor');
        }

        $fileName = $submissionFile->getLocalizedData('name') ?: $submissionFile->getData('originalFileName');
        $safeName = preg_replace('/\s+/', '_', $fileName);

        // Ruta pública en public/journals/1/
        $publicDir = 'C:/xampp/htdocs/ojs/public/journals/1/';
        if (!is_dir($publicDir)) {
            mkdir($publicDir, 0777, true);
        }

        $publicPath = $publicDir . $safeName;
        if (!file_exists($publicPath)) {
            copy($privatePath, $publicPath);
        }

        // Usa la URL pública de NGROK para OnlyOffice
        $ngrokDomain = 'https://528c-45-184-102-35.ngrok-free.app'; // <-- cambia si ngrok reinicia
        $fileUrl = $ngrokDomain . '/ojs/public/journals/1/' . rawurlencode($safeName);

        $templateMgr = \TemplateManager::getManager($request);
        $templateMgr->assign('fileUrl', $fileUrl);
        $templateMgr->assign('fileName', $safeName);

        $plugin = self::$pluginInstance;
        $templateMgr->display($plugin->getTemplateResource('viewer.tpl'));
    }
}
