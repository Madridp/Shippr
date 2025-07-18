<?php 
  switch (get_sitetheme()) {
    case 'orange':
      $color = '#ff9639';
      break;
    case 'green':
      $color = '#06cb59';
      break;
    case 'dark':
      $color = '#2f3640';
      break;
    default:
      $color = '#007bff';
  }
?>
<style type="text/css">
  .text-theme {
    color: <?php echo $color; ?>;
  }

	.field-set, .field-set-right {
		padding: 1.2px 0px;
	}
	.field-set-right {
		text-align: right;
	}

  h1 {
    font-size: 16px;
  }

	table {
		width: 100%;
  }
  
	.cot-table {
		font-size: 11px;
		border: none;
		border-collapse: collapse;
	}

	.cot-table thead tr th, .table-head,
  .cot-table th {
		background-color: #ebebeb;
    padding: 5px 10px;
	}

	.cot-table tr td {
		overflow: hidden;
    padding: 2.5px 10px;
		text-overflow: ellipsis !important;
		white-space: nowrap !important;
	}

	.payment-table {
		font-size: 9px;
		border-collapse: collapse;
	}

	.payment-table th {
		border: 1px solid #aaa;
		background-color: #ebebeb;
		padding: 3px;
	}
	.payment-table td {
		border: 1px solid grey;
		padding: 3px;
	}

  body {
    font-size: 10px;
    font-weight: normal;
  }
 
  label {
    font-size: 10px;
    font-weight: bold;
  }

  .text-small {
    font-size: 10px;
  }

  .text-left{
    text-align: left;
  }

  .text-center{
    text-align: center;
  }

  .text-right{
    text-align: right;
  }

  .text-danger {
    color: #e84118;
  }

  .text-success {
    color: #44bd32;
  }

  .text-primary {
    color: #00a8ff;
  }

  .write-line{
    height: 5px; 
    width: 100%; 
    border-bottom: 0.5px solid #9A9A9A;
  }

  .write-radius{
    height: 7px; 
    width: 100%; 
    border: 0.5px solid black;
    border-radius: 2px;
  }

  .write-checkbox {
    width: 2px;
    height: 2px;
    border: 1px solid <?php echo $color; ?>;
    border-radius: 5px;
  }

  .write-checkbox-checked{
    width: 2px;
    height: 2px;
    border: 1px solid <?php echo $color; ?>;
    background: <?php echo $color; ?>;
    border-radius: 5px;
  }

  .color-checkbox {
    width: 6px;
    height: 6px;
    border: 1px solid <?php echo $color; ?>;
  }

  .square-checkbox {
    width: 8px;
    height: 8px;
    border: 1px solid grey;
    margin-right: 5px;
    display: inline;
  }

  .w-6 {
    width: 6%;
  }

  .w-10{
    width: 10%;
  }

  .w-20{
    width: 20%;
  }

  .w-25{
    width: 25%;
  }

  .w-30{
    width: 30%;
  }

  .w-33{
    width: 33.33%;
  }

  .w-35{
    width: 35%;
  }

  .w-50{
    width: 50%;
  }

  .w-75{
    width: 75%;
  }

  .w-80{
    width: 80%;
  }

  .w-90{
    width: 90%;
  }

  .w-100{
    width: 100%;
  }


  /** Reports */
  .p-5{
    padding: 5px;
  }
  .pendiente, .espera, .completado {
    padding: 10px;
    color: white;
    font-weight: bold;
    text-transform: uppercase;
    border-radius: 5px;
    border: none;
  }
  .pendiente {
    background-color: #e74c3c;
  }
  .espera {
    background-color: #ffa502;
  }
  .completado {
    background-color: #2ecc71;
  }
  .imagen_sola_reporte {
    border-radius: 10px;
    border-bottom: 1px solid #e9ecef;
    width: 150px;
    display: inline-block;
  }

  .f-10 {
    font-size: 10px;
  }

  .f-12 {
    font-size: 12px;
  }

  .f-13 {
    font-size: 13px;
  }
  

  .f-14 {
    font-size: 14px;
  }

  .f-15 {
    font-size: 15px;
  }

  .f-16 {
    font-size: 16px;
  }
</style>

