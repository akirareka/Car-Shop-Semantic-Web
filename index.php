<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Shop</title>

    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">

    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous">
    </script>
    <script src="https://kit.fontawesome.com/c3c1353c4c.js" crossorigin="anonymous"></script>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #F9FF75;
        }

        #container {
   min-height:100%;
   position:relative;
}

#footer {
   position:absolute;
   bottom:-15px;
   width:100%;
   height:100%; 
   background:#6cf;
}

        .search button {
            border-radius: 10px;
            background-color: white;
            border-style: solid;
            float: right;

        }

        nav {
            background-color: #AAF0C1;
            width: 100%;
            height: 100px;
        }

        input {
            /* margin-left: 100%; */
            border-radius: 5px;
            border-color: black;
            border-style: solid;
            margin-right: 15px;
            margin-left:10px;
            width: 1000px;
        }
    </style>
</head>

<body>
    <!-- Connector untuk menghubungkan PHP dan SPARQL -->
    <?php
        require_once("sparqllib.php");
        $test = "";
        if (isset($_POST['search'])) {
            $test = $_POST['search'];
            $data = sparql_get(
            "http://localhost:3030/tugas_semweb",
            "
            PREFIX id: <https://carshop.com/> 
            PREFIX item: <https://carshop.com/ns/item#> 
            PREFIX rdf:  <http://www.w3.org/1999/02/22-rdf-syntax-ns#> 
            SELECT ?NamaMobil ?Merk ?Jenis ?BahanBakar ?TipeDrive ?Kecepatan ?Torsi ?UkuranBan ?MaterialVelg ?Harga
            WHERE
            { 
                ?items
                    item:NamaMobil      ?NamaMobil ;
                    item:Merk           ?Merk ;
                    item:Jenis          ?Jenis ;
                    item:BahanBakar     ?BahanBakar ;
                    item:TipeDrive      ?TipeDrive ;
                    item:Kecepatan      ?Kecepatan ;
                    item:Torsi          ?Torsi ;
                    item:UkuranBan      ?UkuranBan ;
                    item:MaterialVelg   ?MaterialVelg ;
                    item:Harga          ?Harga .

                    FILTER 
                    (regex (?NamaMobil, '$test', 'i') 
                    || regex (?Merk, '$test', 'i') 
                    || regex (?Jenis, '$test', 'i') 
                    || regex (?BahanBakar, '$test', 'i')
                    || regex (?TipeDrive, '$test', 'i')
                    || regex (?MaterialVelg, '$test', 'i')
                    || regex (?Torsi, '$test', 'i')
                    || regex (?Kecepatan, '$test', 'i'))
                    }"
            );
        } else {
            $data = sparql_get(
                "http://localhost:3030/tugas_semweb",
                "
                PREFIX id: <https://carshop.com/> 
                PREFIX item: <https://carshop.com/ns/item#> 
                PREFIX rdf:  <http://www.w3.org/1999/02/22-rdf-syntax-ns#> 
                SELECT ?NamaMobil ?Merk ?Jenis ?BahanBakar ?TipeDrive ?Kecepatan ?Torsi ?UkuranBan ?MaterialVelg ?Harga
                WHERE
                { 
                    ?items
                    item:NamaMobil      ?NamaMobil ;
                    item:Merk           ?Merk ;
                    item:Jenis          ?Jenis ;
                    item:BahanBakar     ?BahanBakar ;
                    item:TipeDrive      ?TipeDrive ;
                    item:Kecepatan      ?Kecepatan ;
                    item:Torsi          ?Torsi ;
                    item:UkuranBan      ?UkuranBan ;
                    item:MaterialVelg   ?MaterialVelg ;
                    item:Harga          ?Harga .
                }
            "
            );
        }

        if (!isset($data)) {
            print "<p>Error: " . sparql_errno() . ": " . sparql_error() . "</p>";
        }
    ?>


    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg ">
        <img style="width: 150px; margin-left:5%; height:95px; " src="src/img/logo_carshop.jpg">
        <h5 style="margin-left: 50px;">FIRST CAR SHOP</h5>
        <div class="container container-fluid ">
            <div class="collapse navbar-collapse">
                <form class="d-flex search" role="search" action="" method="post" id="nameform">
                    <input class="form" type="search" placeholder="  Ketik keyword yang ingin dicari" aria-label="Search"
                        name="search">
                    <button class="button " type="submit">Cari</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container container-fluid mt-3  ">
        <i class="fa-solid fa-magnifying-glass"></i><span>Menampilkan hasil pencarian 
            "<?php echo $test; ?>"</span>
        <table class="table table-hover text-center">
            <thead class="table" style="background-color:black; color:white; ">
                <tr>
                    <th>Nama Mobil</th>
                    <th>Merk</th>
                    <th>Jenis</th>
                    <th>Bahan Bakar</th>
                    <th>Tipe Drive</th>
                    <th>Kecepatan</th>
                    <th>Torsi</th>
                    <th>Ukuran Ban</th>
                    <th>Material Velg</th>
                    <th>Harga</th>
                </tr>
            </thead>
            <tbody class="table-group-divider"; style="background-color:#FFDAC1";>
                <?php $i = 0; ?>
                <?php foreach ($data as $dat) : ?>
                <tr>
                    <td><?= $dat['NamaMobil'] ?></td>
                    <td><?= $dat['Merk'] ?></td>
                    <td><?= $dat['Jenis'] ?></td>
                    <td><?= $dat['BahanBakar'] ?></td>
                    <td><?= $dat['TipeDrive'] ?></td>
                    <td><?= $dat['Kecepatan'] ?></td>
                    <td><?= $dat['Torsi'] ?></td>
                    <td><?= $dat['UkuranBan'] ?></td>
                    <td><?= $dat['MaterialVelg'] ?></td>
                    <td><?= $dat['Harga'] ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="footer"; style="background-color:black;">
        <div class="container">
            <h4>Akirareka Kinantan Jiraiya</h4>
            <h5>140810190032</h5>
            <h6>Proyek Akhir Semantik Web</h6>
            <h6>Jurusan Teknik Informatika Unpad</h6>
        </div>
    </div>
</body>

</html>