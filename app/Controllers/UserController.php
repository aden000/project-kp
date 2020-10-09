<?php

namespace App\Controllers;

use App\Models\UserModel;

class UserController extends BaseController
{
    private function isLoggedIn()
    {
        return session()->get('whoLoggedIn') ? true : false;
    }

    public function changePassword()
    {
        if ($this->isLoggedIn()) {
            if (!$this->validate([
                'curpass' => 'required',
                'newpass' => 'required',
                'newpassconfirm' => 'required|matches[newpass]'
            ])) {
                return redirect()->back()->with('message', [
                    'judul' => 'Error Validasi',
                    'msg' => 'Error: Password baru dan Konfirmasi Password tidak sama',
                    'role' => 'error'
                ]);
            } else {
                $model = new UserModel();
                $user = $model->find(session()->get('whoLoggedIn'));
                if (password_verify($this->request->getPost('curpass'), $user['password'])) {
                    $model->update(session()->get('whoLoggedIn'), [
                        'password' => password_hash($this->request->getPost('newpassconfirm'), PASSWORD_BCRYPT)
                    ]);

                    return redirect()->back()->with('message', [
                        'judul' => 'Penggantian Password',
                        'msg' => 'Penggantian password sukses',
                        'role' => 'success'
                    ]);
                } else {
                    return redirect()->back()->with('message', [
                        'judul' => 'Error Validasi',
                        'msg' => 'Error: Password lama tidak sesuai dengan database',
                        'role' => 'error'
                    ]);
                }
            }
        } else {
            return redirect()->route('home');
        }
    }
}
