<title>Doctor</title>
<?php include_once 'head.php'; ?>

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
</ul>

<!-- Tab panes -->
<div class="tab-content">
    <div id="addDoctor" class="container tab-pane active"><br>
        <form action="../api/apiAddDoctor.php" method="post">
            <h2>Add Doctor</h2>
            <table>
                <tr>
                    <td><label>Last Name:<b class="red">*</b> </label></td>
                    <td><input type="text" id="lastname" name="lastname" size="25" required></td>
                </tr>

                <tr>
                    <td><label>First Name:<b class="red">*</b> </label></td>
                    <td><input type="text" id="firstname" name="firstname" size="25" required></td>
                </tr>

                <tr>
                    <td><label>Street Address:<b class="red">*</b> </label></td>
                    <td><input type="text" id="street" name="street" size="50" required></td>
                </tr>

                <tr>
                    <td><label>Suburb:<b class="red">*</b> </label></td>
                    <td><input type="text" id="suburb" name="suburb" size="20" required></td>
                </tr>

                <tr>
                    <td><label>City:<b class="red">*</b> </label></td>
                    <td><input type="text" id="city" name="city" size="20" required></td>
                </tr>

                <tr>
                    <td><label>Phone Number:<b class="red">*</b> </label></td>
                    <td><input type="text" id="phone" name="phone" size="15" required></td>
                </tr>

                <tr>
                    <td><label>Speciality:<b class="red">*</b> </label></td>
                    <td><input type="text" id="speciality" name="speciality" size="15" required></td>
                </tr>

                <tr>
                    <td><label>Salary:<b class="red">*</b> </label></td>
                    <td><input type="text" id="salary" name="salary" size="15" required></td>
<!--                    <td><input type="range" class="custom-range" name="salary" id="salary" size="10" required></td>-->
                </tr>

                <tr><td><i class="red">* Required Fields</i></td></tr>
                <tr>
                    <td><input class="btn btn-outline-primary" type="submit" value="Add Doctor"/></td>
                    <td><a href="../api/apiLogin.php"><input class="btn btn-outline-primary" type="button" value="Return"></a></td>
                </tr>
            </table>
        </form>
    </div>
    <script>
        $.ajax({
            type: 'GET',
            url: "../api/apiAllDoctors.php",
            dataType: "JSON",
            success: function (data) {
                let i = 0;
                while (i < data.length){
                    $("#getDoctors").append("<option value='" + data[i].id + "'>" + data[i].id + " " + data[i].firstname + " " + data[i].lastname + "</option>");
                    i = i + 1;
                }

                $("#getDoctors").change(function() {
                    alert($("#getDoctors").val());
                });
            },
            error: function () {
                alert("Not connected");
            }
        });


    </script>
    <div id="updateDoctor" class="container tab-pane fade"><br>
        <form action="../api/apiUpdateDoctor.php" method="post">
            <h2>Update Doctor</h2>
            <table>
                <tr>
                    <td><label>Doctors:<b class="red">*</b> </label></td>
                    <td><select id="getDoctors" name="id"></select></td>
                </tr>
                <tr>
                    <td><label>Last Name:<b class="red">*</b> </label></td>
                    <td><input type="text" id="updateLastname" name="lastname" size="25" required></td>
                </tr>

                <tr>
                    <td><label>First Name:<b class="red">*</b> </label></td>
                    <td><input type="text" id="updateFirstname" name="firstname" size="25" required></td>
                </tr>

                <tr>
                    <td><label>Street Address:<b class="red">*</b> </label></td>
                    <td><input type="text" id="updateStreet" name="street" size="50" required></td>
                </tr>

                <tr>
                    <td><label>Suburb:<b class="red">*</b> </label></td>
                    <td><input type="text" id="updateSuburb" name="suburb" size="20" required></td>
                </tr>

                <tr>
                    <td><label>City:<b class="red">*</b> </label></td>
                    <td><input type="text" id="updateCity" name="city" size="20" required></td>
                </tr>

                <tr>
                    <td><label>Phone Number:<b class="red">*</b> </label></td>
                    <td><input type="text" id="updatePhone" name="phone" size="15" required></td>
                </tr>

                <tr>
                    <td><label>Speciality:<b class="red">*</b> </label></td>
                    <td><input type="text" id="updateSpeciality" name="speciality" size="15" required></td>
                </tr>

                <tr>
                    <td><label>Salary:<b class="red">*</b> </label></td>
                    <td><input type="text" id="updateSalary" name="salary" size="15" required></td>
                    <!--                    <td><input type="range" class="custom-range" name="salary" id="salary" size="10" required></td>-->
                </tr>

                <tr><td><i class="red">* Required Fields</i></td></tr>
                <tr>
                    <td><input class="btn btn-outline-primary" type="submit" value="Update Doctor"/ ></td>
                    <td><a href="../api/apiLogin.php"><input class="btn btn-outline-primary" type="button" value="Return"></a></td>
                </tr>
            </table>
        </form>
    </div>
    <div id="deleteDoctor" class="container tab-pane fade"><br>

    </div>
</div>

<?php include_once 'foot.php';?>