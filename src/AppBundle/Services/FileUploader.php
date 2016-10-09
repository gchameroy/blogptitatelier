<?php

namespace AppBundle\Services;

use Symfony\Component\HttpFoundation\File\File;
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
	
	public function uploadFavicon(UploadedFile $file, $targetDir)
	{
		$fileName = $this->_uploadFile($file, $targetDir);

		Image::make($targetDir . '/' . $fileName)
			->fit(64, 64)
			->save($targetDir . '/' . $fileName, 100);

		return $fileName;
	}
	
	public function uploadLogo(UploadedFile $file, $targetDir)
	{
		$fileName = $this->_uploadFile($file, $targetDir);
		return $fileName;
	}
	
	public function uploadBanner(UploadedFile $file, $targetDir)
	{
		$fileName = $this->_uploadFile($file, $targetDir);
		return $fileName;
	}
	
	public function uploadPostImage(UploadedFile $file, $targetDir)
	{
		$fileName = $this->_uploadFile($file, $targetDir);
		return $fileName;
	}
	
	public function importPostImage($fileName, $targetDir)
	{
		$file = new File($fileName);
		$fileName = $this->_uploadFile($file, $targetDir);
		return $fileName;
	}
	
    private function _uploadFile($file, $targetDir)
    {
		do{
			$fileName = md5(random_bytes(10)) . '.' . $file->guessExtension();
		} while(file_exists($targetDir . '/' . $fileName));

		$file->move($targetDir, $fileName);

        return $fileName;
    }
}