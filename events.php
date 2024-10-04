<?php
// events.php - Home Page 
// Written by: John Cabanas, November 2023

// Include
include('header.php');

// Variables used to get the upcoming Saturday given the current date
$currentDate = date('m/d/Y'); // Outputs the date in the format "MM/DD/YYYY"
$firstsaturday = date('m/d/Y', strtotime('next Saturday')); // Outputs the date in the format "MM/DD/YYYY"
$eventdates = array();
array_push($eventdates, $firstsaturday);
$days = 6;
for ($i = 1; $i <= 4; $i++) {
    $tempdate = $days * $i;
    $nextdate = date("m/d/Y", strtotime($firstsaturday . " +$tempdate days")); // Changed to use $firstsaturday
    array_push($eventdates, $nextdate);
}

// Output
echo "<h2 align='center'>Upcoming Events</h2>
    <div class='data-container'>
    <table class='datatable'>
    <caption>Date and time subject to change</caption> // Updated caption format
        <thead>
            <tr>
                <th>Date</th>
                <th>Event</th>
                <th>Time</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th>{$eventdates[0]}</th> // Using curly braces for clarity
                <td>SAT Test Prep</td>
                <td>7:00 AM - 9:00 AM</td>
            </tr>
            <tr>
                <th>{$eventdates[1]}</th> // Using curly braces for clarity
                <td>School Talent Show</td>
                <td>5:00 PM - 7:30 PM</td>
            </tr>
            <tr>
                <th>{$eventdates[2]}</th> // Using curly braces for clarity
                <td>Food Drive</td>
                <td>8:30 PM - 10:30 PM</td>
            </tr>
            <tr>
                <th>{$eventdates[3]}</th> // Using curly braces for clarity
                <td>Homecoming Assembly</td>
                <td>2:00 PM - 3:00 PM</td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td colspan='3'>Events for the upcoming weeks</td>
            </tr>
        </tfoot>
    </table></div>
    
    <div class='events'>
        <div class='event-section'>
            <img src='images/test.jpg' alt='Image of a test answer sheet'> // More descriptive alt text
            <section>
                <h3>SAT Test Prep</h3>
                <p>Prepare for success with our upcoming SAT prep class tailored for high school students. 
                   Join us to enhance your skills, boost confidence, and optimize your performance for this 
                   critical exam, ensuring a path to your desired college or university.</p>
            </section>
        </div>
        <div class='event-section'>
            <img src='images/talent.jpg' alt='Image of a talent show'> // More descriptive alt text
            <section>
                <h3>School Talent Show</h3>
                <p>Get ready to showcase your talents at our upcoming high school talent show. Whether you're 
                   a musician, dancer, comedian, or possess any unique skill, this is your chance to shine and 
                   captivate your school community.</p>
            </section>
        </div>
        <div class='event-section'>
            <img src='images/canned_goods.jpg' alt='Image of multiple canned goods'> // More descriptive alt text
            <section>
                <h3>Food Drive</h3>
                <p>Join us in making a difference in the community by participating in our upcoming high school 
                food drive. Let's come together to support those in need, collecting non-perishable items and 
                contributing to a cause that truly makes a positive impact.</p>
            </section>
        </div>
        <div class='event-section'>
            <img src='images/homecoming.jpg' alt='Image of balloons at ceiling'> // More descriptive alt text
            <section>
                <h3>Homecoming Assembly</h3>
                <p>Get ready for an unforgettable experience at our upcoming high school homecoming assembly. Join 
                the spirit-filled celebration as we come together to showcase school pride and enjoy exciting performances.</p>
            </section>
        </div>
    </div>
";

include('footer.php');
?>