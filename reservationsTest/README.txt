Reservation Management System

Δημιουργία βάσης δεδομένων
//////--
Συνδεθείτε στη MySQL και εκτελέστε το αρχείο SQL.

CREATE DATABASE IF NOT EXISTS reservationstest;
USE reservationstest;

CREATE TABLE IF NOT EXISTS reservations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    reservation_date DATE NOT NULL,
    guests INT NOT NULL
);

////////----


Αν χρησιμοποιείτε XAMPP: Αντιγράψτε τον φάκελο μέσα στον htdocs.

Στο αρχείο confing.php, αλλάξτε τις παραμέτρους ώστε να αντιστοιχούν με τις δικές σας.
----
$DBHost = "localhost"; 
$DBUser = "root"; 
$DBPassword = "";
-----
Εισάγετε το TEST.postman_collection.json στο Postman.
Βεβαιωθείτε ότι ο διακομιστής εκτελείται (π.χ. XAMPP) και ότι η βάση δεδομένων έχει ρυθμιστεί.
Εκτελέστε τη συλλογή χρησιμοποιώντας το Collection Runner του Postman.

Όλα τα αιτήματα επιστρέφουν JSON.

1. Προσθήκη νέας κράτησης

POST /insertBooking.php
Content-Type: application/json

{
  "name": "Γιάννης Παπαδόπουλος",
  "reservation_date": "2025-09-20",
  "guests": 4
}

Απάντηση επιτυχίας:

{
  "status": "OK",
  "message": "Successfully inserted",
  "reservation_id": 1
}

Απάντηση αποτυχίας :

{"Status" : "ERROR", "Message"  : "Invalid guests number"}
{"Status" : "ERROR", "Message" : "Invalid date/time"}
{"Status" : "ERROR", "Message" :"Date error"}
{"Status" : "ERROR", "Message" : "Prepare failed"}
{"Status" : "ERROR", "Message" : "Execution failed"}
{"Status" : "ERROR", "Message" : "VARIABLE NOT SET PROPERLY"}


2. Λήψη όλων των κρατήσεων 
(GET)  /getBooking.php
Απάντηση :

[
  {
    "id": 1,
    "name": "Γιάννης Παπαδόπουλος",
    "reservation_date": "2025-09-20",
    "guests": 4
  },
  {
    "id": 2,
    "name": "Μαρία Κωνσταντίνου",
    "reservation_date": "2025-09-22",
    "guests": 2
  }
]



3. Επεξεργασία κράτησης

PUT  /updateBooking.php


{
"id":5
"name":"Γιάννης Παπαδόπουλος"
"reservation_date":"2025-09-22"
"guests":7
}

Απάντηση:

{
  "status": "OK",
  "message": "Succesfully updated"
}

{
  "status": "OK",
  "message": "No rows affected"
}

Απάντηση αποτυχίας :

{"Status" : "ERROR", "Message"  : "Invalid guests number"}
{"Status" : "ERROR", "Message" : "Invalid date/time"}
{"Status" : "ERROR", "Message" :"Date error"}
{"Status" : "ERROR", "Message" : "Prepare failed"}
{"Status" : "ERROR", "Message" : "Invalid ID"}
{"Status" : "ERROR", "Message" : "Execution failed"}
{"Status" : "ERROR", "Message" : "Missing parameters"}


4. Διαγραφή κράτησης (DELETE)
DELETE  /deleteBooking.php
{
  "id": 1
}


Απάντηση:

{
  "status": "OK",
  "message": "Successfully deleted"
}

{
  "status": "OK",
  "message": "No record found"
}


Απάντηση αποτυχίας :

{"Status" : "ERROR", "Message"  : "Invalid parameters"}
{"Status" : "ERROR", "Message" :"No record found"}
{"Status" : "ERROR", "Message" : "Prepare failed"}
{"Status" : "ERROR", "Message" : "Execution failed"}

{"Status" : "ERROR", "Message" : "Missing parameters"}