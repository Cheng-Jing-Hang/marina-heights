<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="/style.css" rel= "stylesheet">
    <title>Marina Heights</title>
</head>
<body>

<!-- Navbar -->
<div class="navbar">
    <a href="#" onclick="showLogoPopup(); return false;" class="logo-hover"><img src="Image/logo.png" alt="Marina Heights Logo" class="logo"></a>
    <div class="nav-buttons">
        <button class="nav-btn">About Us</button>
        <button class="nav-btn" onclick="window.location.href='faq.html'">FAQ</button>
        <button class="nav-btn" onclick="toggleVisitorPopup()">Plan a Visit</button>
    </div>
    <img src="Image/Visitor Page/Icons/profile.png" alt="Profile Picture" class="profile" id="profile-pic" style="margin-right: 1px; height: 51px; width: 51px">
</div>
<div id="logo-popup" class="logo-popup">
    <div class="logo-popup-content">
        <span class="close-logo" onclick="closeLogoPopup()">&times;</span>
        <img src="Image/logo.png" alt="Marina Heights Logo" class="logo-large">
    </div>
</div>
<!-- Popup Login Form -->
<div class="popup" id="login-popup">
  <div class="login-popup-container">
    <div class="login-header">
      <h3>Resident Login</h3>
      <p>Access your Marina Heights account</p>
    </div>
    
    <form id="loginForm" class="login-form">
      <div class="form-group">
        <label for="login_id">Email / First Name / Last Name / Unit Number</label>
        <input type="text" id="login_id" name="login_id" required
               placeholder="Enter your login details"
               value="<?php echo isset($_COOKIE['remember_login']) ? htmlspecialchars($_COOKIE['remember_login']) : ''; ?>">
        <svg class="input-icon" viewBox="0 0 24 24" width="18">
          <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
        </svg>
      </div>
      
      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" required placeholder="Enter your password">
        <svg class="input-icon" viewBox="0 0 24 24" width="18">
          <path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm-6 9c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm3.1-9H8.9V6c0-1.71 1.39-3.1 3.1-3.1 1.71 0 3.1 1.39 3.1 3.1v2z"/>
        </svg>
      </div>
      
      <div class="form-options">
        <label class="remember-me">
          <input type="checkbox" name="remember" <?php echo isset($_COOKIE['remember_login']) ? 'checked' : ''; ?>>
          Remember me
        </label>
        <a href="#forgot-password" class="forgot-password">Forgot password?</a>
      </div>
      <div id="loginError" style="color: red; margin-bottom: 10px; display: none;"></div>
      <button type="submit" class="login-btn">Sign In</button>
    </form>
    
    <div class="login-footer">
      <p>Not registered yet? <a href="#" onclick="toggleRegisterPopup(); return false;">Create account</a></p>
    </div>
  </div>
</div>
<!-- Register Popup Form -->
<div class="popup" id="register-popup">
  <div class="login-popup-container">
    <div class="login-header">
      <h3>Register as a Resident</h3>
      <p>Create your Marina Heights account</p>
    </div>
    
    <form id="register-form" class="login-form">
      <div class="form-group">
        <label for="first_name">First Name</label>
        <input type="text" id="first_name" name="first_name" required placeholder="Enter your first name">
        <svg class="input-icon" viewBox="0 0 24 24" width="18">
          <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
        </svg>
      </div>
      
      <div class="form-group">
        <label for="last_name">Last Name</label>
        <input type="text" id="last_name" name="last_name" required placeholder="Enter your last name">
        <svg class="input-icon" viewBox="0 0 24 24" width="18">
          <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
        </svg>
      </div>
      
      <div class="form-group">
        <label for="unit_number">Unit Number</label>
        <input type="text" id="unit_number" name="unit_number" required placeholder="e.g. A-12-05">
        <svg class="input-icon" viewBox="0 0 24 24" width="18">
          <path d="M18 2H6c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zM6 4h5v8l-2.5-1.5L6 12V4z"/>
        </svg>
      </div>
      
      <div class="form-group">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" required placeholder="Enter your email">
        <svg class="input-icon" viewBox="0 0 24 24" width="18">
          <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/>
        </svg>
      </div>
      
      <div class="form-group">
        <label for="reg_password">Password</label>
        <input type="password" id="reg_password" name="password" required placeholder="Create a password">
        <svg class="input-icon" viewBox="0 0 24 24" width="18">
          <path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm-6 9c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm3.1-9H8.9V6c0-1.71 1.39-3.1 3.1-3.1 1.71 0 3.1 1.39 3.1 3.1v2z"/>
        </svg>
      </div>
      
      <button type="submit" class="login-btn">Register</button>
    </form>
    
    <div class="login-footer">
      <p>Already have an account? <a href="#" onclick="toggleLoginFromRegister(); return false;">Sign in</a></p>
    </div>
  </div>
</div>
<div class="modal fade" id="registerSuccessModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 rounded-4 shadow-sm">
      <div class="modal-body text-center p-4">
        <div class="display-4 text-success mb-2">
          <i class="bi bi-check-circle-fill"></i>
        </div>
        <h5 class="mb-2 fw-semibold">Registration submitted successfully!</h5>
        <p class="mb-0 text-muted">Your submission will be processed in one working day.</p>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="invalidEmailModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 rounded-4 shadow-sm">
      <div class="modal-body text-center p-4">
        <div class="display-4 text-danger mb-2">
          <i class="bi bi-x-circle-fill"></i>
        </div>
        <h5 class="mb-2 fw-semibold">Invalid email format</h5>
        <p class="mb-0 text-muted">Please enter a valid email address (e.g. yourname@example.com).</p>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="duplicateEmailModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 rounded-4 shadow-sm">
      <div class="modal-body text-center p-4">
        <div class="display-4 text-danger mb-2">
          <i class="bi bi-x-circle-fill"></i>
        </div>
        <h5 class="mb-2 fw-semibold">Email or Unit Number already registered</h5>
        <p class="mb-0 text-muted">Please use a different email or unit number to register.</p>
      </div>
    </div>
  </div>
</div>

<div class="landing-screen">
  <img src="Image/slide2.png" alt="Marina Heights Apartment" class="single-image">
</div>



<section id="facility-wrapper" style="margin: 20px;">
  <div class="facility-flex-container">
    <!-- LEFT: Collapsible Section -->
    <div class="facility-left" style="margin-top: 20px;">
      <section id="about-map" class="active">
        <button class="collapsible" style="font-size: 2.5rem; margin-bottom: 60px;">
          <img src="Image/Visitor Page/Icons/aboutus-icon.png" alt="About Us Icon" style="width: 50px;">About Us <span class="arrow">▼</span>
        </button>
        <div class="content">
          <p>Welcome to Marina Heights, a premier residential condominium nestled in the heart of the city’s coastal charm. Perfectly situated just a short stroll from the shimmering shoreline, Marina Heights offers a rare blend of seaside serenity and urban convenience. With the LRT station just minutes away and a major shopping centre right around the corner, residents enjoy effortless access to both relaxation and city living.</p>   

          <p>Marina Heights is the vision of three passionate partners — Cheng Jing Hang, Chuah Kai Xian, Lee Jia Jun — who bring together years of experience in real estate, architecture, and lifestyle design. Together, they set out to create not just a building, but a vibrant, connected community where modern living meets natural beauty.</p>

          <p>Designed with comfort, elegance, and functionality in mind, Marina Heights features thoughtfully laid-out units, lush communal spaces, and panoramic sea views. Whether you’re a young professional, a growing family, or looking to downsize into something sleek and central, Marina Heights is more than a home — it’s a lifestyle.</p>

          <p>Come discover coastal city living redefined. Welcome to Marina Heights.</p>
        </div>
      </section>
    </div>
    <div class="facility-layout-below-aboutus">
    <div class="facility-image-container">
      <img src="Image/Visitor Page/Floor Plan/Facilities Plan/ground-floor.png" id="img-ground" class="facility-image fade-in" alt="Ground Floor" onclick="openImageModal(this.src)">
      <img src="Image/Visitor Page/Floor Plan/Facilities Plan/sixth-floor.png" id="img-sixth" class="facility-image fade-in" alt="Sixth Floor" style="display: none;" onclick="openImageModal(this.src)">
    </div>
    <div id="image-modal" class="image-modal" onclick="closeImageModal()">
      <span class="close-modal" style="position: absolute; top: 20px; right: 30px; font-size: 40px; color: white;">&times;</span>
      <img class="modal-content" id="modal-img" alt="Zoomed Facility">
    </div>
    <!-- RIGHT: Facilities Plan Section -->
    <div class="facility-right">
      <h3 style="font-size: 2rem; color: #003366; margin-bottom: 15px;"><b>Facilities Plan</b></h3>
      <div class="facility-tabs">
        <div class="tab active-tab" onclick="showFacilityFloor('ground', this)">Level 1</div>
        <div class="tab" onclick="showFacilityFloor('sixth', this)">Level 6</div>
      </div>

      <div class="facility-floors">
        <!-- Ground Floor -->
        <div id="facility-ground" class="facility-floor fade-in">
          <p style="font-size: 1.5rem;">Level 1 (Ground Floor) - Facilities Plan:</p>
          <ol class="facility-list">
            <li>Swimming Pool</li>
            <li>Multipurpose Hall 1</li>
            <li>Multipurpose Hall 2</li>
            <li>Management Office</li>
            <li>Gym Room</li>
            <li>Library</li>
            <li>Game Room</li>
          </ol>
        </div>
        <!-- Sixth Floor -->
        <div id="facility-sixth" class="facility-floor" style="display: none;">
          <p style="font-size: 1.5rem;">Level 6 - Facilities Plan:</p>
          <ol class="facility-list">
            <li>Playground</li>
            <li>Barbeque Area</li>
            <li>Basketball Court</li>
            <li>Pickleball Court</li>
          </ol>
        </div>
      </div>
    </div>
  </div>
</section>
<section id="facility-cost-details" style="margin: 60px 0; background-color: #f9fbfc; padding: 40px 20px; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.05);">
  <h2 style="font-size: 2.8rem; color: #003366; margin-bottom: 30px; text-align: center; font-weight: 700;">
    Facilities Cost and Details
  </h2>

  <div class="facility-details-grid">
    <div class="facility-card">
      <h3><b>Multi-purpose Hall</b></h3>
      <p class="cost">RM500 (per use)</p>
      <p>Spacious, air-conditioned hall with projector, sound system, tables & chairs — ideal for events, parties, or meetings.</p>
    </div>

    <div class="facility-card">
      <h3><b>Game Room</b></h3>
      <p class="cost">RM20/hr</p>
      <p>Cool hangout with air-cond, pool table, PS5, bean bags, and board games — perfect for fun with friends.</p>
    </div>

    <div class="facility-card">
      <h3><b>Swimming Pool</b></h3>
      <p class="cost">FOC (Ground Floor)</p>
      <p>Ground-floor pool with lounge chairs, shaded spots, and a kids’ zone. Lifeguard on duty at all times for safety.</p>
    </div>

    <div class="facility-card">
      <h3><b>Gym</b></h3>
      <p class="cost">FOC</p>
      <p>Open 24/7 with treadmills, free weights, cycling machines, yoga mats, and full air conditioning.</p>
    </div>

    <div class="facility-card">
      <h3><b>Library</b></h3>
      <p class="cost">FOC</p>
      <p>Peaceful reading space with study desks, Wi-Fi, and a curated selection of books and magazines.</p>
    </div>

    <div class="facility-card">
      <h3><b>BBQ Area</b></h3>
      <p class="cost">RM500 (Refundable Deposit)</p>
      <p>Outdoor grills, picnic tables, sink, lighting, and power outlets — perfect for casual gatherings and celebrations.</p>
    </div>

    <div class="facility-card">
      <h3><b>Basketball Court</b></h3>
      <p class="cost">RM10/hr</p>
      <p>Well-lit half-court with standard hoops and benches. Basketballs available at the management office.</p>
    </div>

    <div class="facility-card">
      <h3><b>Pickleball Court</b></h3>
      <p class="cost">RM15/hr</p>
      <p>Smooth court with net, paddles, and balls provided — fast-paced fun for all skill levels.</p>
    </div>
  </div>
</section>
<section id="floor-plan-section" style="margin: 60px 0;">
  <h2 style="font-size: 2.8rem; color: #003366; margin-bottom: 30px; text-align: center; font-weight: 700;">
    Floor Plan
  </h2>

  <div class="floor-tabs" style="text-align: center; margin-bottom: 20px;">
    <div class="tab active-tab" onclick="showFloorPlan('a', this)">Type A</div>
    <div class="tab" onclick="showFloorPlan('b', this)">Type B</div>
    <div class="tab" onclick="showFloorPlan('c', this)">Type C</div>
  </div>

  <div class="floor-image-container" style="text-align: center;">
    <img src="Image/Visitor Page/Floor Plan/Unit Plan/floor-plan-a.png" id="floor-plan-a" class="floor-plan-img fade-in" alt="Type A Floor Plan" onclick="openImageModal(this.src)">
    <img src="Image/Visitor Page/Floor Plan/Unit Plan/floor-plan-b.png" id="floor-plan-b" class="floor-plan-img" alt="Type B Floor Plan" style="display: none;" onclick="openImageModal(this.src)">
    <img src="Image/Visitor Page/Floor Plan/Unit Plan/floor-plan-c.png" id="floor-plan-c" class="floor-plan-img" alt="Type C Floor Plan" style="display: none;" onclick="openImageModal(this.src)">
  </div>
</section>
<section class="team-section">
  <h2 class="team-title"><b>Meet Our Agents</b></h2>
  <div class="team-container">
    <div class="team-member">
      <div class="profile-pic-wrapper"><img src="Image/Visitor Page/Agents/marcus.png" alt="Marcus" class="team-photo"></div>
      <p class="team-desc">
        <strong>Marcus Lee</strong><br>
        Marcus holds a degree in Real Estate Management from the National University of Singapore and a certification in Property Investment Analysis. He is calm, detail-oriented, and known for his integrity, always ensuring clients get reliable, well-researched property advice.
      </p>
    </div>
    <div class="team-member">
      <div class="profile-pic-wrapper"><img src="Image/Visitor Page/Agents/daniel.png" alt="Daniel" class="team-photo"></div>
      <p class="team-desc">
        <strong>Daniel O’Connor</strong><br>
        Daniel graduated in Business Administration from the University of Melbourne with additional training in Urban Planning. Friendly and persuasive, he connects easily with clients and is driven to find the ideal home through energetic and honest service.
      </p>
    </div>
    <div class="team-member">
      <div class="profile-pic-wrapper"><img src="Image/Visitor Page/Agents/sarah.png" alt="Sarah" class="team-photo"></div>
      <p class="team-desc">
        <strong>Sarah Lim</strong><br>
        Sarah has a degree in Marketing from Monash University and a diploma in Property Services. She is empathetic, patient, and an excellent listener, which makes her especially skilled at understanding client needs and guiding them confidently through the buying process.
      </p>
    </div>
  </div>
</section>
<section id="parking-availability-section" style="margin: 60px 0;">
  <h2 style="font-size: 2.8rem; color: #003366; margin-bottom: 30px; text-align: center; font-weight: 700;">
    Visitor Parking Map
  </h2>
  <div class="floor-tabs" style="text-align: center; margin-bottom: 20px;">
    <div class="tab active-tab" onclick="showParkingLot('m1', this)">M1 Parking Lot</div>
    <div class="tab" onclick="showParkingLot('m2', this)">M2 Parking Lot</div>
    <div class="tab" onclick="showParkingLot('m3', this)">Outside Parking Lot</div>
  </div>
  <div class="floor-image-container" style="text-align: center;">
    <!-- M1 -->
    <div id="parking-lot-m1" class="parking-lot-content fade-in">
      <div class="parking-lot-wrapper" style="display: flex; justify-content: center; align-items: flex-start; gap: 40px;">
       <div style="position: relative;">
        <img src="Image/Visitor Page/Parking/parking-m1.png" alt="M1 Parking Lot" class="parking-lot-image2">
       </div>
      </div>
    </div>

    <!-- M2 -->
    <div id="parking-lot-m2" class="parking-lot-content" style="display: none;">
      <div class="parking-lot-wrapper" style="display: flex; justify-content: center; align-items: flex-start; gap: 40px;">
       <div style="position: relative;">
        <img src="Image/Visitor Page/Parking/parking-m2.png" alt="M2 Parking Lot" class="parking-lot-image">
       </div>
      </div>
    </div>
    <!-- M3 -->
    <div id="parking-lot-m3" class="parking-lot-content" style="display: none;">
      <div class="parking-lot-wrapper" style="display: flex; justify-content: center; align-items: flex-start; gap: 40px;">
       <div style="position: relative;">
        <img src="Image/Visitor Page/Parking/parking-outside.png" alt="Outside Parking Lot" class="parking-lot-image3">
       </div>
      </div>
    </div>
  </div>
</section>
<!-- Visitor Pass Popup -->
<div id="visitor-popup" class="visitor-popup">
    <div class="visitor-popup-content">
        <h2><b>Visitor Pass Application</b></h2>
        <form id="visitorForm" action="submit_permission.php" method="post">
            <label for="visitor_name">Name:</label>
            <input type="text" id="visitor_name" name="visitor_name" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="unit">Resident Unit:</label>
            <input type="text" id="unit" name="unit" required>

            <label for="visit_date">Visit Date:</label>
            <input type="date" id="visit_date" name="visit_date" required>

            <label for="num_visitors">Number of Visitors:</label>
            <input type="number" id="num_visitors" name="num_visitors" min="1" required>

            <label for="purpose">Purpose of Visiting:</label>
            <textarea id="purpose" name="purpose" rows="3" required></textarea>

            <div class="button-group">
                <button type="submit" class="submit-btn">SUBMIT</button>
                <button type="button" class="cancel-btn" onclick="toggleVisitorPopup()">CANCEL</button>
            </div>
        </form>
    </div>
</div>

    <!-- Success Modal -->
<div class="modal fade" id="successModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 rounded-4 shadow-sm">
      <div class="modal-body text-center p-4">
        <div class="display-4 text-success mb-2"><i class="bi bi-check-circle-fill"></i></div>
        <h5 id="successModalMsg" class="mb-0 fw-semibold">Visitor pass submitted successfully!</h5>
      </div>
    </div>
  </div>
</div>

    <footer class="footer">
        <div class="footer-container">
            <div class="footer-grid">
                <div class="footer-section about">
                    <h3>Marina Heights</h3>
                    <p style="margin-bottom: 10px;">Luxury living with a community focus.</p>
                    <p>We are dedicated to providing the best resident experience.</p>
                </div>
                <div class="footer-section">
                    <h3>Quick Links</h3>
                    <ul style="list-style: none; padding: 0;">
                        <li style="margin-bottom: 10px;">
                            <a href="#about-map"  style="color: white; text-decoration: none; transition: color 0.3s;" 
                               onmouseover="this.style.color='#feb47b'" onmouseout="this.style.color='white'">About Us</a>
                        </li>
                        <li style="margin-bottom: 10px;">
                            <a href="faq.html" style="color: white; text-decoration: none; transition: color 0.3s;" 
                               onmouseover="this.style.color='#feb47b'" onmouseout="this.style.color='white'">FAQ</a>
                        </li>
                        <li style="margin-bottom: 10px;">
                            <a href="#" onclick="toggleVisitorPopup(); return false;" style="color: white; text-decoration: none; transition: color 0.3s;" 
                               onmouseover="this.style.color='#feb47b'" onmouseout="this.style.color='white'">Plan a Visit</a>
                        </li>
                    </ul>
                </div>
                <div class="footer-section contact">
                    <h3>Contact Us</h3>
                    <p>123 Marina Drive, 11200</p>
                    <p>marina-heights@hotmail.com</p>
                    <div class="social-icons">
                        <a href="#"><i class="bi bi-facebook"></i></a>
                        <a href="#"><i class="bi bi-instagram"></i></a>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2025 Marina Heights. All Rights Reserved. &nbsp;&nbsp;|&nbsp;&nbsp; <a href="admin/admin_access.html">Admin Login</a></p>
            </div>
        </div>
    </footer>


<!-- Bootstrap JS Bundle (Include before </body>) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
let currentSlide = 0;
const slides = document.querySelectorAll('.slide');

function showNextSlide() {
  slides[currentSlide].classList.remove('active');
  currentSlide = (currentSlide + 1) % slides.length;
  slides[currentSlide].classList.add('active');
}

// 🔁 Start slideshow
setInterval(showNextSlide, 5000);
//Resident login 
document.getElementById('loginForm').addEventListener('submit', async function (e) {
    e.preventDefault();

    const login_id = document.getElementById('login_id').value;
    const password = document.getElementById('password').value;
    const remember = document.querySelector('input[name="remember"]').checked;

    const formData = new FormData();
    formData.append('login_id', login_id);
    formData.append('password', password);
    formData.append('remember', remember ? 'on' : '');

    try {
        const response = await fetch('loginprocess.php', {
            method: 'POST',
            body: formData
        });

        const result = await response.json();

        if (result.success) {
            // Redirect to dashboard
            window.location.href = 'resident_dashboard.php';
        } else {
            // Show error inside popup
            const errorDiv = document.getElementById('loginError');
            errorDiv.textContent = result.message || 'Login failed.';
            errorDiv.style.display = 'block';
        }
    } catch (err) {
        console.error('Error:', err);
        const errorDiv = document.getElementById('loginError');
        errorDiv.textContent = 'Something went wrong. Please try again.';
        errorDiv.style.display = 'block';
    }
});
//Visitor pass form pop up 
document.getElementById('visitorForm').addEventListener('submit', function(e) {
  e.preventDefault();

  const form = e.target;
  const formData = new FormData(form);

  fetch('submit_permission.php', {
    method: 'POST',
    body: formData
  })
  .then(res => res.json())
  .then(data => {
    if (data.success) {
      // Ensure modal exists
      const modalElement = document.getElementById('successModal');
      const successModal = new bootstrap.Modal(modalElement);
      document.getElementById('successModalMsg').textContent = "Visitor Pass submitted successfully!";
      successModal.show();
      form.reset();
    } else {
      alert("Failed to submit: " + (data.error || 'Unknown error'));
    }
  })
  .catch(error => {
    console.error('Error submitting form:', error);
  });
});
    // Toggle login popup
    const profilePic = document.getElementById("profile-pic");
    const popup = document.getElementById("login-popup");

    profilePic.addEventListener("click", () => {
        if (popup.classList.contains("show")) {
            popup.classList.remove("show");
            popup.classList.add("hide");
            setTimeout(() => {
                popup.style.display = "none";
                popup.classList.remove("hide");
            }, 500);
        } else {
            popup.style.display = "block";
            setTimeout(() => {
                popup.classList.add("show");
            }, 10);
        }
    });
    window.addEventListener("click", function (event) {
        const popup = document.getElementById("login-popup");
        const profilePic = document.getElementById("profile-pic");

        if (popup.classList.contains("show") &&
            !popup.contains(event.target) &&
            event.target !== profilePic) {
                
            popup.classList.remove("show");
            popup.classList.add("hide");

            setTimeout(() => {
                popup.style.display = "none";
                popup.classList.remove("hide");
            }, 500); 
        }
    });

    // Collapsible logic
    const collapsibles = document.querySelectorAll(".collapsible");
    collapsibles.forEach(btn => {
        btn.addEventListener("click", function () {
            const content = this.nextElementSibling;
            const arrow = this.querySelector(".arrow");
            const wasExpanded = content.classList.contains("expanded");

            content.classList.toggle("expanded");
            arrow.classList.toggle("rotate");
            setTimeout(() => {
                const yOffset = -100;
                let y;
                if (!wasExpanded) {
                   y = content.getBoundingClientRect().top + window.pageYOffset + yOffset;
                } else {
                   y = this.getBoundingClientRect().top + window.pageYOffset + yOffset;                 }
                window.scrollTo({ top: y, behavior: 'smooth' });
            }, 200); 
        });
    });

    // Visitor Section Toggle
    function scrollToSection(id) {
        const element = document.getElementById(id);
        if (element) {
            element.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    }
    function showFacilityFloor(floorId, tabElement) {
        document.querySelectorAll('.facility-tabs .tab').forEach(tab => tab.classList.remove('active-tab'));
        tabElement.classList.add('active-tab');
        const floors = document.querySelectorAll('.facility-floor');
        floors.forEach(floor => {
            floor.classList.remove('fade-in');
            floor.style.display = 'none';
            floor.style.opacity = 0;
            floor.style.transform = 'translateX(-20px)';
        });
        const selectedFloor = document.getElementById(`facility-${floorId}`);
        selectedFloor.style.display = 'block';
        setTimeout(() => {
            selectedFloor.classList.add('fade-in');
        }, 10);
        document.getElementById('img-ground').style.display = (floorId === 'ground') ? 'block' : 'none';
        document.getElementById('img-sixth').style.display = (floorId === 'sixth') ? 'block' : 'none';
    }
// Improved Visitor Popup with Animations
function toggleVisitorPopup() {
    const popup = document.getElementById("visitor-popup");
    
    if (popup.classList.contains("show")) {
        // Start hide animation
        popup.classList.remove("show");
        popup.classList.add("hide");
        
        // Remove after animation completes
        setTimeout(() => {
            popup.style.display = "none";
            popup.classList.remove("hide");
        }, 300); // Match CSS transition duration
    } else {
        // Show popup
        popup.style.display = "flex";
        popup.style.justifyContent = "center";
        popup.style.alignItems = "center";
        
        // Trigger animation after display is set
        setTimeout(() => {
            popup.classList.add("show");
        }, 10);
    }
}


// Close when clicking outside
document.addEventListener("click", function(e) {
    const popup = document.getElementById("visitor-popup");
    const content = document.querySelector(".visitor-popup-content");
    const visitBtn = document.querySelector('[onclick="toggleVisitorPopup()"]');
    
    if (popup.classList.contains("show") && 
        !content.contains(e.target) &&
        e.target !== visitBtn) {
        toggleVisitorPopup();
    }
});
let scale = 1;
let posX = 0;
let posY = 0;
let isDragging = false;
let startX = 0;
let startY = 0;

const modal = document.getElementById("image-modal");
const modalImg = document.getElementById("modal-img");

function updateTransform() {
  modalImg.style.transform = `translate(${posX}px, ${posY}px) scale(${scale})`;
}

function openImageModal(src) {
  modalImg.src = src;
  modal.style.display = "flex";
  requestAnimationFrame(() => {
    modal.classList.add("show");
  });
  document.body.style.overflow = "hidden";
  scale = 1;
  posX = 0;
  posY = 0;
  updateTransform();
  modalImg.style.cursor = "default";
}

function closeImageModal() {
  modal.classList.remove("show");
  modal.classList.add("hide");
  document.body.style.overflow = "";

  setTimeout(() => {
    modal.style.display = "none";
    modal.classList.remove("hide");
    scale = 1;
    posX = 0;
    posY = 0;
    updateTransform();
    modalImg.style.cursor = "default";
  }, 300); // match transition time
}

modalImg.addEventListener("wheel", (e) => {
  e.preventDefault();
  const delta = e.deltaY < 0 ? 0.1 : -0.1;
  scale = Math.min(Math.max(scale + delta, 1), 3);

  if (scale === 1) {
    posX = 0;
    posY = 0;
    modalImg.style.cursor = "default";
  } else {
    modalImg.style.cursor = "grab";
  }

  updateTransform();
}, { passive: false });

modalImg.addEventListener("mousedown", (e) => {
  if (e.button !== 0 || scale === 1) return;
  isDragging = true;
  startX = e.clientX - posX;
  startY = e.clientY - posY;
  modalImg.style.cursor = "grabbing";
  e.preventDefault();
});

window.addEventListener("mouseup", (e) => {
  if (e.button !== 0) return;
  isDragging = false;
  modalImg.style.cursor = scale > 1 ? "grab" : "default";
});

window.addEventListener("mousemove", (e) => {
  if (!isDragging) return;
  posX = e.clientX - startX;
  posY = e.clientY - startY;
  updateTransform();
});

modalImg.addEventListener("mouseleave", () => {
  if (isDragging) {
    isDragging = false;
    modalImg.style.cursor = scale > 1 ? "grab" : "default";
  }
});

modalImg.addEventListener("dblclick", () => {
  scale = 1;
  posX = 0;
  posY = 0;
  updateTransform();
  modalImg.style.cursor = "default";
});

modalImg.addEventListener("click", (e) => {
  e.stopPropagation();
});
function showFloorPlan(type, tabElement) {
  document.querySelectorAll('.floor-tabs .tab').forEach(tab => tab.classList.remove('active-tab'));
  tabElement.classList.add('active-tab');

  const allPlans = ['a', 'b', 'c'];
  allPlans.forEach(p => {
    const img = document.getElementById(`floor-plan-${p}`);
    img.style.display = 'none';
    img.classList.remove('fade-in');
    img.style.opacity = 0;
    img.style.transform = 'translateX(-20px)';
  });

  const selectedImg = document.getElementById(`floor-plan-${type}`);
  selectedImg.style.display = 'inline-block';
  setTimeout(() => {
    selectedImg.classList.add('fade-in');
    selectedImg.style.opacity = 1;
    selectedImg.style.transform = 'translateX(0)';
  }, 10);
}
function showParkingLot(type, tabElement) {
  document.querySelectorAll('.floor-tabs .tab').forEach(tab => tab.classList.remove('active-tab'));
  tabElement.classList.add('active-tab');

  const allLots = ['m1', 'm2', 'm3'];
  allLots.forEach(lot => {
    const section = document.getElementById(`parking-lot-${lot}`);
    if (section) {
      section.style.display = 'none';
      section.classList.remove('fade-in');
    }
  });

  const selectedLot = document.getElementById(`parking-lot-${type}`);
  if (selectedLot) {
    selectedLot.style.display = 'block';
    setTimeout(() => {
      selectedLot.classList.add('fade-in');
    }, 10);
  }
}
function showLogoPopup() {
    const popup = document.getElementById("logo-popup");
    popup.style.display = "flex";
    setTimeout(() => {
        popup.classList.add("show");
    }, 10);
}

function closeLogoPopup() {
    const popup = document.getElementById("logo-popup");
    popup.classList.remove("show");
    setTimeout(() => {
        popup.style.display = "none";
    }, 300);
}

// Close when clicking outside the logo
document.addEventListener("click", function(e) {
    const popup = document.getElementById("logo-popup");
    if (popup.classList.contains("show") && 
        !e.target.closest(".logo-popup-content") && 
        e.target !== document.querySelector(".navbar .logo")) {
        closeLogoPopup();
    }
});
document.addEventListener('DOMContentLoaded', function() {
  const navButton = document.querySelector('.nav-btn');
  const aboutMapSection = document.getElementById('about-map');

  if (navButton && aboutMapSection) {
    navButton.addEventListener('click', function(event) {
      event.preventDefault(); // Good practice to prevent any default link behavior
      aboutMapSection.scrollIntoView({ behavior: 'smooth' });
    });
  }
});
// Toggle register popup
function toggleRegisterPopup() {
    const registerPopup = document.getElementById("register-popup");
    const loginPopup = document.getElementById("login-popup");
    
    if (registerPopup.classList.contains("show")) {
        closeRegisterPopup();
    } else {
        // Close login popup if open
        if (loginPopup.classList.contains("show")) {
            loginPopup.classList.remove("show");
            loginPopup.classList.add("hide");
            setTimeout(() => {
                loginPopup.style.display = "none";
                loginPopup.classList.remove("hide");
            }, 300);
        }
        
        // Show register popup
        registerPopup.style.display = "block";
        setTimeout(() => {
            registerPopup.classList.add("show");
        }, 10);
    }
}

// Close register popup
function closeRegisterPopup() {
    const registerPopup = document.getElementById("register-popup");
    registerPopup.classList.remove("show");
    registerPopup.classList.add("hide");
    setTimeout(() => {
        registerPopup.style.display = "none";
        registerPopup.classList.remove("hide");
    }, 300);
}

// Toggle login popup from register popup
function toggleLoginFromRegister() {
    closeRegisterPopup();
    
    // Show login popup
    const loginPopup = document.getElementById("login-popup");
    loginPopup.style.display = "block";
    setTimeout(() => {
        loginPopup.classList.add("show");
    }, 10);
}

// Close when clicking outside
document.addEventListener("click", function(e) {
    const registerPopup = document.getElementById("register-popup");
    const registerContent = document.querySelector("#register-popup .login-popup-container");
    const registerLink = document.querySelector('[onclick="toggleRegisterPopup()"]');
    
    if (registerPopup.classList.contains("show") && 
        !registerContent.contains(e.target) &&
        e.target !== registerLink) {
        closeRegisterPopup();
    }
});
document.getElementById('register-form').addEventListener('submit', function(e) {
  e.preventDefault();

  const form = this;
  const formData = new FormData(form);

  const email = formData.get('email').trim();
  const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

  // 🛑 Frontend validation for email format
  if (!emailPattern.test(email)) {
    const invalidEmailModal = new bootstrap.Modal(document.getElementById('invalidEmailModal'));
    invalidEmailModal.show();
    return;
  }

  // ✅ Submit form via fetch
  fetch('registerprocess.php', {
    method: 'POST',
    body: formData
  })
  .then(res => res.json())
  .then(data => {
    if (data.success) {
      const successModal = new bootstrap.Modal(document.getElementById('registerSuccessModal'));
      successModal.show();
      form.reset();
    } else if (data.msg.includes("already registered")) {
      const duplicateModal = new bootstrap.Modal(document.getElementById('duplicateEmailModal'));
      duplicateModal.show();
    } else if (data.msg.includes("Invalid email format")) {
      const invalidEmailModal = new bootstrap.Modal(document.getElementById('invalidEmailModal'));
      invalidEmailModal.show();
    } else {
      // fallback alert
      alert(data.msg);
    }
  })
  .catch(err => {
    console.error(err);
    alert("Network error. Please try again.");
  });
});

</script>
</body>
</html>