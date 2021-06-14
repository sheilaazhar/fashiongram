<!DOCTYPE html>
<html>
<head>
	<title> Fashion Detail </title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/detail.css">
	<link href="css/card.css" rel="stylesheet" />
	<style type="text/css">
    body{
		background-image: url("../assets/background.jpg");
	}
</style>
</head>
<body>
<nav class="navbar navbar-dark bg-dark">
  <a class="navbar-brand" href="index.php">FASHIONGRAM</a>
  <form class="form-inline">
    <button class="btn btn-outline-light" type="button" onclick="document.location='search.php'">Advanced Search</button>
  </form>
</nav>
<div class="container">
	<div class="col-lg-8 border p-3 main-section bg-white">
	<div class='row'>
			<div class='col-lg-12 text-center pt-3'>
				<h4>Fashion Detail</h4>
			</div>
		</div>
    <?php
						use BorderCloud\SPARQL\SparqlClient;
						require_once('../vendor/autoload.php');

                        $id = $_GET['id'];

                            $fuseki_server = "http://31.220.62.156:3030/"; // fuseki server address 
							$fuseki_sparql_db = "fashiongram"; // fuseki Sparql database 
							$endpoint = $fuseki_server . "/" . $fuseki_sparql_db . "/query";	
							$sc = new SparqlClient();
							$sc->setEndpointRead($endpoint);
							$q = "PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
                            PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
                            PREFIX xsd: <http://www.w3.org/2001/XMLSchema#>
                            PREFIX : <http://www.semanticweb.org/user/ontologies/2021/3/fashiongram#> 
                            SELECT ?tahun ?jenis ?model ?bahan ?warna ?foto ?id
                            WHERE { ?tren rdf:type :Tren .
                            ?tren :memilikiTren ?produksi.
                            ?produksi rdf:type :Produksi .
                            ?tren :Tahun ?tahun .
                            ?produksi :Id '$id' .
                            ?produksi :urlFoto ?foto .
                            ?produksi :Jenis ?jenis .
                            ?produksi :Model ?model .
                            ?produksi :Warna ?warna .
                            ?produksi :Bahan ?bahan .
                            }
								"; 
							$data = $sc->query($q, 'data');
							$row = $data['result']['rows'][0];
							$err = $sc->getErrors();
							if ($err) {
								print_r($err);
								throw new Exception(print_r($err, true));
							}
                            $tahun=$row["tahun"];
                            $jenis=$row["jenis"];
                            $model=$row["model"];
                            $bahan=$row["bahan"];
                            $foto=$row["foto"];
							$warna=$row["warna"];
                            
                            echo"
							<div class='row m-0'>
			<div class='col-lg-4 left-side-product-box pb-3'>
				<img src='$foto' class='border p-3'>
			</div>
			<div class='col-lg-8'>
				<div class='right-side-pro-detail border p-3 m-0'>
					<div class='row'>
						<div class='col-lg-12'>
							<p class='m-0 p-0'>$model</p>
						</div>
						<div class='col-lg-12'>
							<p class='m-0 p-0 price-pro'>$tahun</p>
							<hr class='p-0 m-0'>
						</div>
						<div class='col-lg-12 pt-2'>
							<h5>Detail</h5>
                            <span>Category : $jenis</span><hr class='m-0 pt-2 mt-2'>
							<span>Material : $bahan</span><hr class='m-0 pt-2 mt-2'>
                            <span>Color : $warna</span><hr class='m-0 pt-2 mt-2'>
						</div>
						<div class='col-lg-12'>
							<p class='tag-section'><strong>Tag : </strong>$jenis , $model , $bahan , $warna , $tahun</p>
						</div>
					</div>
				</div>
			</div>
		</div>";

							$q1 = "PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
                            PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
                            PREFIX xsd: <http://www.w3.org/2001/XMLSchema#>
                            PREFIX : <http://www.semanticweb.org/user/ontologies/2021/3/fashiongram#> 
                            SELECT ?tahun ?jenis ?model ?bahan ?warna ?foto ?id
                            WHERE { ?tren rdf:type :Tren .
                            ?tren :memilikiTren ?produksi.
                            ?produksi rdf:type :Produksi .
                            ?tren :Tahun ?tahun .
                            ?produksi :Id ?id .
                            ?produksi :urlFoto ?foto .
                            ?produksi :Jenis '$jenis' .
                            ?produksi :Model ?model .
                            ?produksi :Warna ?warna .
                            ?produksi :Bahan ?bahan .
                            } ORDER BY RAND() LIMIT 8
								"; 
							$rows = $sc->query($q1, 'rows');
							$err = $sc->getErrors();
							if ($err) {
								print_r($err);
								throw new Exception(print_r($err, true));
							}

                            echo"
							<div class='row'>
			<div class='col-lg-12 text-center pt-3'>
				<h4>More Trend $jenis</h4>
			</div>
		</div>
                <main>
                <div class='container-fluid bg-trasparent my-4 p-3' style='position: relative;'>
                <div class='row row-cols-1 row-cols-xs-2 row-cols-sm-2 row-cols-lg-4 g-3'>";
                foreach ($rows["result"]["rows"] as $row1) {
                $tahun=$row1["tahun"];
                $model=$row1["model"];
                $foto=$row1["foto"];
                $bahan=$row1["bahan"];
                $warna=$row1["warna"];
                $id=$row1["id"];
                echo"
                <div class='col-3'>
                <div class='card h-100 shadow-sm'> <img src='$foto' class='card-img-top' alt='...'>
                <div class='card-body'>
                <div class='clearfix mb-3'> <span class='float-start badge rounded-pill bg-primary'>$tahun</span></div>
                <h5 class='card-subtitle'><b>$model</b></h5>
                <p>$jenis</p>
                <div class='text-center my-4'> <a href='detail.php?id=$id' class='btn btn-warning'>Detail</a>
                </div>
                </div>
                </div>
                </div>";
                };
                echo"
                </div>
                </div>
                </main>
				</div>
				";
			
?>
</body>
</html>