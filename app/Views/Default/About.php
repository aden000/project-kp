<?= $this->extend('Template/Template'); ?>

<?= $this->section('content'); ?>

<?php if (session('message')) : ?>
    <div class="flash-data" data-judul="<?= session('message')['judul']; ?>" data-msg="<?= session('message')['msg']; ?>" data-role="<?= session('message')['role']; ?>"></div>
<?php endif; ?>

<div class="row mx-4" style="padding-top: 20px; padding-bottom: 20px; margin-bottom: 10px;">
    <div class="col col-lg-8">
        <div class="row section-heading">
            <h4>Tentang Website</h4>
        </div>
        <div class="row shadow-sm border border-dark" style="padding: 10px; background-color: #fff;">
            <p>Dalam rangka untuk meningkatkan pelayanan tehadap masyarakat, Dinas Pertanian Tanaman Pangan, Hortikultura dan Perkebunan menyajikan buku Laporan Tahunan Tahun 2018 tentang perkembangan pembangunan Pertanian Tanaman Pangan, Hortikultura dan Perkebunan di Kabupaten Bangkalan. Selain itu buku ini diharapkan dapat dijadikan :<br>
                <br>
                Sebagai acuan untuk meningkatkan pembangunan Pertanian Tanaman Pangan, Hortikultura dan Perkebunan di Kabupaten Bangkalan untuk Tahun mendatang, melalui Program dan Kegiatan yang sesuai dengan kebutuhan masyarakat dan perundang – perundangan yang berlaku. <br>
                Sebagai sumber informasi data sebagai bahan untuk mengambil kebijakan Pertanian Tanaman Pangan, Hortikultura dan Perkebunan yang akan datang. <br>
                Kumpulan hasil pelaksanaan kegiatan pembangunan pada Dinas Pertanian Tanaman Pangan, Hortikultura dan Perkebunan Kabupaten Bangkalan <br>
                Sebagai salah satu refrensi untuk meningkatkan pengetahuan tentang Pertanian Tanaman Pangan, Hortikultura dan Perkebunan di Kabupaten Bangkalan. <br>
                Sasaran dan stategi pembangunan Pertanian Tanaman Pangan, Hortikultura dan Perkebunan saat ini dirumuskan dalam bentuk visi yakni : <br>
                <br>
                “Terwujudnya Peningkatan produksi, produktivitas pertanian dan perkebunan yang berkelanjutan berbasis potensi pertanian unggulan untuk kemakmuran masyarakat”. <br>
                <br>
                Dengan mengacu kepada Misi Bupati Bangkalan di dalam RPJMD Kabupaten Bangkalan tahun 2014 – 2019, maka Dinas Pertanian Tanaman Pangan, Hortikultura dan Perkebunan Kabupaten Bangkalan masuk pada Misi ke-2, yaitu : <br>
                <br>
                Misi 2 : Mempercepat peningkatan perekonomian berbasis potensi lokal <br>
                <br>
                Pembangunan ekonomi pada hakekatnya merupakan upaya meningkatkan kesejahteraan masyarakat melalui peningkatan dan pemerataan pendapatan masyarakat. Pelaksanaan pembangunan ekonomi didasarkan pada sistem ekonomi kerakyatan dan pengembangan sektor unggulan, terutama yang banyak menyerap tenaga kerja yang didukung dengan peningkatan kemampuan sumber daya manusia dan teknologi untuk memperkuat landasan pembangunan yang berkelanjutan dan meningkatkan daya saing serta berorientasi pada globalisasi ekonomi. <br>
                <br>
                Untuk mendukung Misi 2 pada RPJMD Kabupaten Bangkalan tahun 2014 – 2019, dan untuk mendorong pencapaian Misi 2 Bupati Kabupaten Bangkalan, maka Dinas Pertanian Tanaman Pangan, Hortikultura dan Perkebunan Kabupaten Bangkalan menetapkan 5 Misinya, sebagai berikut : <br>
                <br>
                <strong>
                    Misi 1 : Meningkatkan kualitas SDM Pertanian dan perkebunan yang handal <br>
                    Misi 2 : Meningkatkan sarana dan prasarana bidang pertanian dan perkebunan <br>
                    Misi 3 : Meningkatkan produktifitas, produksi, dan mutu produk pertanian serta perkebunan, berkelanjutan, berbasis spesifik lokasi dan komoditi lokal
                </strong>
            </p>
        </div>
    </div>
    <div class="col-lg-4 pl-lg-4 mt-2 mt-lg-0">
        <div class="row section-heading">
            <hgroup>
                <h5>Made with love using <b>CodeIgniter 4</b></h5>
                <h6>Kelompok Kerja Praktek</h6>
            </hgroup>
            <ul class="list-group">
                <a class="list-group-item" href="https://github.com/aditiya98" style="color: inherit; text-decoration: none;">
                    <img src="https://github.com/aditiya98.png" alt="@aditiya98" width="32" height="32" class="rounded mr-2" loading="lazy">
                    Aditiya Gusti Apriliansyah | 06.2017.1.06732
                </a>
                <a class="list-group-item" href="https://github.com/AnEmotionless" style="color: inherit; text-decoration: none;">
                    <img src="https://github.com/AnEmotionless.png" alt="@AnEmotionless" width="32" height="32" class="rounded mr-2" loading="lazy">
                    M. Yusuf Eka Saputra | 06.2017.1.06733
                </a>
                <a class="list-group-item" href="https://github.com/aden000/" style="color: inherit; text-decoration: none;">
                    <img src="https://github.com/aden000.png" alt="@aden000" width="32" height="32" class="rounded mr-2" loading="lazy">
                    Achmad Ade Nugroho | 06.2017.1.06740
                </a>
            </ul>
        </div>
        <!-- <div class="row shadow-sm border border-dark" style="background-color: #fff; height:fit-content; padding:10px;">
        </div> -->
    </div>
</div>
<?= $this->endSection(); ?>