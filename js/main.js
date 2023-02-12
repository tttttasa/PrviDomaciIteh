function prikazi() {
    var x = document.getElementById("id");
    if (x.style.display === "none") {
      x.style.display = "block";
    } else {
      x.style.display = "none";
    }
  } 


$('#btn-izbrisi').click( function(){
  const checked = $('input[type=radio]:checked');
  request = $.ajax({
    url:'crud/delete.php',
    type: 'post',
    data: {'id': checked.val()}
  });
  request.done(function (response, textStatus, jqXHR) {
    if (response === 'Success') {
      checked.closest("tr").remove();
        console.log('Termin je obrisan ');
        alert('Termin je obrisan');
        //$('#izmeniForm').reset;
    }
    else {
      console.log('Termin nije obrisan ' + response);
      alert('Termin nije obrisan');
    }
});
});

$('#btn-izmeni').click(function () {

  const checked = $('input[name=checked-donut]:checked');

  request = $.ajax({
      url: "crud/get.php",
      type: "post",
      data: {'id': checked.val()},
      dataType: "json",
  });

  request.done(function (response, textStatus, jqXHR) {
      console.log('Popunjena');
      $('#idtrener').val(response[0]["trener"]);
      console.log(response[0]["trener"]);

      $('#idlokacija').val(response[0]["lokacija"].trim());
      console.log(response[0]["lokacija"].trim());

      $('#iddatum').val(response[0]["datum"].trim());
      console.log(response[0]["datum"].trim());

      $('#idid').val(checked.val());
 
      console.log(response);
  });

  request.fail(function (jqXHR, textStatus, errorThrown) {
      console.error('The following error occurred: ' + textStatus, errorThrown);
  });

});

$('#izmeniForm').submit(function () {
  event.preventDefault();
  console.log("Izmena");
  const $form = $(this);
  const $inputs = $form.find("input, select, button");
  const serializedData = $form.serialize();
  console.log(serializedData);
  let obj = $form.serializeArray().reduce(function (json, { name, value }) {
    json[name] = value;
    return json;
  }, {}); 
  console.log(obj);
  $inputs.prop("disabled", true);

  request = $.ajax({
      url: "crud/update.php",
      type: "post",
      data: serializedData,
  });

  request.done(function (response, textStatus, jqXHR) {

      if (response === "Success") {
          console.log("Termin je izmenjen"); 
          $inputs.prop("disabled", false);
          updateRow(obj);     
              //location.reload(true);
          //$('#izmeniForm').reset;
      }
      else console.log("Termin nije izmenjen " + response);
      console.log(response);
  });

  request.fail(function (jqXHR, textStatus, errorThrown) {
      console.error("The following error occurred: " + textStatus, errorThrown);
  });


  
});

$('#btnDodaj').submit(function(){
  $('myModal').modal('toggle');
  return false;
});

$('#btn-izmeni').submit(function () {
 
  $('#myModal').modal('toggle');
  return false;
});

$("#dodajForm").submit(function () {
  event.preventDefault();

  const $form = $(this);
  const $inputs = $form.find("input, select, button");
  const serializedData = $form.serialize();
  console.log(serializedData);
  let obj = $form.serializeArray().reduce(function (json, { name, value }) {
    json[name] = value;
    return json;
  }, {});
  console.log(obj);
  $inputs.prop("disabled", true);

  request = $.ajax({
    url: "crud/add.php",
    type: "post",
    data: serializedData,
  });

  request.done(function (response, textStatus, jqXHR) {
    if (response === "Success") {
      $inputs.prop("disabled", false);
      
      alert("Termin je dodat");
      appandRow(obj);
    } else console.log("Termin nije dodat " + response);
    console.log(response);
  });

  request.fail(function (jqXHR, textStatus, errorThrown) {
    console.error("The following error occurred: " + textStatus, errorThrown);
  });
});

function appandRow(obj) {
  console.log(obj);

  $.get("crud/getLastElement.php", function (data) {
    console.log(data);
    console.log($("#tabela tbody tr:last").get());
    $("#tabela tbody").append(`
      <tr>
          <td>${data}</td>
          <td>${obj.trener}</td>
          <td>${obj.lokacija}</td>
          <td>${obj.datum}</td>
          <td>
              <label class="custom-radio-btn">
                  <input type="radio" name="checked-donut" value=${data}>
                  <span class="checkmark"></span>
              </label>
          </td>
      </tr>
    `);
  });
}
function updateRow(obj) {
  console.log(obj);
  console.log(obj.id);
  console.log($(`#tabela tbody #tr-${obj.id} td`).get());
  let tds = $(`#tabela tbody #tr-${obj.id} td`).get();
  tds[1].textContent = obj.trener;
  tds[2].textContent = obj.lokacija;
  tds[3].textContent = obj.datum;
}