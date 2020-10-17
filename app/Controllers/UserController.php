<?php

namespace App\Controllers;

use App\Models\UserModel;

class UserController extends BaseController
{
    private function isLoggedIn()
    {
        return session()->get('whoLoggedIn') ? true : false;
    }

    private function isFullAccess()
    {
        $model = new UserModel();
        $model = $model->select('role')->where('id_user', session()->get('whoLoggedIn'))->first();
        return $model['role'] == 0 ? true : false;
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
            //dd($user);
            if ($this->isFullAccess()) {
                $model = new UserModel();
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
            if ($this->isFullAccess()) {
                $model = new UserModel();
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

    public function kelolaAJAX()
    {
        if ($this->isLoggedIn()) {
            if ($this->request->isAJAX()) {
                if (
                    $this->request->getPost('getUserInfo') == true &&
                    $this->request->getPost('secret') == 'xo12esadsas12s' &&
                    $this->isFullAccess()
                ) {
                    $model = new UserModel();
                    $result = $model->select('id_user, username, nama_user, role')
                        ->where('id_user', $this->request->getPost('id'))
                        ->first();

                    return json_encode($result);
                } else if (
                    $this->request->getPost('getUserResetPassword') == true &&
                    $this->request->getPost('secret') == '3u4tnuj23eqk' &&
                    $this->isFullAccess()
                ) {
                    $model = new UserModel();
                    $result = $model->update($this->request->getPost('id'), [
                        'password' => password_hash(env('defPass'), PASSWORD_BCRYPT)
                    ]);

                    return json_encode([
                        'newpass' => env('defPass')
                    ]);
                } else {
                    return json_encode([
                        'msg' => 'Not accessible'
                    ]);
                }
            } else {
                return json_encode([
                    'msg' => 'Not accessible'
                ]);
            }
        } else {
            return json_encode([
                'msg' => 'Not accessible'
            ]);
        }
    }

    public function editUser()
    {
        if ($this->isLoggedIn()) {
            if ($this->isFullAccess()) {
                if ($this->validate([
                    'frmEUsername' => 'required',
                    'frmENama' => 'required',
                    'frmEAccess' => 'required|numeric',
                    'idEUser' => 'required|numeric'
                ])) {
                    $model = new UserModel();
                    $model->update($this->request->getPost('idEUser'), [
                        'nama_user' => esc($this->request->getPost('frmENama')),
                        'username' => esc($this->request->getPost('frmEUsername')),
                        'role' => $this->request->getPost('frmEAccess')
                    ]);

                    return redirect()->route('admin.user.manage')->with('message', [
                        'judul' => 'Sukses Update',
                        'msg' => 'Sukses untuk mengubah informasi User',
                        'role' => 'success'
                    ]);
                } else {
                    return redirect()->route('admin.user.manage')->with('message', [
                        'judul' => 'Error Validasi',
                        'msg' => 'Anda tidak memenuhi rule validasi salah satu / beberapa validasi',
                        'role' => 'error'
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

    public function deleteUser()
    {
        if ($this->isLoggedIn()) {
            if ($this->isFullAccess()) {
                $model = new UserModel();
                try {
                    $model->delete($this->request->getPost('idUser'));
                    return redirect()->back()->with('message', [
                        'judul' => 'Delete Sukses',
                        'msg' => 'Penghapusan User Sukses',
                        'role' => 'success'
                    ]);
                } catch (\Exception $e) {
                    return redirect()->back()->with('message', [
                        'judul' => 'Error Delete',
                        'msg' => 'User yang anda akan hapus masih terikat pada artikel yang dibuat. Silahkan menghapus artikelnya terlebih dahulu',
                        'role' => 'error'
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
