<?php
    //Koneksi Database
    $server = "localhost";
    $user = "root";
    $pass = "";
    $database = "uas202410101017";

    $koneksi = mysqli_connect($server, $user, $pass, $database) or die(mysqli_error($koneksi));
    $query = "SELECT * from fakultas ORDER BY jumlah_animo DESC";
    $result = mysqli_query($koneksi, $query);

    //Jika tombol simpan di klik
    if(isset($_POST['bsimpan']))
    {
        //Pengujian apakah data akan diedit atau disimpan baru
        if($_GET['hal']=="edit")
        {
            //data akan diedit
            $edit = mysqli_query($koneksi, "UPDATE fakultas set
                                                fakultas = '$_POST[tfak]',
                                                jumlah_animo = '$_POST[tanim]'
                                            WHERE idFak = '$_GET[id]'
                                          ");
            if($edit) //jika edit sukses
            {
                echo "<script>
                        alert('Edit data sukses!');
                        document.location='index.php';
                    </script>";
            }
            else //jika simpan gagal
            {
                echo "<script>
                        alert('Edit data GAGAL!');
                        document.location='index.php';
                    </script>";
            }
        }
        else
        {
            //data akan disimpan baru
            $simpan = mysqli_query($koneksi, "INSERT INTO fakultas (fakultas, jumlah_animo)
                                          VALUES ('$_POST[tfak]', 
                                                 '$_POST[tanim]')
                                          ");
            if($simpan) //jika simpan sukses
            {
                echo "<script>
                        alert('Simpan data SUKSES!');
                        document.location='index.php';
                    </script>";
            }
            else //jika simpan gagal
            {
                echo "<script>
                        alert('Simpan data GAGAL!');
                        document.location='index.php';
                    </script>";
            }
        }
    }

    //Pengujian jika tombol edit/delete di klik
    if(isset($_GET['hal']))
    {
        //Pengujian jika edit data
        if($_GET['hal'] == "edit")
        {
            //Tampilkan data yg akan diedit
            $tampil = mysqli_query($koneksi, "SELECT * from fakultas WHERE idFak = '$_GET[id]' ");
            $data = mysqli_fetch_array($tampil);
            if($data)
            {
                //Jika data ditemukan, maka data ditampung di variabel
                $vfakultas = $data['fakultas'];
                $vanimo = $data['jumlah_animo'];
            }
        }
        else if($_GET['hal'] == 'delete')
        {
            //Persiapan hapus data
            $delete = mysqli_query($koneksi, "DELETE FROM fakultas WHERE idFak = '$_GET[id]' ");
            if($delete){
                echo "<script>
                        alert('Hapus data SUKSES!');
                        document.location='index.php';
                    </script>";
            }
        }
    }
    //pengujian tombol sorting
    if (isset($_POST['sorting'])) :
        require_once 'db.php';
        $sorting = $_POST['sorting'];

        $query = mysqli_query($koneksi, "SELECT * FROM fakultas ORDER BY jumlah_animo " . $sorting . "");
        while ($row = mysqli_fetch_object($query)) : ?>
        <tr id="content">
            <td><?=$no++?></td>
            <td><?=$data['fakultas']?></td>
            <td><?=$data['jumlah_animo']?></td>
            <td>
                <a href="index.php?hal=edit&id= <?=$data['idFak']?>" class="btn btn-warning">Edit</a>
                <a href="index.php?hal=delete&id= <?=$data['idFak']?>" onclick="return confirm ('Apakah anda yakin ingin menghapus data ini?')" class="btn btn-danger">Delete</a>
            </td>
        </tr>
    <?php
        endwhile;
    endif;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UTS_1017</title>

    <link rel="stylesheet" href="Bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet"href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css"/>
    <script src="https://kit.fontawesome.com/0d95b64c38.js" crossorigin="anonymous"></script>
<style>
    aside{
        float: right;
        width: 20%;
        margin-right: 40px;
    }
    .container{
        float: left;
        width: 70%;
        margin-left: 40px;
    }
</style>
</head>
<body>
<div>
    <h1 class="text-center mb-3">FORM DATA FAKULTAS</h1>
</div>
<aside>
    <div class="card mt-3">
      <div class="card-header">
        <i class="fas fa-sort-alpha-down "></i> Sorting
      </div>
      <div class="card body">
        <p class="card-text">Sort by Animo</p>
        <select class="form-select" id="sorting" aria-label="Default select example">
          <option value=""></option>
          <option value="ASC">Sort by Animo Ascending</option>
          <option value="DESC">Sort by Animo Descending</option>
        </select>
      </div>
    </div>
</aside>
<div class="container" id="content">
    <!-- Card Form Awal -->
    <div class="card mt-3">
        <div class="card-header bg-primary text-white">
            Form Input Data Fakultas
        </div>
        <div class="card-body">
            <form method="post" action="">
                <div class="form-group">
                    <label for="">Fakultas</label>
                    <input type="text" name="tfak" value="<?=@$vfakultas?>" class="form-control" placeholder="Input Fakultas disini" required>
                </div>
                <div class="form-group">
                    <label for="">Jumlah Animo</label>
                    <input type="text" name="tanim" value="<?=@$vanimo?>" class="form-control" placeholder="Input Jumlah Animo disini" required>
                </div>

                <button type="submit" class="btn btn-success" name="bsimpan">Simpan</button>
                <button type="reset" class="btn btn-danger" name="breset">Reset</button>
            </form>
        </div>
    </div>
    <!-- Card Form Akhir -->

    <!-- Card Tabel Awal -->
    <div class="card mt-3" id="content">
        <div class="card-header bg-success text-white">
            Daftar Fakultas
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <tr>
                    <th>No.</th>
                    <th>Fakultas</th>
                    <th>Jumlah Animo</th>
                    <th>Aksi</th>
                </tr>
                <?php 
                    $no = 1;
                    $tampil = mysqli_query($koneksi, "SELECT * from fakultas ORDER BY idFak asc");
                    while($data = mysqli_fetch_array($tampil)):
                
                ?>
                <tr>
                    <td><?=$no++?></td>
                    <td><?=$data['fakultas']?></td>
                    <td><?=$data['jumlah_animo']?></td>
                    <td>
                        <a href="index.php?hal=edit&id= <?=$data['idFak']?>" class="btn btn-warning">Edit</a>
                        <a href="index.php?hal=delete&id= <?=$data['idFak']?>" onclick="return confirm ('Apakah anda yakin ingin menghapus data ini?')" class="btn btn-danger">Delete</a>
                    </td>
                </tr>
            <?php endwhile; #penutup perulangan while ?> 
            </table>
        </div>
    </div>
    <!-- Card Tabel Akhir -->

</div>
    <script src="Bootstrap/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" charset="utf-8"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#sorting').on('change', function() {
                $.ajax({
                    type: 'POST',
                    url: 'sorting.php',
                    data: {
                        sorting: $(this).val()
                    },
                    cache: false,
                    success: function(data) {
                        $('#content').html(data);
                    }
                });
            });
        });
    </script>
</body>
</html>