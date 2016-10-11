<?php

namespace AppBundle\Services;

class ConvertCsvToArray
{
	public function convert($fileName, $delimiter = ',')
	{
		if(!file_exists($fileName) || !is_readable($fileName)) {
			return false;
		}

		$header = null;
		$data = array();

		if (($handle = fopen($fileName, 'r')) !== false) {
			while (($row = fgetcsv($handle, 0, $delimiter)) !== false) {
				if(!$header) {
					$header = $row;
				} else {
					$data[] = array_combine($header, $row);
				}
			}
			fclose($handle);
		}
		return $data;
	}
}