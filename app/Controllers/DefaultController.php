<?php

namespace App\Controllers;

use App\Models\ArtikelModel;
use App\Models\GaleriModel;
use App\Models\KomentarModel;
use App\Models\UserModel;
use App\Models\DokumenModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use Config\Database;

class DefaultController extends BaseController
{
    public function index()
    {
        $search = $this->request->getVar("search");
        $db = new ArtikelModel();
        $a = new UserModel();
        $g = new GaleriModel();
        $g = $g->findAll();
        $greetings = env('kataPenyambutan');
        if (session()->get('whoLoggedIn')) $a = $a->find(session()->get('whoLoggedIn'));
        if (!is_null($search)) {

            $result = $db->join('user', 'artikel.id_user = user.id_user', 'right')
                ->join('kategori', 'artikel.id_kategori = kategori.id_kategori', 'right')
                ->select('id_artikel, link_gambar, artikel.created_at, judul_artikel, slug,
                             isi_artikel, nama_user, nama_kategori, published_at, DATE_FORMAT(artikel.created_at, "%d %M %Y"), 
                             DATE_FORMAT(artikel.updated_at, "%d %M %Y")')
                ->groupStart()
                ->like('judul_artikel', $search)
                ->orLike('isi_artikel', $search)
                ->orLike('nama_kategori', $search)
                ->orLike('nama_user', $search)
                ->orLike('DATE_FORMAT(artikel.created_at, "%d %M %Y")', $search)
                ->orLike('DATE_FORMAT(artikel.updated_at, "%d %M %Y")', $search)
                ->groupEnd()
                ->where('published_at IS NOT NULL')
                ->orderBy('id_artikel', 'DESC')
                ->paginate(env('limitShowArtikel', 5), 'bootstrap');

            $data = [
                'judul' => "Home | Pencarian $search | DISPERTAPAHORBUN",
                'artikel' => $result,
                'pager' => $db->pager,
                'a' => $a,
                'galeri' => $g,
                'greetings' => $greetings
            ];
            return view('Default/Index', $data);
        } else {
            $result = $db->join('user', 'artikel.id_user = user.id_user')
                ->join('kategori', 'artikel.id_kategori = kategori.id_kategori')
                ->select('id_artikel, link_gambar, artikel.created_at, judul_artikel, slug, isi_artikel, nama_user, nama_kategori, published_at')
                ->where('published_at IS NOT NULL')
                ->orderBy('id_artikel', 'DESC')
                ->paginate(env('limitShowArtikel', 5), 'bootstrap');
            $data = [
                'judul' => 'Home | DISPERTAPAHORBUN',
                'artikel' => $result,
                'pager' => $db->pager,
                'a' => $a,
                'galeri' => $g,
                'greetings' => $greetings
            ];
            return view('Default/Index', $data);
        }
    }

    public function about()
    {
        $a = new UserModel();
        if (session()->get('whoLoggedIn')) $a = $a->find(session()->get('whoLoggedIn'));
        $data = [
            'judul' => 'Tentang | DISPERTAPAHORBUN',
            'a' => $a
        ];
        return view('Default/About', $data);
    }

    public function document(){
        $a = new UserModel();
        $doc = new DokumenModel();
        $doc = $doc->FindAll();
        if (session()->get('whoLoggedIn')) $a = $a->find(session()->get('whoLoggedIn'));
        $data = [
            'judul' => 'Document | DISPERTAPAHORBUN',
            'a' => $a,
            'doc' => $doc
        ];
        return view('Default/Document', $data);
    }

    public function artikel($slug = null)
    {
        if ($slug == null) return redirect()->route('home');

        $result = null;
        $model = new ArtikelModel();
        $a = new UserModel();
        if (session()->get('whoLoggedIn')) $a = $a->find(session()->get('whoLoggedIn'));
        $session = session();
        if ($session->get('whoLoggedIn')) {
            $result = $model->join('kategori', 'artikel.id_kategori = kategori.id_kategori')
                ->join('user', 'artikel.id_user = user.id_user')
                ->select('artikel.id_artikel, artikel.judul_artikel, artikel.link_gambar, user.nama_user, kategori.nama_kategori,
                    artikel.created_at, artikel.updated_at, artikel.isi_artikel, artikel.published_at')
                ->where('slug', $slug)
                ->first();
        } else {
            $result = $model->join('kategori', 'artikel.id_kategori = kategori.id_kategori')
                ->join('user', 'artikel.id_user = user.id_user')
                ->select('artikel.id_artikel, artikel.judul_artikel, artikel.link_gambar, user.nama_user, kategori.nama_kategori,
                        artikel.created_at, artikel.updated_at, artikel.isi_artikel, artikel.published_at')
                ->where('slug', $slug)
                ->where('artikel.published_at IS NOT NULL')
                ->first();
        }

        if ($result == null) {
            throw new PageNotFoundException("Article not available");
        }

        $data = [
            'judul' => $result['judul_artikel'] . " | DISPERTAPAHORBUN",
            'detail' => $result,
            'komentar' => env('enableComment') ? $this->treeCommentBuilder($slug) : '',
            'rekom_artikel' => $this->makeRecommendArticle($result['id_artikel']),
            'a' => $a
        ];
        return view('Default/Detail', $data);
    }

    private function makeRecommendArticle($id)
    {
        $html = "";
        $aModel = new ArtikelModel();
        $result = $aModel->join('user', 'artikel.id_user = user.id_user', 'right')
            ->join('kategori', 'artikel.id_kategori = kategori.id_kategori', 'right')
            ->select('id_artikel, link_gambar, artikel.created_at, judul_artikel, slug,
                     isi_artikel, nama_user, nama_kategori, published_at')
            ->where('published_at IS NOT NULL')
            ->where('id_artikel NOT IN (' . $id . ')')
            ->orderBy('id_artikel', 'RANDOM')
            ->limit(5)
            ->find();
        if (!empty($result)) {
            foreach ($result as $r) {
                $html .= view('Default\Card\CardArticleRecommendation', compact('r'));
            }
        } else {
            $html .= '<div class="row border border-dark shadow-sm m-lg-2 p-2" style="margin-bottom: 10px; height:auto; background-color: #fff;">';
            $html .= "No article recommendation...";
            $html .= '</div>';
        }
        return $html;
    }

    /**
     * THANKYOU VERY MUCH 
     * https://webeasystep.com/blog/view_article/threaded_comments__in_codeigniter_easy_way
     * i'm VERY GLAD I FOUND THIS WEBSITE, THANKYOU SO MUCH!
     */

    public function treeCommentBuilder($slug)
    {
        $model = new KomentarModel();
        $result2 = $model->join('artikel', 'artikel.id_artikel = komentar.id_artikel')
            ->where('slug', $slug)
            ->findAll();

        $refIDCollector = array();
        foreach ($result2 as $r) {
            array_push($refIDCollector, $r['refer_id']);
        }
        $view = "<h5>" . count($result2) . " Komentar </h6>";
        if (count($result2) == 0) {
            $view .= "<p>Jadilah orang pertama yang berkomentar mengenai artikel ini </p>";
        }
        return $view . "<div class='container'>" . $this->in_parent(0, $slug, $refIDCollector) . "</div>";
    }

    function in_parent($idx, $slug, $refIDCollector)
    {
        // this variable to save all concatenated html
        $html = "";
        // build hierarchy  html structure based on ul li (parent-child) nodes
        if (in_array($idx, $refIDCollector)) {
            $model = new KomentarModel();
            $result = $model->join('artikel', 'artikel.id_artikel = komentar.id_artikel')
                ->where('slug', $slug)
                ->where('refer_id', $idx)
                ->select('komentar.id_komentar, komentar.nama_komentar, komentar.isi_komentar, komentar.created_at')
                ->findAll();

            $html .=  $idx == 0 ? "<div class='ml-0'>" : "<div class='ml-4'>";
            foreach ($result as $re) {
                $html .= "<div>";
                $data = [
                    'komentar' => $re
                ];
                $html .= view('Default\Komentar', $data);
                $html .= $this->in_parent($re['id_komentar'], $slug, $refIDCollector);
                $html .= "</div>";
            }
            $html .=  "</div>";
        }

        return $html;
    }

    public function handleCommentCreate()
    {
        if (!$this->validate([
            'name' => 'required',
            'komentar' => 'required|max_length[100]',
            'emailKomentar' => 'required|valid_email',
            'setujuKomentar' => 'required',
            'refID' => 'required|numeric',
            'slug' => 'required'
        ])) {
            return redirect()->back();
        } else {
            $idArtikel = new ArtikelModel();
            $idArtikel = $idArtikel->where('slug', esc($this->request->getPost('slug')))
                ->select('id_artikel')
                ->first();

            $komentar = new KomentarModel();
            $komentar->save([
                'nama_komentar' => esc($this->request->getPost('name')),
                'email_komentar' => esc($this->request->getPost('emailKomentar')),
                'isi_komentar' => esc($this->request->getPost('komentar')),
                'refer_id' => $this->request->getPost('refID'),
                'id_artikel' => $idArtikel
            ]);

            return redirect()->back();
        }
    }
}
