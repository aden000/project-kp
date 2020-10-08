<?php

namespace App\Controllers;

use App\Models\ArtikelModel;
use App\Models\KomentarModel;

class CommentController extends BaseController
{
    private function isLoggedIn()
    {
        return session()->get('whoLoggedIn') ? true : false;
    }

    private function treeCommentBuilder($id)
    {
        $model = new KomentarModel();
        $result2 = $model->join('artikel', 'artikel.id_artikel = komentar.id_artikel')
            ->where('artikel.id_artikel', $id)
            ->findAll();

        $view = count($result2) == 0 ?
            '<div class="mt-4 mx-4">' .
            '<h6>Tidak ada komentar</h6>' .
            '</div>'
            :
            '';

        $refIDCollector = array();
        foreach ($result2 as $r) {
            array_push($refIDCollector, $r['refer_id']);
        }
        return $view . "<div class='container'>" . $this->in_parent(0, $id, $refIDCollector) . "</div>";
    }

    private function in_parent($idx, $id, $refIDCollector)
    {
        // this variable to save all concatenated html
        $html = "";
        // build hierarchy  html structure based on ul li (parent-child) nodes
        if (in_array($idx, $refIDCollector)) {
            $model = new KomentarModel();
            $result = $model->join('artikel', 'artikel.id_artikel = komentar.id_artikel')
                ->where('artikel.id_artikel', $id)
                ->where('refer_id', $idx)
                ->select('komentar.id_komentar, komentar.nama_komentar, komentar.isi_komentar, komentar.created_at')
                ->findAll();

            $html .=  $idx == 0 ? "<div class='ml-0'>" : "<div class='ml-4'>";
            foreach ($result as $re) {
                $html .= "<div>";
                $data = [
                    'komentar' => $re
                ];
                $html .= view('Admin\Komentar\Komentar', $data);
                $html .= $this->in_parent($re['id_komentar'], $id, $refIDCollector);
                $html .= "</div>";
            }
            $html .=  "</div>";
        }

        return $html;
    }

    public function index($idArtikel)
    {
        if ($this->isLoggedIn()) {
            $artikel = new ArtikelModel();
            $result = $artikel->select('judul_artikel, slug')
                ->where('id_artikel', $idArtikel)
                ->first();
            $data = [
                'judul' => 'Kelola Komentar: ' . $result['judul_artikel'],
                'artikel' => $result,
                'komentar' => $this->treeCommentBuilder($idArtikel)
            ];

            //d($this->isLoggedIn());
            return view('Admin/Komentar/Manage', $data);
        } else {
            return redirect()->route('home');
        }
    }

    public function kelolaAJAX()
    {
        if ($this->isLoggedIn()) {
            if ($this->request->isAJAX()) {
                if ($this->request->getPost('type') == "KomentarEdit"); {
                    $id = $this->request->getPost('idkomentar');

                    $komentar = new KomentarModel();
                    $komentar = $komentar->select('id_komentar, nama_komentar, isi_komentar')
                        ->where('id_komentar', $id)
                        ->first();

                    $data = [
                        'komentar' => $komentar
                    ];
                    return view('Admin/Komentar/ModalBodyKomentarEdit', $data);
                }
            }
        } else {
            return "Sesi Expired, silahkan refresh halaman...";
        }
    }

    public function editComment()
    {
        if ($this->isLoggedIn()) {
            if (!$this->validate([
                'id' => 'required|numeric',
                'namaKomentar' => 'required',
                'isiKomentar' => 'required'
            ])) {
                return redirect()->back()->with('message', [
                    'judul' => 'Error Validasi',
                    'msg' => 'Terjadi kesalahan dalam validasi data',
                    'role' => 'error'
                ]);
            } else {
                $komentar = new KomentarModel();
                $komentar->update($this->request->getPost('id'), [
                    'nama_komentar' => esc($this->request->getPost('namaKomentar')),
                    'isi_komentar' => esc($this->request->getPost('isiKomentar'))
                ]);

                $komentar = $komentar->select('id_artikel')
                    ->where('id_komentar', $this->request->getPost('id'))
                    ->first();

                return redirect()->route('admin.artikel.comment', [$komentar['id_artikel']])->with('message', [
                    'judul' => 'Sukses Update',
                    'msg' => 'Komentar berhasil diupdate!',
                    'role' => 'success'
                ]);
            }
        }
    }
}
