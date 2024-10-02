<?php
// homepage.php - Home Page 
// Written by: John Cabanas, November 2023

// Output
include('header.php');

echo "<div class='carousel-container' id='imageCarousel'>
		<button class='carousel-btn prev-btn' onclick='prevSlide()'>&#8656</button>
		<div class='carousel-slide' style='display: block;'>
			<div class='carousel-text'>Welcome to the West Pine High School website!</div>
			<img class='carousel-image' src='images/img1.jpg' alt='Autumn trees'>
		</div>
		<div class='carousel-slide'>
			<div class='carousel-text'>Make sure to check out our course catalogue</div>
			<img class='carousel-image' src='images/img2.jpg' alt='Chalk board'>
		</div>
		<div class='carousel-slide'>
			<div class='carousel-text'>SAT prep available! Check events page for more details</div>
			<img class='carousel-image' src='images/img3.jpg' alt='Chalk board'>
		</div>
		<div class='carousel-slide'>
		<div class='carousel-text'>Check out the events page for all upcoming events this month</div>
			<img class='carousel-image' src='images/img4.jpg' alt='Chalk board'>
		</div>
		<div class='carousel-slide'>
			<div class='carousel-text'>Take a look at the about us page to see 
			what drives us to do our best for our students</div>
			<img class='carousel-image' src='images/img5.jpg' alt='Chalk board'>
		</div>
		<button class='carousel-btn next-btn' onclick='nextSlide()'>&#8658;</button>
	</div>
	<div class='container'>
		<div>
			<p>Students and faculty, make sure to login to your accounts to access your personal information. 
			   Students can view their grades and teachers can grade assignments</p>
		</div>
		<img src='images/img6.jpg' alt='gradebook'>
	</div>";

	echo "<script>
	let currentSlide = 0;
	const slides = document.querySelectorAll('.carousel-slide');
	
	// Hides all other carousel items that are not the current index
	// Note: forEach(current element, index number of current element)
	function showSlide(index) {
		slides.forEach((slide, i) => {
			if (i === index) {
				slide.style.opacity = 1; // Set opacity to 1 for fade-in effect
				slide.style.display = 'block';
			} else {
				slide.style.opacity = 0; // Set opacity to 0 for fade-out effect
				slide.style.display = 'none';
			}
		});
	}
	
	function nextSlide() {
		currentSlide = (currentSlide + 1) % slides.length;
		showSlide(currentSlide);
	}
	
	function prevSlide() {
		currentSlide = (currentSlide - 1 + slides.length) % slides.length;
		showSlide(currentSlide);
	}
	
	// Auto-advance the carousel every 5 seconds
	setInterval(nextSlide, 5000);
	</script>
	";
include('footer.php');
?>