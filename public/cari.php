<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Fashiongram</title>
    <link
      href="https://fonts.googleapis.com/css?family=Poppins:400,500,700"
      rel="stylesheet"
    />
    <link href="css/main.css" rel="stylesheet" />
  </head>
  <body>
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
                  name="jenis"
                  id="jenis"
                  placeholder="ex: category, material, color"
                />
              </div>
            </div>
            <div class="input-wrap second">
              <div class="input-field second">
                <label>Year</label>
                <div class="input-select">
                  <select data-trigger="" name="tahun">
                    <option placeholder="">Choose year</option>
                    <option>2021</option>
                    <option>2020</option>
                    <option>2019</option>
                  </select>
                </div>
              </div>
            </div>
          </div>
          <button class="btn-search" type="submit">SEARCH</button>
        </div>
      </form>
    </div>
    <script src="js/extention/choices.js"></script>
    <script>
      const choices = new Choices("[data-trigger]", {
        searchEnabled: false,
        itemSelectText: ""
      });
    </script>

    <!--Backend-->
    <?php
						use BorderCloud\SPARQL\SparqlClient;
						require_once('../vendor/autoload.php');
						
						//Error Handling
						$jenis = false;
                        //$model = false;
                        //$bahan = false;
                        //$warna = false;
						$tahun = false;
							
						if(isset($_POST['jenis']))
							$jenis=$_POST['jenis'];
                        //if(isset($_POST['model']))
						//	$model=$_POST['model'];
                        //if(isset($_POST['bahan']))
						//	$bahan=$_POST['bahan'];
						//if(isset($_POST['warna']))
						//	$warna=$_POST['warna'];
						if(isset($_POST['tahun']))
							$tahun=$_POST['tahun'];

                        if(!$tahun){
							echo"<h1>Data Kosong!</h1>";
						}
						//Error Handling
						else{
							$fuseki_server = "http://localhost:3030"; // fuseki server address 
							$fuseki_sparql_db = "fashiongram"; // fuseki Sparql database 
							$endpoint = $fuseki_server . "/" . $fuseki_sparql_db . "/query";	
							$sc = new SparqlClient();
							$sc->setEndpointRead($endpoint);
							$q = "PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
                            PREFIX owl: <http://www.w3.org/2002/07/owl#>
                            PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
                            PREFIX xsd: <http://www.w3.org/2001/XMLSchema#>
                            PREFIX : <http://www.semanticweb.org/user/ontologies/2021/3/fashiongram#> 
                            SELECT ?tahun ?jenis ?model ?bahan ?warna 
                            WHERE { ?tren rdf:type :Tren . 
                            ?tren :Tahun ?tahun .
                            ?tren :memilikiTren ?produksi.
                            ?produksi rdf:type :Produksi .
                              OPTIONAL {?produksi :Jenis ?jenis . }
                              OPTIONAL {?produksi :Model ?model . }
                              OPTIONAL {?produksi :Warna ?warna . }
                              OPTIONAL {?produksi :Bahan ?bahan . }
                            FILTER regex ( ?jenis, '$jenis', 'i')
                            FILTER ( ?tahun = '$tahun'^^xsd:integer ) 
                            }
								"; 
							$rows = $sc->query($q, 'rows');
							$err = $sc->getErrors();
							if ($err) {
								print_r($err);
								throw new Exception(print_r($err, true));
							}
							echo"
								<h1>The Trend </h1>
                                <h2 id='jenis' hidden>$jenis</h2>
								<h2 id='tahun' hidden>$tahun</h2>
								<div class='product-meta'>
								<table id='myTable' class='table table-responsive product-dashboard-table'>
									<tr>
										<th cellpadding='30'>Year</th>
										<th cellpadding='30'>Category</th>
                                        <th cellpadding='30'>Style</th>
										<th cellpadding='30'>Material</th>
										<th cellpadding='30'>Color</th>
									</tr>";
							foreach ($rows["result"]["rows"] as $row) {
								echo"<tr>";
								foreach ($rows["result"]["variables"] as $variable) {
									echo "<td cellpadding='30'>$row[$variable]</td>";
								}
								echo "</tr>";
							}
						}
					?>

  </body>
</html>
