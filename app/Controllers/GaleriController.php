<?php

namespace App\Controllers;

use App\Models\GaleriModel;
use App\Models\UserModel;

class GaleriController extends BaseController
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

    public function manageGaleri()
    {
        if ($this->isLoggedIn()) {
            if ($this->isFullAccess()) {
                $model = new GaleriModel();
                $result = $model->join('user', 'galeri.id_user = user.id_user', 'left')
                    ->select('nama_user, id_galeri, nama_gambar')
                    ->orderBy('id_galeri', 'ASC')
                    ->findAll();
                return view('Admin/ManageGaleri/Index', [
                    'judul' => 'Kelola Galeri | DISPERTAPAHORBUN',
                    'galeri' => $result
                ]);
            } else {
                return redirect()->route('admin.dashboard')->with('message', [
                    'judul' => 'Akses dilarang',
                    'msg' => 'Anda tidak mempunyai akses ke alamat ini',
                    'role' => 'error'
                ]);
            }
        } else {
            return redirect()->route('home');
        }
    }

    public function addGaleriProcess()
    {
        if ($this->isLoggedIn()) {
            if ($this->isFullAccess()) {

                if (!$this->validate([
                    'namaGambar' => 'uploaded[namaGambar]|max_size[namaGambar, 2048]'
                ])) {
                    return redirect()->route('admin.galeri.manage')->with('message', [
                        'judul' => 'Validasi Error',
                        'msg' => $this->validator->getError(),
                        'role' => 'error'
                    ]);
                } else {
                    $file = $this->request->getFile('namaGambar');
                    if ($file->isValid()) {
                        $rname = $file->getRandomName();
                        $gModel = new GaleriModel();
                        $gModel->save([
                            'id_user' => session()->get('whoLoggedIn'),
                            'nama_gambar' => $rname
                        ]);

                        $file->move(FCPATH . 'assets/img/slide/', $rname);
                        return redirect()->route('admin.galeri.manage')->with('message', [
                            'judul' => 'Gambar Galeri ditambahkan',
                            'msg' => 'Gambar berhasil diupload',
                            'role' => 'success'
                        ]);
                    } else {
                        return redirect()->route('admin.galeri.manage')->with('message', [
                            'judul' => 'File tidak valid',
                            'msg' => 'File tidak berupa gambar',
                            'role' => 'error'
                        ]);
                    }
                }
            } else {
                return redirect()->route('admin.dashboard')->with('message', [
                    'judul' => 'Akses dilarang',
                    'msg' => 'Anda tidak mempunyai akses ke alamat ini',
                    'role' => 'error'
                ]);
            }
        } else {
            return redirect()->route('home');
        }
    }

    public function deleteGaleriProcess()
    {
        if ($this->isLoggedIn()) {
            if ($this->isFullAccess()) {
                if ($this->validate([
                    'id' => 'numeric|required'
                ])) {
                    $id = esc($this->request->getPost('id'));
                    $GaleriModel = new GaleriModel();
                    $result = $GaleriModel->find($id);
                    $deletedFile = FCPATH . 'assets/img/slide/' . $result['nama_gambar'];

                    unlink($deletedFile);
                    $GaleriModel->delete($id);

                    return redirect()->route('admin.galeri.manage')->with('message', [
                        'judul' => 'Gambar Galeri Dihapus',
                        'msg' => 'Gambar berhasil dihapus dengan sukses',
                        'role' => 'success'
                    ]);
                } else {
                    return redirect()->route('admin.galeri.manage')->with('message', [
                        'judul' => 'Validasi Error',
                        'msg' => "Terjadi kesalahan, harap reload ulang",
                        'role' => 'error'
                    ]);
                }
            } else {
                return redirect()->route('admin.dashboard')->with('message', [
                    'judul' => 'Akses dilarang',
                    'msg' => 'Anda tidak mempunyai akses ke alamat ini',
                    'role' => 'error'
                ]);
            }
        } else {
            return redirect()->route('home');
        }
    }

    private function delTree($dir)
    {
        $files = array_diff(scandir($dir), array('.', '..'));
        // dd($files);
        foreach ($files as $file) {
            (is_dir("$dir/$file")) ? $this->delTree("$dir/$file") : unlink("$dir/$file");
        }
        return rmdir($dir);
    }
}
