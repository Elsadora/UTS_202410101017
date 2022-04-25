<?php
    //Koneksi Database
    // $server = "localhost";
    // $user = "root";
    // $pass = "";
    // $database = "uas202410101017";

    //Koneksi Database server
    $server = "localhost";
    $user = "202410101017";
    $pass = "secret";
    $database = "uas202410101017";


    $koneksi = mysqli_connect($server, $user, $pass, $database) or die(mysqli_error($koneksi));
    
    // Sorting
    if (isset($_POST['sorting'])) :
        $sorting = $_POST['sorting'];
        $no = 1;
        $tampil = mysqli_query($koneksi, "SELECT * FROM fakultas ORDER BY jumlah_animo " . $sorting . "");
        while ($data = mysqli_fetch_array($tampil)) :
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
    <?php
    endwhile;
endif;
?>