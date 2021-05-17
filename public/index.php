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
  </body>
</html>