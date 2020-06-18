<title>Admission</title>
<?php include_once 'head.php'; ?>

<!--Nav Tabs-->
<ul class="nav nav-tabs justify-content-center" role="tablist">
    <li class="nav-item">
        <a class="nav-link active" data-toggle="tab" href="#addAdmission">Add Admission</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#updateAdmission">Update Admission</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#deleteAdmission">Delete Admission</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#produceInvoice">Produce Invoice</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#closeAdmission">Close Admission</a>
    </li>
</ul>

<!-- Tab panes -->
<div class="tab-content">
    <div id="addAdmission" class="container tab-pane active"><br>
        <script>
            $(document).ready(function () {
                $.ajax({
                    type: 'GET',
                    url: "http://unitecproject.herokuapp.com/api/apiAllPatients.php",
                    dataType: "JSON",
                    success: function (data) {
                        let i = 0;
                        while (i < data.length){
                            $("#getPatient").append("<option value='" + data[i].id + "'>" + data[i].id + " " + data[i].firstname + " " + data[i].lastname + "</option>");
                            i = i + 1;
                        }
                    },
                    error: function () {
                        alert("Not connected");
                    }
                });
                $.ajax({
                    type: 'GET',
                    url: "http://unitecproject.herokuapp.com/api/apiAllWards.php",
                    dataType: "JSON",
                    success: function (data) {
                        let i = 0;
                        while (i < data.length){
                            $("#getWard").append("<option value='" + data[i].id + "'>" + data[i].id + " " + data[i].name + "</option>");
                            i = i + 1;
                        }
                    },
                    error: function () {
                        alert("Not connected");
                    }
                });
            });
        </script>
        <form action="../api/apiAddAdmission.php" method="post">
            <h1>Add Admission</h1>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">Description:* </span>
                </div>
                <input type="text" maxlength="30" class="form-control" id="description" name="description" placeholder="Description*" title="Description" required>
            </div>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">Admission Date:* </span>
                </div>
                <input type="date" maxlength="10" class="form-control" id="admissiondate" name="admissiondate" placeholder="Admission Date" title="Admission Date" required>
            </div>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">Patient:* </span>
                </div>
                <select class="form-control" id="getPatient" name="patientID" required>
                    <option disabled selected hidden>Select a Patient</option>
                </select>
                <div class="input-group-prepend">
                    <span class="input-group-text">Ward:* </span>
                </div>
                <select class="form-control" id="getWard" name="wardID" required>
                    <option disabled selected hidden>Select a Ward</option>
                </select>
            </div>
            <i class="grey">* Required Fields</i>
            <div class="d-flex justify-content-around">
                <input class="btn btn-outline-primary" type="submit" value="Add Admission"/>
                <a href="../api/apiLogin.php"><input class="btn btn-outline-primary" type="button" value="Return"></a>
            </div>
        </form>
    </div>

    <div id="updateAdmission" class="container tab-pane fade"><br>
        <script>
            $(document).ready(function () {
                $.ajax({
                    type: 'GET',
                    url: "http://unitecproject.herokuapp.com/api/apiAllPatients.php",
                    dataType: "JSON",
                    success: function (data) {
                        $("#getUpdateAdmissions").change(function() {
                            var i = 0;
                            while (i < data.length) {
                                if (data[i].id == $("#getUpdateAdmissions").val()) {
                                    $("#updatePatientLastname").val(data[i].lastname);
                                    $("#updatePatientFirstname").val(data[i].firstname);
                                }
                                i++;
                            }
                        });
                    },
                    error: function () {
                        alert("Not connected");
                    }
                });
                $.ajax({
                    type: 'GET',
                    url: "http://unitecproject.herokuapp.com/api/apiAllWards.php",
                    dataType: "JSON",
                    success: function (data) {
                        let i = 0;
                        while (i < data.length){
                            $("#getUpdateWard").append("<option value='" + data[i].id + "'>" + data[i].id + " " + data[i].name + "</option>");
                            i = i + 1;
                        }
                    },
                    error: function () {
                        alert("Not connected");
                    }
                });
                $.ajax({
                    type: 'GET',
                    url: "http://unitecproject.herokuapp.com/api/apiAllAdmissions.php",
                    dataType: "JSON",
                    success: function (data) {
                        let i = 0;
                        while (i < data.length){
                            $("#getUpdateAdmissions").append("<option value='" + data[i].id + "'>" + data[i].id + " " + data[i].description + "</option>");
                            i = i + 1;
                        }
                        $("#getUpdateAdmissions").change(function() {
                            var i = 0;
                            while (i < data.length) {
                                if (data[i].id == $("#getUpdateAdmissions").val()) {
                                    $("#updateAdmissionId").val(data[i].id);
                                    $("#updateDescription").val(data[i].description);
                                    $("#updateAdmissiondate").val(data[i].admissiondate);
                                    $("#updateAdmissiondate").val(data[i].admissiondate);
                                }
                                i++;
                            }
                        });
                    },
                    error: function () {
                        alert("Not connected");
                    }
                });
            });
        </script>
        <form action="../api/apiUpdateAdmission.php" method="post">
            <h1>Update Admission</h1>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">Admissions:* </span>
                </div>
                <select class="form-control" id="getUpdateAdmissions" name="id" required>
                    <option disabled selected hidden>Select an Admission</option>
                </select>
            </div>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">Admission Id: </span>
                </div>
                <input type="text" maxlength="30" class="form-control" id="updateAdmissionId" name="updateAdmissionId" title="Admission Id" readonly>
                <div class="input-group-prepend">
                    <span class="input-group-text">Description:* </span>
                </div>
                <input type="text" maxlength="30" class="form-control" id="updateDescription" name="updateDescription" placeholder="Description*" title="Description" required>
            </div>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">Admission Date:* </span>
                </div>
                <input type="date" maxlength="10" class="form-control" id="updateAdmissiondate" name="updateAdmissiondate" placeholder="Admission Date" title="Admission Date" required>
                <div class="input-group-prepend">
                    <span class="input-group-text">Status:* </span>
                </div>
                <select class="form-control" id="updateStatus" name="updateStatus" required>
                    <option disabled selected hidden>Select a Status</option>
                    <option value="current">Current</option>
                    <option value="complete">Complete</option>
                    <option value="billed" hidden>Billed</option>
                    <option value="closed" hidden>Closed</option>
                </select>
            </div>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">Patient Last Name: </span>
                </div>
                <input type="text" class="form-control" id="updatePatientLastname" name="updatePatientLastname" readonly>
                <div class="input-group-prepend">
                    <span class="input-group-text">Patient First Name: </span>
                </div>
                <input type="text" class="form-control" id="updatePatientFirstname" name="updatePatientFirstname" readonly>
            </div>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">Ward Name: </span>
                </div>
                <input type="text" class="form-control" id="updateWardName" name="updateWardName" readonly>
            </div>
            <i class="grey">* Required Fields</i>
            <div class="d-flex justify-content-around">
                <input class="btn btn-outline-primary" type="submit" value="Update Admission"/>
                <a href="../api/apiLogin.php"><input class="btn btn-outline-primary" type="button" value="Return"></a>
            </div>
        </form>
    </div>

    <div id="deleteAdmission" class="container tab-pane fade"><br>
        <script>
            $(document).ready(function () {
                $.ajax({
                    type: 'GET',
                    url: "http://unitecproject.herokuapp.com/api/apiAllPatients.php",
                    dataType: "JSON",
                    success: function (data) {
                        $("#getDeleteAdmissions").change(function() {
                            var i = 0;
                            while (i < data.length) {
                                if (data[i].id == $("#getDeleteAdmissions").val()) {
                                    $("#deletePatientLastname").val(data[i].lastname);
                                    $("#deletePatientFirstname").val(data[i].firstname);
                                }
                                i++;
                            }
                        });
                    },
                    error: function () {
                        alert("Not connected");
                    }
                });
                $.ajax({
                    type: 'GET',
                    url: "http://unitecproject.herokuapp.com/api/apiAllWards.php",
                    dataType: "JSON",
                    success: function (data) {
                        let i = 0;
                        while (i < data.length){
                            $("#getDeleteWard").append("<option value='" + data[i].id + "'>" + data[i].id + " " + data[i].name + "</option>");
                            i = i + 1;
                        }
                    },
                    error: function () {
                        alert("Not connected");
                    }
                });
                $.ajax({
                    type: 'GET',
                    url: "http://unitecproject.herokuapp.com/api/apiAllAdmissions.php",
                    dataType: "JSON",
                    success: function (data) {
                        let i = 0;
                        while (i < data.length){
                            $("#getDeleteAdmissions").append("<option value='" + data[i].id + "'>" + data[i].id + " " + data[i].description + "</option>");
                            i = i + 1;
                        }
                        $("#getDeleteAdmissions").change(function() {
                            var i = 0;
                            while (i < data.length) {
                                if (data[i].id == $("#getDeleteAdmissions").val()) {
                                    $("#deleteAdmissionId").val(data[i].id);
                                    $("#deleteDescription").val(data[i].description);
                                    $("#deleteAdmissiondate").val(data[i].admissiondate);
                                }
                                i++;
                            }
                        });
                    },
                    error: function () {
                        alert("Not connected");
                    }
                });
            });
        </script>
        <form action="../api/apiDeleteAdmission.php" method="get">
            <h1>Update Admission</h1>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">Admissions:* </span>
                </div>
                <select class="form-control" id="getDeleteAdmissions" name="id" required>
                    <option disabled selected hidden>Select an Admission</option>
                </select>
            </div>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">Admission Id: </span>
                </div>
                <input type="text" class="form-control" id="deleteAdmissionId" name="deleteAdmissionId" placeholder="Admission Id" readonly>
                <div class="input-group-prepend">
                    <span class="input-group-text">Description: </span>
                </div>
                <input type="text" class="form-control" id="deleteDescription" name="deleteDescription" placeholder="Description*" readonly>
            </div>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">Admission Date: </span>
                </div>
                <input type="text" class="form-control" id="deleteAdmissiondate" name="deleteAdmissiondate" placeholder="Admission Date" readonly>
                <div class="input-group-prepend">
                    <span class="input-group-text">Status: </span>
                </div>
                <input type="text" class="form-control" id="deleteStatus" name="deleteStatus" placeholder="Status" readonly>
            </div>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">Patient Last Name: </span>
                </div>
                <input type="text" class="form-control" id="deletePatientLastname" name="deletePatientLastname" readonly>
                <div class="input-group-prepend">
                    <span class="input-group-text">Patient First Name: </span>
                </div>
                <input type="text" class="form-control" id="deletePatientFirstname" name="deletePatientFirstname" readonly>
            </div>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">Ward Name: </span>
                </div>
                <input type="text" class="form-control" id="deleteWardName" name="deleteWardName" readonly>
            </div>
            <i class="grey">* Required Fields</i>
            <div class="d-flex justify-content-around">
                <input class="btn btn-outline-primary" type="submit" value="Delete Admission"/>
                <a href="../api/apiLogin.php"><input class="btn btn-outline-primary" type="button" value="Return"></a>
            </div>
        </form>
    </div>

    <div id="produceInvoice" class="container tab-pane fade"><br>
        <script>
            $(document).ready(function () {
                $.ajax({
                    type: 'GET',
                    url: "http://unitecproject.herokuapp.com/api/apiShowInvoice.php",
                    dataType: "JSON",
                    success: function (data) {
                        i = 0;
                        while (i < data.length) {
                            $("#admission").append("<option value='" + data[i].AdmissionID + "'>" + data[i].AdmissionID + " " + data[i].description + "</option>");
                            i++;
                        }

                        $("#admission").change(function() {
                            i = 0;
                            while (i < data.length) {
                                if (data[i].AdmissionID == $("#admission").val()) {
                                    $("#invoice").html("<table>");
                                    $("#invoice").append("<tr><td>Patient ID:</td><td>" + data[i].patient.id + "</td>" +
                                        "<td>Patient Name:</td><td>" + data[i].patient.name + "</td></tr>");
                                    $("#invoice").append("<tr><td>Patient Address:</td><td>" + data[i].patient.address + "</td></tr>");
                                    $("#invoice").append("<tr style='height: 20px'></tr>");

                                    m = 0;
                                    subtotal = 0;
                                    while (m < data[i].medication.length) {
                                        $("#invoice").append("<tr><td>Medication Name:</td><td>" + data[i].medication[m].name + "</td>" +
                                            "<td>Medication Cost:</td><td>$" + data[i].medication[m].cost + "</td>" +
                                            "<td>Prescribed Quantity:</td><td>" + data[i].medication[m].amount + "</td></tr>");
                                        subtotal += (data[i].medication[m].cost) * (data[i].medication[m].amount);
                                        m++;
                                    }
                                    $("#invoice").append("<tr style='height: 20px'></tr>");

                                    d = 0;
                                    fee = 0;
                                    while (d < data[i].doctor.length) {
                                        $("#invoice").append("<tr><td>Doctor Name:</td><td>" + data[i].doctor[d].name + "</td>" +
                                            "<td>Fee:</td><td>$" + data[i].doctor[d].fee + "</td></tr>");
                                        fee += parseInt(data[i].doctor[d].fee);
                                        d++;
                                    }
                                    $("#invoice").append("<tr style='height: 20px'></tr>");

                                    due = subtotal + fee;
                                    $("#invoice").append("<tr><td>Total Due:</td><td>$" + due + "</td></tr>");
                                    $("#invoice").append("<tr style='height: 30px'></tr>");
                                    $("#invoice").append("</table>");
                                }
                                i++;
                            }
                        });
                    },
                    error: function () {
                        alert("Not connected");
                    }
                });
            });
        </script>
        <form action="../api/apiBilledInvoice.php" method="post">
            <h1>Produce Invoice</h1>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">Complete Admissions: </span>
                </div>
                <select class="form-control" id="admission" name="id" required>
                    <option disabled selected hidden>Select an Admission</option>
                </select>
            </div>

            <div id="invoice">
            </div>

            <div class="d-flex justify-content-around">
                <input class="btn btn-outline-primary" type="submit" value="Produce Invoice"/>
                <a href="../api/apiLogin.php"><input class="btn btn-outline-primary" type="button" value="Return"></a>
            </div>
        </form>
    </div>

    <div id="closeAdmission" class="container tab-pane fade"><br>
        <script>
            $(document).ready(function () {
                $.ajax({
                    type: 'GET',
                    url: "http://unitecproject.herokuapp.com/api/apiAllAdmissions.php",
                    dataType: "JSON",
                    success: function (data) {
                        let i = 0;
                        while (i < data.length){
                            $("#getCloseAdmissions").append("<option value='" + data[i].id + "'>" + data[i].id + " " + data[i].description + "</option>");
                            i = i + 1;
                        }
                        $("#getCloseAdmissions").change(function() {
                            var i = 0;
                            while (i < data.length) {
                                if (data[i].id == $("#getCloseAdmissions").val()) {
                                    $("#closeAdmissionId").val(data[i].id);
                                    $("#closeDescription").val(data[i].description);
                                    $("#closeAdmissiondate").val(data[i].admissiondate);
                                }
                                i++;
                            }
                        });
                    },
                    error: function () {
                        alert("Not connected");
                    }
                });
            });
        </script>
        <form action="../api/apiCloseAdmission.php" method="post">
            <h1>Close Admission</h1>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">Billed Admissions (That Have Payments):* </span>
                </div>
                <select class="form-control" id="getCloseAdmissions" name="id" required>
                    <option disabled selected hidden>Select an Admission</option>
                </select>
            </div>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">Admission Id: </span>
                </div>
                <input type="text" class="form-control" id="closeAdmissionId" name="closeAdmissionId" placeholder="Admission Id" readonly>
                <div class="input-group-prepend">
                    <span class="input-group-text">Admission Date: </span>
                </div>
                <input type="date" class="form-control" id="closeAdmissiondate" name="admissiondate" placeholder="Admission Date" readonly>
            </div>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">Description: </span>
                </div>
                <input type="text" class="form-control" id="closeDescription" name="closeDescription" placeholder="Description" readonly>
            </div>
            <i class="grey">* Required Fields</i>
            <div class="d-flex justify-content-around">
                <input class="btn btn-outline-primary" type="submit" value="Close Admission"/>
                <a href="../api/apiLogin.php"><input class="btn btn-outline-primary" type="button" value="Return"></a>
            </div>
        </form>
    </div>
</div>
<?php include_once 'foot.php';?>