<?php
include_once('header.php');
require_once "../config/config.php";
$conn = mysqli_connect("localhost", "root", "", "prediksi");
$data = $_GET['nama_provinsi'];
//menentukan jumlah n
$query = mysqli_query($conn, "SELECT * FROM hasil WHERE ID_PROVINSI = '$data' ");
$n = mysqli_num_rows($query);
//total jumlah y
$y = array();
$periode = array();
$nY = 0;
while ($d = mysqli_fetch_assoc($query)) {
    $i = 1;
    array_push($y, $d['jumlah']);
    array_push($periode, $d['tahun']);
    $nY = $nY + $d['jumlah'];
    $i++;
}
//menentukan x
$x = array();
if ($n % 2 == 0) {
    //genap
    $tipe = true;
    $temp = - ($n - 1);
    for ($i = 0; $i < $n; $i++) {
        if ($i == 0) {
            array_push($x, $temp);
        } else {
            $temp = $temp + 2;
            array_push($x, $temp);
        }
    }
} else if ($n % 2 != 0) {
    //ganjil
    $tipe = false;
    $temp = - (($n - 1) / 2);
    for ($i = 0; $i < $n; $i++) {
        if ($i == 0) {
            array_push($x, $temp);
        } else {
            $temp = $temp + 1;
            array_push($x, $temp);
        }
    }
}
//x pangkat 2
$x2 = array();
$nX2 = 0;
for ($i = 0; $i < $n; $i++) {
    $x2[$i] = $x[$i] * $x[$i];
    $nX2 = $nX2 + $x2[$i];
}
$xy = array();
$nXY = 0;
for ($i = 0; $i < $n; $i++) {
    $xy[$i] = $x[$i] * $y[$i];
    $nXY = $nXY + $xy[$i];
}
//nilai a
$sqljumlah = mysqli_query($conn, "SELECT SUM(jumlah) FROM `hasil` INNER JOIN provinsi as p ON hasil.id_provinsi=p.id_provinsi WHERE p.id_provinsi='$data' ");
$rowjmlh = mysqli_fetch_array($sqljumlah);
$jumlah = $rowjmlh['SUM(jumlah)'];
$a = $jumlah / $n;
//nilai b
$b = $nXY / $nX2;
//b dikali n
$bn = $b * 3;
//total prediksi
$total = $a + $bn;

?>

<div class="container-fluid">

    <div class="d-sm-flex justify-content-center  mb-4">
        <h1 class="text-light mb-0 text-gray-800 ">Prediksi Least Square</h1>

    </div>
    <div class="card-body">
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
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
                        $query = mysqli_query($conn, "SELECT * FROM hasil WHERE id_provinsi = '$data' ");
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