<?php
namespace App\Provider;

/**
* Provide some ads
*/
class AdsProvider
{

	private $keysUsed = [];

	private $data = [
		[
			'title' => 'AdsTitle1',
			'description' => 'Description 1'
 		],
		[
			'title' => 'AdsTitle2',
			'description' => 'Description 2'
 		],
		[
			'title' => 'AdsTitle3',
			'description' => 'Description 3'
 		],
	];

	/**
	* Get randOne ads
	* @return Array
	*/
	public function get()
	{

		$i = $this->getKey();
		$this->keysUsed[] = $i;

		return $this->data[$i];
	}

	public function getAll()
	{
		return $this->data;
	}

	private function getKey()
	{
		$i = mt_rand(0,2);
		while (in_array($i, $this->keysUsed)) {
			$i = mt_rand(0,2);
		}
		dump($i);
		return $i;
	}



	
	
}