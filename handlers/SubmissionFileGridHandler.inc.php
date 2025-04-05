<?php

namespace APP\plugins\generic\visualizadorDocsPlugin\handlers;

use PKP\controllers\grid\files\submission\SubmissionFilesGridHandler as PKPSubmissionFilesGridHandler;

class SubmissionFileGridHandler extends PKPSubmissionFilesGridHandler
{
    protected function getRowInstance()
    {
        require_once($this->getPluginPath() . '/handlers/SubmissionFileGridRow.inc.php');
        return new \APP\plugins\generic\visualizadorDocsPlugin\handlers\SubmissionFileGridRow();
    }
}
