<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
	<div>
		<h4 class="content-title mb-2">Hi, welcome back!</h4>
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="#">Dashoard</a></li>
				<li class="breadcrumb-item active" aria-current="page"> blank</li>
			</ol>
		</nav>
			</div>
	<div class="d-flex my-auto">
	</div>
</div>
<!-- /breadcrumb -->

<!-- row -->
<div class="row row-sm ">
	<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
		<?php if($this->session->role_id == 1){
			$this->load->view('dashboard/index_admin');
		}elseif($this->session->role_id == 2){
			$this->load->view('dashboard/index_member');
		}elseif($this->session->role_id == 3){
			$this->load->view('dashboard/index_kasubsi');
		}else{
			redirect('auth/signin');
		}
		?>
	</div>
</div>
<!-- /row -->