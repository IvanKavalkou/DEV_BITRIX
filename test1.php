<?PHP
// api Битрикс24: https://dev.1c-bitrix.ru/rest_help/
require_once __DIR__ . '/components/main/component.php';
// require_once __DIR__ . '/components/table/component.php';
?>
<!DOCTYPE html>
<html lang="ru">

<head>
 <!-- #endregion -->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<title>Шахматка</title>

	<link type="image/png" sizes="16x16" rel="icon" href="public/image/icons8-планировщик-16.png">

	<!-- Custom fonts for this template-->
	<link href="public/css/sb-admin-2.min.css" rel="stylesheet" type="text/css">
	<link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

	<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">

	<!-- Custom styles for this template-->
	<link href="public/css/sb-admin-2.min.css?v=1" rel="stylesheet">
	<link rel="stylesheet" href="public/css/custom.css?v=1.6122">
</head>

<body id="page-top">
	<nav class="navbar navbar-expand navbar-light bg-white topbar static-top shadow">
		<div class="container-fluid">
			<img src="public/image/logo.png" alt="Logo" class="d-inline-block align-text-top logo">
			<span class="navbar-text" style="padding-right: 25px;">
				<?php echo $_SESSION['currentUser'] ?>
			</span>
		</div>
	</nav>
	<!-- Page Wrapper -->
	<div id="wrapper">

		<!-- Content Wrapper -->
		<div id="content-wrapper" class="d-flex flex-column">

			<!-- Main Content -->
			<div id="content">

				<!-- Begin Page Content -->
				<div class="container-fluid">

					<!-- Content Row -->
					<div class="row">

						<div class="col-xl-3 col-md-6 mb-4">
							<div class="card border-left-primary shadow h-100 py-2">
								<div class="card-body">
									<div class="row no-gutters align-items-center">
										<div class="col mr-2">
											<div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Фильтр по дате</div>
											<div class="h5 mb-0 font-weight-bold text-gray-800">
												<input type="text" class="form-control form__input" name="daterange" value="<?php echo $startDay; ?> - <?php echo $endDay; ?>" />
											</div>
											<div class="mb-0 font-weight-bold text-gray-800 padding-top">
												<button data-filter data-period="current_week" class="d-none btn-up d-sm-inline-block btn btn-sm btn-primary shadow-sm">Тек. неделя</button>
												<button data-filter data-period="next_week" class="d-none btn-up d-sm-inline-block btn btn-sm btn-primary shadow-sm">След. неделя</button>
												<button data-filter data-period="current_month" class="d-none btn-up d-sm-inline-block btn btn-sm btn-primary shadow-sm">Тек. месяц</button>
												<button data-filter data-period="next_month" class="d-none btn-up d-sm-inline-block btn btn-sm btn-primary shadow-sm">След. месяц</button>
											</div>
										</div>
										<div class="col-auto">
											<i class="fas fa-calendar fa-2x text-gray-300"></i>
										</div>
									</div>
								</div>
							</div>
						</div>

						<!-- Earnings (Monthly) Card Example -->
						<div class="col-xl-3 col-md-6 mb-4">
							<div class="card border-left-success shadow h-100 py-2">
								<div class="card-body">
									<div class="row no-gutters align-items-center">
										<div class="col mr-2">
											<div class="text-xs font-weight-bold text-success text-uppercase mb-1">Фильтр по комнате</div>
											<div class="h5 mb-0 font-weight-bold text-gray-800">
												<select class="form-control form__input selectpicker" data-live-search="true" name="room__filter" multiple title="Выбрано все">
													<?php foreach ($roomList as $room) : ?>
														<option <?php echo (in_array($room['ID'], $_SESSION['filters']['rooms'])) ? 'selected' : '' ?> value="<?php echo $room['ID'] ?>"><?php echo $room['NAME'] ?></option>
													<? endforeach; ?>
												</select>
											</div>
										</div>
										<div class="col-auto">
											<i class="fas fa-house fa-2x text-gray-300"></i>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<!-- Content Row -->

					<div class="row">

						<!-- Area Chart -->
						<div class="col-xl-12 col-lg-12">
							<div class="card shadow mb-4">
								<!-- Card Header - Dropdown -->
								<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
									<h6 class="m-0 font-weight-bold text-primary">Шахматка</h6>
									<a href="#" data-reload class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-arrows-rotate fa-sm text-white-50"></i> Обновить</a>
								</div>
								<!-- Card Body -->
								<div class="card-body">
									<table data-table class="table table-bordered table-hover table-responsive">
										<thead>
											<tr>
												<th class="sticky w-1" rowspan="2">Смена</th>
												<th class="sticky w-2" rowspan="2">Сотрудник</th>
												<th class="sticky w-3" rowspan="2">День недели</th>
												<th class="sticky w-4" rowspan="2">Комнаты</th>
												<?php for ($i = 0; $i < count($times) - 1; $i += 4) : ?>
													<th colspan="4"><?php echo $times[$i]; ?></th>
												<? endfor; ?>
											</tr>
											<tr>
												<?php for ($i = 0; $i < count($times) - 1; $i++) : ?>
													<th><?php echo explode(':', $times[$i])[1]; ?></th>
												<? endfor; ?>
											</tr>
										</thead>
										<tbody></tbody>
									</table>
								</div>
							</div>
						</div>
					</div>

				</div>
				<!-- /.container-fluid -->

			</div>
			<!-- End of Main Content -->

			<!-- Footer -->
			<footer class="sticky-footer bg-white">
				<div class="container my-auto">
					<div class="copyright text-center my-auto">
						<span>Copyright &copy; SellUs <?php echo date('Y'); ?></span>
					</div>
				</div>
			</footer>
			<!-- End of Footer -->

		</div>
		<!-- End of Content Wrapper -->

	</div>
	<!-- End of Page Wrapper -->

	<!-- Scroll to Top Button-->
	<a class="scroll-to-top rounded" href="#page-top">
		<i class="fas fa-angle-up"></i>
	</a>

	<!-- Logout Modal-->
	<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Создать сделку?</h5>
					<button class="close" type="button" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">×</span>
					</button>
				</div>
				<form class="form__modal">
					<input type="hidden" name="ajax" value="Y">
					<input type="hidden" name="deal_id" value="">
					<div class="modal-body">
						<div class="form-group">
							<button type="button" data-deal_open data-open class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
								Сделка
							</button>
						</div>
						<div class="form-group">
							<label for="contact">Контакт</label>
							<div class="row">
								<div class="col">
									<input type="hidden" name="contact__modal" value="">
									<input class="form-control" type="text" id="contact" value="" name="contact__modal_name">
								</div>
								<button style="margin-right: 5px;" type="button" data-contact_search data-search class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm">
									<i class="fa-magnifying-glass fas fa-sm text-white-100"></i>
								</button>
								<button type="button" data-contact_open data-open class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
									<i class="fa-share-from-square fas fa-sm text-white-100"></i>
								</button>
							</div>
						</div>
						<div class="form-group">
						
							<label>Дата и время</label>
							<div class="row">
								<div class="col">
									<input type="text" class="form-control" name="daterange__modal">
								</div>
								<div class="col">
									<select class="form-control selectpicker" title="Начало" data-live-search="true" name="time-start__modal" multiple data-max-options="1">
										<?php foreach ($times as $ind => $hour) : ?>
											<option data-ind_start="<?php echo $ind ?>" value="<?php echo $hour ?>"><?php echo $hour ?></option>
										<? endforeach; ?>
									</select>
								</div>
								<div class="col">
									<select class="form-control selectpicker" title="Конец" data-live-search="true" name="time-end__modal" multiple data-max-options="1">
										<?php foreach ($times as $ind => $hour) : ?>
											<option data-ind_end="<?php echo $ind ?>" value="<?php echo $hour ?>"><?php echo $hour ?></option>
										<? endforeach; ?>
									</select>
								</div>
							</div>
						</div>
<!-- #endregion -->
						<input type="hidden" name="user-id" value="<?php echo $_SESSION['currentID']; ?>">

		const times = <?php echo json_encode($times); ?>;

</body>

</html>