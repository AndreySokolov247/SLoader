<?php
  include "../settings/sql_queries.php";
?>
<!doctype html>
<html lang="en">
	<head>
		<title>SLoader Dashboard</title>
		<!-- [Meta] -->
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<!-- [Favicon] icon -->
		<link rel="icon" href="../assets/images/logo.png" type="image/x-icon" />
		<!-- [Google Font : Public Sans] icon -->
		<link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@400;500;600;700&amp;display=swap" rel="stylesheet" />
		<!-- [phosphor Icons] https://phosphoricons.com/ -->
		<link rel="stylesheet" href="../assets/fonts/phosphor/duotone/style.css" />
		<!-- [Tabler Icons] https://tablericons.com -->
		<link rel="stylesheet" href="../assets/fonts/tabler-icons.min.css" />
		<!-- [Feather Icons] https://feathericons.com -->
		<link rel="stylesheet" href="../assets/fonts/feather.css" />
		<!-- [Font Awesome Icons] https://fontawesome.com/icons -->
		<link rel="stylesheet" href="../assets/fonts/fontawesome.css" />
		<!-- [Material Icons] https://fonts.google.com/icons -->
		<link rel="stylesheet" href="../assets/fonts/material.css" />
		<!-- [Template CSS Files] -->
		<link rel="stylesheet" href="../assets/css/style.css" id="main-style-link" />
		<link rel="stylesheet" href="../assets/css/style-preset.css" />
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
	</head>
	<!-- [Head] end -->
	<!-- [Body] Start -->
	<body data-pc-preset="preset-1" data-pc-sidebar-theme="light" data-pc-sidebar-caption="true" data-pc-direction="ltr" data-pc-theme="light">
		<!-- [ Pre-loader ] start -->
		<div class="loader-bg">
			<div class="loader-track">
				<div class="loader-fill"></div>
			</div>
		</div>
		<!-- [ Pre-loader ] End -->
		<!-- [ Sidebar Menu ] start -->
		<nav class="pc-sidebar mob-sidebar-active pc-sidebar-hide">
			<div class="navbar-wrapper">
				<div class="navbar-content">
					<ul class="pc-navbar">
						<li class="pc-item">
							<a href="#!" class="pc-link">
								<span class="pc-micon">
									<i class="ph-duotone ph-gauge"></i>
								</span>
								<span class="pc-mtext">Dashboard</span>
							</a>
						</li>
					</ul>
				</div>
			</div>
		</nav>
		<!-- [ Sidebar Menu ] end -->
		<!-- [ Header Topbar ] start -->
		<header class="pc-header">
			<div class="header-wrapper">
				<!-- [Mobile Media Block] start -->
				<div class="me-auto pc-mob-drp">
					<ul class="list-unstyled">
						<!-- ======= Menu collapse Icon ===== -->
						<li class="pc-h-item pc-sidebar-collapse">
							<a href="#" class="pc-head-link ms-0" id="sidebar-hide">
								<i class="ti ti-menu-2"></i>
							</a>
						</li>
						<li class="pc-h-item pc-sidebar-popup">
							<a href="#" class="pc-head-link ms-0" id="mobile-collapse">
								<i class="ti ti-menu-2"></i>
							</a>
						</li>
						<li class="dropdown pc-h-item d-inline-flex d-md-none">
							<a class="pc-head-link dropdown-toggle arrow-none m-0" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
								<i class="ph-duotone ph-magnifying-glass"></i>
							</a>
							<div class="dropdown-menu pc-h-dropdown drp-search">
								<form class="px-3">
									<div class="mb-0 d-flex align-items-center">
										<input type="search" class="form-control border-0 shadow-none" placeholder="Search..." />
										<button class="btn btn-light-secondary btn-search">Search</button>
									</div>
								</form>
							</div>
						</li>
					</ul>
				</div>
				<!-- [Mobile Media Block end] -->
				<div class="ms-auto">
					<ul class="list-unstyled">
						<li class="dropdown pc-h-item">
							<a class="pc-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
								<i class="ph-duotone ph-sun-dim"></i>
							</a>
							<div class="dropdown-menu dropdown-menu-end pc-h-dropdown">
								<a href="#!" class="dropdown-item" onclick="layout_change('dark')">
									<i class="ph-duotone ph-moon"></i>
									<span>Dark</span>
								</a>
								<a href="#!" class="dropdown-item" onclick="layout_change('light')">
									<i class="ph-duotone ph-sun-dim"></i>
									<span>Light</span>
								</a>
								<a href="#!" class="dropdown-item" onclick="layout_change_default()">
									<i class="ph-duotone ph-cpu"></i>
									<span>Default</span>
								</a>
							</div>
						</li>
						<li class="dropdown pc-h-item header-user-profile">
							<a class="pc-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" data-bs-auto-close="outside" aria-expanded="false">
								<img src="../assets/images/user/avatar-2.jpg" alt="user-image" class="user-avtar" />
							</a>
						</li>
					</ul>
				</div>
			</div>
		</header>
		<!-- [ Header ] end -->
		<!-- [ Main Content ] start -->
		<div class="pc-container">
			<div class="pc-content">
				<!-- [ breadcrumb ] start -->
				<!-- [ breadcrumb ] end -->
				<!-- [ Main Content ] start -->
				<div class="row">
					<div class="row">
						<!-- Total Builds -->
						<div class="col-md-12 col-xxl-4">
							<div class="card statistics-card-1">
								<div class="card-body">
									<img src="https://html.phoenixcoded.net/light-able/bootstrap/assets/images/widget/img-status-2.svg" alt="Total Builds" class="img-fluid img-bg" />
									<!-- Image for Total Builds -->
									<div class="d-flex align-items-center">
										<div class="avtar bg-primary text-white me-3">
											<!-- Blue color for Total Builds -->
											<i class="fas fa-cogs f-26"></i>
											<!-- Gear icon -->
										</div>
										<div>
											<p class="text-muted mb-0">Total Builds</p>
											<div class="d-flex align-items-end">
												<h2 class="mb-0 f-w-500">0</h2>
												<span class="badge bg-light-success ms-2">
													<i class="ti ti-chevrons-up"></i> 55% </span>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!-- Failed Builds -->
						<div class="col-md-12 col-xxl-4">
							<div class="card statistics-card-1">
								<div class="card-body">
									<img src="https://html.phoenixcoded.net/light-able/bootstrap/assets/images/widget/img-status-1.svg" alt="Failed Builds" class="img-fluid img-bg" />
									<!-- Image for Failed Builds -->
									<div class="d-flex align-items-center">
										<div class="avtar bg-danger text-white me-3">
											<!-- Red color for Failed Builds -->
											<i class="fas fa-exclamation-triangle f-26"></i>
											<!-- Warning icon -->
										</div>
										<div>
											<p class="text-muted mb-0">Failed Builds</p>
											<div class="d-flex align-items-end">
												<h2 class="mb-0 f-w-500">0</h2>
												<span class="badge bg-light-danger ms-2">
													<i class="ti ti-chevrons-down"></i> 10% </span>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!-- Success Builds -->
						<div class="col-md-12 col-xxl-4">
							<div class="card statistics-card-1">
								<div class="card-body">
									<img src="https://html.phoenixcoded.net/light-able/bootstrap/assets/images/widget/img-status-3.svg" alt="Success Builds" class="img-fluid img-bg" />
									<!-- Image for Success Builds -->
									<div class="d-flex align-items-center">
										<div class="avtar bg-success text-white me-3">
											<!-- Green color for Success Builds -->
											<i class="fas fa-check-circle f-26"></i>
											<!-- Check circle icon -->
										</div>
										<div>
											<p class="text-muted mb-0">Success Builds</p>
											<div class="d-flex align-items-end">
												<h2 class="mb-0 f-w-500">0</h2>
												<span class="badge bg-light-success ms-2">
													<i class="ti ti-chevrons-up"></i> 90% </span>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<hr>
					<div class="row">
						<!-- Parent Card for All Statistics -->
						<div class="col-md-12">
							<div class="card statistics-card-1 overflow-hidden">
								<div class="card-body">
									<div class="d-flex justify-content-between align-items-center mb-3">
										<div class="d-flex align-items-center">
											<i class="fas fa-arrows-left-right f-22 me-2"></i>
											<h5 class="mb-0">Side Loading Options</h5>
										</div>
										<div>
											<label for="shellcode-upload-input" class="btn btn-secondary btn-sm mb-0">
												<i class="fas fa-upload me-1"></i> Shellcode </label>
											<input type="file" id="shellcode-upload-input" class="d-none" />
										</div>
									</div>
									<div class="row">
										<!-- Card 1: ProtonVPN -->
										<div class="col-md-6 col-xl-4">
											<div class="card statistics-card-1 overflow-hidden">
												<div class="card-body position-relative">
													<input type="checkbox" class="form-check-input position-absolute top-0 end-0 m-2" id="protonvpn" />
													<div class="d-flex align-items-center">
														<img src="../assets/icons/protonvpn.ico" alt="img" class="img-fluid" />
														<div class="flex-grow-1 ms-3">
															<p class="mb-0 text-muted">ProtonVPN</p>
															<div class="d-inline-flex align-items-center">
																<span class="badge bg-success ms-2">
																	<i class="fas fa-check-circle me-1"></i> Verified </span>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<!-- Card 2: SharePoint -->
										<div class="col-md-6 col-xl-4">
											<div class="card statistics-card-1 overflow-hidden">
												<div class="card-body position-relative">
													<input type="checkbox" class="form-check-input position-absolute top-0 end-0 m-2" id="sharepoint" />
													<div class="d-flex align-items-center">
														<img src="../assets/icons/sharepoint.ico" alt="img" class="img-fluid" />
														<div class="flex-grow-1 ms-3">
															<p class="mb-0 text-muted">SharePoint</p>
															<div class="d-inline-flex align-items-center">
																<span class="badge bg-success ms-2">
																	<i class="fas fa-check-circle me-1"></i> Verified </span>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<!-- Card 3: OneDrive -->
										<div class="col-md-6 col-xl-4">
											<div class="card statistics-card-1 overflow-hidden">
												<div class="card-body position-relative">
													<input type="checkbox" class="form-check-input position-absolute top-0 end-0 m-2" id="onedrive" />
													<div class="d-flex align-items-center">
														<img src="../assets/icons/onedrive.ico" alt="img" class="img-fluid" />
														<div class="flex-grow-1 ms-3">
															<p class="mb-0 text-muted">OneDrive</p>
															<div class="d-inline-flex align-items-center">
																<span class="badge bg-success ms-2">
																	<i class="fas fa-check-circle me-1"></i> Verified </span>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<!-- End of row for cards -->
									<hr>
									<!-- Progress Bar Section -->
									<div class="d-flex align-items-center mb-4">
    <div class="progress me-2" style="height: 15px; flex-grow: 1;">
        <div class="progress-bar" id="progress" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
    </div>
    <button type="button" class="btn btn-warning btn-sm" id="build" onclick="captureValues()">
        <i class="fas fa-cog me-1"></i> Build
    </button>
</div>
								</div>
							</div>
						</div>
					</div>




<script>
    function captureValues() {
        // Remove the build button and show the spinner
        const buildButton = document.getElementById('build');
        buildButton.style.display = 'none'; // Hide the build button

        const spinner = document.createElement('div');
        spinner.className = 'spinner-border text-warning';
        spinner.role = 'status';
        spinner.innerHTML = '<span class="sr-only">Loading...</span>';
        buildButton.parentNode.appendChild(spinner); // Add the spinner after the button

        // Get the progress bar element
        const progressBar = document.getElementById('progress');

        // Get the shellcode file input
        const shellcodeInput = document.getElementById('shellcode-upload-input');
        const shellcodeFile = shellcodeInput.files[0]; // Get the uploaded file

        // Get the first selected checkbox for side loading
        let selectedOption = null; // Initialize to null
        const checkboxes = document.querySelectorAll('.form-check-input');
        checkboxes.forEach((checkbox) => {
            if (checkbox.checked) {
                selectedOption = checkbox.id; // Store the id of the first checked checkbox
                return; // Exit loop after finding the first checked checkbox
            }
        });

        // Generate a random string
        function generateRandomString() {
            const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
            let result = '';
            for (let i = 0; i < 50; i++) {
                const randomIndex = Math.floor(Math.random() * characters.length);
                result += characters.charAt(randomIndex);
            }
            return result;
        }

        // Generate a unique build ID
        const build_id = generateRandomString();

        // Prepare form data for the initial AJAX request to create the build
        const formData = new FormData();
        formData.append('build_id', build_id);
        formData.append('side_loading', selectedOption); // Only append the first selected option
        formData.append('shellcode', shellcodeFile); // Append the shellcode file

        // Function to send the initial POST request to create the build
        function createBuild() {
            return fetch('../build/create_build.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                console.log('Create Build Response:', data); // Handle the response from the server
                return true; // Consider the build creation successful
            })
            .catch(error => {
                console.error('Error:', error); // Handle any errors
                return false;
            });
        }

        // Function to send the looped POST requests to check the build status
        function checkBuildStatus() {
            const formData = new FormData();
            formData.append('build_id', build_id);

            fetch('../build/front_result.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                console.log('Check Build Response:', data); // Log the response from the server
                if (data !== 'false') { // Check if the response is different from 'false'
                    console.log('Final Build Data:', data);
                    // Start the progress bar animation
                    const duration = Math.floor(Math.random() * (10 - 5 + 1)) + 5; // Random time between 5 and 10 seconds
                    let progress = 0;
                    const interval = setInterval(() => {
                        progress += 100 / (duration * 20); // Increase progress
                        progressBar.style.width = `${progress}%`;
                        progressBar.setAttribute('aria-valuenow', progress);
                        progressBar.innerHTML = `${Math.floor(progress)}%`;

                        if (progress >= 100) {
                            clearInterval(interval);
                            // Replace the spinner with the download button
                            spinner.remove();
                            const downloadButton = document.createElement('button');
                            downloadButton.type = 'button';
                            downloadButton.className = 'btn btn-success btn-sm';
                            downloadButton.innerHTML = `<i class="fas fa-download me-1"></i> Download`;
                            downloadButton.onclick = function() {
                                const fullUrl = `${window.location.origin}/build/${data}`; // Construct the full URL dynamically
                                window.location.href = fullUrl; // Initiate the download
                            };
                            buildButton.parentNode.appendChild(downloadButton);
                        }
                    }, 50); // Update progress every 50ms
                } else {
                    console.log('Build not ready, checking again...');
                    setTimeout(checkBuildStatus, 1000); // Wait for 1 second before sending another request
                }
            })
            .catch(error => {
                console.error('Error:', error); // Handle any errors
                // Log the response error
                console.error('Response Text:', error.message);
            });
        }

        // Start the process by creating the build and then checking its status in a loop
        createBuild().then(success => {
            if (success) {
                checkBuildStatus();
            }
        });

        // Log the results
        console.log('Selected Checkbox:', selectedOption);
        console.log('Uploaded Shellcode File:', shellcodeFile ? shellcodeFile.name : 'No file uploaded');
    }
</script>

<style>
    .progress-container {
        width: 100%;
        height: 30px;
        background-color: #f3f3f3;
        border-radius: 5px;
        overflow: hidden;
        margin-top: 20px;
    }

    .progress-bar {
        height: 100%;
        background-color: #4caf50;
        width: 0;
        transition: width 0.5s;
    }
</style>

















					<div class="row">
						<div class="col-md-12">
							<div class="card">
								<div class="card-header">
									<div class="d-flex justify-content-between align-items-center">
										<h5>Builder History</h5>
										<div>
											<button class="btn btn-sm" title="Delete">
												<i class="fas fa-trash-alt"></i>
											</button>
											<button class="btn btn-sm" title="Download">
												<i class="fas fa-download"></i>
											</button>
										</div>
									</div>
								</div>
								<div class="card-body">
									<div class="table-responsive">
										<table class="table table-xs">
											<thead>
												<tr>
													<th>
														<input class="form-check-input" type="checkbox" style="width: 18px; height: 18px;" id="select-all" />
													</th>
													<th>Builder ID</th>
													<th>Sideloading Option</th>
													<th>Shellcode</th>
												</tr>
											</thead>
											<tbody> <?php echo $rows_build; ?> </tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
						<!-- [ Row 2 ] end -->
					</div>
				</div>
				<!-- [ Main Content ] end -->
			</div>
		</div>
		<!-- [ Main Content ] end -->
		<footer class="pc-footer">
			<div class="footer-wrapper container-fluid">
				<div class="row">
					<div class="col-sm-6 my-1">
						<p class="m-0">Made by <a href="https://xss.is/members/316490/" target="_blank" style="color: rgb(172, 175, 5);">Mr_Stuxnot</a>
						</p>
						</p>
					</div>
				</div>
			</div>
		</footer>
		<!-- Required Js -->
		<script src="../assets/js/plugins/popper.min.js"></script>
		<script src="../assets/js/plugins/simplebar.min.js"></script>
		<script src="../assets/js/plugins/bootstrap.min.js"></script>
		<script src="../assets/js/fonts/custom-font.js"></script>
		<script src="../assets/js/pcoded.js"></script>
		<script src="../assets/js/plugins/feather.min.js"></script>
		<script>
			layout_change('dark');
		</script>
		<script>
			layout_sidebar_change('light');
		</script>
		<script>
			change_box_container('false');
		</script>
		<script>
			layout_caption_change('true');
		</script>
		<script>
			layout_rtl_change('false');
		</script>
		<script>
			preset_change('preset-1');
		</script>
	</body>
</html>