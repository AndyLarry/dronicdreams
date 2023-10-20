var d = [];

$('#txt-search').keyup(function(){
    $('.next').prop('disabled', true);
    var searchField = $(this).val();
    if(searchField === '')  {
      $('#filter-records').html('');
      return;
    }
    var regex = new RegExp(searchField, "i");
    var output = '';
    $.each(data, function(key, val){
      var fullname = val.nom_enfant +' '+ val.prenom_enfant;
      if ((fullname.search(regex) != -1)) {
        output += '<li id_famille="' +val.id_famille +'" class="li-search">'+ val.nom_enfant +' '+ val.prenom_enfant +'</li>';
      }
    });
    $('#filter-records').html(output);
});

$(document).on("click", ".li-search", function () {
  $("#txt-search").val($(this).html());
  setFormFields($(this).attr("id_famille"));
  $("#filter-records").html("");
  $(".next").prop("disabled", false);
});


$(".card-block .opt-icon .fas").on("click", function () {
  //console.log($(event.target).attr("btn_id") + " ---- " + d.nom_pere);
  let tab = $(event.target).attr("btn_id").split("_");

  if(tab[0] in d)d[tab[0]] = tab[1];
  else d[tab[0]]=tab[1];
});

$(".radio-group .radio").on("click", function () {
  $(".selected .fa").removeClass("fa-check");
  $(".radio").removeClass("selected");
  $(this).addClass("selected");
  if ($("#suser").hasClass("selected") == true) {
    $(".next").prop("disabled", true);
    $(".searchfield").show();
  } else {
    setFormFields(false);
    $(".next").prop("disabled", false);
    $("#filter-records").html("");
    $(".searchfield").hide();
  }
});
var step = 1;
$(document).ready(function () { stepProgress(step); });

$(".next").on("click", function () {
  var nextstep = false;
  if (step == 2) {
    nextstep = checkForm("userinfo");
  } else {
    nextstep = true;
  }
  if (nextstep == true) {
    if (step < $(".step").length) {
      $(".step").show();
      $(".step")
        .not(":eq(" + step++ + ")")
        .hide();
      stepProgress(step);
    }
    hideButtons(step);
  }
});

// ON CLICK BACK BUTTON
$(".back").on("click", function () {
  if (step > 1) {
    step = step - 2;
    $(".next").trigger("click");
  }
  hideButtons(step);
});

// CALCULATE PROGRESS BAR
stepProgress = function (currstep) {
  var percent = parseFloat(100 / $(".step").length) * currstep;
  percent = percent.toFixed();
  $(".progress-bar")
    .css("width", percent + "%")
    .html(percent + "%");
};

// DISPLAY AND HIDE "NEXT", "BACK" AND "SUMBIT" BUTTONS
hideButtons = function (step) {
  var limit = parseInt($(".step").length);
  $(".action").hide();
  if (step < limit) {
    $(".next").show();
  }
  if (step > 1) {
    $(".back").show();
  }
  if (step == limit) {
    $(".next").hide();
    $(".submit").show();
  }
};

function setFormFields(id) {
  if (id != false) {
    // FILL STEP 2 FORM FIELDS
    d = data.find(x => x.id_famille == id);
    $('#nompere').val(d.nom_pere);
    $('#prenompere').val(d.prenom_pere);
    $('#nommere').val(d.nom_mere);
    $('#prenommere').val(d.prenom_mere);
    $('#nomenfant').val(d.nom_enfant);
    $('#prenomenfant').val(d.prenom_enfant);
    $('#ageenfant').val(d.age_enfant);
    //$('#localisationcas').val(d.localisationcas);
    //$('#coordonnecas').val(d.coordonnecas);
  } else {
    // EMPTY USER SEARCH INPUT
    $("#txt-search").val('');
    // EMPTY STEP 2 FORM FIELDS
    $('#nompere').val('');
    $('#prenompere').val('');
    $('#nommere').val('');
    $('#prenommere').val('');
    $('#nomenfant').val('');
    $('#prenomenfant').val('');
    $('#ageenfant').val('');
    $('#localisationcas').val('');
    $('#coordonnecas').val('');
  }
}

function checkForm(val) {
  // CHECK IF ALL "REQUIRED" FIELD ALL FILLED IN
  var valid = true;
  $("#" + val + " input:required").each(function () {
    if ($(this).val() === "") {
      $(this).addClass("is-invalid");
      valid = false;
    } else {
      $(this).removeClass("is-invalid");
    }
  });
  return valid;
}

 function removeAllChildNodes(parent) {
    while (parent.firstChild) {
        parent.removeChild(parent.firstChild);
    }
}

function classifier()
{
  var content = "";
  var grave = 0;
  var bacterie = 0;
  var couleur = "#FFFFFF";
  var classe = "INFECTION PEU PROBABLE";
  for (const [key, value] of Object.entries(d)) {
    if(!key.includes("_") && value == "non")
    {
      content += `
                    <tr style="background-color:#00ff11">
                      <td>`+key+`</td>
                      <td>`+value+`</td>
                    </tr>
      `;
    }
    else if(!key.includes("_") && value == "oui")
    {
      if(key == "ombilic" || key == "pustule" || key == "pusyeux")bacterie++;
      else grave++;

      content += `
                    <tr style="background-color:#f54242">
                      <td>`+key+`</td>
                      <td>`+value+`</td>
                    </tr>
      `;
    }
  }
  console.log("grave = "+grave+" - bacterie = "+bacterie);
  if(grave == 0 && bacterie > 0){
    couleur = "#fcfc00";
    classe = "INFECTION BACTERIENNE LOCALE";
  }
  else if(grave > 0){
    couleur = "#f54242";
    classe = "MALADIE GRAVE";
  }
  else if(grave == 0 && bacterie == 0){
    couleur = "#00ff11";
  }

  var contentBody = document.getElementById("endpage");
  removeAllChildNodes(contentBody);
  contentBody.insertAdjacentHTML(
              "afterbegin",
              `<center>
                  <h3>Resultat de l'evaluation</h1>
                  <table border="1" cellpadding="8" style="border-collapse: collapse">
                    <tr>
                      <th>Nom du nourrisson:</th>
                      <td colspan="3">`+d.nom_enfant+`</td>
                    </tr>
                    <tr>
                      <th>Prénom du nourrisson:</th>
                      <td colspan="3">`+d.prenom_enfant+`</td>
                    </tr>
                    <tr>
                    <tr>
                      <th>Age du nourrisson (en jours):</th>
                      <td colspan="3">`+d.age_enfant+`</td>
                    </tr>
                    <tr>
                      <th>Noms et prénoms du Père:</th>
                      <td colspan="3">`+d.nom_pere+" "+d.prenom_pere+`</td>
                    </tr>
                    <tr>
                      <th>Noms et prénoms de la Mère:</th>
                      <td colspan="3">`+d.nom_mere+" "+d.prenom_mere+`</td>
                    </tr>
                    <tr>
                      <th colspan="4">Resultats</th>
                    </tr>
                    <tr>
                      <td>Evaluations</td>
                      <td>Constatations</td>
                    </tr>
                    `+content+`
                    <tr style="background-color:`+couleur+`">
                      <td>Classification</td>
                      <td><b>`+classe+`</b></td>
                    </tr>
                  </table>
                </center>
    `
  );
}