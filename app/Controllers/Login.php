<?php

namespace App\Controllers;

use App\Models\Msuser;

/**
 * @property IncomingRequest $request
 */
class Login extends BaseController
{
    public function __construct()
    {
        helper('form');
        $this->user = new Msuser();
    }
    public function index()
    {
        return view('V_login');
    }

    public function cek()
    {
        $user = $this->request->getPost('user');
        $pass = $this->request->getPost('pass');
        $data = array();
        $cekData = $this->user->cek($user);
        if ($cekData) {
            if (password_verify($pass, rtrim($cekData['pass']))) {
                session()->set('id_user', $cekData['id']);
                session()->set('nama', $cekData['user']);
                $id = ['deviceid' => $this->request->getIPAddress()];
                $this->user->edit($id, $cekData['id']);
                $data['success'] =  1;
                $date = ['last_login' => date('Y-m-d H:i:s')];
                $this->user->edit($date, $cekData['id']);
            } else {
                $data['success'] = 0;
            }
        } else {
            $data['success'] = 0;
        }
        echo json_encode($data);
    }
    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('login'));
    }
}
