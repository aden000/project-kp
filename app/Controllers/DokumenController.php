<?php

namespace App\Controllers;

use App\Models\DokumenModel;
use App\Models\UserModel;

class DokumenController extends BaseController
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

    private function isRoleDokumen()
    {
        $model = new UserModel();
        $model = $model->select('role')->where('id_user', session()->get('whoLoggedIn'))->first();
        return $model['role'] == 2 ? true : false;
    }

    public function manageDokumen()
    {
        if ($this->isLoggedIn()) {
            if ($this->isRoleDokumen() || $this->isFullAccess()) {
                $model = new DokumenModel();
                $result = $model->join('user', 'dokumen.id_user = user.id_user')
                ->select('id_dokumen, nama_dokumen, file_dokumen, dokumen.created_at, nama_user')
                ->findAll();
                return view('Admin/ManageDokumen/Index', [
                    'judul' => 'Kelola Dokumen | DISPERTAPAHORBUN',
                    'dokumen' => $result
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

    public function addDokumenProcess()
    {
        if ($this->isLoggedIn()) {
            if ($this->isFullAccess() || $this->isRoleDokumen()) {

                if (!$this->validate([
                    'namaDokumen' => 'required',
                    'fileDokumen' => 'uploaded[fileDokumen]'
                ])) {
                    return redirect()->route('admin.dokumen.manage')->with('message', [
                        'judul' => 'Validasi Error',
                        'msg' => $this->validator->getError(),
                        'role' => 'error'
                    ]);
                } else {
                    $file = $this->request->getFile('fileDokumen');
                    if ($file->isValid()) {
                        $rname = $file->getRandomName();
                        $gModel = new DokumenModel();
                        $gModel->save([
                            'nama_dokumen' => esc($this->request->getPost('namaDokumen')),
                            'file_dokumen' => $rname,
                            'id_user' => session()->get('whoLoggedIn')
                        ]);

                        $file->move(FCPATH . 'assets/dokumen', $rname);
                        return redirect()->route('admin.dokumen.manage')->with('message', [
                            'judul' => 'Dokumen ditambahkan',
                            'msg' => 'Dokumen berhasil diupload',
                            'role' => 'success'
                        ]);
                    } else {
                        return redirect()->route('admin.dokumen.manage')->with('message', [
                            'judul' => 'File tidak valid',
                            'msg' => 'File tidak berupa dokumen',
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

    public function deleteDokumenProcess()
    {
        if ($this->isLoggedIn()) {
            if ($this->isFullAccess() || $this->isRoleDokumen()) {
                if ($this->validate([
                    'id' => 'numeric|required'
                ])) {
                    $id = esc($this->request->getPost('id'));
                    $DokumenModel = new DokumenModel();
                    $result = $DokumenModel->find($id);
                    $deletedFile = FCPATH . 'assets/dokumen/' . $result['file_dokumen'];

                    unlink($deletedFile);
                    $DokumenModel->delete($id);

                    return redirect()->route('admin.dokumen.manage')->with('message', [
                        'judul' => 'Dokumen Dihapus',
                        'msg' => 'Dokumen berhasil dihapus dengan sukses',
                        'role' => 'success'
                    ]);
                } else {
                    return redirect()->route('admin.dokumen.manage')->with('message', [
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
