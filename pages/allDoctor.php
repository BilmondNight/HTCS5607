<title>Doctor</title>
<?php include_once 'head.php'; ?>
<?php include_once 'head-child.php'; ?>
<!--Nav Tabs-->
<ul class="nav nav-tabs justify-content-center" role="tablist">
    <li class="nav-item">
        <a class="nav-link active" data-toggle="tab" href="#addDoctor">Add Doctor</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#updateDoctor">Update Doctor</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#deleteDoctor">Delete Doctor</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#doctorsReport">Doctors Report</a>
    </li>
</ul>

<!-- Tab panes -->
<div class="tab-content">
    <div id="addDoctor" class="container tab-pane active"><br>
        <form action="../api/apiAddDoctor.php" method="post">
            <h1>Add Doctor</h1>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">Last Name:* </span>
                </div>
                <input type="text" maxlength="25" class="form-control" id="lastname" name="lastname" placeholder="Last Name" required>
                <div class="input-group-prepend">
                    <span class="input-group-text">First Name:* </span>
                </div>
                <input type="text" maxlength="25" class="form-control" id="firstname" name="firstname" placeholder="First Name" required>
            </div>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">Street Address:* </span>
                </div>
                <input type="text" maxlength="50" class="form-control" id="street" name="street" placeholder="Street Address" required>
            </div>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">Suburb:* </span>
                </div>
                <input type="text" maxlength="20" class="form-control" id="suburb" name="suburb" placeholder="Suburb*" required>
                <div class="input-group-prepend">
                    <span class="input-group-text">City: </span>
                </div>
                <input type="text" maxlength="20" class="form-control" id="city" name="city" placeholder="City">
            </div>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">Phone Number: </span>
                </div>
                <input type="text" maxlength="15" class="form-control" id="phone" name="phone" placeholder="Phone Number">
                <div class="input-group-prepend">
                    <span class="input-group-text">Speciality:* </span>
                </div>
                <input type="text" maxlength="20" class="form-control" id="speciality" name="speciality" placeholder="Speciality*" required>
                <div class="input-group-prepend">
                    <span class="input-group-text">Salary($):* </span>
                </div>
                <input type="number" step=".01" min="20000" max="200000" maxlength="9" class ="form-control" id="salary" name="salary" required>
            </div>
            <i class="grey">* Required Fields</i>
            <div class="d-flex justify-content-around">
                <input class="btn btn-outline-primary" id="addDoctor" type="submit" value="Add Doctor">
                <input class="btn btn-outline-primary" onclick="goBack()" value="Return">
            </div>
        </form>
    </div>

    <div id="updateDoctor" class="container tab-pane fade"><br>
        <script>
            $.ajax({
                type: 'GET',
                url: "../api/apiAllDoctors.php",
                dataType: "JSON",
                success: function (data) {
                    var i = 0;
                    while (i < data.length){
                        $("#getUpdateDoctors").append("<option value='" + data[i].id + "'>" + data[i].id + " " + data[i].firstname + " " + data[i].lastname + "</option>");
                        i++;
                    }
                    $("#getUpdateDoctors").change(function() {
                        i = 0;
                        while (i < data.length) {
                            if (data[i].id == $("#getUpdateDoctors").val()) {
                                $("#updateDoctorId").val(data[i].id);
                                $("#updateLastname").val(data[i].lastname);
                                $("#updateFirstname").val(data[i].firstname);
                                $("#updateStreet").val(data[i].street);
                                $("#updateSuburb").val(data[i].suburb);
                                $("#updateCity").val(data[i].city);
                                $("#updatePhone").val(data[i].phone);
                                $("#updateSpeciality").val(data[i].speciality);
                                $("#updateSalary").val(data[i].salary);
                            }
                            i++;
                        }
                    });
                },
                error: function () {
                    alert("Not connected");
                }
            });
        </script>
        <form action="../api/apiUpdateDoctor.php" method="post">
            <h1>Update Doctor</h1>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">Doctors:* </span>
                </div>
                <select class="form-control" id="getUpdateDoctors" name="id" required>
                    <option disabled value="" selected hidden>Select a Doctor</option>
                </select>
            </div>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">Doctor Id: </span>
                </div>
                <input type="text" class="form-control" id="updateDoctorId" name="id" readonly>
                <div class="input-group-prepend">
                    <span class="input-group-text">Last Name:* </span>
                </div>
                <input type="text" maxlength="25" class="form-control" id="updateLastname" name="lastname" placeholder="Last Name" required>
                <div class="input-group-prepend">
                    <span class="input-group-text">First Name:* </span>
                </div>
                <input type="text" maxlength="25" class="form-control" id="updateFirstname" name="firstname" placeholder="First Name" required>
            </div>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">Street Address:* </span>
                </div>
                <input type="text" maxlength="50" class="form-control" id="updateStreet" name="street" placeholder="Street Address" required>
            </div>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">Suburb:* </span>
                </div>
                <input type="text" maxlength="20" class="form-control" id="updateSuburb" name="suburb" placeholder="Suburb" required>
                <div class="input-group-prepend">
                    <span class="input-group-text">City: </span>
                </div>
                <input type="text" maxlength="20" class="form-control" id="updateCity" name="city" placeholder="City">
            </div>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">Phone Number: </span>
                </div>
                <input type="text" maxlength="15" class="form-control" id="updatePhone" name="phone" placeholder="Phone Number">
                <div class="input-group-prepend">
                    <span class="input-group-text">Speciality:* </span>
                </div>
                <input type="text" maxlength="20" class="form-control" id="updateSpeciality" name="speciality" placeholder="Speciality" required>
                <div class="input-group-prepend">
                    <span class="input-group-text">Salary($):* </span>
                </div>
                <input type="number" step=".01" min="20000" max="200000" maxlength="9" class ="form-control" id="updateSalary" name="salary" required>
            </div>
            <i class="grey">* Required Fields</i>
            <div class="d-flex justify-content-around">
                <input class="btn btn-outline-primary" type="submit" value="Update Doctor">
                <input class="btn btn-outline-primary" onclick="goBack()" value="Return">
            </div>
        </form>
    </div>

    <div id="deleteDoctor" class="container tab-pane fade"><br>
        <script>
            $.ajax({
                type: 'GET',
                url: "../api/apiDoctorsNoAllocation.php",
                dataType: "JSON",
                success: function (data) {
                    var i = 0;
                    while (i < data.length){
                        $("#getDeleteDoctors").append("<option value='" + data[i].id + "'>" + data[i].id + " " + data[i].firstname + " " + data[i].lastname + "</option>");
                        i = i + 1;
                    }
                    $("#getDeleteDoctors").change(function() {
                        i = 0;
                        while (i < data.length) {
                            if (data[i].id == $("#getDeleteDoctors").val()) {
                                $("#deleteDoctorId").val(data[i].id);
                                $("#deleteLastname").val(data[i].lastname);
                                $("#deleteFirstname").val(data[i].firstname);
                                $("#deleteStreet").val(data[i].street);
                                $("#deleteSuburb").val(data[i].suburb);
                                $("#deleteCity").val(data[i].city);
                                $("#deletePhone").val(data[i].phone);
                                $("#deleteSpeciality").val(data[i].speciality);
                                $("#deleteSalary").val(data[i].salary);
                            }
                            i++;
                        }
                    });
                },
                error: function () {
                    alert("Not connected");
                }
            });
        </script>
        <form action="../api/apiDeleteDoctor.php" method="post">
            <h1>Delete Doctor</h1>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">Doctors:* </span>
                </div>
                <select class="form-control" id="getDeleteDoctors" name="id" required>
                    <option disabled value="" selected hidden>Select a Doctor</option>
                </select>
            </div>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">Doctor Id: </span>
                </div>
                <input type="text" class="form-control" id="deleteDoctorId" name="id" readonly>
                <div class="input-group-prepend">
                    <span class="input-group-text">Last Name: </span>
                </div>
                <input type="text" class="form-control" id="deleteLastname" name="lastname" readonly>
                <div class="input-group-prepend">
                    <span class="input-group-text">First Name: </span>
                </div>
                <input type="text" class="form-control" id="deleteFirstname" name="firstname" readonly>
            </div>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">Street Address: </span>
                </div>
                <input type="text" class="form-control" id="deleteStreet" name="street" readonly>
            </div>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">Suburb: </span>
                </div>
                <input type="text" class="form-control" id="deleteSuburb" name="suburb" readonly>
                <div class="input-group-prepend">
                    <span class="input-group-text">City: </span>
                </div>
                <input type="text" class="form-control" id="deleteCity" name="city" readonly>
            </div>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">Phone Number: </span>
                </div>
                <input type="text" class="form-control" id="deletePhone" name="phone" readonly>
                <div class="input-group-prepend">
                    <span class="input-group-text">Speciality: </span>
                </div>
                <input type="text" class="form-control" id="deleteSpeciality" name="speciality" readonly>
                <div class="input-group-prepend">
                    <span class="input-group-text">Salary($): </span>
                </div>
                <input type="text" class="form-control" id="deleteSalary" name="salary" readonly>
            </div>
            <i class="grey">* Required Fields</i>
            <div class="d-flex justify-content-around">
                <input class="btn btn-outline-primary" type="submit" value="Delete Doctor">
                <input class="btn btn-outline-primary" onclick="goBack()" value="Return">
            </div>
        </form>
    </div>

    <div id="doctorsReport" class="container tab-pane fade" style="width: 50rem"><br>
        <h1>Doctors Report</h1>
        <script>
            $(document).ready(function () {
                $.ajax({
                    type: 'GET',
                    url: "../api/apiDoctorsReport.php",
                    dataType: "JSON",
                    success: function (data) {
                        var i = 0;
                        while (i < data.length){
                            $("#report").append("<hr>");
                            $("#report").append("<table class='table table-borderless' style='table-layout: fixed; width: 125%'><tr><td><b>Doctor ID:</b> "+data[i].DoctorID+" </td><td><b>Doctor Name:</b> "+data[i].firstname+" "+data[i].lastname+" </td><td></td></tr> " +
                                "<tr><td colspan='3'><b>Address:</b> "+data[i].street+", "+data[i].suburb+", "+data[i].city+"</td></tr>" +
                                "<tr><td><b>Phone Number:</b> "+data[i].phone+" </td><td><b>Speciality:</b> "+data[i].speciality+" </td><td><b>Salary($):</b> "+data[i].salary+" </td></tr>" +
                                "<tr><td><b>Admissions:</b> "+data[i].admission+" </td><td><b>Research Projects:</b> "+data[i].project+"</td><td></td></tr></table>");
                            $("#report").append("<hr>");
                            i++;
                        }
                    },
                    error: function () {
                        alert("Not connected");
                    }
                });
            });
        </script>
        <div id="report">
        </div>
        <input class="btn btn-outline-primary" onclick="goBack()" value="Return">
        <br><br><br>
    </div>

</div>
<?php include_once 'foot.php';?>