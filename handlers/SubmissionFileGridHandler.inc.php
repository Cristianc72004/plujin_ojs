<?php

namespace APP\plugins\generic\visualizadorDocsPlugin\handlers;

use PKP\controllers\grid\files\submission\SubmissionFilesGridHandler as PKPSubmissionFilesGridHandler;

/**
 * Este handler extiende la grilla de archivos de envío para insertar el botón personalizado.
 */
class SubmissionFileGridHandler extends PKPSubmissionFilesGridHandler
{
    /**
     * Sobrescribe la función getRowInstance para usar nuestra fila extendida
     */
    protected function getRowInstance()
    {
        // Asegúrate de que el archivo de la fila esté disponible
        require_once($this->getPluginPath() . '/handlers/SubmissionFileGridRow.inc.php');

        // Retorna una instancia de la fila personalizada
        return new \APP\plugins\generic\visualizadorDocsPlugin\handlers\SubmissionFileGridRow();
    }
}

