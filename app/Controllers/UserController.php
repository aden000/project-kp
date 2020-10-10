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

    public function manageUser()
    {
        if ($this->isLoggedIn()) {
            $model = new UserModel();
            $user = $model->find(session()->get('whoLoggedIn'));
            //dd($user);
            if ($user['role'] == 0) {
                return view('Admin/ManageUser/Index', [
                    'judul' => 'Kelola User | DISPERTAPAHORBUN',
                    'user' => $model->findAll()
                ]);
            } else {
                return redirect()->route('admin.artikel')->with('message', [
                    'judul' => 'Akses dilarang',
                    'msg' => 'Anda tidak mempunyai akses ke alamat ini',
                    'role' => 'error'
                ]);
            }
        } else {
            return redirect()->route('home');
        }
    }

    public function createUser()
    {
        if ($this->isLoggedIn()) {
            $model = new UserModel();
            $user = $model->find(session()->get('whoLoggedIn'));
            if ($user['role'] == 0) {
                if (!$this->validate([
                    'frmUsername' => 'required',
                    'frmNama' => 'required',
                    'frmPassword' => 'required',
                    'frmAccess' => 'required|numeric'
                ])) {
                    return redirect()->back()->with('message', [
                        'judul' => 'Error Validasi',
                        'msg' => 'Cek kembali form isian anda, dan jangan lupa pilih hak akses',
                        'role' => 'error'
                    ]);
                } else {
                    $model->insert([
                        'username' => esc($this->request->getPost('frmUsername')),
                        'nama_user' => esc($this->request->getPost('frmNama')),
                        'password' => password_hash($this->request->getPost('frmPassword'), PASSWORD_BCRYPT),
                        'role' => $this->request->getPost('frmAccess')
                    ]);

                    return redirect()->back()->with('message', [
                        'judul' => 'Penambahan Sukses',
                        'msg' => 'User telah ditambahkan dengan sukses',
                        'role' => 'success'
                    ]);
                }
            } else {
                return redirect()->route('admin.artikel')->with('message', [
                    'judul' => 'Akses dilarang',
                    'msg' => 'Anda tidak mempunyai akses ke alamat ini',
                    'role' => 'error'
                ]);
            }
        } else {
            return redirect()->route('home');
        }
    }
}
