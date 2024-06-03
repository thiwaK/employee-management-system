<?php
	include("../include/header.php");
    // include('../phpclasses/pagination.php');
	include("../include/db_connect.php");
	include("../include/validate_login.php");

	if (!in_array($usertype, $allowedRoles)){
		echo "Unauthorized.";
		exit;
	}

    $limit = 10;
	$getempcount = 0;

	if ($getempcount > 0){				
		//initialize pagination class
		$pagConfig = array(
			'totalRows' => $getempcount,
			'perPage' => $limit,
			'link_func' => 'searchFilter'
		);
		$pagination =  new Pagination($pagConfig);
	}
?>

<div class="container-fluid">
	<div class="row ml-0 mr-0">
		<!-- Left sidebar for navigation -->
		<section class="col-lg-2 col-md-3 left border-right m-0" >
			<?php include("../include/sidebar.php"); ?>
		</section>

		<!-- Main content area -->
		<section class="col-md-8 col-lg-9 right border-left m-0">
			<?php include("../templates/division.php"); ?>
		</section>
	</div>

	<?php include("../include/context_menu.php"); ?>
    <?php include("../templates/employee_context.php"); ?>
	<?php include("../include/notification_model.php"); ?>


	<script>

		const employeeTableBody = document.getElementById('divisionTableBody');
		const pgHeaderElement = document.getElementById('pg_header');
		const searchElement = document.getElementById('search');
		const searchOptionElement = document.getElementById('search_option');
		// const searchButton = document.getElementById('saerch_button');
		Notify = new Notify();


		// const pagination = document.getElementById('pagination');
		const fullUrl = window.location.pathname + window.location.search;
		const urlObject = new URL(fullUrl, window.location.origin);
		const params = new URLSearchParams(urlObject.search);
		const qValue = params.get('q');

        console.log(qValue);

        // Division Filter
		if (qValue.toLowerCase() == "a" && pgHeaderElement){
			pgHeaderElement.textContent = 'Administration';
		} else if (qValue.toLowerCase() == 'sc' && pgHeaderElement){
			pgHeaderElement.textContent = 'Soil Conservation';
		} else if (qValue.toLowerCase() == 'a_c' && pgHeaderElement){
			pgHeaderElement.textContent = 'Agro-Climatology & Climate';
		}else if (qValue.toLowerCase() == 'lup_g' && pgHeaderElement){
			pgHeaderElement.textContent = 'Land Use Planning & Geo-Informatics';
		}else if (qValue.toLowerCase() == 'lawrm' && pgHeaderElement){
			pgHeaderElement.textContent = 'Land and Water Resouces Management';
		}else if (qValue.toLowerCase() == 'km' && pgHeaderElement){
			pgHeaderElement.textContent = 'Knowledge Management';
        }

		function fetchEmployees(page = 1, update=0) {

			const searchValue = searchElement.value;
			const selectedValue = searchOptionElement.value;
			var url = '../API/get_employee.php?q=' + encodeURIComponent(qValue);

			if (searchValue) {
				url += '&s=' + searchValue + '&o=' + selectedValue;
			}

			fetch(url)
				.then(response => response.json())
				.then(data => {
					// console.log(data);
					populateTable(data);
					// createPagination(data.totalPages, page);
					if (update){Notify.Success("Success", "Table updated");}
					
				})
				.catch(error => {
					console.error('Error fetching employee data:', error);
					employeeTableBody.innerHTML = '<tr><td colspan="5">Error loading data</td></tr>';
					if (update){Notify.Error("Failed", "Table updated error")}
				});
		}

		function populateTable(employees) {
			employeeTableBody.innerHTML = ''; // Clear existing rows
			if (employees.length > 0) {
				employees.forEach(employee => {
					const row = document.createElement('tr');
					row.className = 'emp_row';
					row.dataset.id = employee.employee_number;

					row.innerHTML = `
						<td class="emp_id">${employee.employee_number}</td>
						<td>${employee.name_with_initials}</td>
						<td>${employee.designation}</td>
						<td>${employee.division_name}</td>
						<td>${employee.service_category}</td>
					`;
					employeeTableBody.appendChild(row);
				});
			} else {
				employeeTableBody.innerHTML = '<tr><td colspan="5">No employee record found</td></tr>';
			}
		}

		// searchButton.addEventListener('click', function(event) {
		// 	fetchEmployees(update=1);
		// });

		document.getElementById('search_form').addEventListener('submit', function(event) {
			event.preventDefault();
			fetchEmployees(update=1);

		});

		document.addEventListener('DOMContentLoaded', function() {
			fetchEmployees();
		});

	</script>