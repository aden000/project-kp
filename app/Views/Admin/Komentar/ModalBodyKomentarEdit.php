    <input type="hidden" name="id" value="<?= $komentar['id_komentar']; ?>">
    <div class="form-group">
        <label for="namaKomentar">Nama Komentar</label>
        <input type="text" class="form-control" name="namaKomentar" id="namaKomentar" aria-describedby="namaKomentarHelpId" placeholder="Nama Komentar" value="<?= $komentar['nama_komentar']; ?>">
    </div>
    <div class="form-group">
        <label for="isiKomentar">Isi Komentar</label>
        <textarea class="form-control" name="isiKomentar" id="isiKomentar" rows="3"><?= $komentar['isi_komentar']; ?></textarea>
    </div>
    </form>