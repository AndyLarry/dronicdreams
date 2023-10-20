<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" />
    <link rel="stylesheet" href="style/main.css">
    <title>Enregistrement de cas</title>
</head>
<body>
<?php
    try
    {
        // On se connecte à MySQL
        $mysqlClient = new PDO('mysql:host=localhost;dbname=dronicdreams;charset=utf8', 'root', 'root');
    }
    catch(Exception $e)
    {
        // En cas d'erreur, on affiche un message et on arrête tout
            die('Erreur : '.$e->getMessage());
    }

    // Si tout va bien, on peut continuer

    // On récupère tout le contenu de la table recipes
    $sqlQuery = 'SELECT * FROM famille';
    $result = array();
    $recipesStatement = $mysqlClient->prepare($sqlQuery);
    $recipesStatement->execute();
    while ($row = $recipesStatement->fetch(PDO::FETCH_ASSOC)) {
        array_push($result,$row);
    }
?>
<div class="container d-flex justify-content-center pt-2">
  <div class="text-center pb-2">
    <h6>Evaluer, classer et traiter le nourrisson malade agé de 0 à 2 mois (0 à 59 jours)</h6>
  </div>
</div>

<div class="container d-flex justify-content-center" style="min-width:720px!important">
  <div class="col-11 col-offset-2">
    <div class="progress mt-3" style="height: 30px;">
      <div class="progress-bar progress-bar-striped progress-bar-animated" style="font-weight:bold; font-size:15px;" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
    </div>
    <div class="card mt-3">
      <div class="card-header font-weight-bold">Etapes d'evaluation de la maladie</div>
      <div class="card-body p-4 step">
        <div class="radio-group row justify-content-between px-3 text-center" style="justify-content:center !important">
          <div class="col-auto me-sm-2 mx-1 card-block py-0 text-center radio">
            <div class="opt-icon"><i btn_id="newfam" class="fas fa-user-plus" style="font-size: 80px; margin-left: 25px;"></i></div>
            <p><b>Nouvelle famille</b></p>
          </div>
          <div id="suser" class="selected col-auto ms-sm-2 mx-1 card-block py-0 text-center radio">
            <div class="opt-icon"><i btn_id="exifam" class="fas fa-users" style="font-size: 80px;"></i></div>
            <p><b>Rechercher famille</b></p>
          </div>
        </div>
        <div class="searchfield text-center pb-1" style="font-size:12px">Exemple de recherche <b>Tendry RAKOTO</b></div>
        <div class="searchfield input-group px-5">
          <span class="input-group-text" id="basic-addon1"><i class="fas fa-search text-white" aria-hidden="true"></i></span>
          <input id="txt-search" class="form-control" type="text" placeholder="Rechercher" aria-label="Search">
        </div>
        <div id="filter-records" class="mx-5"></div>
      </div>
      <div id="userinfo" class="card-body p-4 step" style="display: none">
        <div class="text-center">
          <h5 class="card-title font-weight-bold pb-2">Information famille</h5>
        </div>

        <div class="form-group row">
          <div class="col-2"></div>
          <div class="col-4">
            <label for="nompere">Nom du pere<b style="color: #dc3545;">*</b></label>
            <input type="text" name="nompere" class="form-control" id="nompere" required>
            <div class="invalid-feedback">Ce champ est requis</div>
          </div>
          <div class="col-4">
            <label for="prenompere">Prenom du pere<b style="color: #dc3545;">*</b></label>
            <input type="text" class="form-control" id="prenompere" required>
            <div class="invalid-feedback">Ce champ est requis</div>
          </div>
        </div>
        <div class="form-group row">
          <div class="col-2"></div>
          <div class="col-4">
            <label for="nommere">Nom de la mere<b style="color: #dc3545;">*</b></label>
            <input type="text" name="nommere" class="form-control" id="nommere" required>
            <div class="invalid-feedback">Ce champ est requis</div>
          </div>
          <div class="col-4">
            <label for="prenommere">Prenom de la mere<b style="color: #dc3545;">*</b></label>
            <input type="text" class="form-control" id="prenommere" required>
            <div class="invalid-feedback">Ce champ est requis</div>
          </div>
        </div>
        <div class="form-group row">
          <div class="col-2"></div>
          <div class="col-4">
            <label for="nomenfant">Nom de l'enfant<b style="color: #dc3545;">*</b></label>
            <input type="text" name="nomenfant" class="form-control" id="nomenfant" required>
            <div class="invalid-feedback">Ce champ est requis</div>
          </div>
          <div class="col-4">
            <label for="prenomenfant">Prenom de l'enfant<b style="color: #dc3545;">*</b></label>
            <input type="text" class="form-control" id="prenomenfant" required>
            <div class="invalid-feedback">Ce champ est requis</div>
          </div>
        </div>
        <div class="form-group row pt-2">
          <label for="ageenfant" class="col-2 text-end control-label col-form-label">Age de l'enfant<b style="color: #dc3545;">*</b></label>
          <div class="col-8">
            <input type="number" class="form-control" id="ageenfant" required>
            <div class="invalid-feedback">Ce champ est requis</div>
          </div>
        </div>
        <div class="form-group row pt-2">
          <label for="localisationcas" class="col-2 text-end control-label col-form-label">Localisation</label>
          <div class="col-8">
            <input type="text" class="form-control" id="localisationcas">
          </div>
        </div>
        <div class="form-group row pt-2">
          <label for="coordonnecas" class="col-2 text-end control-label col-form-label">Coordonnées<b style="color: #dc3545;">*</b></label>
          <div class="col-8">
            <input type="text" class="form-control" id="coordonnecas" required onfocus="getLocation();">
            <div class="invalid-feedback">Ce champ est requis</div>
          </div>
        </div>
        <div class="text-center text-muted"><b style="color: #dc3545;">*</b> champs requis</div>
      </div>

      <div class="card-body p-5 step" style="display: none">
        <p><b>DEMANDE</b> - Le nourrisson a-t-il eu des convulsions ?</p>
        <div class="radio-group row justify-content-between px-3 text-center" style="justify-content:center !important">
            <div class="col-auto me-sm-2 mx-1 card-block py-0 text-center radio">
                <div class="opt-icon"><i btn_id="convulsion_oui" class="fas fa-check-circle" style="font-size: 80px;"></i></div>
                <p><b>Oui</b></p>
            </div>
            <div class="col-auto ms-sm-2 mx-1 card-block py-0 text-center radio">
                <div class="opt-icon"><i btn_id="convulsion_non" class="fas fa-times-circle" style="font-size: 80px;"></i></div>
                <p><b>Non</b></p>
            </div>
        </div>
      </div>

      <div class="card-body p-5 step" style="display: none">
        <p><b>DEMANDE</b> - Le nourrisson a-t-il des difficultés à s'alimenter ?</p>
        <div class="radio-group row justify-content-between px-3 text-center" style="justify-content:center !important">
            <div class="col-auto me-sm-2 mx-1 card-block py-0 text-center radio">
                <div class="opt-icon"><i btn_id="aliment_oui" class="fas fa-check-circle" style="font-size: 80px;"></i></div>
                <p><b>Oui</b></p>
            </div>
            <div class="col-auto ms-sm-2 mx-1 card-block py-0 text-center radio">
                <div class="opt-icon"><i btn_id="aliment_non" class="fas fa-times-circle" style="font-size: 80px;"></i></div>
                <p><b>Non</b></p>
            </div>
        </div>
    </div>

      <div class="card-body p-5 step" style="display: none">
        <p><b>OBSERVER, ECOUTER, PALPER</b> - Regarder si le nourrisson convulse actuellement.</p>
        <div class="radio-group row justify-content-between px-3 text-center" style="justify-content:center !important">
            <div class="col-auto me-sm-2 mx-1 card-block py-0 text-center radio">
                <div class="opt-icon"><i btn_id="convulse_oui" class="fas fa-check-circle" style="font-size: 80px;"></i></div>
                <p><b>Oui, il convulse</b></p>
            </div>
            <div class="col-auto ms-sm-2 mx-1 card-block py-0 text-center radio">
                <div class="opt-icon"><i btn_id="convulse_non" class="fas fa-times-circle" style="font-size: 80px;"></i></div>
                <p><b>Non, il ne convulse pas</b></p>
            </div>
        </div>
      </div>

        <div class="card-body p-5 step" style="display: none">
        <p><b>OBSERVER, ECOUTER, PALPER</b> - Compter les mouvements respiratoires par minutes, recommencer si le nombre est supérieur ou égale à 60 mouvements respiratoires par minutes</p>
            <div class="radio-group row justify-content-between px-3 text-center" style="justify-content:center !important">
                <div class="col-auto me-sm-2 mx-1 card-block py-0 text-center radio">
                    <div class="opt-icon"><i btn_id="compte_oui" class="fas fa-check-circle" style="font-size: 80px;"></i></div>
                    <p><b>Oui, comptage fait</b></p>
                </div>
                <div class="col-auto ms-sm-2 mx-1 card-block py-0 text-center radio">
                    <div class="opt-icon"><i btn_id="compte_non" class="fas fa-times-circle" style="font-size: 80px;"></i></div>
                    <p><b>Non, comptage non fait</b></p>
                </div>
            </div>
        </div>

    <div class="card-body p-5 step" style="display: none">
    <p><b>OBSERVER, ECOUTER, PALPER</b> - Rechercher un tirage sous-costal marqué.</p>
        <div class="radio-group row justify-content-between px-3 text-center" style="justify-content:center !important">
            <div class="col-auto me-sm-2 mx-1 card-block py-0 text-center radio">
                <div class="opt-icon"><i btn_id="tirage_oui" class="fas fa-check-circle" style="font-size: 80px;"></i></div>
                <p><b>Oui, il y en a</b></p>
            </div>
            <div class="col-auto ms-sm-2 mx-1 card-block py-0 text-center radio">
                <div class="opt-icon"><i btn_id="tirage_non" class="fas fa-times-circle" style="font-size: 80px;"></i></div>
                <p><b>Non, il n'y en a pas</b></p>
            </div>
        </div>
    </div>

    <div class="card-body p-5 step" style="display: none">
    <p><b>OBSERVER, ECOUTER, PALPER</b> - Regarder et ecouter un geignement expiratoire.</p>
        <div class="radio-group row justify-content-between px-3 text-center" style="justify-content:center !important">
            <div class="col-auto me-sm-2 mx-1 card-block py-0 text-center radio">
                <div class="opt-icon"><i btn_id="geigne_oui" class="fas fa-check-circle" style="font-size: 80px;"></i></div>
                <p><b>Oui, il y a un geignement</b></p>
            </div>
            <div class="col-auto ms-sm-2 mx-1 card-block py-0 text-center radio">
                <div class="opt-icon"><i btn_id="geigne_non" class="fas fa-times-circle" style="font-size: 80px;"></i></div>
                <p><b>Non, respiration normale</b></p>
            </div>
        </div>
    </div>

    <div class="card-body p-5 step" style="display: none">
    <p><b>OBSERVER, ECOUTER, PALPER</b> - Observer les mouvements du nourrisson : bouge-t-il seulement s'il est stimulé ?</p>
        <div class="radio-group row justify-content-between px-3 text-center" style="justify-content:center !important">
            <div class="col-auto me-sm-2 mx-1 card-block py-0 text-center radio">
                <div class="opt-icon"><i btn_id="mouv1_oui" class="fas fa-check-circle" style="font-size: 80px;"></i></div>
                <p><b>Oui, il bouge seulement s'il est stimulé</b></p>
            </div>
            <div class="col-auto ms-sm-2 mx-1 card-block py-0 text-center radio">
                <div class="opt-icon"><i btn_id="mouv1_non" class="fas fa-times-circle" style="font-size: 80px;"></i></div>
                <p><b>Non, il bouge normalement</b></p>
            </div>
        </div>
    </div>

    <div class="card-body p-5 step" style="display: none">
    <p><b>OBSERVER, ECOUTER, PALPER</b> - Observer les mouvements du nourrisson : ne bouge-t-il pas même s'il est stimulé ?</p>
        <div class="radio-group row justify-content-between px-3 text-center" style="justify-content:center !important">
            <div class="col-auto me-sm-2 mx-1 card-block py-0 text-center radio">
                <div class="opt-icon"><i btn_id="mouv2_oui" class="fas fa-check-circle" style="font-size: 80px;"></i></div>
                <p><b>Oui, il ne bouge pas</b></p>
            </div>
            <div class="col-auto ms-sm-2 mx-1 card-block py-0 text-center radio">
                <div class="opt-icon"><i btn_id="mouv2_non" class="fas fa-times-circle" style="font-size: 80px;"></i></div>
                <p><b>Non, il bouge bien</b></p>
            </div>
        </div>
    </div>

    <div class="card-body p-5 step" style="display: none">
    <p><b>OBSERVER, ECOUTER, PALPER</b> - Prendre la température (a-t-il de la fièvre ou est-t-il hypothermique).</p>
        <div class="radio-group row justify-content-between px-3 text-center" style="justify-content:center !important">
            <div class="col-auto me-sm-2 mx-1 card-block py-0 text-center radio">
                <div class="opt-icon"><i btn_id="fievre_oui" class="fas fa-check-circle" style="font-size: 80px;"></i></div>
                <p><b>Oui, il a de la fièvre ou il est hypothermique</b></p>
            </div>
            <div class="col-auto ms-sm-2 mx-1 card-block py-0 text-center radio">
                <div class="opt-icon"><i btn_id="fievre_non" class="fas fa-times-circle" style="font-size: 80px;"></i></div>
                <p><b>Non, sa température est normale</b></p>
            </div>
        </div>
    </div>

    <div class="card-body p-5 step" style="display: none">
    <p><b>OBSERVER, ECOUTER, PALPER</b> - Rechercher des pustules cutanées.</p>
        <div class="radio-group row justify-content-between px-3 text-center" style="justify-content:center !important">
            <div class="col-auto me-sm-2 mx-1 card-block py-0 text-center radio">
                <div class="opt-icon"><i btn_id="pustule_oui" class="fas fa-check-circle" style="font-size: 80px;"></i></div>
                <p><b>Oui, il y en a</b></p>
            </div>
            <div class="col-auto ms-sm-2 mx-1 card-block py-0 text-center radio">
                <div class="opt-icon"><i btn_id="pustule_non" class="fas fa-times-circle" style="font-size: 80px;"></i></div>
                <p><b>Non, il n'y en a pas</b></p>
            </div>
        </div>
        <div class="container">
          <div class="row">
              <div class="col-md-6">
                  <div id="my_camera"></div>
                  <br/>
                  <input type=button value="Prendre photo" onClick="take_snapshot()">
                  <input type="hidden" name="image" class="image-tag">
              </div>
              <div class="col-md-6">
                  <div id="results">Affichage de la photo prise</div>
              </div>
              <div class="col-md-12 text-center">
                  <br/>
                  <button class="btn btn-success">Submit</button>
              </div>
          </div>
        </div>
    </div>

    <div class="card-body p-5 step" style="display: none">
    <p><b>OBSERVER, ECOUTER, PALPER</b> - Regarder l'ombilic, est-t-il rouge ou suintant de pus ?</p>
        <div class="radio-group row justify-content-between px-3 text-center" style="justify-content:center !important">
            <div class="col-auto me-sm-2 mx-1 card-block py-0 text-center radio">
                <div class="opt-icon"><i btn_id="ombilic_oui" class="fas fa-check-circle" style="font-size: 80px;"></i></div>
                <p><b>Oui, il est rouge ou suintant de pus</b></p>
            </div>
            <div class="col-auto ms-sm-2 mx-1 card-block py-0 text-center radio">
                <div class="opt-icon"><i btn_id="ombilic_non" class="fas fa-times-circle" style="font-size: 80px;"></i></div>
                <p><b>Non, il est normal</b></p>
            </div>
        </div>
    </div>

    <div class="card-body p-5 step" style="display: none">
    <p><b>OBSERVER, ECOUTER, PALPER</b> - Regarder si du pus s'ecoule des yeux.</p>
        <div class="radio-group row justify-content-between px-3 text-center" style="justify-content:center !important">
            <div class="col-auto me-sm-2 mx-1 card-block py-0 text-center radio">
                <div class="opt-icon"><i btn_id="pusyeux_oui" class="fas fa-check-circle" style="font-size: 80px;"></i></div>
                <p><b>Oui, il s'en écoule</b></p>
            </div>
            <div class="col-auto ms-sm-2 mx-1 card-block py-0 text-center radio">
                <div class="opt-icon"><i btn_id="pusyeux_non" class="fas fa-times-circle" style="font-size: 80px;"></i></div>
                <p><b>Non, il ne s'en ecoule pas</b></p>
            </div>
        </div>
    </div>

    <div id="endpage" class="card-body p-5 step" style="display: none">
    <p><b>OBSERVER, ECOUTER, PALPER</b> - Regarder si le nourrisson est léthargique ou inconscient.</p>
        <div class="radio-group row justify-content-between px-3 text-center" style="justify-content:center !important">
            <div class="col-auto me-sm-2 mx-1 card-block py-0 text-center radio">
                <div class="opt-icon"><i btn_id="letha_oui" class="fas fa-check-circle" style="font-size: 80px;"></i></div>
                <p><b>Oui, le nourrisson est léthargique ou inconscient</b></p>
            </div>
            <div class="col-auto ms-sm-2 mx-1 card-block py-0 text-center radio">
                <div class="opt-icon"><i btn_id="letha_non" class="fas fa-times-circle" style="font-size: 80px;"></i></div>
                <p><b>Non, le nourrisson est conscient</b></p>
            </div>
        </div>
    </div>

      <div class="card-footer">
        <button class="action back btn btn-sm btn-outline-warning" style="display: none">Précédent</button>
        <button class="action next btn btn-sm btn-outline-secondary float-end" disabled="">Suivant</button>
        <button onclick="classifier();" class="action submit btn btn-sm btn-outline-success float-end" style="display: none">Enregistrer et classer</button>
      </div>
    </div>

  </div>
</div>
</body>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        var data = <?php echo json_encode($result); ?>;
    </script>
    <script src="script/app.js"></script>
    <script>
        const x = document.getElementById("coordonnecas");

        function getLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition);
        } else {
            x.innerHTML = "La géolocalisation n'est pas supporté sur cette appareil.";
        }
        }

        function showPosition(position) {
        x.innerHTML = "<b>Latitude:</b> " + position.coords.latitude +
        " ,<b>Longitude:</b> " + position.coords.longitude;
        }
    </script> 

    <!-- Configure a few settings and attach camera -->
<script language="JavaScript">
    Webcam.set({
        width: 490,
        height: 390,
        image_format: 'jpeg',
        jpeg_quality: 90
    });
  
    Webcam.attach( '#my_camera' );
  
    function take_snapshot() {
        Webcam.snap( function(data_uri) {
            $(".image-tag").val(data_uri);
            document.getElementById('results').innerHTML = '<img src="'+data_uri+'"/>';
        } );
    }
</script>
</html>