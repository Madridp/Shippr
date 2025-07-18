<!--  Core JS Files   -->
<script src="<?php echo URL.PLUGINS.'jquery/jquery-3.2.1.min.js' ?>" type="text/javascript"></script>

<!-- jQuery UI CDN -->
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

<!-- Admin panel scripts -->
<script src="<?php echo URL.PLUGINS.'bootstrap/js/bootstrap.bundle.js' ?>" type="text/javascript"></script>
<script src="<?php echo URL.PLUGINS.'pace/pace.min.js'; ?>"></script>
<script src="<?php echo URL.PLUGINS.'perfect-scrollbar/js/perfect-scrollbar.jquery.min.js' ?>"></script>
<script src="<?php echo URL.PLUGINS.'waitMe/waitMe.min.js'; ?>"></script>

<!-- Lightbox -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.10.0/js/lightbox.min.js"></script>

<!-- Mask -->
<script src="<?php echo URL.JS.'jquery.mask.min.js'; ?>"></script>

<!-- Sweet Alert CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js" type="text/javascript"></script>

<!-- Morris Js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>

<!-- Charts js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js"></script>

<!-- js para DataTables -->
<script src="<?php echo URL.PLUGINS.'DataTables/media/js/jquery.dataTables.js' ?>"></script>
<script src="https://cdn.datatables.net/responsive/2.2.1/js/dataTables.responsive.js"></script>
<script src="assets/plugins/DataTables/media/js/dataTables.bootstrap.min.js"></script>
<script src="assets/plugins/DataTables/extensions/Buttons/js/dataTables.buttons.min.js"></script>
<script src="assets/plugins/DataTables/extensions/Buttons/js/buttons.bootstrap.min.js"></script>
<script src="assets/plugins/DataTables/extensions/Buttons/js/buttons.flash.min.js"></script>
<script src="assets/plugins/DataTables/extensions/Buttons/js/jszip.min.js"></script>
<script src="assets/plugins/DataTables/extensions/Buttons/js/pdfmake.min.js"></script>
<script src="assets/plugins/DataTables/extensions/Buttons/js/vfs_fonts.min.js"></script>
<script src="assets/plugins/DataTables/extensions/Buttons/js/buttons.html5.min.js"></script>
<script src="assets/plugins/DataTables/extensions/Buttons/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/plug-ins/1.10.19/dataRender/ellipsis.js"></script>

<!-- Bootstrap Select2.0 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

<!-- Moment js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>

<!-- VUE.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.5.16/vue.js"></script>

<!-- Axios js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.18.0/axios.min.js"></script>

<!-- Full Calendar js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/locale/es.js"></script>

<!-- js Cookie -->
<script src="https://cdn.jsdelivr.net/npm/js-cookie@2/src/js.cookie.min.js"></script>

<!-- Toastr notifications -->
<script src="<?php echo URL.PLUGINS.'toastr/toastr.min.js' ?>" type='text/javascript'></script>

<!-- JavaScript tests -->
<script>
	function _csrf() {
		return '<?php echo CSRF_TOKEN; ?>';
	}

	function _url() {
		return '<?php echo URL; ?>';
	}

	function _images() {
		return '<?php echo URL.IMG; ?>';
	}

	function _uploads() {
		return '<?php echo fix_url(URL.UPLOADS); ?>';
	}
	
	$(document).ready(function(){
		toastr.options = {
			"closeButton": true,
			"debug": false,
			"progressBar": true,
			"positionClass": "toast-top-right",
			"preventDuplicates": false,
			"onclick": null,
			"showDuration": 1000,
			"hideDuration": 1000,
			"timeOut": 2000,
			"extendedTimeOut": 1000,
			"showEasing": "swing",
			"hideEasing": "linear",
			"showMethod": "fadeIn",
			"hideMethod": "fadeOut"
		};
		$('.collapse-info-faq').collapse();
	});
</script>

<!-- Lazy loaded scripts -->
<?php echo load_scripts(); ?>
<!-- Ends lazy loaded scripts -->

<!-- Google amps API -->
<script src="<?php echo 'https://maps.googleapis.com/maps/api/js?key='.STATIC_GMAPS.'&libraries=places&callback=initAutocomplete' ?>" async defer></script>

<!-- Custom js -->
<script src="<?php echo URL.JS.'main.min.js?v='.get_siteversion(); ?>" type="text/javascript"></script>