<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Fashiongram</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="css/card.css" rel="stylesheet" />
    <link
      href="https://fonts.googleapis.com/css?family=Poppins:400,500,700"
      rel="stylesheet"
    />
    <link href="css/main.css" rel="stylesheet" />
  </head>
  <body>
  <nav class="navbar navbar-dark bg-dark">
  <a class="navbar-brand" href="index.php">FASHIONGRAM</a>
</nav>
    <div class="s013">
      <form action="cari.php" method="POST">
        <fieldset>
          <legend>FASHIONGRAM</legend>
          <pagetitle>Find & Follow The Fashion Trend!</pagetitle>
        </fieldset>
        <div class="inner-form">
          <div class="left">
            <div class="input-wrap first">
              <div class="input-field first">
                <label>Type here....</label>
                <input
                  type="text"
                  name="keywords"
                  id="keywords"
                  placeholder="ex: category, material, color"
                />
              </div>
            </div>
            <div class="input-wrap second">
              <div class="input-field second">
              <label>Year</label>
                <div class="input-select">
                  <select data-trigger="" name="tahun">
                    <option value="" placeholder="" disabled hidden selected>Choose Year</option>
                    <option value="2021">2021</option>
                    <option value="2020">2020</option>
                    <option value="2019">2019</option>
                  </select>
                </div>
              </div>
            </div>
          </div>
          <button class="btn-search" type="submit">SEARCH</button>
        </div>
      </form>
    </div>
    <?php
						use BorderCloud\SPARQL\SparqlClient;
						require_once('../vendor/autoload.php');

            $fuseki_server = "http://localhost:3030"; // fuseki server address 
							$fuseki_sparql_db = "fashiongram"; // fuseki Sparql database 
							$endpoint = $fuseki_server . "/" . $fuseki_sparql_db . "/query";	
							$sc = new SparqlClient();
							$sc->setEndpointRead($endpoint);
							$q = "PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
              PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
              PREFIX xsd: <http://www.w3.org/2001/XMLSchema#>
              PREFIX : <http://www.semanticweb.org/user/ontologies/2021/3/fashiongram#> 
              SELECT ?tahun ?jenis ?model ?bahan ?warna ?foto
              WHERE { ?tren rdf:type :Tren .
              ?tren :memilikiTren ?produksi.
              ?produksi rdf:type :Produksi .
              OPTIONAL {?tren :Tahun ?tahun . }
              OPTIONAL {?produksi :urlFoto ?foto . }
              OPTIONAL {?produksi :Jenis ?jenis . }
              OPTIONAL {?produksi :Model ?model . }
              OPTIONAL {?produksi :Warna ?warna . }
              OPTIONAL {?produksi :Bahan ?bahan . }}
								"; 
							$rows = $sc->query($q, 'rows');
							$err = $sc->getErrors();
							if ($err) {
								print_r($err);
								throw new Exception(print_r($err, true));
							}
							echo"
              <main>
              <div class='container-fluid bg-trasparent my-4 p-3' style='position: relative;'>
              <div class='row row-cols-1 row-cols-xs-2 row-cols-sm-2 row-cols-lg-4 g-3'>";
              foreach ($rows["result"]["rows"] as $row) {
                $tahun=$row["tahun"];
                $jenis=$row["jenis"];
                $model=$row["model"];
                $foto=$row["foto"];
                $bahan=$row["bahan"];
                $warna=$row["warna"];
              echo"
              <div class='col'>
                <div class='card h-100 shadow-sm'> <img src='$foto' class='card-img-top' alt='...'>
                <div class='card-body'>
                <div class='clearfix mb-3'> <span class='float-start badge rounded-pill bg-primary'>$tahun</span></div>
                <h5 class='card-subtitle'><b>$model</b></h5>
                <p>$jenis</p>
                <p>$bahan</p>
                <p>$warna</p>
                </div>
                </div>
                </div>";
          };
            echo"
        </div>
    </div>
</main>";
?>
    <script src="js/extention/choices.js"></script>
    <script src="vendor/jquery/jquery-3.2.1.min.js"></script>
    <script src="vendor/bootstrap/js/popper.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="vendor/select2/select2.min.js"></script>
    <script src="js/main.js"></script>
    <script>
      const choices = new Choices("[data-trigger]", {
        searchEnabled: false,
        itemSelectText: ""
      });
    </script>
  </body>
</html>