<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AuthFilter implements FilterInterface
{
  public function before(RequestInterface $request, $arguments = null)
  {
    // cek apakah ada session
    helper('cookie');
    helper('yapim');
    session();
    if (!session()->has('id') && !session()->has('e')) {
      session()->setFlashdata('pesan', 'Kamu belum masuk.');
      return redirect()->to('/masuk')->withInput();
    } else {
      $db = \Config\Database::connect();
      // CEK KALAU IS_ACTIVE NYA 0
      $user = $db->table('user')->where(['id' => session()->get('id')])->get()->getRowArray();
      if ($user['is_active'] == 0) {
        // session()->destroy();
        session()->remove('id');
        session()->remove('e');
        delete_cookie('e');
        delete_cookie('ui');
        session()->setFlashdata('pesan', 'Akun kamu tidak aktif!!!');
        return redirect()->to('/masuk')->withCookies();
      }
    }
    // cek apakah cookie id sama session id itu sama
    if (get_cookie('ui') != session()->get('id')) {
      session()->remove('id');
      session()->remove('e');
      delete_cookie('e');
      delete_cookie('ui');
      session()->setFlashdata('pesan', 'ID Kamu tidak benar.');
      return redirect()->to('/masuk')->withInput()->withCookies();
    }

    $uri = service('uri');
    $db = \Config\Database::connect();
    // CEK KALAU IS_ACTIVE NYA 0
    $user =
      $role_id = session()->get('role_id');
    $menu = $uri->getSegment(2);

    $queryMenu = $db->table('user_menu')->where('menu', $menu)->get()->getRowArray();
    $menu_id = $queryMenu['id'];

    $data = [
      'role_id' => $role_id,
      'menu_id' => $menu_id
    ];
    $userAccess = $db->table('user_access_menu')->where($data)->countAllResults();
    if ($userAccess == 0 && $menu != 'notifikasi') {
      return redirect()->to('/auth/blocked');
    }
  }

  //--------------------------------------------------------------------

  public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
  {
    // cek apakah ada session
    if (session()->has('id') && get_cookie('e')) {
      return redirect()->to('/auth');
    }
  }
}
