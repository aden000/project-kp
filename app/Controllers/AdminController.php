<?php

namespace App\Controllers;

use App\Models\ArtikelModel;
use App\Models\GaleriModel;
use App\Models\KategoriModel;
use App\Models\DokumenModel;
use App\Models\UserModel;
use CodeIgniter\Config\DotEnv;
use CodeIgniter\Database\Exceptions\DatabaseException;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\I18n\Time;
use DateTime;
use Exception;

class AdminController extends BaseController
{
    // public function getEncrypted($val)
    // {
    //     $user = new UserModel();
    //     $user->update(1, [
    //         'password' => password_hash($val, PASSWORD_BCRYPT)
    //     ]);
    //     echo "complete(?)";

    //     // echo bin2hex(\CodeIgniter\Encryption\Encryption::createKey(32));
    //     // echo "<br>";
    //     // echo hex2bin(bin2hex(\CodeIgniter\Encryption\Encryption::createKey(32)));
    // }

    public function showLogin()
    {
        $data = [
            'judul' => "Login | DISPERTAPAHORBUN"
        ];
        if (session()->get('whoLoggedIn')) return redirect()->route('admin.artikel');
        else return view('Admin/Login', $data);
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
            if ($result != null && $result['username'] == $user && password_verify($pass, $result['password'])) {
                $session = session();
                $session->set('whoLoggedIn', $result['id_user']);
                $session->markAsTempdata('whoLoggedIn', 7200);
                return redirect()->route('admin.dashboard')->with('message', [
                    'judul' => 'Selamat Datang',
                    'msg' => 'Selamat datang ' . $result['nama_user'] . ' Telah login',
                    'role' => 'success'
                ]);
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

    public function showDashboard()
    {
        if (session()->get('whoLoggedIn')) {
            $users = new UserModel();
            $user = $users->find(session()->get('whoLoggedIn'));

            $Artikel = new ArtikelModel();
            $allArtikel = $Artikel->findAll();

            $Kategori = new KategoriModel();
            $allKategori = $Kategori->findAll();

            $Galeri = new GaleriModel();
            $allGaleri = $Galeri->findAll();

            $Dokumen = new DokumenModel();
            $allDokumen = $Dokumen->findAll();

            $totalUser = $users->findAll();
            $fullAccessUser = $users->where('role', '0')->findAll();
            $postOnlyUser = $users->where('role', '1')->findAll();
            $docOnlyUser = $users->where('role', '2')->findAll();

            $pubArtikel = $Artikel->where('published_at IS NOT NULL')->findAll();

            return view('Admin/Dashboard', [
                'judul' => 'Dashboard | DISPERTAPAHORBUN',
                'user' => $user,
                'allArtikel' => $allArtikel,
                'pubArtikel' => $pubArtikel,
                'allKategori' => $allKategori,
                'allGaleri' => $allGaleri,
                'allDokumen' => $allDokumen,
                'fullAccessUser' => $fullAccessUser,
                'postOnlyUser' => $postOnlyUser,
                'docOnlyUser' => $docOnlyUser,
                'totalUser' => $totalUser
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
            $kategoridb = new KategoriModel();
            if ($kategoridb->countAll() == 0) {
                return redirect()->route('admin.kategori')->with('message', [
                    'judul' => 'Buat Kategori Terlebih dahulu',
                    'msg' => 'Artikel dibuat berdasarkan kategori, silahkan membuat kategori terlebih dahulu',
                    'role' => 'info'
                ]);
            } else {
                return view('Admin/ManageArticle', $data);
            }
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
                        if (env('CI_ENVIRONMENT') !== 'production') :
                            try {
                                $model->save([
                                    'id_kategori' => $this->request->getPost('kategoriSelect'),
                                    'judul_artikel' => esc($this->request->getPost('judulArtikel')),
                                    'slug' => url_title(esc($this->request->getPost('judulArtikel')), '-', true),
                                    'link_gambar' => $newname,
                                    'isi_artikel' => $this->request->getPost('isiArtikel'),
                                    'id_user' => $session->get('whoLoggedIn'),
                                    'published_at' => ($this->request->getPost('SimpanBos') === 'SimpanBos') ? Time::now() : null
                                ]);
                            } catch (Exception $e) {
                                return redirect()->route('admin.artikel')->with('message', [
                                    'judul' => 'Terjadi Kesalahan',
                                    'msg' => $e->getMessage(),
                                    'role' => 'error'
                                ]);
                            }
                        else :
                            $model->save([
                                'id_kategori' => $this->request->getPost('kategoriSelect'),
                                'judul_artikel' => esc($this->request->getPost('judulArtikel')),
                                'slug' => url_title(esc($this->request->getPost('judulArtikel')), '-', true),
                                'link_gambar' => $newname,
                                'isi_artikel' => $this->request->getPost('isiArtikel'),
                                'id_user' => $session->get('whoLoggedIn'),
                                'published_at' => ($this->request->getPost('SimpanBos') === 'SimpanBos') ? Time::now() : null
                            ]);
                            if ($err = $model->errors(true)) {
                                return redirect()->route('admin.artikel')->with('message', [
                                    'judul' => 'Terjadi Kesalahan',
                                    'msg' => implode(",", (array) $err),
                                    'role' => 'error'
                                ]);
                            }
                        endif;

                        $file->move(FCPATH . 'assets/artikel/img/' . $model->getInsertID() . '/', $newname);
                        $var = ($this->request->getPost('SimpanBos') === 'SimpanBos') ? ' dan dipublikasikan' : ' dan disimpan ke draf';
                        return redirect()->route('admin.artikel')->with('message', [
                            'judul' => 'Artikel dibuat',
                            'msg' => 'Artikel dan gambar berhasil dibuat' . $var,
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
                        $oldNamePath = FCPATH . 'assets/artikel/img/' . $id . '/' . $specificNameId['link_gambar'];
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

                        $file->move(FCPATH . 'assets/artikel/img/' . $id . '/', $newname);
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
            $deletedPath = FCPATH . 'assets/artikel/img/' . $id . '/';
            // $file = $artikelModel->find($id);
            // $namafile = $file['link_gambar'];
            // unlink($deletedPath . $namafile);
            // if (file_exists($deletedPath . 'index.html')) {
            //     unlink($deletedPath . 'index.html');
            // }
            $this->delTree($deletedPath);

            $artikelModel->delete($id, !env('enableComment'));


            return redirect()->route('admin.artikel')->with('message', [
                'judul' => 'Hapus Artikel Sukses',
                'msg' => 'Artikel berhasil untuk dihapus',
                'role' => 'success'
            ]);
        } else {
            return redirect()->route('home');
        }
    }

    public function delTree($dir)
    {
        $files = array_diff(scandir($dir), array('.', '..'));
        // dd($files);
        foreach ($files as $file) {
            (is_dir("$dir/$file")) ? $this->delTree("$dir/$file") : unlink("$dir/$file");
        }
        return rmdir($dir);
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
                } else if ($this->request->getPost("type") === "uploadfilefortinymce") {
                    $id = $this->request->getPost('id');
                    $file = $this->request->getFile('file');
                    if (isset($id)) {
                        // $this->response->setStatusCode(500, 'You catched the undefined: ' . $id);
                        $aModel = new ArtikelModel();
                        $id = $aModel->getNextIncrement();
                        // error_log("DEBUG: ID: " . $id . " SHIT");
                        if (
                            $file->isValid() &&
                            ($file->getMimeType() == "image/png" ||
                                $file->getMimeType() == "image/jpg" ||
                                $file->getMimeType() == "image/bmp" ||
                                $file->getMimeType() == "image/jpeg")
                        ) {
                            // $this->response->setStatusCode(500, 'Error, didn\'t get the ID: ' . $id);
                            $filename = $file->getRandomName();
                            $file->move(FCPATH . 'assets/artikel/img/' . $id . '/', $filename);
                            return json_encode([
                                'location' => "/assets/artikel/img/" . $id . "/" . $filename,
                            ]);
                        } else {
                            $this->response->setStatusCode(403, 'Not valid file or mime type');
                        }
                    } else {
                        // $this->response->setStatusCode(500, 'No... Not this shit again: ' . $id);
                        if (
                            $file->isValid() &&
                            ($file->getMimeType() == "image/png" ||
                                $file->getMimeType() == "image/jpg" ||
                                $file->getMimeType() == "image/bmp" ||
                                $file->getMimeType() == "image/jpeg")
                        ) {
                            $filename = $file->getRandomName();
                            $file->move(FCPATH . 'assets/artikel/img/' . $id . '/', $filename);
                            return json_encode([
                                'location' => "/assets/artikel/img/" . $id . "/" . $filename,
                            ]);
                        } else {
                            $this->response->setStatusCode(403, 'Not valid file or mime type');
                        }
                    }
                } else if (
                    $this->request->getPost("type") == "gettogglepublish" &&
                    $this->request->getPost("secret") == "usaojdn1dwq12e3"
                ) {
                    $aModel = new ArtikelModel();
                    $id = $this->request->getPost("id");
                    $result = $aModel->find($id);
                    $aModel->update($id, [
                        'published_at' => $result['published_at'] == null ? Time::now() : null
                    ]);
                    $newresult = $aModel->find($id);
                    return json_encode([
                        'judul' => $newresult['published_at'] == null ? 'Berhasil untuk Batal Terbit' : 'Berhasil untuk Terbit',
                        'published' => $newresult['published_at'] == null ? false : true
                    ]);
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
                'nama_kategori' => esc($this->request->getVar('namakategori'))
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
                    'nama_kategori' => esc($this->request->getPost('namakategoriedit'))
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
            if (env('CI_ENVIRONMENT') !== 'production') {
                try {
                    $kategoriModel->delete($this->request->getPost("idkHapus"));
                } catch (Exception $e) {
                    return redirect()->route('admin.kategori')->with('message', [
                        'judul' => 'Terjadi kesalahan',
                        'msg' => 'Kategori tidak dapat dihapus dikarenakan ada artikel yang menggunakan kategori ini',
                        'role' => 'error'
                    ]);
                }
            } else {
                $kategoriModel->delete($this->request->getPost("idkHapus"));
                if ($kategoriModel->errors(true)) {
                    return redirect()->route('admin.kategori')->with('message', [
                        'judul' => 'Terjadi kesalahan',
                        'msg' => 'Kategori tidak dapat dihapus dikarenakan ada artikel yang menggunakan kategori ini',
                        'role' => 'error'
                    ]);
                }
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
