<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Health Monitor')</title>
    
    <!-- CSS Files -->
    <link rel="shortcut icon" href="{{ asset('assets/icons/logo.svg') }}" type="image/x-icon">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/PapaParse/5.3.0/papaparse.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>
    <link rel="stylesheet" href="{{ asset('css/swiper.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css\style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/responsive.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .drag-area {
            border: 2px dashed #444444;
            border-radius: 5px;
            padding: 30px;
            text-align: center;
            background: #f8f9fa;
            cursor: pointer;
            transition: border 0.3s ease;
        }

        .drag-area.active {
            border: 2px solid #505050;
            background: #e9ecef;
        }

        .field-mapping {
            display: none;
        }
        
        /* Add transition for smooth column resizing */
        .col-md-6 {
            transition: all 0.3s ease-in-out;
        }
        
        /* Class for full-width state */
        .col-md-6.full-width {
            width: 100%;
            flex: 0 0 100%;
            max-width: 100%;
        }

        .mapping-row {
            margin-bottom: 15px;
            padding: 10px;
            background: #f8f9fa;
            border-radius: 5px;
        }

        /* Progress bar and steps styling */
        .step-indicator {
            color: #6c757d;
            font-weight: 500;
            position: relative;
        }

        .step-indicator.active {
            color: #0d6efd;
        }

        .step-indicator.completed {
            color: #198754;
        }

        /* Time schedule styling */
        .time-slot {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 10px;
        }

        .time-slot-header {
            font-weight: 500;
            margin-bottom: 10px;
        }

        .time-inputs {
            display: flex;
            gap: 10px;
        }

        .uploadbtn, .browsebtn {
          background:  linear-gradient(93.22deg, #0b6fc0 1.06%, #1fd2e5 97.02%);
          border: none;
          padding: 6px 23px;
        }

        #nextBtn, #prevBtn {
            background:  linear-gradient(93.22deg, #0b6fc0 1.06%, #1fd2e5 97.02%);
            border: none;
            padding: 6px 23px;
        }
        .progress-bar {
            background:  linear-gradient(93.22deg, #0b6fc0 1.06%, #1fd2e5 97.02%);
        }
        .time-slot {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
        }
        
        .time-slot-header {
            font-weight: 500;
            margin-bottom: 10px;
            color: #495057;
        }
        
        .time-inputs {
            display: flex;
            gap: 15px;
        }
        
        .time-inputs .form-group {
            flex: 1;
        }
        
        .form-check-input:checked {
            background-color: #0d6efd;
            border-color: #0d6efd;
        }

        .col-12 {
            
            padding-top: 0px !important;
            padding-bottom: 0px !important;
            padding-left: 7em !important;
            padding-right: 4.5em !important;
        }
        .page-head > span {
            font-size: 2.5rem;
            font-weight: 500;
            color: #0b6fc0;
        }
        .page-head {
            font-size: 2.5rem;
        }
        .card-header {
            background: #0b6fc0;
            padding: 15px;
            
        }
        .card-header > .card-title {
            color: #fff !important;
        }

        .time-slots {
            background: #fff;
            border-radius: 8px;
        }
        
        .time-slot {
            padding: 8px 12px;
            transition: background-color 0.2s;
        }
        
        .time-slot:hover {
            background-color: #f8f9fa;
        }
        
        .day-label {
            font-weight: 500;
            color: #333;
            font-size: 0.95rem;
        }
        
        .time-input-group {
            gap: 10px;
            align-items: center;
        }
        
        .time-separator {
            color: #6c757d;
            font-size: 0.9rem;
        }
        
        .form-control-sm {
            height: 35px;
            padding: 0.25rem 0.5rem;
        }
        
        /* Make time inputs more compact */
        input[type="time"] {
            width: 140px;
            background-color: #fff;
            border: 1px solid #ced4da;
            border-radius: 4px;
        }
        
        input[type="time"]:focus {
            border-color: #86b7fe;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
        }

        .time-slots {
            background: #ffffff;
            border-radius: 8px;
        }
        
        .time-slot {
            padding: 8px 12px;
            transition: background-color 0.2s;
        }
        
        .time-slot:hover {
            background-color: #f8f9fa;
        }
        
        .day-label {
            font-weight: 500;
            color: #333;
            font-size: 0.95rem;
        }
        
        .time-input-group {
            gap: 10px;
            align-items: center;
        }
        
        .time-separator {
            color: #6c757d;
            font-size: 0.9rem;
        }
        
        .form-control-sm {
            height: 35px;
            padding: 0.25rem 0.5rem;
        }
        
        /* Make time inputs more compact */
        input[type="time"] {
            width: 140px;
            background-color: #fff;
            border: 1px solid #ced4da;
            border-radius: 4px;
        }
        
        input[type="time"]:focus {
            border-color: #86b7fe;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
        }

        .drag-area {
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .drag-area:hover {
            border-color: #3B82F6;
            background: #F1F5F9 !important;
        }
        
        .drag-area.active {
            border-color: #515151;
            background: #F1F5F9 !important;
        }
        
        .browsebtn {
            background: linear-gradient(93.22deg, #0b6fc0 1.06%, #1fd2e5 97.02%);
            border: none;
        }
        
        .browsebtn:hover {
            opacity: 0.9;
        }
        
        .text-muted {
            color: #8B98A5 !important;
        }
        .right-col {
         padding-left: 15em !important;
         padding-right: 15em !important;
        }

        .mapping-row {
            margin-bottom: 15px;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        
        .mapping-row:hover {
            background: #f1f5f9;
        }
        
        .mapping-row select.is-invalid {
            border-color: #dc3545;
        }
        
        #fieldMapping {
            max-width: 800px;
            margin: 0 auto;
        }
        .or-divider {
            margin: 2rem 0;
        }

        /* Tab Styling */
.nav-tabs {
    border-bottom: none;
    padding: 0.5rem 1rem 0;
    background: #f8f9fa;
    border-top-left-radius: 0.5rem;
    border-top-right-radius: 0.5rem;
}

.nav-tabs .nav-link {
    border: none;
    color: #495057;
    padding: 1rem 2rem;
    border-radius: 0.5rem 0.5rem 0 0;
    font-weight: 500;
    transition: all 0.2s ease;
}

.nav-tabs .nav-link.active {
    background: linear-gradient(93.22deg, #0b6fc0 1.06%, #1fd2e5 97.02%);
    color: white !important;
    border: none;
    font-weight: 500 !important;
}

.nav-tabs .nav-link:hover:not(.active) {
    background: #e9ecef;
    border: none;
}

.tab-content {
    padding: 2rem;
}

/* Add or update these styles in your existing CSS */

.nav-tabs {
    display: flex;
    width: 100%;
    border-bottom: none;
    padding: 0;
    background: #f8f9fa;
    border-top-left-radius: 0.5rem;
    border-top-right-radius: 0.5rem;
}

.nav-tabs .nav-item {
    width: 50%; /* Make each tab take up 50% width */
    margin: 0; /* Remove any margins */
}

.nav-tabs .nav-link {
    width: 100%;
    border: none;
    color: #495057;
    padding: 1rem;
    text-align: center;
    font-weight: 500;
    transition: all 0.2s ease;
    border-radius: 0;
    margin: 0; /* Remove any margins */
}

.nav-tabs .nav-link.active {
    background: linear-gradient(93.22deg, #0b6fc0 1.06%, #1fd2e5 97.02%);
    color: white;
    border: none;
}

.nav-tabs .nav-link:hover:not(.active) {
    background: #e9ecef;
    border: none;
}

/* Ensure the tab content takes full width */
.tab-content {
    width: 100%;
    padding: 2rem;
}

/* Remove any padding from the card that might affect width */
.card {
    padding: 0;
}

.card-body {
    padding: 0;
}
.upload-progress {
    display: none;
    padding: 20px;
}

.upload-progress .progress {
    height: 20px;
    margin-bottom: 10px;
}

.upload-progress .progress-bar {
    background: linear-gradient(93.22deg, #0b6fc0 1.06%, #1fd2e5 97.02%);
    transition: width 0.5s ease;
}
.download-btn {
    font-weight: 500;
}

.upload-txt {
    color: black !important;
}

/* Add this to your existing CSS */
select.form-select option:first-child {
    color: #6c757d;  /* This is Bootstrap's default placeholder color */
}

select.form-select {
    color: #6c757d;  /* Initial state color */
}

/* When an actual option is selected (not the placeholder) */
select.form-select:not(:invalid) {
    color: #212529;  /* Bootstrap's default text color */
}

/* Add to your existing CSS */
.form-check-inline {
    margin-right: 0;
}

.form-check-input {
    cursor: pointer;
}

.form-check-label {
    cursor: pointer;
    color: #495057;
    font-weight: 400;
}

.form-check-input:checked {
    background-color: #0b6fc0;
    border-color: #0b6fc0;
}

.gap-3 {
    gap: 1rem !important;
}

.radio-label {
    font-weight: 500 !important;
    color: #495057 !important;
    
}
.right-column {
    padding-left: 12em;
    padding-right:12em;
}
    </style>
</head>

<body>
    <!-- loading Start -->
  
    <!-- loading End -->

    <!-- Navbar Start -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="/"><img src="assets/images/logo.png" width="145" class="img-fluid" alt="logo"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul
                    class="navbar-nav align-items-lg-center justify-content-lg-center flex-lg-grow-1 mb-2 mb-lg-0 mt-lg-0 mt-4">
                    <li class="nav-item">
                        <a class="nav-link mx-2 text-primary" href="emergency.html">Emergency</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link mx-2 text-primary" href="community.html">Community</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link mx-2 text-primary" href="signup.html">Register</a>
                    </li>
                </ul>
                <div class="login-btn">
                    <a href="login.html"><button class="btn primary-btn">Login</button></a>
                </div>
            </div>
        </div>
    </nav>
    <!-- Navbar End -->
    <div class="container-fluid py-4">
        <div class="row mb-4">
            <div class="col-12 text-center">
                <h2 class="page-head">HealthCare <span>Providers</span></h2>
                <p>
                    Register your healthcare facility using either bulk upload or step-by-step form</p>
            </div>
        </div>
    
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <ul class="nav nav-tabs" id="providerTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active w-100" id="bulk-tab" data-bs-toggle="tab" data-bs-target="#bulk" type="button" role="tab">
                                Bulk Upload Health Care Providers Data
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link w-100" id="form-tab" data-bs-toggle="tab" data-bs-target="#form" type="button" role="tab">
                                Health Care Providers Registration Form
                            </button>
                        </li>
                    </ul>
                
    
                    <!-- Tab Content -->
                    <div class="tab-content" id="providerTabContent">
                        <!-- Bulk Upload Tab -->
                        <div class="tab-pane fade show active" id="bulk" role="tabpanel">
                            <div class="card-body">
                                <div class="text-center mb-5">
                                    <p class="text-muted download-btn">
                                        Upload Health Care providers' data using a file containing all of their information.
                                        This is particularly useful when you have a large number of health care providers to import.
                                    </p>
                                </div>
    
                                <div class="mb-3 d-flex justify-content-between align-items-center">
                                    <span class="text-muted download-btn upload-txt">
                                        <i class="bi bi-cloud-arrow-up"></i>
                                        Upload your file
                                    </span>
                                    <a href="assets\DB Structure for Health Care Providers.xlsx" class="text-primary text-decoration-none download-btn">
                                        <i class="fas fa-download me-1"></i>
                                        Download sample file (.xls format)
                                    </a>
                                </div>
    
                                <!-- Drag & Drop Area -->
                                <div class="drag-area" id="dragArea">
                                    <div class="text-center py-3">
                                        <div class="mb-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="66" height="66" fill="#8B98A5" class="bi bi-cloud-arrow-up" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd" d="M7.646 5.146a.5.5 0 0 1 .708 0l2 2a.5.5 0 0 1-.708.708L8.5 6.707V10.5a.5.5 0 0 1-1 0V6.707L6.354 7.854a.5.5 0 1 1-.708-.708z"/>
                                                <path d="M4.406 3.342A5.53 5.53 0 0 1 8 2c2.69 0 4.923 2 5.166 4.579C14.758 6.804 16 8.137 16 9.773 16 11.569 14.502 13 12.687 13H3.781C1.708 13 0 11.366 0 9.318c0-1.763 1.266-3.223 2.942-3.593.143-.863.698-1.723 1.464-2.383m.653.757c-.757.653-1.153 1.44-1.153 2.056v.448l-.445.049C2.064 6.805 1 7.952 1 9.318 1 10.785 2.23 12 3.781 12h8.906C13.98 12 15 10.988 15 9.773c0-1.216-1.02-2.228-2.313-2.228h-.5v-.5C12.188 4.825 10.328 3 8 3a4.53 4.53 0 0 0-2.941 1.1z"/>
                                            </svg>
                                        </div>
                                        <p class="text-muted mb-2 download-btn">Select your file or drag and drop it here</p>
                                        <p class="text-muted small mb-3 download-btn">.csv, .xls, .xlsx or .txt (max. 80MB)</p>
                                        <button class="btn btn-primary browsebtn px-4" onclick="document.getElementById('fileInput').click()">
                                            Browse File
                                        </button>
                                        <input type="file" id="fileInput" hidden accept=".csv,.xls,.xlsx">
                                    </div>
                                </div>
                                <!-- Add this after the drag-area div -->
<div id="uploadProgress" class="upload-progress">
    <p class="text-center mb-3">Uploading file...</p>
    <div class="progress">
        <div class="progress-bar" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
    </div>
    <p class="text-center text-muted mt-2" id="uploadStatus">Processing...</p>
</div>
    
                                <!-- Field Mapping Section -->
                                <div class="field-mapping mt-4" id="fieldMapping" style="display: none;">
                                    <h5 class="mb-3">Map CSV Fields</h5>
                                    <div id="mappingContainer">
                                        <!-- Mapping fields will be added dynamically -->
                                    </div>
                                    <button class="btn btn-success mt-3" onclick="submitMapping()">
                                        Confirm Mapping
                                    </button>
                                </div>
                            </div>
                        </div>
    
                        <!-- Step Form Tab -->
                        <div class="tab-pane fade" id="form" role="tabpanel">
                            <div class="card-body right-column">
                                <!-- Progress Bar -->
                                <div class="progress mb-4" style="height: 3px;">
                                    <div class="progress-bar" role="progressbar" id="formProgress" style="width: 33%"></div>
                                </div>
                                
                                <div class="d-flex justify-content-between mb-4">
                                    <span class="step-indicator active" id="step1Indicator">Organization</span>
                                    <span class="step-indicator" id="step2Indicator">Location</span>
                                    <span class="step-indicator" id="step3Indicator">Details</span>
                                </div>
    
                                <!-- Step 1: Organization Details -->
                                <form id="step1" class="form-step">
                                    <div class="mb-3">
                                        <input type="text" class="form-control" name="org_name" placeholder="Organization Name*" required>
                                    </div>
                                    <div class="mb-3">
                                        <select class="form-select" name="facility_type" id="facilityType" required>
                                            <option value="">Facility Type*</option>
                                            <option value="hospital">Hospital</option>
                                            <option value="emergency">Emergency</option>
                                            <option value="medical labs">Medical Labs</option>
                                            <option value="chemists">Chemists</option>
                                            <option value="other">Other</option>
                                        </select>
                                        <!-- Add this new div for custom facility type -->
                                        <div id="otherFacilityType" style="display: none;" class="mt-2">
                                            <input type="text" class="form-control" name="other_facility_type" placeholder="Please specify facility type*">
                                        </div>
                                    </div>
                                    
                                    <!-- Update the Ownership Type select and add a new input field -->
                                    <div class="mb-3">
                                        <select class="form-select" name="ownership_type" id="ownershipType" required>
                                            <option value="">Ownership Type*</option>
                                            <option value="government">Government</option>
                                            <option value="state">State</option>
                                            <option value="private">Private</option>
                                            <option value="charity">Charity</option>
                                            <option value="church">Church</option>
                                            <option value="other">Other</option>
                                        </select>
                                        <!-- Add this new div for custom ownership type -->
                                        <div id="otherOwnershipType" style="display: none;" class="mt-2">
                                            <input type="text" class="form-control" name="other_ownership_type" placeholder="Please specify ownership type*">
                                        </div>
                                    </div>
                                    
                                    
                                    <div class="mb-3">
                                        <input type="email" class="form-control" name="email_address" placeholder="Email Address*" required>
                                    </div>
                                    <div class="mb-3">
                                        <input type="tel" class="form-control" name="phone_number" placeholder="Phone Number*" required>
                                    </div>
                                    <div class="text-end">
                                        <button type="button" class="btn btn-primary" id="nextBtn" onclick="nextStep(event)">Next</button>
                                    </div>
                                </form>
    
                                <!-- Step 2: Location Information -->
                                <form id="step2" class="form-step" style="display: none;">
                                    <div class="mb-3 form-group">
                                        <select id="country" class="form-select" required>
                                            <option value="">Select Country*</option>
                                        </select>
                                    </div>
                                    <div class="mb-3 form-group">
                                        <select id="state" class="form-select" required disabled>
                                            <option value="">Select State*</option>
                                        </select>
                                    </div>
                                    <div class="mb-3 form-group">
                                        <input type="text" class="form-control" name="city" placeholder="City*" required>
                                    </div>
                                    <div class="mb-3">
                                        <input type="text" class="form-control" name="zipcode" placeholder="Zipcode*" required>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <button type="button" class="btn btn-secondary" id="prevBtn" onclick="prevStep(event)">Previous</button>
                                        <button type="button" class="btn btn-primary" id="nextBtn" onclick="nextStep(event)">Next</button>
                                    </div>
                                </form>
    
                                <!-- Step 3: Additional Details -->
                                <form id="step3" class="form-step" style="display: none;">
                                    <div class="mb-3">
                                        <input type="url" class="form-control" name="google_map_link" placeholder="Google Map Link">
                                    </div>
                                    
                                    <!-- A&E Available Section -->
                                    <div class="mb-3 d-flex justify-content-between align-items-center" style="margin-bottom: 40px !important; margin-top: 40px !important;">
                                        <div class="radio-label">Is your facility A&E?</div>
                                        <div class="d-flex gap-3">
                                            <div class="form-check form-check-inline mb-0">
                                                <input class="form-check-input" type="radio" name="ae_available" id="ae_yes" value="yes">
                                                <label class="form-check-label" for="ae_yes">Yes</label>
                                            </div>
                                            <div class="form-check form-check-inline mb-0">
                                                <input class="form-check-input" type="radio" name="ae_available" id="ae_no" value="no">
                                                <label class="form-check-label" for="ae_no">No</label>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- 24 Hours Service Section -->
                                    <div class="mb-3 d-flex justify-content-between align-items-center">
                                        <div class="radio-label">Is 24 Hours Service?*</div>
                                        <div class="d-flex gap-3">
                                            <div class="form-check form-check-inline mb-0">
                                                <input class="form-check-input" type="radio" name="is_24hours" id="24hours_yes" value="yes" checked>
                                                <label class="form-check-label" for="24hours_yes">Yes</label>
                                            </div>
                                            <div class="form-check form-check-inline mb-0">
                                                <input class="form-check-input" type="radio" name="is_24hours" id="24hours_no" value="no">
                                                <label class="form-check-label" for="24hours_no">No</label>
                                            </div>
                                        </div>
                                    </div>
                                    
    
                                    <!-- Time Schedule Fields -->
                                    <div id="timeSchedule" style="display: none;" class="mt-4">
                                        <h6 class="mb-4">Operating Hours</h6>
                                        <div class="time-slots">
                                            <!-- Will be populated by JavaScript -->
                                        </div>
                                    </div>
    
                                    <div class="d-flex justify-content-between mt-4">
                                        <button type="button" class="btn btn-secondary" onclick="prevStep(event)">Previous</button>
                                        <button type="button" class="btn btn-primary" id="nextBtn" onclick="submitForm(event)">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
        <!-- Thank You Message -->
        <div class="thank-you-message text-center py-5" id="thankYouMessage" style="display: none;">
            <div class="success-icon mb-4">
                <i class="fas fa-check-circle text-success" style="font-size: 48px;"></i>
            </div>
            <h3 class="text-success mb-3">Thank You!</h3>
            <p class="text-muted">Your information has been successfully submitted.</p>
            <button class="btn btn-primary mt-3 uploadbtn" onclick="resetForm()">Submit Another</button>
        </div>
    </div>
    <!-- Hero Start -->
    <!-- Blogs End -->

        <!-- Footer start -->
        <footer class="footer-section">
            <div class="container">
                <div class="row row-gap-3">
                    <div class="col-lg-5 col-md-6 text-md-start text-center">
                        <div class="footer-card">
                            <div class="footer-img">
                                <a href="">
                                    <img src="assets/images/logo.png" width="150" alt="" class="img-fluid">
                                </a>
                            </div>
                            <div class="footer-content">
                                <p class="mt-4 mb-3">Join our newsletter for latest updates <br>
                                    and features. You don't want to miss it!</p>
                                <div class="footer-subscribe position-relative w-100">
                                    <input type="email" class="" placeholder="Enter your email here">
                                    <button type="submit" class="btn">Subscribe</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-6 text-md-start text-center">
                        <ul class="navbar-nav">
                            <h5 class="fw-bold footer-heading text-primary">Home</h5>
                            <li class="nav-item"><a href="emergency.html" class="nav-link">Emergency</a></li>
                            <li class="nav-item"><a href="login.html" class="nav-link">Symptoms</a></li>
                            <li class="nav-item"><a href="login.html" class="nav-link">Remote Care</a></li>
                            <li class="nav-item"><a href="login.html" class="nav-link">Monitors</a></li>
                            <li class="nav-item"><a href="login.html" class="nav-link">Health Info</a></li>
                            <li class="nav-item"><a href="#" class="nav-link">Blogs</a></li>
                        </ul>
                    </div>
                    <div class="col-lg-2 col-md-6 text-md-start text-center">
                        <ul class="navbar-nav">
                            <h5 class="fw-bold footer-heading text-primary">Communities</h5>
                            <li class="nav-item"><a href="/user-dashboard/hospitals.html" class="nav-link">Hospitals</a></li>
                            <li class="nav-item"><a href="#" class="nav-link">Pharmacy</a></li>
                            <li class="nav-item"><a href="/user-dashboard/Chemists.html" class="nav-link">Community Digital
                                    Health Assistants</a></li>
                            <li class="nav-item"><a href="#" class="nav-link">Tech Support</a></li>
                            <li class="nav-item"><a href="/user-dashboard/complaints.html" class="nav-link">Complaints</a></li>
                            <li class="nav-item"><a href="/user-dashboard/reviews.html" class="nav-link">Reviews</a></li>
                            <li class="nav-item"><a href="/user-dashboard/privacy-policy.html" class="nav-link">Privacy
                                    Policy</a></li>
                        </ul>
                    </div>
                    <div class="col-lg-2 col-md-6 text-md-start text-center">
                        <ul class="navbar-nav">
                            <h5 class="fw-bold footer-heading text-primary">Profile</h5>
                            <li class="nav-item"><a href="login.html" class="nav-link">Sponsorship</a></li>
                            <li class="nav-item"><a href="login.html" class="nav-link">Print</a></li>
                            <li class="nav-item"><a href="login.html" class="nav-link">Password & Pin</a></li>
                            <li class="nav-item"><a href="login.html" class="nav-link">Access Control</a></li>
                            <li class="nav-item"><a href="login.html" class="nav-link">National Policies</a></li>
                            <li class="nav-item"><a href="#" class="nav-link">Share link</a></li>
                            <li class="nav-item"><a href="login.html" class="nav-link">Delete Account</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <hr class="mt-5 mb-2">
            <div class="copyright-section d-flex align-items-center">
                <p class="font-size">© Copyright 2025 HealthMonitor. All rights reserved</p>
                <p class="ms-md-auto me-3 font-size">Share on socials</p>
                <div class="social-media">
                    <img src="assets/icons/X.svg" alt="img" class="">
                    <img src="assets/icons/Facebook.svg" alt="img" class="">
                    <img src="assets/icons/Instagram.svg" alt="img" class="">
                    <img src="assets/icons/Telegram.svg" alt="img" class="">
                </div>
            </div>
        
        </footer>
        <!-- Footer end -->

    <!-- Demo Video Start -->
    <!-- <div class="demo-video d-none" id="demo-video">
        <div class="video-popup">
            <iframe src="https://www.youtube.com/embed/1WGTftm_IEU?si=LRPCj-aTZp5tMti9"></iframe>
        </div>
    </div> -->
    <!-- Demo Video End -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.full.min.js"></script>
    
    
    <script>
        // File Upload Handling
// File Upload Handling
const dragArea = document.getElementById('dragArea');
const fileInput = document.getElementById('fileInput');
const filePreview = document.getElementById('filePreview');
const startImportBtn = document.getElementById('startImportBtn');
const fieldMapping = document.getElementById('fieldMapping');
let selectedFile = null;

// Mapping fields that match our database structure
const mappingFields = [
    'organization_name',
    'facility_type',
    'other_facility_type',
    'ownership_type',
    'other_ownership_type',
    'email_address',
    'phone_number',
    'country',
    'state',
    'city',
    'zipcode',
    'google_map_link',
    'is_ae_available',
    'is_24hours',
    'operating_hours'
];

// Make entire drag area clickable
dragArea.addEventListener('click', (e) => {
    // Only trigger file input if the click wasn't on the start import button
    if (!e.target.matches('#startImportBtn')) {
        fileInput.click();
    }
});

// Drag and drop handlers
dragArea.addEventListener('dragover', (e) => {
    e.preventDefault();
    dragArea.classList.add('active');
});

dragArea.addEventListener('dragleave', () => {
    dragArea.classList.remove('active');
});

dragArea.addEventListener('drop', (e) => {
    e.preventDefault();
    dragArea.classList.remove('active');
    const file = e.dataTransfer.files[0];
    handleFile(file);
});

fileInput.addEventListener('change', (e) => {
    const file = e.target.files[0];
    handleFile(file);
});

function handleFile(file) {
    console.log('Handling file:', file.name);
    if (file.name.endsWith('.csv') || file.name.endsWith('.xls') || file.name.endsWith('.xlsx')) {
        selectedFile = file;
        updateFilePreview(file);
    } else {
        alert('Please upload a CSV, XLS, or XLSX file');
    }
}

function updateFilePreview(file) {
    const fileSize = (file.size / (1024 * 1024)).toFixed(2); // Convert to MB
    dragArea.innerHTML = `
        <div class="text-center py-3">
            <div class="mb-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="#28a745" class="bi bi-file-earmark-check" viewBox="0 0 16 16">
                    <path d="M10.854 7.854a.5.5 0 0 0-.708-.708L7.5 9.793 6.354 8.646a.5.5 0 1 0-.708.708l1.5 1.5a.5.5 0 0 0 .708 0z"/>
                    <path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2M9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5z"/>
                </svg>
            </div>
            <p class="text-success mb-1">${file.name}</p>
            <p class="text-muted small mb-3">${fileSize} MB</p>
            <button class="btn btn-primary browsebtn px-4" id="startImportBtn" onclick="startImport(event)">
                Start Import
            </button>
        </div>
    `;
}

async function startImport(event) {
    event.stopPropagation();
    if (!selectedFile) return;

    try {
        // Hide drag area and show progress
        dragArea.style.display = 'none';
        const uploadProgress = document.getElementById('uploadProgress');
        uploadProgress.style.display = 'block';
        
        // Process the file
        const data = await processFile(selectedFile);
        
        // Get headers
        const headers = Object.keys(data[0]);
        console.log('File headers:', headers);
        
        // Hide progress and show mapping
        uploadProgress.style.display = 'none';
        showFieldMapping(headers);
        
    } catch (error) {
        console.error('Error processing file:', error);
        alert('Error processing file: ' + error.message);
        // Reset the upload area
        uploadProgress.style.display = 'none';
        dragArea.style.display = 'block';
    }
}

// Process different file types
async function processFile(file) {
    try {
        console.log('Processing file:', file.name);
        const extension = file.name.split('.').pop().toLowerCase();
        let data;

        if (extension === 'csv') {
            data = await processCSV(file);
        } else if (['xls', 'xlsx'].includes(extension)) {
            data = await processExcel(file);
        } else {
            throw new Error('Unsupported file format');
        }

        return data;
    } catch (error) {
        console.error('Error processing file:', error);
        throw error;
    }
}

// Process CSV files
async function processCSV(file) {
    return new Promise((resolve, reject) => {
        Papa.parse(file, {
            header: true,
            skipEmptyLines: true,
            complete: (results) => {
                console.log('CSV Processing Results:', results);
                resolve(results.data);
            },
            error: (error) => {
                console.error('CSV Processing Error:', error);
                reject(error);
            }
        });
    });
}

// Process Excel files
async function processExcel(file) {
    try {
        const data = await file.arrayBuffer();
        const workbook = XLSX.read(data, { type: 'array' });
        const firstSheet = workbook.Sheets[workbook.SheetNames[0]];
        return XLSX.utils.sheet_to_json(firstSheet);
    } catch (error) {
        console.error('Excel Processing Error:', error);
        throw error;
    }
}

// Show field mapping interface
function showFieldMapping(headers) {
    console.log('Showing field mapping interface for headers:', headers);
    const mappingContainer = document.getElementById('mappingContainer');
    mappingContainer.innerHTML = '';

    mappingFields.forEach(field => {
        const row = document.createElement('div');
        row.className = 'mapping-row';
        row.innerHTML = `
            <div class="row align-items-center">
                <div class="col-md-4">
                    <label class="form-label mb-0">${field}:</label>
                </div>
                <div class="col-md-8">
                    <select class="form-select" data-field="${field}">
                        <option value="">Select Column</option>
                        ${headers.map(header => 
                            `<option value="${header.trim()}" ${header.trim().toLowerCase() === field.toLowerCase() ? 'selected' : ''}>
                                ${header.trim()}
                            </option>`
                        ).join('')}
                    </select>
                </div>
            </div>
        `;
        mappingContainer.appendChild(row);
    });

    // Show the mapping section
    document.getElementById('fieldMapping').style.display = 'block';
}

// Submit mapping and process data
async function submitMapping() {
    try {
        console.log('Starting bulk data submission...');
        const mapping = {};
        const mappingSelects = document.querySelectorAll('#mappingContainer select');
        
        // Collect mapping selections
        mappingSelects.forEach(select => {
            mapping[select.dataset.field] = select.value;
        });
        
        console.log('Field mapping:', mapping);

        // Process the data with mapping
        const data = await processFile(selectedFile);
        const processedData = data.map((row, index) => {
    const processedRow = {};
    for (const [field, headerName] of Object.entries(mapping)) {
        if (headerName) {
            if (field === 'is_ae_available' || field === 'is_24hours') {
                // Convert yes/no/true/false to boolean
                const value = row[headerName]?.toString().toLowerCase();
                processedRow[field] = value === 'yes' || value === 'true' || value === '1';
            } else {
                // Handle NULL strings and empty values
                const value = row[headerName];
                processedRow[field] = (value === 'NULL' || value === 'null' || value === '') ? null : value;
            }
        }
    }
    return processedRow;
});

        console.log('Data being sent to server:', JSON.stringify({ providers: processedData }, null, 2));

        // Validate required fields before sending
        const missingFields = processedData.map((row, index) => {
            const missing = [];
            ['organization_name', 'facility_type', 'ownership_type', 'email_address', 
             'phone_number', 'country', 'state', 'city', 'zipcode'].forEach(field => {
                if (!row[field]) {
                    missing.push(field);
                }
            });
            return missing.length > 0 ? { row: index + 1, fields: missing } : null;
        }).filter(Boolean);

        if (missingFields.length > 0) {
            let errorMessage = 'Required fields missing in following rows:\n\n';
            missingFields.forEach(error => {
                errorMessage += `Row ${error.row}: ${error.fields.join(', ')}\n`;
            });
            throw new Error(errorMessage);
        }

        // Send to server
        const response = await fetch('/healthcare-providers/bulk', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ providers: processedData })
        });

        // Get the raw response text first
        const responseText = await response.text();
        console.log('Raw server response:', responseText);

        // Try to parse it as JSON
        let result;
        try {
            result = JSON.parse(responseText);
        } catch (e) {
            console.error('Failed to parse server response as JSON:', responseText);
            throw new Error('Server returned invalid JSON response');
        }

        if (!response.ok) {
            throw new Error(result.message || `Server error: ${response.status}`);
        }

        console.log('Bulk upload results:', result);

        if (result.status === 'success') {
            let message = `Successfully processed ${result.results.success} records.\n`;
            if (result.results.failed > 0) {
                message += `\nFailed to process ${result.results.failed} records.`;
                if (result.results.errors.length > 0) {
                    message += '\n\nErrors:\n';
                    result.results.errors.forEach(error => {
                        message += `Row ${error.row}: ${error.errors ? Object.values(error.errors).join(', ') : error.message}\n`;
                    });
                }
            }
            alert(message);
            showThankYouMessage(true);
        } else {
            throw new Error(result.message || 'Bulk upload failed');
        }

    } catch (error) {
        console.error('Bulk upload error:', error);
        alert('Failed to process bulk upload: ' + error.message);

        // Reset the form if needed
        const fieldMapping = document.getElementById('fieldMapping');
        if (fieldMapping) {
            fieldMapping.style.display = 'none';
        }
        const dragArea = document.getElementById('dragArea');
        if (dragArea) {
            dragArea.style.display = 'block';
            dragArea.innerHTML = `
                <div class="text-center py-3">
                    <div class="mb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="66" height="66" fill="#8B98A5" class="bi bi-cloud-arrow-up" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M7.646 5.146a.5.5 0 0 1 .708 0l2 2a.5.5 0 0 1-.708.708L8.5 6.707V10.5a.5.5 0 0 1-1 0V6.707L6.354 7.854a.5.5 0 1 1-.708-.708z"/>
                            <path d="M4.406 3.342A5.53 5.53 0 0 1 8 2c2.69 0 4.923 2 5.166 4.579C14.758 6.804 16 8.137 16 9.773 16 11.569 14.502 13 12.687 13H3.781C1.708 13 0 11.366 0 9.318c0-1.763 1.266-3.223 2.942-3.593.143-.863.698-1.723 1.464-2.383m.653.757c-.757.653-1.153 1.44-1.153 2.056v.448l-.445.049C2.064 6.805 1 7.952 1 9.318 1 10.785 2.23 12 3.781 12h8.906C13.98 12 15 10.988 15 9.773c0-1.216-1.02-2.228-2.313-2.228h-.5v-.5C12.188 4.825 10.328 3 8 3a4.53 4.53 0 0 0-2.941 1.1z"/>
                        </svg>
                    </div>
                    <p class="text-muted mb-2 small">Select your file or drag and drop it here</p>
                    <p class="text-muted small mb-3">.csv, .xls, .xlsx or .txt (max. 80MB)</p>
                    <button class="btn btn-primary browsebtn px-4" onclick="document.getElementById('fileInput').click()">
                        Browse File
                    </button>
                    <input type="file" id="fileInput" hidden accept=".csv,.xls,.xlsx">
                </div>
            `;
        }
    }
}
function submitForm(event) {
    if (event) {
        event.preventDefault();
    }
    showThankYouMessage(false); // Pass false for step form
}
        // Form step handling
        // Form step handling
        let currentStep = 1;
        const totalSteps = 3;
        
        function updateProgress() {
            const progress = (currentStep / totalSteps) * 100;
            document.getElementById('formProgress').style.width = `${progress}%`;
            
            // Update step indicators
            for (let i = 1; i <= totalSteps; i++) {
                const indicator = document.getElementById(`step${i}Indicator`);
                if (i === currentStep) {
                    indicator.classList.add('active');
                } else if (i < currentStep) {
                    indicator.classList.add('completed');
                    indicator.classList.remove('active');
                } else {
                    indicator.classList.remove('active', 'completed');
                }
            }
        }
        
        function showStep(step) {
            // Hide all forms
            document.querySelectorAll('.form-step').forEach(form => {
                form.style.display = 'none';
            });
            
            // Show current step
            document.getElementById(`step${step}`).style.display = 'block';
            
            // Update buttons
            document.getElementById('prevBtn').style.display = step === 1 ? 'none' : 'block';
            document.getElementById('nextBtn').innerHTML = step === totalSteps ? 'Submit' : 'Next';
            
            updateProgress();
        }
        
        // Replace the existing nextStep and prevStep functions with these:
function nextStep(e) {
    if (e) {
        e.preventDefault(); // Prevent form submission
    }
    // Validate current step
    const currentForm = document.getElementById(`step${currentStep}`);
    if (currentForm.checkValidity()) {
        if (currentStep < totalSteps) {
            currentStep++;
            showStep(currentStep);
        } else {
            // Handle form submission
            submitForm();
        }
    } else {
        currentForm.reportValidity();
    }
}

function prevStep(e) {
    if (e) {
        e.preventDefault(); // Prevent form submission
    }
    if (currentStep > 1) {
        currentStep--;
        showStep(currentStep);
    }
}
        
        // Handle time schedule visibility
        // Handle time schedule visibility
document.addEventListener('DOMContentLoaded', function() {
    const timeScheduleDiv = document.getElementById('timeSchedule');
    const timeSlotsDiv = timeScheduleDiv.querySelector('.time-slots');
    const days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];

    // Create time slots
    function createTimeSlots() {
        timeSlotsDiv.innerHTML = days.map(day => `
            <div class="time-slot row align-items-center g-3 mb-2">
                <div class="col-3">
                    <span class="day-label">${day}</span>
                </div>
                <div class="col-9">
                    <div class="d-flex align-items-center time-input-group">
                        <input type="time" class="form-control form-control-sm" name="${day.toLowerCase()}_start" 
                               placeholder="Start Time" required>
                        <span class="time-separator mx-2">to</span>
                        <input type="time" class="form-control form-control-sm" name="${day.toLowerCase()}_end" 
                               placeholder="End Time" required>
                    </div>
                </div>
            </div>
        `).join('');
    }

    // Handle 24 hours toggle
    document.querySelectorAll('input[name="is_24hours"]').forEach(radio => {
        radio.addEventListener('change', function() {
            const showTimeSchedule = this.value === 'no';
            if (showTimeSchedule) {
                createTimeSlots(); // Create the time slots when showing
            }
            timeScheduleDiv.style.display = showTimeSchedule ? 'block' : 'none';
            
            // Update required attribute for time inputs
            const timeInputs = timeScheduleDiv.querySelectorAll('input[type="time"]');
            timeInputs.forEach(input => {
                input.required = showTimeSchedule;
            });
        });
    });

    // Add required to A&E radio buttons
    document.querySelectorAll('input[name="ae_available"]').forEach(radio => {
        radio.required = true;
    });
});
const countryDropdown = $('#country');
const stateDropdown = $('#state');
const cityDropdown = $('#city');

// Step 1: Load Countries
function loadCountries() {
    $.ajax({
        url: 'https://restcountries.com/v3.1/all',
        method: 'GET',
        success: function (data) {
            // Sort countries alphabetically
            const sortedCountries = data.sort((a, b) =>
                a.name.common.localeCompare(b.name.common)
            );

            // Populate the country dropdown
            countryDropdown.empty().append('<option value="">Select Country</option>');
            sortedCountries.forEach(country => {
                countryDropdown.append(new Option(country.name.common, country.cca2)); // ISO code as value
            });
        },
        error: function () {
            alert('Failed to load countries. Try again later.');
        }
    });
}

// Step 2: Load States
function loadStates(countryCode) {
    console.log('Fetching states for country code:', countryCode); // Debugging log
    $.ajax({
        url: `https://wft-geo-db.p.rapidapi.com/v1/geo/countries/${countryCode}/regions`,
        method: 'GET',
        headers: {
            'x-rapidapi-host': 'wft-geo-db.p.rapidapi.com',
            'x-rapidapi-key': 'b83f74efaamshb4574179b332748p156dadjsn907ed0ab88f9' // Replace with your actual API key
        },
        success: function (data) {
            console.log('States fetched successfully:', data); // Debugging log
            stateDropdown.empty().append('<option value="">Select State</option>');
            if (data.data && data.data.length > 0) {
                data.data.forEach(state => {
                    stateDropdown.append(new Option(state.name, state.code));
                });
                stateDropdown.prop('disabled', false);
            } else {
                alert('No states found for the selected country.');
            }
        },
        error: function (xhr, status, error) {
            console.error('Error fetching states:', error); // Debugging log
            alert('Failed to load states. Please try again later.');
        }
    });
}

// Step 3: Load Cities

// Step 4: Event Listeners
$(document).ready(function () {
    // Load countries on page load
    loadCountries();

    // When a country is selected, load states
    countryDropdown.on('change', function () {
        const countryCode = $(this).val();
        if (countryCode) {
            loadStates(countryCode);
            cityDropdown.prop('disabled', true).empty().append('<option value="">Select City</option>');
        } else {
            stateDropdown.prop('disabled', true).empty().append('<option value="">Select State</option>');
            cityDropdown.prop('disabled', true).empty().append('<option value="">Select City</option>');
        }
    });

    // When a state is selected, load cities
    stateDropdown.on('change', function () {
        const stateCode = $(this).val();
        const countryCode = countryDropdown.val();
        if (stateCode && countryCode) {
            loadCities(stateCode, countryCode);
        } else {
            cityDropdown.prop('disabled', true).empty().append('<option value="">Select City</option>');
        }
    });
});
function resetForm() {
    selectedFile = null;
    // Reset file upload area
    dragArea.innerHTML = `
        <div class="text-center py-3">
            <div class="mb-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="66" height="66" fill="#8B98A5" class="bi bi-cloud-arrow-up" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M7.646 5.146a.5.5 0 0 1 .708 0l2 2a.5.5 0 0 1-.708.708L8.5 6.707V10.5a.5.5 0 0 1-1 0V6.707L6.354 7.854a.5.5 0 1 1-.708-.708z"/>
                    <path d="M4.406 3.342A5.53 5.53 0 0 1 8 2c2.69 0 4.923 2 5.166 4.579C14.758 6.804 16 8.137 16 9.773 16 11.569 14.502 13 12.687 13H3.781C1.708 13 0 11.366 0 9.318c0-1.763 1.266-3.223 2.942-3.593.143-.863.698-1.723 1.464-2.383m.653.757c-.757.653-1.153 1.44-1.153 2.056v.448l-.445.049C2.064 6.805 1 7.952 1 9.318 1 10.785 2.23 12 3.781 12h8.906C13.98 12 15 10.988 15 9.773c0-1.216-1.02-2.228-2.313-2.228h-.5v-.5C12.188 4.825 10.328 3 8 3a4.53 4.53 0 0 0-2.941 1.1z"/>
                </svg>
            </div>
            <p class="text-muted mb-1 small">Select your file or drag and drop it here</p>
            <p class="text-muted small mb-2">CSV, XLS or XLSX (max. 800MB)</p>
            <button class="btn btn-primary browsebtn px-3 py-1" onclick="document.getElementById('fileInput').click()">
                Browse File
            </button>
            <input type="file" id="fileInput" hidden accept=".csv,.xls,.xlsx">
        </div>
    `;
    fileInput.value = '';
    
    // Show all sections again
    const uploadSection = document.querySelector('.card');
    if (uploadSection) uploadSection.style.display = 'block';
    dragArea.style.display = 'block';
    fieldMapping.style.display = 'none';
    document.getElementById('thankYouMessage').style.display = 'none';

    // Show the form and divider again
    const formColumn = document.getElementById('formColumn');
    const orDivider = document.querySelector('.divider');
    if (formColumn) {
        formColumn.style.display = 'block';
        // Reset form to first step
        currentStep = 1;
        showStep(1);
        // Clear all form inputs
        document.querySelectorAll('.form-step input, .form-step select').forEach(input => {
            input.value = '';
        });
    }
    if (orDivider) orDivider.style.display = 'flex';

    // Reattach click event to drag area
    dragArea.addEventListener('click', (e) => {
        if (!e.target.matches('#startImportBtn')) {
            fileInput.click();
        }
    });
}

// function submitForm() {
//     // Hide the entire container except header and footer
//     const container = document.querySelector('.container-fluid.py-4');
//     if (container) {
//         container.style.display = 'none';
//     }
    
//     // Show the thank you message
//     const thankYouMessage = document.getElementById('thankYouMessage');
//     if (thankYouMessage) {
//         // Move thank you message outside the main container
//         document.body.insertBefore(thankYouMessage, document.querySelector('footer'));
//         thankYouMessage.style.display = 'block';
//         thankYouMessage.style.margin = '4rem auto';
//         thankYouMessage.style.maxWidth = '600px';
        
//         // Scroll to thank you message
//         thankYouMessage.scrollIntoView({ 
//             behavior: 'smooth',
//             block: 'center'
//         });
//     }
// }

function resetForm() {
    selectedFile = null;
    
    // Show the main container again
    const container = document.querySelector('.container-fluid.py-4');
    if (container) {
        container.style.display = 'block';
    }
    
    // Move thank you message back to original container and hide it
    const thankYouMessage = document.getElementById('thankYouMessage');
    if (thankYouMessage) {
        container.appendChild(thankYouMessage);
        thankYouMessage.style.display = 'none';
    }
    
    // Reset file upload area
    dragArea.innerHTML = `
        <div class="text-center py-3">
            <div class="mb-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="66" height="66" fill="#8B98A5" class="bi bi-cloud-arrow-up" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M7.646 5.146a.5.5 0 0 1 .708 0l2 2a.5.5 0 0 1-.708.708L8.5 6.707V10.5a.5.5 0 0 1-1 0V6.707L6.354 7.854a.5.5 0 1 1-.708-.708z"/>
                    <path d="M4.406 3.342A5.53 5.53 0 0 1 8 2c2.69 0 4.923 2 5.166 4.579C14.758 6.804 16 8.137 16 9.773 16 11.569 14.502 13 12.687 13H3.781C1.708 13 0 11.366 0 9.318c0-1.763 1.266-3.223 2.942-3.593.143-.863.698-1.723 1.464-2.383m.653.757c-.757.653-1.153 1.44-1.153 2.056v.448l-.445.049C2.064 6.805 1 7.952 1 9.318 1 10.785 2.23 12 3.781 12h8.906C13.98 12 15 10.988 15 9.773c0-1.216-1.02-2.228-2.313-2.228h-.5v-.5C12.188 4.825 10.328 3 8 3a4.53 4.53 0 0 0-2.941 1.1z"/>
                </svg>
            </div>
            <p class="text-muted mb-1 small">Select your file or drag and drop it here</p>
            <p class="text-muted small mb-2">CSV, XLS or XLSX (max. 800MB)</p>
            <button class="btn btn-primary browsebtn px-3 py-1" onclick="document.getElementById('fileInput').click()">
                Browse File
            </button>
            <input type="file" id="fileInput" hidden accept=".csv,.xls,.xlsx">
        </div>
    `;
    
    // Reset other form elements
    fileInput.value = '';
    dragArea.style.display = 'block';
    fieldMapping.style.display = 'none';
    
    // Show form column and reset to first step
    const formColumn = document.getElementById('formColumn');
    if (formColumn) {
        formColumn.style.display = 'block';
        currentStep = 1;
        showStep(1);
        document.querySelectorAll('.form-step input, .form-step select').forEach(input => {
            input.value = '';
        });
    }
    
    // Show OR divider
    const orDivider = document.querySelector('.or-divider');
    if (orDivider) {
        orDivider.style.display = 'flex';
    }
}

// Initialize Bootstrap tabs
var triggerTabList = [].slice.call(document.querySelectorAll('#providerTabs button'))
triggerTabList.forEach(function (triggerEl) {
    var tabTrigger = new bootstrap.Tab(triggerEl)
    triggerEl.addEventListener('click', function (event) {
        event.preventDefault()
        tabTrigger.show()
    })
})

// Optional: Add animation when switching tabs
document.querySelectorAll('#providerTabs button').forEach(tab => {
    tab.addEventListener('shown.bs.tab', function (event) {
        const targetPanel = document.querySelector(event.target.dataset.bsTarget)
        targetPanel.style.opacity = 0
        setTimeout(() => {
            targetPanel.style.opacity = 1
        }, 50)
    })
})

// Add this to your existing JavaScript
document.addEventListener('DOMContentLoaded', function() {
    // Handle Facility Type
    const facilityType = document.getElementById('facilityType');
    const otherFacilityType = document.getElementById('otherFacilityType');
    const otherFacilityInput = otherFacilityType.querySelector('input');

    facilityType.addEventListener('change', function() {
        if (this.value === 'other') {
            otherFacilityType.style.display = 'block';
            otherFacilityInput.required = true;
        } else {
            otherFacilityType.style.display = 'none';
            otherFacilityInput.required = false;
            otherFacilityInput.value = ''; // Clear the input when hidden
        }
    });

    // Handle Ownership Type
    const ownershipType = document.getElementById('ownershipType');
    const otherOwnershipType = document.getElementById('otherOwnershipType');
    const otherOwnershipInput = otherOwnershipType.querySelector('input');

    ownershipType.addEventListener('change', function() {
        if (this.value === 'other') {
            otherOwnershipType.style.display = 'block';
            otherOwnershipInput.required = true;
        } else {
            otherOwnershipType.style.display = 'none';
            otherOwnershipInput.required = false;
            otherOwnershipInput.value = ''; // Clear the input when hidden
        }
    });
});

function showThankYouMessage(fromBulkUpload = false) {
    // Hide the entire container except header and footer
    const container = document.querySelector('.container-fluid.py-4');
    if (container) {
        container.style.display = 'none';
    }
    
    // Show and update the thank you message
    const thankYouMessage = document.getElementById('thankYouMessage');
    if (thankYouMessage) {
        // Update message and button based on source
        if (fromBulkUpload) {
            thankYouMessage.querySelector('p.text-muted').textContent = 'Your file has been successfully submitted and fields have been mapped.';
            thankYouMessage.querySelector('button').textContent = 'Upload Another File';
            thankYouMessage.querySelector('button').onclick = resetForm;
        } else {
            thankYouMessage.querySelector('p.text-muted').textContent = "We've successfully registered your facility as a Health Care Provider.";
            thankYouMessage.querySelector('button').textContent = 'Return To Home';
            thankYouMessage.querySelector('button').onclick = () => window.location.href = '/';
        }

        // Move thank you message outside the main container
        document.body.insertBefore(thankYouMessage, document.querySelector('footer'));
        thankYouMessage.style.display = 'block';
        thankYouMessage.style.margin = '4rem auto';
        thankYouMessage.style.maxWidth = '600px';
        
        // Scroll to thank you message
        thankYouMessage.scrollIntoView({ 
            behavior: 'smooth',
            block: 'center'
        });
    }
}
// Global object to store form data
// Global object to store form data
let formData = {};

// Function to collect data from each step
function collectFormData(step) {
    console.log(`Collecting data from Step ${step}...`);
    const form = document.getElementById(`step${step}`);
    const formElements = form.elements;
    
    for (let element of formElements) {
        if (element.name) {
            if (element.type === 'radio') {
                if (element.checked) {
                    // Convert 'yes'/'no' to boolean for radio buttons
                    formData[element.name] = element.value === 'yes';
                    console.log(`${element.name}: ${formData[element.name]} (radio button)`);
                }
            } else {
                formData[element.name] = element.value;
                console.log(`${element.name}: ${formData[element.name]}`);
            }
        }
    }
    console.log(`Step ${step} data collection complete.`);
}

// Main submit form function
async function submitForm(event) {
    if (event) {
        event.preventDefault();
    }

    console.log('Starting form submission process...');
    console.log('-----------------------------------');

    // Collect data from all steps
    collectFormData(1);
    collectFormData(2);
    collectFormData(3);

    // Initialize operating_hours as null
    let operatingHours = null;

    // Only collect operating hours if not 24 hours
    if (formData.is_24hours === false) {
        console.log('Collecting operating hours (not 24/7)...');
        operatingHours = {};
        
        const timeSlots = document.querySelectorAll('.time-slot');
        timeSlots.forEach(slot => {
            const day = slot.querySelector('.day-label').textContent.toLowerCase();
            const startTime = slot.querySelector(`input[name="${day}_start"]`).value;
            const endTime = slot.querySelector(`input[name="${day}_end"]`).value;
            
            if (startTime && endTime) {
                operatingHours[day] = {
                    start_time: startTime,
                    end_time: endTime
                };
                console.log(`Operating hours for ${day}: ${startTime} to ${endTime}`);
            }
        });
    }

    // Prepare the final data object
    const finalData = {
        organization_name: formData.org_name,
        facility_type: formData.facility_type,
        other_facility_type: formData.facility_type === 'other' ? formData.other_facility_type : null,
        ownership_type: formData.ownership_type,
        other_ownership_type: formData.ownership_type === 'other' ? formData.other_ownership_type : null,
        email_address: formData.email_address,
        phone_number: formData.phone_number,
        country: document.getElementById('country').value,
        state: document.getElementById('state').value,
        city: formData.city,
        zipcode: formData.zipcode,
        google_map_link: formData.google_map_link || null,
        is_ae_available: formData.ae_available || false,
        is_24hours: formData.is_24hours,
        operating_hours: operatingHours // This will be null if is_24hours is true
    };

    console.log('Final data prepared for submission:', finalData);
    console.group('Data Validation Checks');
    console.log('Required fields present:', checkRequiredFields(finalData));
    console.log('Email format valid:', isValidEmail(finalData.email_address));
    console.log('Phone format valid:', isValidPhone(finalData.phone_number));
    console.groupEnd();

    try {
        console.log('Attempting to submit data to server...');
        // Get CSRF token
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
        
        // Send the data to the server
        const response = await fetch('/healthcare-providers', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify(finalData)
        });

        const result = await response.json();

        if (response.ok) {
            console.log('%cForm submission successful!', 'color: green; font-weight: bold');
            console.log('Server response:', result);
            
            // Show success message
            showThankYouMessage(false);
            // Reset form data
            formData = {};
        } else {
            console.error('Server returned an error:', response.status);
            console.error('Error details:', result);

            // Show validation errors if any
            if (response.status === 422) {
                console.group('Validation Errors');
                const errors = result.errors;
                let errorMessage = 'Please correct the following errors:\n';
                for (const field in errors) {
                    console.error(`${field}:`, errors[field]);
                    errorMessage += `\n${errors[field].join('\n')}`;
                }
                console.groupEnd();
                alert(errorMessage);
            } else {
                throw new Error(result.message || 'Submission failed');
            }
        }
    } catch (error) {
        console.error('%cForm submission failed!', 'color: red; font-weight: bold');
        console.error('Error details:', error);
        alert('Failed to submit the form. Please try again.');
    }
}

// Helper function to check required fields
function checkRequiredFields(data) {
    const requiredFields = [
        'organization_name',
        'facility_type',
        'ownership_type',
        'email_address',
        'phone_number',
        'country',
        'state',
        'city',
        'zipcode'
    ];
    
    const missingFields = requiredFields.filter(field => !data[field]);
    if (missingFields.length > 0) {
        console.warn('Missing required fields:', missingFields);
    }
    return missingFields.length === 0;
}

// Helper function to validate email format
function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

// Helper function to validate phone format
function isValidPhone(phone) {
    // This is a basic validation - adjust based on your requirements
    const phoneRegex = /^[+]?[\d\s-]{8,}$/;
    return phoneRegex.test(phone);
}
 </script>
</body>

</html>