<?php

namespace App\Controllers;

use App\Models\ArtikelModel;
use App\Models\KategoriModel;
use App\Models\UserModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use Exception;

class AdminController extends BaseController
{
    public function getEncrypted($val)
    {
        $user = new UserModel();
        $user->update(1, [
            'password' => password_hash($val, PASSWORD_BCRYPT)
        ]);
        echo "complete(?)";

        // echo bin2hex(\CodeIgniter\Encryption\Encryption::createKey(32));
        // echo "<br>";
        // echo hex2bin(bin2hex(\CodeIgniter\Encryption\Encryption::createKey(32)));
    }

    public function loginProcess()
    {
        if ($this->request->getPost('loginPlease')) {
            //$db = Database::connect();

            $user = $this->request->getPost('user');
            $pass = $this->request->getPost('pass');
            $hasil = new UserModel();
            $result = $hasil->where('username', $user)
                // ->where('password', $pass)
                ->first();
            if ($result != null && password_verify($pass, $result['password'])) {
                $session = session();
                $session->set('whoLoggedIn', $result['id_user']);
                $session->markAsTempdata('whoLoggedIn', 7200);
                return redirect('admin.artikel');
            } else
                return redirect()->back()->with('message', [
                    'judul' => 'Terjadi Kesalahan',
                    'msg' => 'Username atau Password tidak ditemukan!',
                    'role' => 'error'
                ]);
        }
    }

    public function logoutProcess()
    {
        $session = session();
        if ($session->get('whoLoggedIn') && $this->request->getPost('logoutPlease')) {
            $session->remove('whoLoggedIn');
            return redirect()->route('home')->with('message', [
                'judul' => 'Telah Logout',
                'msg' => 'Anda telah berhasil logout',
                'role' => 'success'
            ]);
        } else {
            return redirect()->route('home');
        }
    }

    public function manageArticle()
    {
        $session = session();
        if ($session->get('whoLoggedIn')) {
            $db = new ArtikelModel();
            $result = $db->join('user', 'user.id_user = artikel.id_user')
                ->join('kategori', 'kategori.id_kategori = artikel.id_kategori')
                ->orderBy('id_artikel', 'DESC')
                ->findAll();
            $data = [
                'judul' => 'Kelola Artikel | DISPERTAPAHORBUN',
                'artikel' => $result
            ];
            return view('Admin/ManageArticle', $data);
        } else {
            return redirect()->route('home');
        }
    }

    public function articleCreate()
    {
        $session = session();
        if ($session->get('whoLoggedIn')) {
            $kategoriModel = new KategoriModel();
            $data = [
                'judul' => 'Tambah Artikel | DISPERTAPAHORBUN',
                'errors' => null,
                'kategori' => $kategoriModel->findAll()
            ];
            return view('Admin/ArticleCreate', $data);
        } else {
            return redirect()->route('home');
        }
    }

    public function articleCreateProcess()
    {
        $session = session();
        if ($session->get('whoLoggedIn')) {
            if (!$this->validate(
                [
                    'judulArtikel' => 'required',
                    'kategoriSelect' => 'required|numeric',
                    'isiArtikel' => 'required',
                    'gambar' => 'uploaded[gambar]|max_size[gambar, 2048]'
                ]
            )) {
                $kategoriModel = new KategoriModel();
                $data = [
                    'judul' => 'Tambah Artikel | DISPERTAPAHORBUN',
                    'kategori' => $kategoriModel->findAll(),
                    'errors' => $this->validator->getErrors()
                ];
                return view('Admin/ArticleCreate', $data);
            } else {
                /**
                 * RESOLVE: USE FORM_OPEN_MULTIPART
                 * DUDE, I NEED 1 NIGHT TO RESOLVE THIS LOL XD
                 */
                $file = $this->request->getFile('gambar');
                if ($file != null) {
                    if ($file->isValid()) {
                        $newname = $file->getRandomName();
                        $model = new ArtikelModel();
                        $model->save([
                            'id_kategori' => $this->request->getPost('kategoriSelect'),
                            'judul_artikel' => esc($this->request->getPost('judulArtikel')),
                            'slug' => url_title(esc($this->request->getPost('judulArtikel')), '-', true),
                            'link_gambar' => $newname,
                            'isi_artikel' => $this->request->getPost('isiArtikel'),
                            'id_user' => $session->get('whoLoggedIn')
                        ]);

                        $file->move(ROOTPATH . 'public/assets/artikel/img/' . $model->getInsertID() . '/', $newname);

                        return redirect()->route('admin.artikel')->with('message', [
                            'judul' => 'Artikel dibuat',
                            'msg' => 'Artikel dan gambar berhasil dibuat',
                            'role' => 'success'
                        ]);
                    } else {
                        return redirect()->back()->withInput();
                    }
                } else {
                    return redirect()->back()->withInput();
                }
            }
        } else {
            return redirect()->route('home');
        }
    }

    public function articleEdit($id)
    {
        $session = session();
        if ($session->get('whoLoggedIn')) {
            $artikel = new ArtikelModel();
            $kategori = new KategoriModel();
            $data = [
                'artikel' => $artikel->find($id),
                'kategori' => $kategori->findAll(),
                'judul' => 'Edit Artikel | DISPERTAPAHORBUN',
                'errors' => null
            ];
            return view('Admin/ArticleEdit', $data);
        } else {
            return redirect()->route('home');
        }
    }

    public function articleEditProcess($id)
    {
        $session = session();
        if ($session->get('whoLoggedIn')) {
            if (!$this->validate(
                [
                    'judulArtikel' => 'required',
                    'kategoriSelect' => 'required|numeric',
                    'isiArtikel' => 'required',
                    'gambar' => 'permit_empty'
                ]
            )) {
                $kategoriModel = new KategoriModel();
                $artikel = new ArtikelModel();
                $data = [
                    'judul' => 'Tambah Artikel | DISPERTAPAHORBUN',
                    'kategori' => $kategoriModel->findAll(),
                    'errors' => $this->validator->getErrors(),
                    'artikel' => $artikel->find($id)
                ];
                return view('Admin/ArticleEdit', $data);
            } else {
                $file = $this->request->getFile('gambar');
                if (!$file->isValid()) {
                    $artikelModel = new ArtikelModel();
                    $artikelModel->update($id, [
                        'id_kategori' => $this->request->getPost('kategoriSelect'),
                        'judul_artikel' => esc($this->request->getPost('judulArtikel')),
                        'slug' => url_title(esc($this->request->getPost('judulArtikel')), '-', true),
                        'isi_artikel' => $this->request->getPost('isiArtikel'),
                        'id_user' => $session->get('whoLoggedIn')
                    ]);

                    return redirect()->route('admin.artikel')->with('message', [
                        'judul' => 'Edit Artikel Sukses',
                        'msg' => 'Artikel berhasil untuk diedit',
                        'role' => 'success'
                    ]);
                } else {
                    if (!$this->validate([
                        'gambar' => 'uploaded[gambar]|max_size[gambar, 2048]'
                    ])) {
                        $artikel = new ArtikelModel();
                        $kategoriModel = new KategoriModel();
                        $data = [
                            'judul' => 'Tambah Artikel | DISPERTAPAHORBUN',
                            'kategori' => $kategoriModel->findAll(),
                            'errors' => $this->validator->getErrors(),
                            'artikel' => $artikel->find($id)
                        ];
                        return view('Admin/ArticleEdit', $data);
                    } else {
                        $artikelModel = new ArtikelModel();
                        $specificNameId = $artikelModel->find($id);
                        $oldNamePath = ROOTPATH . '/public/assets/artikel/img/' . $id . '/' . $specificNameId['link_gambar'];
                        unlink($oldNamePath);

                        $newname = $file->getRandomName();
                        $artikelModel->update($id, [
                            'id_kategori' => $this->request->getPost('kategoriSelect'),
                            'judul_artikel' => esc($this->request->getPost('judulArtikel')),
                            'slug' => url_title(esc($this->request->getPost('judulArtikel')), '-', true),
                            'isi_artikel' => $this->request->getPost('isiArtikel'),
                            'id_user' => $session->get('whoLoggedIn'),
                            'link_gambar' => $newname
                        ]);

                        $file->move(ROOTPATH . '/public/assets/artikel/img/' . $id . '/', $newname);
                        return redirect()->route('admin.artikel')->with('message', [
                            'judul' => 'Edit Artikel Sukses',
                            'msg' => 'Artikel berhasil untuk diedit dan gambar berhasil diupload',
                            'role' => 'success'
                        ]);
                    }
                }
            }
        } else {
            return redirect()->route('home');
        }
    }

    public function articleDeleteProcess($id)
    {
        $session = session();
        if ($session->get('whoLoggedIn')) {
            $artikelModel = new ArtikelModel();
            $deletedPath = ROOTPATH . '/public/assets/artikel/img/' . $id . '/';
            $file = $artikelModel->find($id);
            $namafile = $file['link_gambar'];
            unlink($deletedPath . $namafile);
            if (file_exists($deletedPath . 'index.html')) {
                unlink($deletedPath . 'index.html');
            }
            rmdir($deletedPath);

            $artikelModel->delete($id);

            return redirect()->route('admin.artikel')->with('message', [
                'judul' => 'Hapus Artikel Sukses',
                'msg' => 'Artikel berhasil untuk dihapus',
                'role' => 'success'
            ]);
        } else {
            return redirect()->route('home');
        }
    }

    /**
     * KATEGORI SECTION
     */

    public function manageKategori()
    {
        $session = session();
        if ($session->get('whoLoggedIn')) {
            $kategoriModel = new KategoriModel();
            $data = [
                'judul' => 'Kelola Kategori | DISPERTAPAHORBUN',
                'kategori' => $kategoriModel->findAll()
            ];
            return view('Admin/ManageKategori', $data);
        } else {
            return redirect()->route('home');
        }
    }

    public function kelolaAJAX()
    {
        $session = session();
        if ($session->get('whoLoggedIn')) {
            if ($this->request->isAJAX()) {
                if ($this->request->getPost("type") === "getkategoribyid") {
                    $kategoriModel = new KategoriModel();
                    $kategori = $kategoriModel->find($this->request->getPost("id"));
                    return $kategori['nama_kategori'];
                }
            } else {
                throw new PageNotFoundException();
            }
        } else {
            return "Sesi Expired, Silahkan Refresh Halaman ini dan login ulang";
        }
    }

    public function kategoriCreateProcess()
    {
        $session = session();
        if ($session->get('whoLoggedIn')) {
            $kategoriModel = new KategoriModel();
            $kategoriModel->save([
                'nama_kategori' => $this->request->getVar('namakategori')
            ]);

            return redirect()->back()->with('message', [
                'judul' => 'Tambah Kategori Sukses',
                'msg' => 'Kategori berhasil untuk ditambahkan',
                'role' => 'success'
            ]);
        } else {
            return redirect()->route('home');
        }
    }

    public function kategoriEditProcess()
    {
        $session = session();
        if ($session->get('whoLoggedIn')) {
            if (!$this->validate([
                'idkEdit' => 'required|numeric',
                'namakategoriedit' => 'required'
            ])) {
                return redirect()->route('admin.kategori')->with('message', [
                    'judul' => 'Terjadi kesalahan',
                    'msg' => 'Data tidak valid',
                    'role' => 'error'
                ]);
            } else {
                $kategoriModel = new KategoriModel();
                $kategoriModel->update($this->request->getPost('idkEdit'), [
                    'nama_kategori' => $this->request->getPost('namakategoriedit')
                ]);

                return redirect()->route('admin.kategori')->with('message', [
                    'judul' => 'Edit Kategori Sukses',
                    'msg' => 'Kategori berhasil untuk diedit',
                    'role' => 'success'
                ]);
            }
        } else {
            return redirect()->route('home');
        }
    }

    public function kategoriDeleteProcess()
    {
        $session = session();
        if ($session->get('whoLoggedIn')) {
            $kategoriModel = new KategoriModel();
            try {
                //dd($this->request->getPost());
                $kategoriModel->delete($this->request->getPost("idkHapus"));
            } catch (Exception $e) {
                return redirect()->route('admin.kategori')->with('message', [
                    'judul' => 'Terjadi kesalahan',
                    'msg' => 'Kategori tidak dapat dihapus dikarenakan ada artikel yang menggunakan kategori ini',
                    'role' => 'error'
                ]);
                //throw new Exception("Kategori gagal dihapus karena masih ada artikel yang menggunakan kategori ini");
            }
            return redirect()->route('admin.kategori')->with('message', [
                'judul' => 'Hapus Kategori Sukses',
                'msg' => 'Kategori berhasil untuk dihapus',
                'role' => 'success'
            ]);
        } else {
            return redirect()->route('home');
        }
    }
}
