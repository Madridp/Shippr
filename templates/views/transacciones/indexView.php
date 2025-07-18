<?php require INCLUDES.'header.php' ?>
<?php require INCLUDES.'sidebar.php' ?>

<!--Begin Content-->
<div class="content">
	<?php echo get_breadcrums([['',$d->title]]) ?>
	<?php flasher(); ?>

	<div class="row">
		<div class="col-xl-12">
			<div class="pvr-wrapper">
				<div class="pvr-box">
					<h5 class="pvr-header"><?php echo $d->title; ?></h5>
					<?php if ($d->transacciones): ?>
						<table class="table table-striped table-bordered table-ssm table-hover vmiddle" id="data-table" style="width: 100% !important;">
							<thead class="thead-dark">
								<tr>
									<th>Número</th>
									<th>Tipo</th>
									<th class="text-center">Estado</th>
									<th class="text-center">Importe</th>
									<th class="text-right">Fecha</th>
								</tr>
							</thead>
							<tbody>
									<?php foreach ($d->transacciones as $t): ?>
										<tr>
											<td>
                        <?php if ($t->v_id !== null && $t->tipo === 'retiro_saldo'): ?>
													<small class="float-right"><a href="<?php echo 'compras/ver/'.$t->v_folio; ?>" target="_blank"><?php echo sprintf('Compra #%s', $t->v_folio) ?></a></small>
												<?php elseif ($t->tipo_ref === 'envio' && in_array($t->tipo, ['cargo_sobrepeso_saldo','cargo_recoleccion_saldo'])): ?>
													<small class="float-right"><a href="<?php echo 'envios/ver/'.$t->e_id; ?>" target="_blank"><?php echo sprintf('Ver envío #%s', $t->e_id); ?></a></small>
												<?php elseif ($t->tipo_ref === 'compra' && in_array($t->tipo, ['devolucion_saldo'])): ?>
													<small class="float-right"><a href="<?php echo 'compras/ver/'.$t->v_folio; ?>" target="_blank"><?php echo sprintf('Compra #%s', $t->v_folio) ?></a></small>
                        <?php endif; ?>
                        <?php echo $t->numero; ?><?php echo ($t->tipo === 'abono_saldo' && $t->status === 'pagado' ? sprintf(' => Ticket %s', $t->referencia) : ''); ?>
											</td>
											<td><?php echo format_trans_tipo($t->tipo); ?></td>
											<td class="text-center"><?php echo format_payment_status_pill($t->status) ?></td>
											<td class="text-center"><?php echo format_trans_tipo_monto($t->tipo, $t->total); ?></td>
											<td class="text-right"><?php echo fecha($t->creado); ?></td>
										</tr>
									<?php endforeach; ?>
							</tbody>
						</table>
					<?php else : ?>
						<div class="text-center py-5">
							<img class="d-block mx-auto img-empty-state" src="<?php echo URL.IMG.'undraw_empty_orders.svg'; ?>" alt="No hay registros" style="width: 300px;">
							<h4 class="mt-3 mb-2"><b>Upps... no hay transacciones registradas aún</b></h4>
						</div>
					<?php endif ?>
				</div>
			</div>
		</div>
	</div>
</div>
<!--End Content-->

<?php require INCLUDES.'footer.php' ?>