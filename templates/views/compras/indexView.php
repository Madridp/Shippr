<?php require INCLUDES.'header.php' ?>
<?php require INCLUDES.'sidebar.php' ?>

<!--Begin Content-->
<div class="content">
	<?php echo get_breadcrums([['','Todas mis compras']]) ?>
	<?php flasher(); ?>

	<div class="row">
		<div class="col-xl-12">
			<div class="pvr-wrapper">
				<div class="pvr-box">
					<h5 class="pvr-header"><?php echo $d->title; ?></h5>
					<?php if ($d->v): ?>
						<table class="table table-striped table-borderless table-hover vmiddle" id="data-table" style="width: 100% !important;">
							<thead class="thead-dark">
								<tr>
									<th class="text-left">Información</th>
									<th class="text-center">Estado de compra</th>
									<th class="text-center">Estado del pago</th>
									<th class="text-center">Subtotal</th>
									<th class="text-center">Comisiones</th>
									<th class="text-center">Total</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($d->v as $v): ?>
									<tr>
										<td class="">
											<small class="text-muted float-right"><?php echo 'Envíos '.$v->envios; ?></small>
											<?php echo 'Compra #'.$v->folio; ?>
											<?php if ($v->pago_status === 'pendiente'): ?>
												<span class="ml-2 badge badge-danger"><?php echo get_payment_status($v->pago_status); ?></span>											
											<?php endif; ?>
											<small class="text-muted d-block"><?php echo fecha($v->creado); ?></small>
										</td>
										<td class="text-center ">
											<?php echo get_venta_status_boton($v->status) ?>
										</td>
										<td class="text-center ">
											<?php echo format_payment_status_pill($v->pago_status) ?>
										</td>
										<td class="text-center ">
											<?php echo money($v->subtotal) ?>
										</td>
										<td class="text-center ">
											<?php echo money($v->comision) ?>
										</td>
										<td class="text-center ">
											<?php echo money($v->total) ?>
										</td>
										<td class="text-right">
											<div class="btn-group">
												<?php if ($v->pago_status === 'pendiente'): ?>
													<a class="btn btn-sm  btn-success text-white" href="<?php echo buildURL('compras/pagar/'.$v->id, ['nonce' => $v->nonce]); ?>" <?php echo tooltip('Realizar pago'); ?>><i class="fa fa-money-check-alt"></i></a>
												<?php endif; ?>
												<a class="btn btn-sm  btn-primary text-white" href="<?php echo 'compras/ver/'.$v->folio ?>"><i class="fa fa-eye"></i></a>
											</div>
										</td>
									</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					<?php else : ?>
						<div class="text-center py-5">
							<img class="d-block mx-auto" src="<?php echo URL.IMG.'undraw_empty_orders.svg' ?>" alt="No hay compras" style="width: 300px;">
							<a href="carrito/nuevo" class="btn btn-success btn-lg text-white mt-5">Agregar un envío</a>
						</div>
					<?php endif ?>
				</div>
			</div>
		</div>
	</div>
</div>
<!--End Content-->

<?php require INCLUDES.'footer.php' ?>