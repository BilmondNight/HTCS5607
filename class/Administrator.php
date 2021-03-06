<?php
include_once("DB.php");
include_once "Patient.php";
include_once "Ward.php";
include_once "Doctor.php";
include_once "Medication.php";
include_once "Admission.php";
include_once "Invoice.php";
include_once "AdmissionsAll.php";
include_once "PatientsReport.php";
include_once "PatientPayment.php";
include_once "DoctorsReport.php";

class Administrator
{
    public $id;
    public $username;
    private $password;
    public $email;
    public $phone;
    public $role;

    /**
     * Administrator constructor.
     */
    public function __construct()
    {
        $this->id = null;
        $this->username = null;
        $this->password = null;
        $this->email = null;
        $this->phone = null;
        $this->role = null;
    }

    public function login($username, $password)
    {
        $conn = (new DB())->conn;
        $query = "select * from Admin where username = '$username'";   // check if the username exists
        $result = mysqli_query($conn, $query);
        if ($result->num_rows == 1) {    // if the username exists, check the password
            while ($row = $result->fetch_assoc()) {
                if ($row['password'] == $password) {
                    $this->id = $row['AdminID'];
                    $this->username = $row['username'];
                    $this->password = $row['password'];
                    $this->email = $row['email'];
                    $this->phone = $row['phone'];
                    $this->role = $row['role'];
                }else {
                    $this->role = "wrong";
                }
            }
        }else {
            $this->role = "wrong";
        }
        $conn->close();
    }

    // finding records from patient, doctors, medications, payments, ward by admission -start-
    public function findPatientByAdmission($patientID)
    {
        $conn = (new DB())->conn;
        $sql = "select * from Patient where PatientID = " . $patientID;
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
            $getPatientID = $row["PatientID"];
            $lastname = $row["lastname"];
            $firstname = $row["firstname"];
            $address = $row["street"].", ".$row["suburb"].", ".$row["city"];
            $patient = array("patient"=>$getPatientID, "lastname"=>$lastname, "firstname"=>$firstname, "address"=>$address);
            }
        }
        $conn->close();
        return $patient;
    }

    public function findDoctorsByAdmission($admissionID)
    {
        $conn = (new DB())->conn;
        $sql = "select * from Doctor, Allocation, Admission where Doctor.DoctorID = Allocation.doctorID and Allocation.admissionID = Admission.AdmissionID and Admission.AdmissionID = " . $admissionID;
        $result = $conn->query($sql);
        $doctors = array();
        if ($result->num_rows>0){
            while ($row=$result->fetch_assoc()){
                $getDoctorID = $row["DoctorID"];
                $lastname = $row["lastname"];
                $firstname = $row["firstname"];
                $getAllocationID = $row["AllocationID"];
                $fee = $row["fee"];
                $role = $row["role"];
                $doctor = array("doctor"=>$getDoctorID, "lastname"=>$lastname, "firstname"=>$firstname, "allocation"=>$getAllocationID, "fee"=>$fee, "role"=>$role);
                array_push($doctors,$doctor);
            }
        }
        $conn->close();
        return $doctors;
    }

    public function findMedicationsByAdmission($admissionID)
    {
        $conn = (new DB())->conn;
        $sql = "select * from Medication, Prescription, Admission where Medication.MedicationID = Prescription.medicationID and Prescription.admissionID = Admission.AdmissionID and Admission.AdmissionID = " . $admissionID;
        $result = $conn->query($sql);
        $medications = array();
        if ($result->num_rows>0){
            while ($row=$result->fetch_assoc()){
                $getMedicationId = $row["MedicationID"];
                $name = $row["name"];
                $cost = $row["cost"];
                $getPrescriptionID = $row["PrescriptionID"];
                $date = $row["prescriptiondate"];
                $amount = $row["amount"];
                $medication = array("medication"=>$getMedicationId, "name"=>$name, "cost"=>$cost, "prescription"=>$getPrescriptionID, "prescriptiondate"=>$date, "amount"=>$amount);
                array_push($medications,$medication);
            }
        }
        $conn->close();
        return $medications;
    }

    public function findWardByAdmission($wardID)
    {
        $conn = (new DB())->conn;
        $sql = "select * from Ward where WardID = " . $wardID;
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $getWardID = $row["WardID"];
                $name = $row["name"];
                $ward = array("ward"=>$getWardID, "name"=>$name);
            }
        }
        $conn->close();
        return $ward;
    }

    public function findPaymentsByAdmission($admissionID)
    {
        $conn = (new DB())->conn;
        $sql = "select * from Payment, Admission where Payment.admissionID = Admission.AdmissionID and Admission.AdmissionID = " . $admissionID;
        $result = $conn->query($sql);
        $payments = array();
        if ($result->num_rows>0){
            while ($row=$result->fetch_assoc()){
                $getPaymentCode = $row["PaymentCode"];
                $amount = $row["amount"];
                $payment = array("payment"=>$getPaymentCode, "amount"=>$amount);
                array_push($payments,$payment);
            }
        }
        $conn->close();
        return $payments;
    }
    // finding records from patient, doctors, medications, payments, ward by admission -end-

    // finding records from admission by patient
    public function findAdmissionsByPatient($patientID)
    {
        $conn = (new DB())->conn;
        $sql = "select * from Admission where status = 'billed' and patientID = ". $patientID;
        $result = $conn->query($sql);
        $admissions = array();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $getAdmissionID = $row["AdmissionID"];
                $description = $row["description"];
                $admission = array("admission"=>$getAdmissionID, "description"=>$description);
                array_push($admissions, $admission);
            }
        }
        $conn->close();
        return $admissions;
    }

    // finding records for invoice
    public function completeAdmissions()
    {
        $conn = (new DB())->conn;
        $sql = "select * from Admission where status = 'complete'";
        $admissions = array();
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $admission = new Invoice($row["AdmissionID"], $row["description"], $this->findPatientByAdmission($row["patientID"]), $this->findMedicationsByAdmission($row["AdmissionID"]), $this->findDoctorsByAdmission($row["AdmissionID"]));
                array_push($admissions, $admission);
            }
        }
        $conn->close();
        return $admissions;
    }

    // finding records for admissions report
    public function showAdmissions()
    {
        $conn = (new DB())->conn;
        $sql = "select * from Admission";
        $admissions = array();
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $admission = new AdmissionsAll($row["AdmissionID"], $row["description"], $row["admissiondate"], $row["status"],
                    $this->findPatientByAdmission($row["patientID"]), $this->findMedicationsByAdmission($row["AdmissionID"]),
                    $this->findDoctorsByAdmission($row["AdmissionID"]), $this->findPaymentsByAdmission($row["AdmissionID"]));
                array_push($admissions, $admission);
            }
        }
        $conn->close();
        return $admissions;
    }

    // finding records for allocating/remove doctor, prescribing/remove medication
    public function currentAdmissionsForAllocationPrescription()
    {
        $conn = (new DB())->conn;
        $sql = "select * from Admission WHERE status = 'current'";
        $admissions = array();
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $admission = new AdmissionsAll($row["AdmissionID"], $row["description"], $row["admissiondate"], $row["status"],
                    $this->findPatientByAdmission($row["patientID"]), $this->findMedicationsByAdmission($row["AdmissionID"]),
                    $this->findDoctorsByAdmission($row["AdmissionID"]), $this->findPaymentsByAdmission($row["AdmissionID"]));
                array_push($admissions, $admission);
            }
        }
        $conn->close();
        return $admissions;
    }

    // finding records for adding payment
    public function patientsWithBilledAdmission()
    {
        $conn = (new DB())->conn;
        $sql = "SELECT * FROM Patient WHERE EXISTS (SELECT patientID FROM Admission WHERE Admission.patientID = Patient.PatientID AND Admission.status = 'billed')";
        $patients = array();
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $patient = new PatientPayment($row["PatientID"], $row["lastname"], $row["firstname"], $this->findAdmissionsByPatient($row["PatientID"]));
                array_push($patients, $patient);
            }
        }
        $conn->close();
        return $patients;
    }

    // finding records for patients report -start-
    public function showPatients()
    {
        $conn = (new DB())->conn;
        $sql = "select * from Patient";
        $patients = array();
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $patient = new PatientsReport($row["PatientID"], $row["lastname"], $row["firstname"], $row["street"], $row["suburb"], $row["city"], $row["email"], $row["phone"], $row["insurcode"], $this->countCompleteAdmissions($row["PatientID"]), $this->countCurrentAdmissions($row["PatientID"]));
                array_push($patients, $patient);
            }
        }
        $conn->close();
        return $patients;
    }

    public function countCompleteAdmissions($patientID)
    {
        $conn = (new DB())->conn;
        $sql = "SELECT Admission.patientID FROM Admission WHERE status='complete' AND patientID=" . $patientID;
        $result = $conn->query($sql);
        $number = mysqli_num_rows($result);
        $conn->close();
        return $number;
    }

    public function countCurrentAdmissions($patientID)
    {
        $conn = (new DB())->conn;
        $sql = "SELECT Admission.patientID FROM Admission WHERE status='current' AND patientID=" . $patientID;
        $result = $conn->query($sql);
        $number = mysqli_num_rows($result);
        $conn->close();
        return $number;
    }
    // finding records for patients report -end-

    // finding records for doctors report -start-
    public function showDoctors()
    {
        $conn = (new DB())->conn;
        $sql = "select * from Doctor";
        $doctors = array();
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $doctor = new DoctorsReport($row["DoctorID"], $row["lastname"], $row["firstname"], $row["street"], $row["suburb"], $row["city"], $row["phone"], $row["speciality"], $row["salary"], $this->countAdmissionsForDoctor($row["DoctorID"]), $this->countProjectsForDoctor($row["DoctorID"]));
                array_push($doctors, $doctor);
            }
        }
        $conn->close();
        return $doctors;
    }

    public function countAdmissionsForDoctor($doctorID)
    {
        $conn = (new DB())->conn;
        $sql = "SELECT Admission.AdmissionID FROM Admission, Allocation, Doctor WHERE Admission.AdmissionID = Allocation.admissionID AND Allocation.doctorID = Doctor.DoctorID AND Doctor.DoctorID =" . $doctorID;
        $result = $conn->query($sql);
        $number = mysqli_num_rows($result);
        $conn->close();
        return $number;
    }

    public function countProjectsForDoctor($doctorID)
    {
        $conn = (new DB())->conn;
        $sql = "SELECT Researchproject.doctorID FROM Researchproject WHERE doctorID=" . $doctorID;
        $result = $conn->query($sql);
        $number = mysqli_num_rows($result);
        $conn->close();
        return $number;
    }
    // finding records for doctors report -end-

    // finding records for updating patient
    public function allPatiens(){
        $conn = (new DB())->conn;
        $sql = "select * from Patient";
        $result = $conn->query($sql);
        $patients = array();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $patient = new Patient($row["PatientID"], $row["lastname"], $row["firstname"], $row["street"], $row["suburb"], $row["city"], $row["email"], $row["phone"], $row["insurcode"]);
                array_push($patients,$patient);
            }
        }
        $conn->close();
        return $patients;
    }

    // finding records for deleting patient
    public function patiensWithoutAdmission(){
        $conn = (new DB())->conn;
        $sql = "SELECT * FROM Patient WHERE NOT EXISTS (SELECT patientID FROM Admission WHERE Admission.patientID = Patient.PatientID)";
        $result = $conn->query($sql);
        $patients = array();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $patient = new Patient($row["PatientID"], $row["lastname"], $row["firstname"], $row["street"], $row["suburb"], $row["city"], $row["email"], $row["phone"], $row["insurcode"]);
                array_push($patients,$patient);
            }
        }
        $conn->close();
        return $patients;
    }

    // finding records for updating doctor
    public function allDoctors(){
        $conn = (new DB())->conn;
        $sql = "select * from Doctor";
        $result = $conn->query($sql);
        $doctors = array();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $doctor = new Doctor($row["DoctorID"], $row["lastname"], $row["firstname"], $row["street"], $row["suburb"], $row["city"], $row["phone"], $row["speciality"], $row["salary"]);
                array_push($doctors,$doctor);
            }
        }
        $conn->close();
        return $doctors;
    }

    // finding records for deleting doctor
    public function doctorsWithoutAllocation(){
        $conn = (new DB())->conn;
        $sql = "SELECT * FROM Doctor WHERE NOT EXISTS (SELECT * FROM Allocation, Researchproject
                WHERE Allocation.doctorID = Doctor.DoctorID OR Researchproject.doctorID = Doctor.DoctorID)";
        $result = $conn->query($sql);
        $doctors = array();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $doctor = new Doctor($row["DoctorID"], $row["lastname"], $row["firstname"], $row["street"], $row["suburb"], $row["city"], $row["phone"], $row["speciality"], $row["salary"]);
                array_push($doctors,$doctor);
            }
        }
        $conn->close();
        return $doctors;
    }

    // finding records for updating ward
    public function allWards(){
        $conn = (new DB())->conn;
        $sql = "select * from Ward";
        $result = $conn->query($sql);
        $wards = array();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $ward = new Ward($row["WardID"], $row["name"], $row["location"], $row["capacity"]);
                array_push($wards,$ward);
            }
        }
        $conn->close();
        return $wards;
    }

    // finding records for deleting ward
    public function wardsWithoutAdmission(){
        $conn = (new DB())->conn;
        $sql = "SELECT * FROM Ward WHERE NOT EXISTS (SELECT wardID FROM Admission WHERE Admission.wardID = Ward.WardID)";
        $result = $conn->query($sql);
        $wards = array();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $ward = new Ward($row["WardID"], $row["name"], $row["location"], $row["capacity"]);
                array_push($wards,$ward);
            }
        }
        $conn->close();
        return $wards;
    }

    // finding records for updating medication
    public function allMedications(){
        $conn = (new DB())->conn;
        $sql = "select * from Medication";
        $result = $conn->query($sql);
        $medications = array();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $medication = new Medication($row["MedicationID"], $row["name"], $row["cost"]);
                array_push($medications, $medication);
            }
        }
        $conn->close();
        return $medications;
    }

    // finding records for deleting medication
    public function medicationsWithoutPresciption(){
        $conn = (new DB())->conn;
        $sql = "SELECT * FROM Medication WHERE NOT EXISTS (SELECT medicationID FROM Prescription WHERE Prescription.medicationID = Medication.MedicationID)";
        $result = $conn->query($sql);
        $medications = array();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $medication = new Medication($row["MedicationID"], $row["name"], $row["cost"]);
                array_push($medications, $medication);
            }
        }
        $conn->close();
        return $medications;
    }

    // finding records for updating admission
    public function currentAdmissions()
    {
        $conn = (new DB())->conn;
        $sql = "select * from Admission where status = 'current'";
        $admissions = array();
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $admission = new Admission($row["AdmissionID"], $row["description"], $row["admissiondate"], $row["status"], $this->findPatientByAdmission($row["patientID"]), $this->findWardByAdmission($row["wardID"]));
                array_push($admissions, $admission);
            }
        }
        $conn->close();
        return $admissions;
    }

    // finding records for deleting admission
    public function closeAdmissions()
    {
        $conn = (new DB())->conn;
        $sql = "select * from Admission where status = 'close'";
        $admissions = array();
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $admission = new Admission($row["AdmissionID"], $row["description"], $row["admissiondate"], $row["status"], $this->findPatientByAdmission($row["patientID"]), $this->findWardByAdmission($row["wardID"]));
                array_push($admissions, $admission);
            }
        }
        $conn->close();
        return $admissions;
    }

    // finding records for closing admission
    public function billedAdmissions()
    {
        $conn = (new DB())->conn;
        $sql = "select * from Admission where status = 'billed'";
        $admissions = array();
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $admission = new AdmissionsAll($row["AdmissionID"], $row["description"], $row["admissiondate"], $row["status"],
                    $this->findPatientByAdmission($row["patientID"]), $this->findMedicationsByAdmission($row["AdmissionID"]),
                    $this->findDoctorsByAdmission($row["AdmissionID"]), $this->findPaymentsByAdmission($row["AdmissionID"]));
                array_push($admissions, $admission);
            }
        }
        $conn->close();
        return $admissions;
    }
}
