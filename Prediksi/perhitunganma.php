<?php
include_once('header.php');
require_once "../config/config.php";

$data = $_GET['nama_provinsi'];
//menentukan jumlah n
$query = mysqli_query($con, "SELECT * FROM hasil WHERE ID_PROVINSI = '$data' ");
$n = mysqli_num_rows($query);

$sqljumlah = mysqli_query($con, "SELECT SUM(jumlah) FROM `hasil` INNER JOIN provinsi as p ON hasil.id_provinsi=p.id_provinsi WHERE p.id_provinsi='$data' ");
$rowjmlh = mysqli_fetch_array($sqljumlah);
$jumlah = $rowjmlh['SUM(jumlah)'];

$total = $jumlah / $n;

?>

<div class="container-fluid">
    <div class="d-sm-flex justify-content-center  mb-4">
        <h1 class="text-light mb-0 text-gray-800 ">Prediksi Moving Average</h1>

    </div>
    <div class="card-body">

        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0"">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tahun Panen</th>
                            <th>Jumlah Panen</th>
                            <th>Prediksi 2022</th>
                            
                        </tr>
                        <tr>
                            
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $data = $_GET['nama_provinsi'];
                        $query = mysqli_query($con, "SELECT * FROM hasil WHERE id_provinsi = '$data' ");
                        $no = 1;
                        if (mysqli_num_rows($query) > 0) {
                            while ($row = mysqli_fetch_array($query)) {
                        ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $row['tahun'] ?></td>
                                    <td><?= $row['jumlah'] ?></td>

                    </tr>
            <?php
                            }
                            echo "<tr><td></td>
                            <td></td>
                            <td></td>
                            <td>$total</td></tr>";
                        } else {
                            echo "<tr><td colspan=\"8\" align=\"center\">data tidak ada</td></tr>";
                        }
            ?>
            
            </tbody>
                </table>
                <span class=" font-weight-bold">
                    HASIL PREDIKSI JUMLAH PANEN TAHUN 2022 ADALAH <?= $total ?> TON
                    </span>


                    </section>
            </div>
        </div>

        <script>
            $(document).ready(function() {
                $('.admin').DataTable({
                    " paging": true,
                });
            });
        </script>
        <div>
        </div>
    </div>

    <?php include_once('footer.php');
    ?>