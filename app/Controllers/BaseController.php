<?php

namespace App\Controllers;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 *
 * @package CodeIgniter
 */

use CodeIgniter\Controller;
use CodeIgniter\I18n\Time;

class BaseController extends Controller
{

	/**
	 * An array of helpers to be loaded automatically upon
	 * class instantiation. These helpers will be available
	 * to all other controllers that extend BaseController.
	 *
	 * @var array
	 */
	protected $helpers = ['cookie', 'date', 'App\Helpers\yapim', 'text'];

	/**
	 * Constructor.
	 */
	public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
	{
		// Do Not Edit This Line
		parent::initController($request, $response, $logger);

		//--------------------------------------------------------------------
		// Preload any models, libraries, etc, here.
		//--------------------------------------------------------------------
		// E.g.:
		session();
		helper('cookie');

		$this->db = \Config\Database::connect();
		$this->validation = \Config\Services::validation();
		$this->id = session()->get('id');

		$this->logModel = new \App\Models\LogModel();
		$this->tugasModel = new \App\Models\TugasModel();
		$this->komentarTugas = new \App\Models\KomentarTugasModel();
		$this->komentarArtikel = new \App\Models\KomentarArtikelModel();
		$this->absenModel = new \App\Models\AbsenModel();
		$this->dataAbsenModel = new \App\Models\DataAbsenModel();
		$this->dataTugasModel = new \App\Models\DataTugasModel();
		$this->artikelModel = new \App\Models\ArtikelModel();
		$this->userModel = new \App\Models\UserModel();
		$this->notifModel = new \App\Models\NotifikasiModel();
	}
}
