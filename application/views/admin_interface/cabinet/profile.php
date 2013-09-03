<!DOCTYPE html>
<html lang="en">
<head>
<?php $this->load->view("admin_interface/includes/head");?>
</head>
<body>
	<div id="wrap">
		<?php $this->load->view("admin_interface/includes/header");?>
		<div class="container">
			<div class="row">
				<?php $this->load->view("admin_interface/includes/sidebar");?>
				<div class="span9">
					<ul class="breadcrumb">
						<li class="active">Мой профиль</li>
					</ul>
					<p><?=$this->session->userdata('msgs');?></p>
					<?php $this->load->view("admin_interface/forms/profile-admin");?>
				</div>
			</div>
		</div>
		<div id="push"></div>
	</div>
	<?php $this->load->view("admin_interface/includes/footer");?>
	<?php $this->load->view("admin_interface/includes/scripts");?>
</body>
</html>
