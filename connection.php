<?php
$con=mysqli_connect("localhost","root","","online_booking_tecket");
if($con==false) {
    echo '<script>alert("Sorry!!!\n\nDatabase not connected.")</script>';
} else {
    $seatColumnExists = mysqli_query($con, "SHOW COLUMNS FROM booking LIKE 'Seat_Count'");
    if ($seatColumnExists && mysqli_num_rows($seatColumnExists) === 0) {
        mysqli_query($con, "ALTER TABLE booking ADD COLUMN Seat_Count INT(6) NOT NULL DEFAULT 1 AFTER Id");
    }
    $seatNumberColumnExists = mysqli_query($con, "SHOW COLUMNS FROM booking LIKE 'Seat_Number'");
    if ($seatNumberColumnExists && mysqli_num_rows($seatNumberColumnExists) === 0) {
        mysqli_query($con, "ALTER TABLE booking ADD COLUMN Seat_Number INT(6) DEFAULT NULL AFTER Seat_Count");
    }
    $seatUniqueIndex = mysqli_query($con, "SHOW INDEX FROM booking WHERE Key_name='uniq_trip_seat'");
    if ($seatUniqueIndex && mysqli_num_rows($seatUniqueIndex) === 0) {
        mysqli_query($con, "ALTER TABLE booking ADD UNIQUE KEY uniq_trip_seat (Id, Seat_Number)");
    }
    $ticketCodeColumnExists = mysqli_query($con, "SHOW COLUMNS FROM booking LIKE 'Ticket_Code'");
    if ($ticketCodeColumnExists && mysqli_num_rows($ticketCodeColumnExists) === 0) {
        mysqli_query($con, "ALTER TABLE booking ADD COLUMN Ticket_Code VARCHAR(5) DEFAULT NULL AFTER Seat_Number");
    }
    $ticketCodeUniqueIndex = mysqli_query($con, "SHOW INDEX FROM booking WHERE Key_name='uniq_ticket_code'");
    if ($ticketCodeUniqueIndex && mysqli_num_rows($ticketCodeUniqueIndex) === 0) {
        mysqli_query($con, "ALTER TABLE booking ADD UNIQUE KEY uniq_ticket_code (Ticket_Code)");
    }
}
?>
