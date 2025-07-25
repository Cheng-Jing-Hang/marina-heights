<?php
session_start();
$firstName = $_SESSION['first_name'] ?? 'Resident';
require_once __DIR__ . '/admin/Menus/db/connect.php'; // Adjust path as needed

// Fetch latest 3 notices
$stmt = $conn->prepare("SELECT id, title, content, posted_at FROM notices ORDER BY posted_at DESC LIMIT 3");
$stmt->execute();
$result = $stmt->get_result();

$notices = [];
while ($row = $result->fetch_assoc()) {
    $notices[] = $row;  // you can store whole row as is
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resident Dashboard - Marina Heights</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Times+New+Roman&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        /* --- USER'S ORIGINAL NAVBAR CSS - FONT ADJUSTED FOR GLOBAL CHANGE --- */
        body {
            /* Using Times New Roman globally as requested */
            font-family: 'Times New Roman', Times, serif;
            padding: 0;
            margin: 0;
            background-color: #f8fafc; /* A lighter, cleaner gray from Tailwind */
            color: #1e293b; /* A softer black from Tailwind */
        }
        
        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #003366;
            color: white;
            padding: 10px 20px;
            position: relative;
        }
        
        .home-btn {
            color: white;
            font-weight: bold;
            text-decoration: none;
            font-size: 1.1em;
            position: relative;
            padding: 15px 0;
            transition: all 0.3s ease;
        }
        
        .home-btn::after {
            content: '';
            position: absolute;
            bottom: 10px;
            left: 0;
            width: 0;
            height: 2px;
            background-color: white;
            transition: width 0.3s ease;
        }
        .home-btn:hover {
            transform: scale(1.05);
        }         
        .home-btn:hover::after {
            width: 100%;
        }
        
        .nav-center {
            display: flex;
            justify-content: center;
            flex-grow: 1;
        }
        
        .nav-menu {
            display: flex;
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .nav-item {
            position: relative;
            margin: 0 15px;
        }
        
        .nav-btn {
            background: none;
            border: none;
            color: white;
            font-weight: bold;
            padding: 15px 0;
            font-size: 1em;
            cursor: pointer;
            position: relative;
            transition: all 0.3s ease;
            /* Font family is now inherited from the body for consistency */
        }
        
        .nav-btn::after {
            content: '';
            position: absolute;
            bottom: 10px;
            left: 0;
            width: 0;
            height: 2px;
            background-color: white;
            transition: width 0.3s ease;
        }
        
        .nav-btn:hover {
            transform: scale(1.05);
        }
        
        .nav-btn:hover::after {
            width: 100%;
        }
        
        .arrow {
            margin-left: 8px;
            position: relative;
            width: 12px;
            height: 8px;
            display: inline-flex;
            align-items: center;
        }
        
        .arrow::before {
            content: "";
            position: absolute;
            top: 50%;
            left: 0;
            width: 8px;
            height: 8px;
            border-left: 2px solid white;
            border-bottom: 2px solid white;
            transform: translateY(-65%) rotate(-45deg);
            transition: all 0.3s ease;
        }
        
        .dropdown-container {
            position: absolute;
            width: 100%;
            left: 0;
            z-index: 100;
            padding-top: 10px;
        }
        
        .dropdown-box {
            background-color: white;
            width: 250px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            border-radius: 8px;
            padding: 10px 0;
            transform: translateY(-20px);
            opacity: 0;
            transition: all 0.3s ease;
            pointer-events: none;
        }
        
        .dropdown-item {
            padding: 12px 20px;
            color: #333;
            text-decoration: none;
            display: block;
            transition: all 0.2s ease;
            border-bottom: 1px solid #eee;
            white-space: normal;
            word-wrap: break-word;
            overflow-wrap: break-word;
        }
        
        .dropdown-item:hover {
            background-color: #f5f5f5;
            padding-left: 25px;
            font-weight: bold;
            color: #000;
        }
        
        .dropdown-item.logout {
            color: #e74c3c;
            font-weight: bold;
        }
        
        .nav-item.active .arrow::before {
            transform: translateY(-35%) rotate(135deg);
        }
        
        .nav-item.active .dropdown-box {
            max-height: 500px;
            padding: 10px 0;
            transition: all 0.4s cubic-bezier(0.65, 0, 0.35, 1);
            pointer-events: auto;
        }
        
        .nav-item.active .dropdown-box {
            transform: translateY(0);
            opacity: 1;
        }
        
        .profile-container {
            display: flex;
            align-items: center;
            position: relative;
        }
        
        .profile-img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            cursor: pointer;
            transition: transform 0.3s ease;
        }
        
        .profile-img:hover {
            transform: scale(1.1);
        }
        
        .profile-arrow {
            margin-left: 8px;
            position: relative;
            width: 12px;
            height: 8px;
            display: flex;
            align-items: center;
        }
        
        .profile-arrow::before {
            content: "";
            position: absolute;
            top: 50%;
            left: 0;
            width: 8px;
            height: 8px;
            border-left: 2px solid white;
            border-bottom: 2px solid white;
            transform: translateY(-65%) rotate(-45deg);
            transition: all 0.3s ease;
        }
        
        .profile-dropdown-container {
            position: absolute;
            right: 0;
            top: calc(100% + 15px);;
            z-index: 100;
            padding-top: 0px;
            overflow: hidden;
            max-height: 0;
            transition: max-height 0.5s ease;
        }
        
        .profile-dropdown {
            background-color: white;
            width: 200px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            border-radius: 8px;
            padding: 0;
            max-height: 0;
            overflow: hidden;
            transform-origin: top;
            transition: all 0.4s cubic-bezier(0.65, 0, 0.35, 1);
        }
        
        .profile-container.active .profile-arrow::before {
            transform: translateY(-35%) rotate(135deg);
        }
        
        .profile-container.active .profile-dropdown-container {
            max-height: 500px;
        }
        
        .profile-container.active .profile-dropdown {
            max-height: 500px; 
            padding: 10px 0;
            transition: all 0.4s cubic-bezier(0.65, 0, 0.35, 1);
        }
        /* --- END OF UNTOUCHED NAVBAR CSS --- */

        /* --- NEW MODAL CSS --- */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.6);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s ease, visibility 0.3s ease;
        }

        .modal-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        .modal-container {
            background-color: white;
            padding: 2rem;
            border-radius: 0.75rem; /* Tailwind: rounded-xl */
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2); /* Tailwind: shadow-2xl */
            max-width: 90%;
            width: 500px;
            position: relative;
            transform: scale(0.9);
            opacity: 0;
            transition: transform 0.3s ease, opacity 0.3s ease;
        }

        .modal-overlay.active .modal-container {
            transform: scale(1);
            opacity: 1;
        }

        .modal-close-btn {
            position: absolute;
            top: 1rem;
            right: 1rem;
            background: none;
            border: none;
            font-size: 1.5rem;
            color: #64748B; /* slate-500 */
            cursor: pointer;
            transition: color 0.2s ease;
        }

        .modal-close-btn:hover {
            color: #1E293B; /* slate-900 */
        }

        .modal-content {
            margin-top: 1rem;
            /* Add any specific content styling here */
        }

        /* Styles for the "Log Out" link within the profile dropdown */
        .profile-dropdown .dropdown-item.logout {
            color: #e74c3c;
        }

        /* Specific styles for modal form elements */
        .modal-form label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: bold;
            color: #334155; /* slate-700 */
        }

        .modal-form input[type="text"],
        .modal-form input[type="email"],
        .modal-form input[type="date"],
        .modal-form textarea,
        .modal-form select {
            width: 100%;
            padding: 0.75rem;
            margin-bottom: 1rem;
            border: 1px solid #CBD5E1; /* slate-300 */
            border-radius: 0.375rem; /* rounded-md */
            box-sizing: border-box;
            font-family: inherit;
        }

        .modal-form button {
            background-color: #003366;
            color: white;
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 0.375rem;
            cursor: pointer;
            transition: background-color 0.2s ease;
        }

        .modal-form button:hover {
            background-color: #002244;
        }
        .navbar img.logo {
            height: 40px;
            border-radius: 50%; 
            object-fit: cover; 
            border: 2px solid white;
            padding: 2px;
        }
.logo-hover {
    display: inline-block;
    transition: transform 0.3s ease;
    transform-origin: center;
}

.logo-hover:hover {
    transform: scale(1.2);
}

.logo-popup {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.8);
    z-index: 1001;
    justify-content: center;
    align-items: center;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.logo-popup.show {
    display: flex;
    opacity: 1;
}

.logo-popup-content {
    position: relative;
    padding: 20px;
    max-width: 80%;
    max-height: 80%;
    text-align: center;
}

.logo-large {
    max-width: 100%;
    max-height: 80vh;
    object-fit: contain;
    border-radius: 8px;
}
        .close-logo {
            position: absolute;
            top: -15px;
            right: -15px;
            color: white;
            font-size: 35px;
            font-weight: bold;
            cursor: pointer;
            background: #003366;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
        }

        .close-logo:hover {
            background: #004080;
        }
.hidden {
  display: none;
}
    </style>
</head>
<body class="bg-slate-100">

<div class="top-bar">
    <a href="#" onclick="showLogoPopup(); return false;" class="logo-hover"><img src="Image/logo.png" alt="Marina Heights Logo" class="logo" style="height: 40px; border-radius: 50%; object-fit: cover; border: 2px solid white; padding: 2px;"></a>
    <div id="logo-popup" class="logo-popup">
        <div class="logo-popup-content">
            <span class="close-logo" onclick="closeLogoPopup()">&times;</span>
            <img src="Image/logo.png" alt="Marina Heights Logo" class="logo-large">
        </div>
    </div>
    <div class="nav-center">
        <ul class="nav-menu">
            <li class="nav-item" id="servicesItem">
                <button class="nav-btn">
                    Services
                    <span class="arrow"></span>
                </button>
                <div class="dropdown-container">
                    <div class="dropdown-box">
                        <a href="#" class="dropdown-item" data-modal-target="bookingModal">Booking&nbsp;&nbsp;<i class="bi bi-pen"></i></a>
                    </div>
                </div>
            </li>
            <li class="nav-item" id="financeItem">
                <button class="nav-btn">
                    Finance
                    <span class="arrow"></span>
                </button>
                <div class="dropdown-container">
                    <div class="dropdown-box">
                        <a href="#" class="dropdown-item" data-modal-target="managementFeeModal">Management Fee&nbsp;&nbsp;<i class="bi bi-cash-coin"></i></a>
                    </div>
                </div>
            </li>
            <li class="nav-item" id="generalItem">
                <button class="nav-btn">
                    General
                    <span class="arrow"></span>
                </button>
                <div class="dropdown-container">
                    <div class="dropdown-box">
                        <a href="#" class="dropdown-item" data-modal-target="reportModal">Report&nbsp;&nbsp;<i class="bi bi-flag"></i></a>
                    </div>
                </div>
            </li>
        </ul>
    </div>

    <div class="profile-container" id="profileContainer">
        <img src="Image/Visitor Page/Icons/profile.png" alt="Profile Picture" class="profile-img" id="profilePic" onerror="this.onerror=null;this.src='https://placehold.co/100x100/E2E8F0/475569?text=P';">
        <span class="profile-arrow"></span>
        <div class="profile-dropdown-container">
            <div class="profile-dropdown">
                <a href="#" class="dropdown-item" data-modal-target="accountSettingsModal">Privacy & Account Settings &nbsp;&nbsp;</a>
                <a href="#" class="dropdown-item logout" data-modal-target="logoutModal">Log Out&nbsp;&nbsp;<i class="bi bi-box-arrow-left"></i></a>
            </div>
        </div>
    </div>
</div>
<main class="px-4 sm:px-6 lg:px-8 py-8">
    <div class="max-w-7xl mx-auto">
        
        <div class="text-center mb-8">
              <h1 class="text-2xl sm:text-3xl font-bold text-slate-800">
    Welcome, <span class="text-blue-900"><?= htmlspecialchars($firstName) ?></span>
  </h1>
            <p class="mt-2 text-slate-500">Your central hub for everything at Marina Heights.</p>
        </div>

        <div class="text-center my-8 p-8 bg-gradient-to-r from-blue-900 to-[#003366] rounded-xl shadow-lg">
            <h2 class="text-4xl sm:text-5xl font-extrabold text-white tracking-tight">Marina Heights</h2>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
<div id="notices" class="lg:col-span-2 bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition-shadow duration-300">
    <a href="/admin/Menus/noticeboard.php" class="block">
        <h3 class="text-xl font-bold text-slate-700 mb-4 flex items-center hover:text-blue-800 transition-colors duration-200">
            <i class="bi bi-pin-angle-fill mr-3 text-blue-800"></i>Notice Board
        </h3>
    </a>
    <div class="space-y-4" id="notice-board-content">
        <?php if (count($notices) === 0): ?>
            <p class="text-slate-500">No new notices at the moment.</p>
        <?php else: ?>
            <?php foreach ($notices as $notice): ?>
                <div class="notice-item mb-4">
                    <h4 class="font-semibold text-blue-800"><?= htmlspecialchars($notice['title']) ?></h4>
                    <small class="text-gray-500"><?= date('M d, Y', strtotime($notice['posted_at'])) ?></small>
                    <p class="text-slate-700 mt-1"><?= nl2br(htmlspecialchars(substr($notice['content'], 0, 150))) ?><?= strlen($notice['content']) > 150 ? '...' : '' ?></p>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>


            <div id="calendar" class="bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition-shadow duration-300">
                <h3 id="calendar-title" class="text-xl font-bold text-slate-700 mb-4 text-center">📅 July 2024</h3>
                <table class="w-full text-sm text-center">
                    <thead>
                        <tr class="text-slate-600">
                            <th class="py-2">Sun</th>
                            <th class="py-2">Mon</th>
                            <th class="py-2">Tue</th>
                            <th class="py-2">Wed</th>
                            <th class="py-2">Thu</th>
                            <th class="py-2">Fri</th>
                            <th class="py-2">Sat</th>
                        </tr>
                    </thead>
                    <tbody id="calendar-body" class="text-slate-700">
                        <tr>
                            <td class="py-2 text-slate-400">30</td>
                            <td class="py-2">1</td>
                            <td class="py-2">2</td>
                            <td class="py-2">3</td>
                            <td class="py-2">4</td>
                            <td class="py-2">5</td>
                            <td class="py-2">6</td>
                        </tr>
                        <tr>
                            <td class="py-2">7</td>
                            <td class="py-2">8</td>
                            <td class="py-2">9</td>
                            <td class="py-2">10</td>
                            <td class="py-2">11</td>
                            <td class="py-2">12</td>
                            <td class="py-2 bg-blue-500 text-white font-bold rounded-full">13</td>
                        </tr>
                        <tr>
                            <td class="py-2">14</td>
                            <td class="py-2">15</td>
                            <td class="py-2">16</td>
                            <td class="py-2">17</td>
                            <td class="py-2">18</td>
                            <td class="py-2">19</td>
                            <td class="py-2">20</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>

<footer class="bg-[#003366] text-white mt-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="text-center md:text-left">
                <h3 class="font-bold text-lg mb-2">Marina Heights</h3>
                <p class="text-sm text-slate-300">Luxury living with a community focus. We are dedicated to providing the best resident experience.</p>
            </div>
            <div class="text-center">
                <h3 class="font-bold text-lg mb-2">Quick Links</h3>
                <ul class="space-y-1">
                    <li><a href="#" class="text-sm text-slate-300 hover:text-white transition-colors" data-modal-target="bookingModal">Booking</a></li>
                    <li><a href="#" class="text-sm text-slate-300 hover:text-white transition-colors" data-modal-target="managementFeeModal">Management Fee</a></li>
                    <li><a href="#" class="text-sm text-slate-300 hover:text-white transition-colors" data-modal-target="reportModal">Report an Issue</a></li>
                </ul>
            </div>
            <div class="text-center md:text-right">
                <h3 class="font-bold text-lg mb-2">Contact Us</h3>
                <p class="text-sm text-slate-300">123 Marina Drive, 11200</p>
                <p class="text-sm text-slate-300">marina-heights@hotmail.com</p>
                <div class="flex justify-center md:justify-end space-x-4 mt-4">
                    <a href="#" class="text-slate-300 hover:text-white transition-colors"><i class="bi bi-facebook text-xl"></i></a>
                    <a href="#" class="text-slate-300 hover:text-white transition-colors"><i class="bi bi-instagram text-xl"></i></a>
                </div>
            </div>
        </div>
        <div class="border-t border-slate-500 mt-8 pt-6 text-center text-sm text-slate-400">
            <p>&copy; 2025 Marina Heights. All Rights Reserved. &nbsp;&nbsp;|&nbsp;&nbsp; <a href="admin/admin_access.html" class="hover:text-white transition-colors">Admin Login</a></p>
        </div>
    </div>
</footer>

<div class="modal-overlay" id="modalOverlay">
<div id="bookingModal" class="modal-container hidden">
  <button class="modal-close-btn" data-close-modal>&times;</button>
  <h2 class="text-2xl font-bold text-slate-800 mb-4">Book a Facility</h2>
  <div class="modal-content">
<form class="modal-form" id="bookingForm">
  <label for="bookingFacility">Facility:</label>
  <select id="bookingFacility" name="facility" required onchange="onFacilityChange()">
    <option value="">Select Facility</option>
    <option value="multi_purpose_hall">Multi-purpose Hall (RM500 per use)</option>
    <option value="game_room">Game Room (RM20/hr)</option>
    <option value="bbq_area">BBQ Area (RM500 refundable deposit)</option>
    <option value="basketball_court">Basketball Court (RM10/hr)</option>
    <option value="pickleball_court">Pickleball Court (RM15/hr)</option>
  </select>

  <label for="bookingDate">Date:</label>
  <input type="date" id="bookingDate" name="date" required />

  <div id="hoursContainer" style="display:none;">
    <label for="bookingHours">Number of Hours:</label>
    <input type="number" id="bookingHours" name="hours" min="1" value="1" onchange="updatePaymentAmount()" required />
    <br /><br />
  </div>
   
  <label for="paymentAmount">Payment Amount (RM):</label>
  <input type="text" id="paymentAmount" name="paymentAmount" readonly />

  <label for="paymentMethod">Payment Method:</label>
  <select id="paymentMethod" name="paymentMethod" required>
    <option value="" disabled selected>Select a payment method</option>
    <option value="credit_card">Credit Card</option>
    <option value="online_bank_transfer">Online Bank Transfer</option>
    <option value="e_wallet">E-Wallet (e.g. Touch 'n Go, GrabPay)</option>
  </select>

  <button type="submit">Submit Booking</button>
</form>
  </div>
</div>

    <div id="managementFeeModal" class="modal-container hidden">
        <button class="modal-close-btn" data-close-modal>&times;</button>
        <h2 class="text-2xl font-bold text-slate-800 mb-4">Management Fee Details</h2>
        <div class="modal-content">
            <p class="text-slate-600 mb-4"> Your current outstanding balance is: 
                <strong class="text-red-600">RM <span id="outstandingAmount">0.00</span></strong>
            </p>
            <p class="text-slate-600 mb-4">Next due date: 
                <strong><span id="nextDueDate">-</span></strong>
            </p>
            <form id="managementFeeForm" class="modal-form">
                <label for="paymentAmount">Payment Amount:</label>
                <input type="text" id="paymentAmount" name="amount" placeholder="e.g., 450.00" pattern="^\d+(\.\d{1,2})?$" inputmode="decimal" required required>
                <label for="paymentMethod">Payment Method:</label>
                <select id="paymentMethod" name="method" required>
                    <option value="">Select Method</option>
                    <option value="credit_card">Credit Card</option>
                    <option value="bank_transfer">Online Bank Transfer</option>
                </select>
                <button type="submit">Proceed to Payment</button>
            </form>
        </div>
    </div>

    <div id="paymentHistoryModal" class="modal-container hidden">
        <button class="modal-close-btn" data-close-modal>&times;</button>
        <h2 class="text-2xl font-bold text-slate-800 mb-4">Payment History</h2>
        <div class="modal-content">
            <ul class="list-disc pl-5 text-slate-700">
                <li class="mb-2"><strong>July 1, 2024:</strong> RM 450.00 (Paid)</li>
                <li class="mb-2"><strong>June 1, 2024:</strong> RM 450.00 (Paid)</li>
                <li class="mb-2"><strong>May 1, 2024:</strong> RM 450.00 (Paid)</li>
                <li class="mb-2 text-red-600"><strong>April 1, 2024:</strong> RM 450.00 (Overdue)</li>
            </ul>
            <p class="mt-4 text-slate-500">For a full detailed statement, please contact the management office.</p>
        </div>
    </div>

    <div id="maintenanceScheduleModal" class="modal-container hidden">
        <button class="modal-close-btn" data-close-modal>&times;</button>
        <h2 class="text-2xl font-bold text-slate-800 mb-4">Upcoming Maintenance Schedule</h2>
        <div class="modal-content">
            <ul class="list-disc pl-5 text-slate-700">
                <li class="mb-2"><strong>Aug 5, 2024:</strong> Elevator Maintenance (Block A, 9 AM - 1 PM)</li>
                <li class="mb-2"><strong>Aug 10, 2024:</strong> Pool Cleaning (All Day)</li>
                <li class="mb-2"><strong>Sep 1, 2024:</strong> Fire Alarm System Check (All Blocks, 10 AM - 4 PM)</li>
            </ul>
            <p class="mt-4 text-slate-500">Scheduled maintenance helps keep our facilities in top condition. Thank you for your cooperation.</p>
        </div>
    </div>

    <div id="votingModal" class="modal-container hidden">
        <button class="modal-close-btn" data-close-modal>&times;</button>
        <h2 class="text-2xl font-bold text-slate-800 mb-4">Current Voting Polls</h2>
        <div class="modal-content">
            <p class="text-slate-600 mb-4">No active voting polls at the moment.</p>
            <p class="text-slate-500">Please check back later for new community polls or proposals.</p>
        </div>
        </div>
    
    <div id="reportModal" class="modal-container hidden">
        <button class="modal-close-btn" data-close-modal>&times;</button>
        <h2 class="text-2xl font-bold text-slate-800 mb-4">Report an Issue</h2>
        <div class="modal-content">
            <form id="reportForm" class="modal-form">
  <label for="issueType">Type of Issue:</label>
  <select id="issueType" name="type" required onchange="handleIssueTypeChange()">
      <option value="">Select Type</option>
      <option value="plumbing">Plumbing</option>
      <option value="electrical">Electrical</option>
      <option value="security">Security</option>
      <option value="common_area">Common Area</option>
      <option value="other">Other</option>
  </select>

  <div id="otherTitleContainer" class="hidden">
    <label for="otherTitle">Please specify the issue title:</label>
    <input type="text" id="otherTitle" name="otherTitle" placeholder="Enter issue title" />
  </div>

  <label for="issueDescription">Description:</label>
  <textarea id="issueDescription" name="description" rows="5" required></textarea>

  <button type="submit">Submit Report</button>
</form>


    </div>
</div>


<!-- ✅ Account settings modal -->
<div id="accountSettingsModal" class="modal-container hidden">
  <button class="modal-close-btn" data-close-modal>&times;</button>
  <h2 class="text-2xl font-bold text-slate-800 mb-4">Account Settings</h2>
  <form id="accountSettingsForm" class="modal-form">
    <label for="residentEmail">Email:</label>
    <input type="email" id="residentEmail" name="email" required autocomplete="email" class="form-control mb-2">

    <label for="residentUnit">Unit No.:</label>
    <input type="text" id="residentUnit" name="unit_number" required autocomplete="off" class="form-control mb-2">

    <label for="residentPassword">New Password:</label>
    <input type="password" id="residentPassword" name="password" placeholder="Leave blank to keep current" autocomplete="new-password" class="form-control mb-2">

    <button type="submit" class="btn btn-primary mt-4">Save Changes</button>
  </form>
</div>




    <div id="logoutModal" class="modal-container hidden">
        <button class="modal-close-btn" data-close-modal>&times;</button>
        <h2 class="text-2xl font-bold text-slate-800 mb-4">Confirm Log Out?</h2>
        <div class="modal-content">
            <p class="text-slate-600 mb-6">Are you sure you want to log out of your account?</p>
            <div class="flex justify-end space-x-4">
                <button class="px-4 py-2 rounded-md border border-slate-300 text-slate-700 hover:bg-slate-100" onclick="closeModal()">Cancel</button>
                <button class="px-4 py-2 rounded-md bg-red-600 text-white hover:bg-red-700" onclick="performLogout()">Log Out</button>
            </div>
        </div>
    </div>
</div>

<!-- Success Modal for Booking -->
<div class="modal fade" id="bookingSuccessModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 rounded-4 shadow-sm">
      <div class="modal-body text-center p-4">
        <div class="display-4 text-success mb-2"><i class="bi bi-check-circle-fill"></i></div>
        <h5 class="mb-0 fw-semibold">Booking submitted successfully!</h5>
      </div>
    </div>
  </div>
</div>

<!-- Success Modal for Payment -->
<div class="modal fade" id="paidSuccessModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 rounded-4 shadow-sm">
      <div class="modal-body text-center p-4">
        <div class="display-4 text-success mb-2"><i class="bi bi-check-circle-fill"></i></div>
        <h5 class="mb-0 fw-semibold">Management fee paid successfully!</h5>
      </div>
    </div>
  </div>
</div>

<!-- Success Modal for Account Settings -->
<div class="modal fade" id="accountSuccessModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 rounded-4 shadow-sm">
      <div class="modal-body text-center p-4">
        <div class="display-4 text-success mb-2"><i class="bi bi-check-circle-fill"></i></div>
        <h5 class="mb-0 fw-semibold">Account edited successfully!</h5>
      </div>
    </div>
  </div>
</div>

<!-- Success Modal for Reports -->
<div class="modal fade" id="reportSuccessModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 rounded-4 shadow-sm">
      <div class="modal-body text-center p-4">
        <div class="display-4 text-success mb-2"><i class="bi bi-check-circle-fill"></i></div>
        <h5 class="mb-0 fw-semibold">Report submitted successfully!</h5>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
// 🧠 Global initializer after DOM is ready (only runs once)
document.addEventListener('DOMContentLoaded', () => {
  initStaticListeners();
});

// 🛠 Called AFTER a page is dynamically loaded with loadPage()
function initDynamicPageScripts() {
  initManagementFeeForm();
  initAccountSettingsForm();
  initManagementFeeModal();
}

// ✅ This runs once: static event listeners
function initStaticListeners() {
  // Management Fee modal
  const managementFeeModal = document.getElementById('managementFeeModal');
  if (managementFeeModal) {
    managementFeeModal.addEventListener('show.bs.modal', () => {
      fetch('get_maintenance_fees.php')
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            document.getElementById('outstandingAmount').textContent = parseFloat(data.total_due).toFixed(2);
            document.getElementById('nextDueDate').textContent = data.next_due ? formatDate(data.next_due) : '-';
          } else {
            console.error('Failed to fetch maintenance fees:', data.error);
          }
        })
        .catch(error => {
          console.error('Error fetching maintenance fees:', error);
        });

      // 🟢 INIT the form only when modal opens
      initManagementFeeForm();
    });
  }

  // Account Settings modal
  const accountSettingsModal = document.getElementById('accountSettingsModal');
  if (accountSettingsModal) {
    accountSettingsModal.addEventListener('show.bs.modal', () => {
      // 🟢 INIT the form only when modal opens
      initAccountSettingsForm();
    });
  }
}


// ✅ Initializes management fee form
function initManagementFeeForm() {
  const managementFeeForm = document.getElementById('managementFeeForm');
  if (managementFeeForm) {
    managementFeeForm.addEventListener('submit', function(event) {
      event.preventDefault();
      const formData = new FormData(managementFeeForm);

      fetch('submit_maintenance_fees.php', {
        method: 'POST',
        body: formData
      })
      .then(response => response.json())
      .then(result => {
        if (result.success) {
          const successModal = new bootstrap.Modal(document.getElementById('paidSuccessModal'));
          successModal.show();
          managementFeeForm.reset();
          closeModal();
        } else {
          alert('Payment failed: ' + (result.error || 'Unknown error'));
        }
      })
      .catch(error => {
        alert('Error submitting payment: ' + error.message);
      });
    });
  }
}

// ✅ Initializes account settings form
function initAccountSettingsForm() {
  const accountSettingsForm = document.getElementById('accountSettingsForm');
  if (accountSettingsForm) {
    accountSettingsForm.addEventListener('submit', function(event) {
      event.preventDefault();
      const formData = new FormData(accountSettingsForm);

      fetch('update_account_settings.php', {
        method: 'POST',
        body: formData
      })
      .then(response => response.json())
      .then(result => {
        if (result.success) {
          const successModal = new bootstrap.Modal(document.getElementById('accountSuccessModal'));
          successModal.show();
          accountSettingsForm.reset();
          closeModal();
        } else {
          alert('Update failed: ' + (result.error || 'Unknown error'));
        }
      })
      .catch(error => {
        alert('Error updating account: ' + error.message);
      });
    });
  }
}

// 📅 Optional date formatter
function formatDate(isoDate) {
  const options = { year: 'numeric', month: 'long', day: 'numeric' };
  const dateObj = new Date(isoDate);
  return dateObj.toLocaleDateString(undefined, options);
}


//REPORTS FORM
document.addEventListener("DOMContentLoaded", function () {
  const reportForm = document.getElementById("reportForm");

  if (reportForm) {
    reportForm.addEventListener("submit", function (event) {
      event.preventDefault();

      const form = event.target;

      const data = {
  type: form.type.value,
  otherTitle: form.otherTitle ? form.otherTitle.value : '',
  description: form.description.value
};

console.log("Form data:", data); // 👈 ADD THIS

      fetch('/submit_report.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
      })
      .then(response => {
        if (!response.ok) throw new Error(`HTTP error! Status: ${response.status}`);
        return response.json();
      })
      .then(result => {
        if (result.success) {
          // Show the success modal
          const modal = new bootstrap.Modal(document.getElementById('reportSuccessModal'));
          modal.show();
          form.reset();
          document.getElementById('otherTitleLabel').classList.add('hidden');
          document.getElementById('otherTitle').classList.add('hidden');
        } else {
          alert('Failed to submit report: ' + (result.error || 'Unknown error'));
        }
      })
      .catch(error => {
        console.error('Error submitting report:', error);
        alert('An error occurred while submitting your report.');
      });
    });
  }
});
//BOOKING FACILITIES FORM
document.addEventListener("DOMContentLoaded", function () {
  const bookingForm = document.getElementById("bookingForm");

  if (bookingForm) {
    bookingForm.addEventListener("submit", function (event) {
      event.preventDefault();

      const form = event.target;

      const data = {
        facility: form.facility.value,
        date: form.date.value,
        hours: form.hours ? parseInt(form.hours.value) : 1,
        paymentAmount: form.paymentAmount.value,
        paymentMethod: form.paymentMethod.value
      };

      fetch('/submit_booking.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
      })
      .then(response => {
        if (!response.ok) {
          throw new Error(`HTTP error! Status: ${response.status}`);
        }
        return response.json();
      })
      .then(result => {
        if (result.success) {
          // Show the success modal
          const successModal = new bootstrap.Modal(document.getElementById('bookingSuccessModal'));
          successModal.show();

          // Reset form
          form.reset();
          document.getElementById('hoursContainer').style.display = 'none';
          document.getElementById('paymentAmount').value = '';
        } else {
          alert('Failed to submit booking: ' + (result.error || 'Unknown error'));
        }
      })
      .catch(error => {
        console.error('Error submitting booking:', error);
        alert('An error occurred while submitting your booking.');
      });
    });
  }
});

    // --- USER'S ORIGINAL DROPDOWN JAVASCRIPT - UNTOUCHED ---
 document.addEventListener('DOMContentLoaded', function () {
  // Handle nav-item dropdowns
  document.querySelectorAll('.nav-item').forEach(item => {
    const btn = item.querySelector('.nav-btn');
    if (!btn) return; // Skip if .nav-btn not found

    btn.addEventListener('click', function (e) {
      e.stopPropagation();

      // Close other dropdowns
      document.querySelectorAll('.nav-item').forEach(i => {
        if (i !== item) i.classList.remove('active');
      });

      // Close profile dropdown if open
      const profileContainer = document.getElementById('profileContainer');
      if (profileContainer) profileContainer.classList.remove('active');

      // Toggle current dropdown
      item.classList.toggle('active');
    });
  });

  // Profile dropdown toggle
  const profilePic = document.getElementById('profilePic');
  const profileContainer = document.getElementById('profileContainer');

  if (profilePic && profileContainer) {
    profilePic.addEventListener('click', function (e) {
      e.stopPropagation();

      // Close nav dropdowns
      document.querySelectorAll('.nav-item').forEach(item => {
        item.classList.remove('active');
      });

      // Toggle profile dropdown
      profileContainer.classList.toggle('active');
    });
  }

  // Close all dropdowns when clicking outside
  document.addEventListener('click', function () {
    document.querySelectorAll('.nav-item').forEach(item => {
      item.classList.remove('active');
    });
    if (profileContainer) profileContainer.classList.remove('active');
  });
});


    // --- New JavaScript for loading notices on resident dashboard ---
    document.addEventListener('DOMContentLoaded', () => {
        loadNoticesForResidents();
    });

function loadNoticesForResidents() {
  fetch('/api/get_notices.php')
    .then(res => res.json())
    .then(data => {
      if (data.length === 0) {
        noticesContainer.innerHTML = '<p class="text-slate-500">No new notices at the moment.</p>';
        return;
      }
      // render notices from data instead of localStorage
    })
    .catch(() => {
      noticesContainer.innerHTML = '<p class="text-red-500">Failed to load notices.</p>';
    });
}


    // --- NEW JAVASCRIPT FOR MODAL FUNCTIONALITY ---
    const modalOverlay = document.getElementById('modalOverlay');
    const allModals = document.querySelectorAll('.modal-container'); // All modal content boxes

    // Function to open a specific modal
    function openModal(modalId) {
        // Close all dropdowns first
        document.querySelectorAll('.nav-item').forEach(item => {
            item.classList.remove('active');
        });
        document.getElementById('profileContainer').classList.remove('active');

        // Hide all modals
        allModals.forEach(modal => {
            modal.classList.add('hidden'); // Use Tailwind's hidden class
        });

        // Show the requested modal
        const targetModal = document.getElementById(modalId);
        if (targetModal) {
            targetModal.classList.remove('hidden');
            modalOverlay.classList.add('active'); // Show overlay and trigger its transitions
        }
    }

    // Function to close all modals
    function closeModal() {
        modalOverlay.classList.remove('active'); // Hide overlay and trigger its transitions
        setTimeout(() => {
            allModals.forEach(modal => {
                modal.classList.add('hidden'); // Hide actual modal content after transition
            });
        }, 300); // Match this timeout to the CSS transition duration for opacity
    }

// Improved modal handling that works for both navbar and footer
    function setupModalTriggers() {
    // Handle clicks anywhere in document
        document.addEventListener('click', function(e) {
        // Check if clicked element or its parent has data-modal-target
            const modalTrigger = e.target.closest('[data-modal-target]');
        
            if (modalTrigger) {
                e.preventDefault();
                const modalId = modalTrigger.getAttribute('data-modal-target');
                openModal(modalId);
            }
        
        // Handle close buttons
            if (e.target.closest('[data-close-modal]')) {
                e.preventDefault();
                closeModal();
            }
        });
    
    // Close modal when clicking outside
        modalOverlay.addEventListener('click', function(e) {
            if (e.target === modalOverlay) {
                closeModal();
            }
        });
    }

    // Initialize everything when DOM is loaded
    document.addEventListener('DOMContentLoaded', () => {
        loadNoticesForResidents();
        setupModalTriggers(); // Add this line to initialize modal functionality
    });

    // Basic form submission handler (client-side only, no actual data processing here)
function handleFormSubmission(event, formType) {
  event.preventDefault();

  if (formType !== 'booking') {
    alert('Unsupported form type');
    return;
  }

  const form = event.target;
  const formData = new FormData(form);

}
  function handleIssueTypeChange() {
    const issueType = document.getElementById('issueType').value;
    const otherTitleContainer = document.getElementById('otherTitleContainer');

    if (issueType === 'other') {
      otherTitleContainer.classList.remove('hidden');
    } else {
      otherTitleContainer.classList.add('hidden');
    }
  }

  // Optional: Run on page load in case a value is already selected
  window.addEventListener('DOMContentLoaded', handleIssueTypeChange);

  const facilityRates = {
    "multi_purpose_hall": { type: "fixed", amount: 500 },
    "game_room": { type: "hourly", amount: 20 },
    "bbq_area": { type: "fixed", amount: 500 },
    "basketball_court": { type: "hourly", amount: 10 },
    "pickleball_court": { type: "hourly", amount: 15 }
  };

  function onFacilityChange() {
    const select = document.getElementById('bookingFacility');
    const hoursContainer = document.getElementById('hoursContainer');
    const paymentAmountInput = document.getElementById('paymentAmount');
    const hoursInput = document.getElementById('bookingHours');

    const selected = select.value;
    if (!selected || !(selected in facilityRates)) {
      hoursContainer.style.display = 'none';
      paymentAmountInput.value = '';
      return;
    }

    const rate = facilityRates[selected];
    if (rate.type === 'hourly') {
      hoursContainer.style.display = 'block';
      hoursInput.value = 1;
      paymentAmountInput.value = rate.amount.toFixed(2);
    } else {
      hoursContainer.style.display = 'none';
      paymentAmountInput.value = rate.amount.toFixed(2);
    }
  }

  function updatePaymentAmount() {
    const select = document.getElementById('bookingFacility');
    const paymentAmountInput = document.getElementById('paymentAmount');
    const hoursInput = document.getElementById('bookingHours');

    const selected = select.value;
    if (!selected || !(selected in facilityRates)) {
      paymentAmountInput.value = '';
      return;
    }

    const rate = facilityRates[selected];
    if (rate.type === 'hourly') {
      const hours = parseInt(hoursInput.value, 10);
      if (hours > 0) {
        paymentAmountInput.value = (hours * rate.amount).toFixed(2);
      } else {
        paymentAmountInput.value = '';
      }
    } else {
      paymentAmountInput.value = rate.amount.toFixed(2);
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
    // Placeholder for actual logout logic
function performLogout() {
    window.location.href = 'index.php';
    closeModal();
}

</script>

<script src="calendar.js"></script>

</body>
</html>