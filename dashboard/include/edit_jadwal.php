<h1>Tambah Jadwal</h1>

<?php
if (isset($_POST['submit'])) {

    $_SESSION['message'] = "";

    $valid = true;
    $err   = array();

    foreach ($_POST as $key => $val) {
        ${$key} = $val;
        $_SESSION['' . $key . ''] = $val;
    }

    if ($mapel == "") {
        array_push($err, "Mapel harus dipilih");
        $valid = false;
    }

    if ($hari == "") {
        array_push($err, "hari harus dipilih");
        $valid = false;
    }

    $mulai = strtotime($mulai);
    $selesai = strtotime($selesai);

    // echo var_dump($hari, $mapel, $kelas, $mulai, $selesai);
    // die();


    if ($valid == false) {
        echo '<script>alert("tidak boleh ada field yang kosong")</script>';
    } else {
        $query        =    "UPDATE jadwal SET id_hari='$hari', id_mapel='$mapel', kelas='$kelas', mulai='$mulai',selesai='$selesai' WHERE id_jadwal='$id_jadwal' ";
        $exec         =    mysqli_query($conn, $query);

        if ($exec) {
            $_SESSION['message'] = "Berhasil edit Jadwal";
            echo '<script>window.location = "index.php?page=22"</script>';
        } else {
            echo mysqli_error($conn);
        }
    }
} else {
    unset($_SESSION['hari']);
    unset($_SESSION['mapel']);
    unset($_SESSION['kelas']);
    unset($_SESSION['mulai']);
    unset($_SESSION['selesai']);
}
?>

<?php
$queryJadwal   =    "SELECT * FROM jadwal JOIN mapel ON jadwal.id_mapel=mapel.kode_mapel_kegiatan JOIN hari ON jadwal.id_hari=hari.Id WHERE jadwal.id_jadwal='$id_jadwal'";
$execJadwal   =    mysqli_query($conn, $queryJadwal);
if ($execJadwal) {
    $jadwal = mysqli_fetch_assoc($execJadwal);
}

?>

<div class="row">
    <div class="col-sm-12 col-md-8 col-lg-10 col-lg-offset-1">
        <div class="card" style="margin-top: 50px">
            <div class="card-header" data-background-color="blue">
                <h4 class="title">Tambah Jadwal Kelas <?php echo $kelas; ?></h4>
                <p class="category">Masukan data Jadwal dengan benar</p>
            </div>
            <div class="card-content">
                <a href="index.php?page=22" class="btn btn-primary btn-md pull-right"><i class="fa fa-arrow-left"></i> Kembali</a>
                <h3 style="overflow: hidden;"><b>Data Jadwal</b></h3>

                <form action="" method="post">
                    <input type="hidden" name="kelas" value="<?= $jadwal['kelas'] ?>">
                    <div class="form-group floating-label">
                        <label for="mapel">Mata Pelajaran</label>
                        <select name="mapel" id="mapel" class="form-control">
                            <option value="" selected disabled>-- Pilih Mata Pelajaran --</option>
                            <?php
                            $queryMapel    =    "SELECT * FROM mapel";
                            $execMapel    =    mysqli_query($conn, $queryMapel);
                            if ($execMapel) {
                                while ($mapel = mysqli_fetch_array($execMapel)) {
                                    $selected = ($mapel['kode_mapel_kegiatan'] == $jadwal['id_mapel']) ? 'selected' : '';
                            ?>
                                    <option <?= $selected; ?> value="<?php echo $mapel['kode_mapel_kegiatan'] ?>"><?php echo $mapel['kode_mapel_kegiatan'] ?> - <?php echo $mapel['nama_mapel_kegiatan'] ?></option>
                            <?php
                                }
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group floating-label">
                        <label for="hari">Hari</label>
                        <select name="hari" id="mapel" class="form-control">
                            <option value="" selected disabled>-- Pilih Hari --</option>
                            <?php
                            $queryMapel    =    "SELECT * FROM hari";
                            $execMapel    =    mysqli_query($conn, $queryMapel);
                            if ($execMapel) {
                                while ($mapel = mysqli_fetch_array($execMapel)) {
                                    $selected = ($mapel['Id'] == $jadwal['id_hari']) ? 'selected' : '';

                            ?>
                                    <option <?= $selected; ?> value="<?php echo $mapel['Id'] ?>"><?php echo $mapel['nama_hari'] ?></option>
                            <?php
                                }
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group floating-label">
                        <label for="mulai">Jam Mulai</label>
                        <input type="time" class="form-control" name="mulai" id="mulai" value="<?= date('H:i', $jadwal['mulai']) ?>" required>
                    </div>
                    <div class="form-group floating-label">
                        <label for="selesai">Jam Selesai</label>
                        <input type="time" class="form-control" name="selesai" id="selesai" value="<?= date('H:i', $jadwal['selesai']) ?>" required>
                    </div>



                    <button type="submit" name="submit" class="btn btn-primary pull-right"><i class="fa fa-save"></i> &nbsp;Simpan</button>
                    <button type="reset" class="btn btn-warning pull-right"><i class="fa fa-eraser"></i> Bersihkan</button>
                </form>

            </div>
        </div>
    </div>
</div>