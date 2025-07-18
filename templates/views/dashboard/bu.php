<!-- Columna de información izquierda -->
<div class="row">
	<div class="col-8">
		<div class="row">
			<div class="col-12">
				<!-- Greetings -->
				<div class="pvr-wrapper">
				    <div class="welcome_message pvr-box-gray">
				        <div class="element-info">
				            <div class="element-info-with-icon">
				                <div class="element-info-text">
				                    <h3 class="element-inner-header m-t-0 text-theme" id="good_morning" data-typeit="true">
				                    	<span style="display:inline;position:relative;font:inherit;color:inherit;" class="ti-container">
				                    		<?php echo greeting().", ".Auth::auth()['nombre']; ?>
				                  		</span>
				                    </h3>
				                    <div class="element-inner-desc text-justify m-b-20">
				                      Lorem Ipsum is simply dummy text of the printing and typesetting
				                      industry. Lorem Ipsum has been the industry's standard of type and
				                      scrambled it to make a type specimen book. It has survived not only
				                      five centuries
				                    </div>
				                    <button type="button" class="btn btn-primary ">Pendientes</button>
				                    <button type="button" class="btn btn-outline-danger">Calendarío</button>
				                </div>
				            </div>
				        </div>
				    </div>
				</div>

				<!-- Estadísticas -->
			</div>
		</div>
    
	</div><!-- ends row -->

	<!-- Barra lateral de información derecha -->
	<div class="col-4">
		<div class="row">
			<!-- Inbox -->
			<div class="col-12 m-b-20">
				<div class="box_dashboard_v2 inbox_v2 yellow_dashboard_v2">
	        <h2 class="text-left m-t-0 m-b-0">
	          Inbox
	        </h2>
	        <p class="text-left">
	          Mensajes sin leer
	        </p>
	        <p class="text-right">
	          <i class="material-icons add_shadow f-s-50" style="filter: drop-shadow(rgba(0, 0, 0, 0.2) 0px 0px 1px) drop-shadow(rgba(0, 0, 0, 0.2) 3px 3px 3px) drop-shadow(rgba(0, 0, 0, 0.2) 9px 8px 6px);">email</i>
	        </p>
	        <div class="p-10 p-l-0 text-left">
	            <a class="p-l-0 text-white" href="javascript:void(0)">
	              <span data-count="true" data-number="564" id="new_msg_dash_v2">58</span>
	              Nuevos mensajes
	            </a>
	        </div>
	    	</div>
			</div><!--  -->

    	<!-- Pendientes -->
    	<div class="col-12 m-b-20">
    		<div class="pvr-wrapper">
          <div class="pvr-box">
              <h5 class="pvr-header">
                  Tareas pendientes
                  <div class="pvr-box-controls">
                      <i class="material-icons" data-box="refresh" data-effect="win8_linear">refresh</i>
                      <i class="material-icons" data-box="fullscreen">fullscreen</i>
                      <i class="material-icons" data-box="close">close</i>
                  </div>
              </h5>
              <ul class="todolist">
                  <li class="active">
                      <a href="javascript:void(0)" class="todolist-container active" data-click="todolist">
                          <div class="todolist-input"><i class="fa fa-square-o"></i></div>
                          <div class="todolist-title">
                              Lorem Ipsum is simply dummy text of the printing and typesetting.
                          </div>
                      </a>
                  </li>
                  <li class="active">
                      <a href="javascript:void(0)" class="todolist-container" data-click="todolist">
                          <div class="todolist-input"><i class="fa fa-square-o"></i></div>
                          <div class="todolist-title">
                              Lorem Ipsum is simply dummy.
                          </div>
                      </a>
                  </li>
                  <li>
                      <a href="javascript:void(0)" class="todolist-container" data-click="todolist">
                          <div class="todolist-input"><i class="fa fa-square-o"></i></div>
                          <div class="todolist-title">
                              Lorem Ipsum is simply dummy text of the printing.
                          </div>
                      </a>
                  </li>
                  <li>
                      <a href="javascript:void(0)" class="todolist-container" data-click="todolist">
                          <div class="todolist-input"><i class="fa fa-square-o"></i></div>
                          <div class="todolist-title">
                              Lorem Ipsum is simply dummy text.
                          </div>
                      </a>
                  </li>
                  <li>
                      <a href="javascript:void(0)" class="todolist-container" data-click="todolist">
                          <div class="todolist-input"><i class="fa fa-square-o"></i></div>
                          <div class="todolist-title">
                              Lorem Ipsum is simply dummy text of the.
                          </div>
                      </a>
                  </li>
                  <li class="active">
                      <a href="javascript:void(0)" class="todolist-container" data-click="todolist">
                          <div class="todolist-input"><i class="fa fa-square-o"></i></div>
                          <div class="todolist-title">
                              Lorem Ipsum is simply dummy text of the printing and typesetting.
                          </div>
                      </a>
                  </li>
                  <li>
                      <a href="javascript:void(0)" class="todolist-container active" data-click="todolist">
                          <div class="todolist-input"><i class="fa fa-square-o"></i></div>
                          <div class="todolist-title">
                              Lorem Ipsum is simply dummy text of the printing and typesetting.
                          </div>
                      </a>
                  </li>
              </ul>
          </div>
        </div>
    	</div>

    	<!-- Calendario -->
    	<div class="col-12 m-b-20">
				<h5>Aquí irá el calendario</h5>
    	</div>
		</div><!-- ends row -->
		
	</div><!-- ends col-4 -->
</div><!-- ends row -->