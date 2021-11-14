<?php namespace App\Controllers\Aplikasi;
use App\Controllers\BaseController;

class Aplikasi extends BaseController
{

	public function index(){
		return redirect()->to('/auth/blocked');
	}	

}
