<?php

use \Breakdance\Forms\Actions\Action;

class FileLog extends Action {

    /**
     * Get the displayable label of the action.
     *
     * @return string
     */
    public static function name()
    {
        return 'File Log';
    }

    /**
     * Get the URL friendly slug of the action.
     *
     * @return string
     */
    public static function slug()
    {
        return 'file-log';
    }

    /**
     * Do something on form submission
     *
     * @return array
     */
    public function run($form, $settings, $extra)
    {
        try {
            $this->writeToFile($extra['formId'], $extra['fields']);
        } catch(Exception $e) {
            return ['type' => 'error', 'message' => $e->getMessage()];
        }

        return ['type' => 'success', 'message' => 'Submission logged to file'];
    }

    /**
     * @param $formId
     * @param $formData
     * @return void
     * @throws JsonException
     * @throws RuntimeException
     */
    public function writeToFile($formId, $formData)
    {
        $jsonData = json_encode($formData, JSON_THROW_ON_ERROR);

        $path = trailingslashit(plugin_dir_path(__FILE__) . "submissions/" . $formId);

        if (!wp_mkdir_p($path, FS_CHMOD_DIR, true) && !is_dir($path)) {
            throw new \RuntimeException(sprintf('Directory "%s" could not be created', $path));
        }

        $filename = $path . time() .".json";
        $written = file_put_contents($filename, $jsonData);

        if ($written === false) {
            throw new \RuntimeException(sprintf('File "%s" could not be written', $filename));
        }
    }
}
