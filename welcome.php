<?php

require "connection.php";
require "model/termin.php";
session_start();
if (!($_SESSION['user_id'])) {
    header("Location: index.php");
    die();
}

$result = Termin::getAll($conn);
if (!$result) {
    echo "Greska kod upita<br>";
    die();
}
if ($result->num_rows == 0) {
    echo "Nema pregleda";
    die();
} 
else {
?>

<!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="icon" href="css/imges/balance.png" />
        <link rel="stylesheet" href="css/home.css">
        <title>Balance club gym</title>
    </head>

    <body>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

        <div class="jumbotron text-center" style="background-color: #4a646e94;">
            <div class="container">
                <h1 style="color: #ffffff;">Balance club gym</h1>
            </div>
        </div>

        <div class="col-md-8" style="text-align:center; width:66.6%;float:right">
            <div id="pregled">
                <table id="tabela" class="table sortable table-bordered" style="color: #ffffff; background-color: #25353b57;">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Trener</th>
                            <th scope="col">Lokacija</th>
                            <th scope="col">Datum</th>
                            <th scope="col">Izaberi termin</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($red = $result->fetch_array()) {
                        ?>
                            <tr>
                                <td><?php echo $red["id"] ?></td>
                                <td><?php echo $red["trener"] ?></td>
                                <td><?php echo $red["lokacija"] ?></td>
                                <td><?php echo $red["datum"],'.' ?></td>
                                <td>
                                    <label class="radio-btn">
                                        <input type="radio" name="checked-donut" value=<?php echo $red["id"] ?>>
                                        <span class="checkmark"></span>
                                    </label>
                                </td>

                            </tr>
                    <?php
                        }  
                    }
                    ?>
                    </tbody>
                </table>
                <div>




                </div>
            </div>
        </div>

        <div class="col-md-4" style="display: block; background-color: #25353b57;">
            

            <div style="text-align:center;">
                <h3>Pretraga termina</h3>

                <input type="text" id="myInput" class="btn" placeholder="Pretrazite termin..." onkeyup="pretrazi()">

            </div>
            <div style="text-align:center; ">
                <h3>Dodaj novi termin</h3>
                <button id="btn-dodaj" class="btn" data-toggle="modal" data-target="#myModal"><img src="css/images/add.png" style="width: 25px;height: 25px;"></button>
            </div>
            <div style="text-align:center;">
                <h3>Izmeni termin</h3>
                <button id="btn-izmeni" class="btn" data-toggle="modal" data-target="#izmeniModal"><img src="css/images/edit.png" style="width: 25px;height: 25px;"></button>
            </div>
            <div style="text-align:center;">
                <h3>Izbrisi termin</h3>
                <button id="btn-izbrisi" class="btn"><img src="css/images/delete.png" style="width: 25px;height: 25px;"></button>
            </div>
            <div style="text-align:center;">
                <h3>Sortiraj po nazivu</h3>
                <button id="btn-izmeni" class="btn" onclick="sortTable()"><img src="css/images/sort.png" style="width: 25px;height: 25px;"></button>
            </div>
            <br>
        </div>

        <br>
        <a href="exit.php" class="label label-danger" style="font-size:16px; position: fixed; bottom:0; left:0; float:left">Logout</a>
        <div class="modal fade" id="myModal" role="dialog">
            <div class="modal-dialog">

                <!--Modalna forma za dodavanje-->
                <div class="modal-content" style="border: 4px solid #ffffff;">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="container pregled-form">
                            <form action="#" method="post" id="dodajForm">
                                <h3 id="naslov" style="color:  #ffffff" text-align="center">Dodavanje termina</h3>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input type="text" style="border: 1px solid #006699" name="trener" class="form-control" placeholder="Trener *" value="" />
                                        </div>
                                        <div class="form-group">
                                            <input type="text" style="border: 1px solid #006699" name="lokacija" class="form-control" placeholder="Lokacija  *" value="" />
                                        </div>
                                        <div class="form-group">
                                            <input type="date" style="border: 1px solid #006699" name="datum" class="form-control" placeholder="Datum *" value="" />
                                        </div>
                                        <div class="form-group">
                                            <button id="btnDodaj" type="submit" class="btn btn-success btn-block" style="background-color:  #7fadbfdb; border: 1px solid #25353b57;"><i class="glyphicon glyphicon-plus"></i> Dodaj termin
                                            </button>
                                        </div>

                                    </div>


                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" style="color: white; background-color:  #7fadbfdb; border: 1px solid white" data-dismiss="modal">Zatvori</button>
                    </div>
                </div>

            </div>
        </div>


        <div class="modal fade" id="izmeniModal" role="dialog">
            <div class="modal-dialog">

                <!-- Modalna forma za izmenu izabranog pregleda-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="container pregled-form">
                            <form action="#" method="post" id="izmeniForm">
                                <h3 style="color: white">Izmena termina</h3>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input id="idid" type="text" name="id" class="form-control" placeholder="Id termina *" value="" readonly />
                                        </div>
                                        <div class="form-group">
                                            <input id="idtrener" type="text" name="trener" class="form-control" placeholder="Trener *" value="" />
                                        </div>
                                        <div class="form-group">
                                            <input id="idlokacija" type="text" name="lokacija" class="form-control" placeholder="Lokacija *" value="" />
                                        </div>
                                        <div class="form-group">
                                            <input id="iddatum" type="date" name="datum" class="form-control" placeholder="Datum *" value="" />
                                        </div>
                                        <div class="form-group">
                                            <button id="btnIzmeni" type="submit" class="btn btn-success btn-block" style="color: white; background-color: #7fadbfdb; border: 1px solid white"><i class="glyphicon glyphicon-pencil"></i> Izmeni termin
                                            </button>
                                        </div>

                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal" style="color: white; background-color: #7fadbfdb; border: 1px solid white" >Zatvori</button>
                    </div>
                </div>

            </div>
        </div>

        <script src="https://www.kryogenix.org/code/browser/sorttable/sorttable.js"></script>
        <script src="js/main.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    
        <script>
        function pretrazi() {

            var input, filter, table, tr, i, td1, td2, td3, td4, txtValue1, txtValue2, txtValue3, txtValue4;
            input = document.getElementById("myInput");
            filter = input.value.toUpperCase();
            table = document.getElementById("tabela");
            tr = table.getElementsByTagName("tr");

            for (i = 0; i < tr.length; i++) {
                td1 = tr[i].getElementsByTagName("td")[1];
                td2 = tr[i].getElementsByTagName("td")[2];
                td3 = tr[i].getElementsByTagName("td")[3];
                td4 = tr[i].getElementsByTagName("td")[4];

                if (td1 || td2 || td3 || td4) {
                    txtValue1 = td1.textContent || td1.innerText;
                    txtValue2 = td2.textContent || td2.innerText;
                    txtValue3 = td3.textContent || td3.innerText;
                    txtValue4 = td4.textContent || td4.innerText;

                    if (txtValue1.toUpperCase().indexOf(filter) > -1 || txtValue2.toUpperCase().indexOf(filter) > -1 ||
                        txtValue3.toUpperCase().indexOf(filter) > -1 || txtValue4.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }

        function sortTable() {
            var table, rows, switching, i, x, y, shouldSwitch;
            table = document.getElementById("tabela");
            switching = true;
            while (switching) {
                switching = false;
                rows = table.rows;
                for (i = 1; i < (rows.length - 1); i++) {
                    shouldSwitch = false;
                    x = rows[i].getElementsByTagName("TD")[1];
                    y = rows[i + 1].getElementsByTagName("TD")[1];
                    if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                        shouldSwitch = true;
                        break;
                    }
                }
                if (shouldSwitch) {
                    rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                    switching = true;
                }
            }
        }
    </script>
    </body>

    </html>