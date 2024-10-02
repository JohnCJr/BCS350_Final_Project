<?php
// about us.php - About us page
// Written by: John Cabanas, November 2023

// Include
	include('header.php');

// Output
	echo "<img id='about-img' src='images/tree.jpg' alt='tree in a field'>
          <div class='about-body'>
            <div class='about-section'>
                <img src='images/study.jpg' alt='stack of books'>
                <h2>Study</h2>
                <p>Studying is a crucial aspect of high school education, providing 
                   students with the necessary tools for academic success and personal 
                   development. Beyond the immediate goal of achieving good grades, 
                   effective study habits foster essential skills such as time management, 
                   critical thinking, and problem-solving. High schoolers who dedicate time 
                   to studying not only grasp the material but also build a foundation for 
                   lifelong learning. Additionally, a strong academic foundation opens doors 
                   to future educational and career opportunities, making the investment in 
                   studying during high school a key factor in shaping a student's future.
                </p>
            </div>
            <div class='about-section'>
                <img src='images/growth.jpg' alt='seedling'>
                <h2>Growth</h2>
                <p>High school serves as a transformative period for personal growth, 
                offering students a platform to discover and develop their unique identities. 
                Engaging in diverse experiences, extracurricular activities, and social interactions 
                allows high schoolers to cultivate essential life skills, including communication, 
                leadership, and teamwork. Navigating challenges and successes during these formative 
                years contributes to increased self-awareness and resilience, preparing students for 
                the complexities of adulthood. Ultimately, the personal growth experienced in high 
                school lays the groundwork for individuals to navigate the broader world with confidence 
                and adaptability.
                </p>
            </div>
            <div class='about-section'>
                <img src='images/understanding.jpg' alt='mathematical equation'>
                <h2>Understanding</h2>
                <p>High school represents a crucial phase for high schoolers to gain a deeper 
                understanding of themselves, their peers, and the world around them. Through academic 
                pursuits, students delve into various subjects, fostering intellectual curiosity and 
                critical thinking. Interactions with a diverse community expose them to different 
                perspectives, nurturing empathy and cultural awareness. As high schoolers gain 
                understanding, they become better equipped to make informed decisions, contribute 
                meaningfully to society, and embrace the complexity of the global landscape.
                </p>
            </div>
            <div id='contact-info'>
                <h2>Contact Us!</h2>
                <hr>
                <p>Visit our website: <a href='#'>Westpinehighschool.org</a></p>
                <p>Email us at: <a href='mailto:wpineschool@WPINE.com'>wpineschool@WPINE.com</a></p>
                <p>Call us: <a href='tel:+1234567890'>+1 (234) 567-890</a></p>
                <p>Our address: <address>123 Pine Dr</address></p>
            </div>
          </div>";

	include('footer.php');
?>