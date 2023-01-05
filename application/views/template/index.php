<!DOCTYPE html>
<html lang="en">
	<head>
		<?php $this->load->view('template/head');?>
	</head>

	<body class="main-body  app">
				
		<!-- Loader -->
		<div id="global-loader">
			<img src="<?=base_url();?>assets/img/loaders/loader-4.svg" class="loader-img" alt="Loader">
        </div>
		<!-- /Loader -->

		<!-- page -->
		<div class="page">

			<!-- main-header opened -->
			<?php $this->load->view('template/main-header');?>
			<!-- main-header closed -->

			<!--Horizontal-main -->
			<?php if($this->session->role_id == 1) { ?>
				<?php $this->load->view('template/horizontal-main');?>
			<?php } elseif($this->session->role_id == 3) {  ?>
				<?php $this->load->view('template/horizontal-main-kasubsi');?>
			<?php } else {  ?>
				<?php $this->load->view('template/horizontal-main-user');?>
			<?php } ?>
			<!--Horizontal-main -->

			<!-- main-content opened -->
			<div class="main-content horizontal-content">

				<!-- container opened -->
				<div class="container" id="konten">
				<?php if(isset($konten)){ ?>
        
				<?php $this->load->view($konten); ?>
				
				<?php }else{  ?>

					<?php echo "File Konten Tidak Ada"; ?>

				<?php } ?>
				</div>
				<!-- Container closed -->

			</div>
			<!-- main-content closed -->

			<!--Sidebar-right-->
			<?php $this->load->view('template/sidebar-right');?>
			<!--/Sidebar-right-->

			<!-- Footer opened -->
			<?php $this->load->view('template/footer');?>
			<!-- Footer closed -->

		</div>
		<!-- end page -->

		<!--- Back-to-top --->
		<a href="#top" id="back-to-top"><i class="las la-angle-double-up"></i></a>

		<!-- Footer opened -->
		<?php $this->load->view('template/js');?>
		<!-- Footer closed -->

		<script type="text/javascript">
			delJanjiOtomatis();

			$(document).off("click", ".menuclick").on("click", ".menuclick", function(event, messages) {
				event.preventDefault()
				var url = $(this).attr("href");
				var title = $(this).attr("title");
				$("a").removeClass('active');
				$(this).addClass('active');
				$(this).parent().addClass('active').siblings().removeClass('active');

				// $("#content").html("<img src='{{ asset("assets/img/loaders/loader-4.svg") }}' class='loader-img' alt='Loader'>");
				$.get(url, {
					ajax: "yes"
				}, function(data) {
					// $('.modal.aside').remove();
					history.replaceState(title, title, url);
					$(".uri").val(url);
					$('title').html(title);
					$("#konten").html(data);
				})
			})

			function delJanjiOtomatis(){
				$.ajax({
					url: '<?=base_url()?>perhak/deleteJanjiOtomatis',
					type: 'POST',
					success: function(res){
					}
				})
			}
		</script>

	</body>
</html>