<?php
/**
 * Created by PhpStorm.
 * User: DhanPris
 * Date: 15/05/2018
 * Time: 11:51
 */

namespace App\Traits;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

trait fileUploadTrait
{
    /**
     * @var string
     */
    protected $uploadPath = 'uploads';

    /**
     * @var
     */
    public $folderName;

    /**
     * @var string
     */
    public $rule = 'image|max:2000';

    /**
     * @return bool
     */
    private function createUploadFolder(): bool
    {
        if (!file_exists(config('filesystems.disks.public.root') . '/' . $this->uploadPath . '/' . $this->folderName)) {
            $attachmentPath = config('filesystems.disks.public.root') . '/' . $this->uploadPath . '/' . $this->folderName;
            mkdir($attachmentPath, 0777);

            Storage::put('public/' . $this->uploadPath . '/' . $this->folderName . '/index.html', 'Silent Is Golden');

            return true;
        }

        return false;

    }

    /**
     * For handle validation file action
     *
     * @param $file
     * @return fileUploadTrait|\Illuminate\Http\RedirectResponse
     */
    private function validateFileAction($file)
    {

        $rules = array('fileupload' => $this->rule);
        $file  = array('fileupload' => $file);

        $fileValidator = Validator::make($file, $rules);

        if ($fileValidator->fails()) {

            $messages = $fileValidator->messages();

            return redirect()->back()->withInput(request()->all())
                ->withErrors($messages);

        }
    }

    /**
     * For Handle validation file
     *
     * @param $files
     * @return fileUploadTrait|\Illuminate\Http\RedirectResponse
     */
    private function validateFile($files)
    {

        if (is_array($files)) {
            foreach ($files as $file) {
                return $this->validateFileAction($file);
            }
        }

        return $this->validateFileAction($files);
    }

    /**
     * For Handle Put File
     *
     * @param $file
     * @return bool|string
     */
    private function putFile($file)
    {
        $fileName = preg_replace('/\s+/', '_', time() . ' ' . $file->getClientOriginalName());
        $path     = $this->uploadPath . '/' . $this->folderName . '/';

        if (Storage::putFileAs('public/' . $path, $file, $fileName)) {
            return $path . $fileName;
        }

        return false;
    }

    /**
     * For Handle Save File Process
     *
     * @param $files
     * @return array
     */
    public function saveFiles($files)
    {
        $data = [];

        if($files != null){

            $this->validateFile($files);

            $this->createUploadFolder();

            if (is_array($files)) {

                foreach ($files as $file) {
                    $data[] = $this->putFile($file);
                }

            } else {

                $data[] = $this->putFile($files);
            }

        }

        return $data;
    }
}