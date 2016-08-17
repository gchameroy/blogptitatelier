<?php

namespace AppBundle;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Intervention\Image\ImageManagerStatic as Image;

class FileUploader
{
	public function uploadAvatar(UploadedFile $file, $targetDir)
	{
		$fileName = $this->_uploadFile($file, $targetDir);

		Image::make($targetDir . '/' . $fileName)
			->fit(110, 110)
			->save($targetDir . '/' . $fileName, 100);

		return $fileName;
	}
	
    private function _uploadFile(UploadedFile $file, $targetDir)
    {
		do{
			$fileName = md5(random_bytes(10)) . '.' . $file->guessExtension();
		} while(file_exists($targetDir . '/' . $fileName));

		$file->move($targetDir, $fileName);

        return $fileName;
    }
}