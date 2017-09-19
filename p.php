<!-- Page-->
<div class="page text-center">
    <!-- Page Header-->
    <?php $this->funciones->menuTop("VIAJERO")?>
    <?php $this->funciones->tituloBannerHTML('Pedidos ('.$st_cnt.')','mdi mdi-shopping'); ?>

	<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
	<script>
		var x = $(document).ready(function () {
			$('.mandarDatos').click(function () {
		        var p = $(this).parents("div.unit:first").find("p.mensaje:first");
				$.ajax({
                    type: 'POST',
                    url : '/viajero/makeOfferInline/' + $(this).attr('x-idpp'),
                    data: $(this).parents("form").serialize(),
                    dataType: "json",
                    success: function () {
                        message();
	                    p.html("Haz realizado tu oferta a este pedido");
                    }
                });

            });
		});
			x.ready(ocultar);
				function ocultar(p) {
			        $('.contenerdordeform').hide();

					}
				function message() {
		            $('.contenerdordeform').hide();
		            $(this).parents("form").nextAll("div.mensajes:first").find("p.mensaje:first").html('<p class="mensaje" style="color: #1cb474">Haz realizado tu oferta a este pedido </p>' );
					}
				function mostrar(a,p) {

		             $('.contenerdordeform', $(a).parent().parent()).show();
		    $('.btnmostar', $(a).parent().parent()).hide();
		    $('.newbutton',$(a).parent().parent()).hide();

			}


		</script>
    <!--Fin-->
    <!-- Page Content-->
    <main class="page-content section-41">
        <div class="shell">
          <?php # $this->funciones->listaFiltroHTML('viajero/listado/', $filtro, array('ope' => 'Abiertos', 'clo' => 'Cerrados', 'ent' => 'Entregados'), array('fec' => 'Fecha', 'com' => 'Comisión', 'pre' => 'Precio'), $_SESSION['sor']); ?>
            <?php $filtros = array('last7d' => 'Últimos 7 días', 'last30d' => '8 - 30 días', 'last30dgt' => '31 días +');
            if ($filtro == 'q') { $filtros = array('last7d' => 'Últimos 7 días', 'last30d' => '8 - 30 días', 'last30dgt' => '31 días +', 'q' => 'Todos');}
            ?>
            <?php $this->funciones->listaFiltroHTML('viajero/listado/', $filtro, $filtros); ?>
            <?php if (!empty($ppidu)) { $default = 'Buscando Usuario: ' . $ppidu; } else { $default = ''; } $this->funciones->buscadorHTMLget('viajero/listado/' . $filtro, $patron, $default); ?>
            <?php if ($e_pages > 1) $this->funciones->paginador('viajero/listado/' . $filtro, $e_pages, $pag); ?>
	        <div class="shell">
            <?php foreach ($prepedidos as $prepedido) { ?>
	            <div class="offset-sm-top-20 offset-top-10">
                <!-- Product-->
                <div class="product product-list product-list-wide unit unit-sm-horizontal unit-xs-top">
                    <!-- Product Image-->
                    <div class="product-image unit-left" style="padding: 10px !important; min-width: 14%;">
                        <!-- Product Thumnails-->
                        <?php if ($prepedido->idpp <> $prepedido->img) { ?>
		                    <img width="150" height="150" src="<?php echo URLpImages; ?>pedidos/none.png" alt="" class="img-responsive">
                        <?php } else { ?>
		                    <img width="150" height="150" src="<?php echo URLpImages; ?>pedidos/<?php echo $prepedido->img; ?>.png" alt="" class="img-responsive">
                        <?php } ?>
                        <!-- Product Label-->
                        <?php
                        $estado_css = "label-info";
                        $estado_label = "Abierto";
                        switch ($prepedido->est) {
                            case 'E': $estado_css = "label-danger"; //Pedido expirado
                                $estado_label = "Pedido expirado"; break;
                            case 6: $estado_css = "label-primary"; //Pedido entregado
                                $estado_label = "Entregado"; break;
                            case 5: $estado_css = "label-primary"; //Acuerdo pagado
                                $estado_label = "En proceso de entrega"; break;
                            case 4: $estado_css = "label-warning"; //Oferta aceptada
                                $estado_label = "Con Acuerdos"; break;
                            case 3: $estado_css = "label-info"; //Recibiendo ofertas
                                $estado_label = "Abierto..."; break;
                            default: $estado_css = "label-info";
                                $estado_label = "Abierto"; break;
                        }?>
	                    <span class="product-label label-custom label-md-custom label-rounded-custom <?php echo $estado_css; ?>"><?php echo $estado_label; ?></span>
                    </div>
                    <div class="unit-body text-left offset-top-0" style="padding-top: 4px !important;">
                        <div class="unit unit-lg-horizontal unit-lg-top">
                            <div class="unit-body" style="width: 300px;">
                                <span class="offset-top-0 text-light">
                                  <!-- <span style="font-size: 12px;">&nbsp;&nbsp;<i class="mdi mdi-clock"></i>&nbsp;<?php echo $prepedido->fec . ' | ' . $prepedido->tim; ?></span><br /> -->
                                  <span style="font-size: 12px;" title="<?php echo date("d/m",strtotime($prepedido->fec)) . ' a las ' . substr($prepedido->tim,0,5); ?>">&nbsp;&nbsp;<i class="mdi mdi-clock"></i>&nbsp;<?php echo $this->funciones->time_elapsed_string($prepedido->fec . ' ' . $prepedido->tim); ?></span><br />
                                  <span style="font-size: 16px;"><p class="product-brand text-italic text-mantis text-bold section-0"><a href="<?php echo $prepedido->url; ?>" target="_blank"><i class="icon icon-xxs mdi mdi-link-variant text-mantis"></i>&nbsp;<span style="vertical-align: top;"><?php if(strlen($prepedido->url)>28) echo substr($prepedido->url,0,28).'...'; else echo $prepedido->url; ?></span></a></p></span>
                                  <span class="icon icon-xxs mdi mdi-account-circle"></span>
                                    <span class="text-bold" style="vertical-align: top; padding-left: 2px;"><?php $cli = explode(' ',trim($prepedido->nom)); echo $cli[0]; ?>&nbsp;<?php if ($prepedido->ape) echo substr($prepedido->ape,0,1) . '.'; ?>
                                        <?php if (!empty($ppCount[$prepedido->idu]) && $ppCount[$prepedido->idu] > 1) { ?>
		                                    <a class="text-light text-warning" href="?ppidu=<?php echo $prepedido->idu; ?>">(<span>Ver <?php echo $ppCount[$prepedido->idu] . " pedidos"; ?>&nbsp;<i style="font-size: 14px;" class="text-bold icon icon-xxs mdi mdi-magnify" ></i>)</span></a>
                                        <?php } ?>
                                    </span><br />
                                    <?php $em = explode("@",$prepedido->mai); $name = implode(array_slice($em, 0, count($em)-1), '@'); $len  = floor(strlen($name)/2); $hide_mai = substr($name,0, $len) . str_repeat('*', $len) . "@" . end($em);  ?>
	                                <span class="icon icon-xxs mdi mdi-email"></span><span style="vertical-align: top; padding-left: 2px;"><?php echo $hide_mai; ?></span>
                                    <?php if($prepedido->obs!="") { if($prepedido->obs!="ch") {?><br /><span class="icon icon-xxs mdi mdi-information-outline"></span><span style="vertical-align: top; padding-left: 2px;"><?php echo $prepedido->obs; ?></span><?php }} ?>
                                </span>
	                            <!-- Product Rating-->
                            </div>
                            <hr class="hr visible-xs visible-sm bg-gray" style="margin: 0px;">
                            <div class="unit-right product-list-right offset-xs-top-0 padding-xs-top-0 offset-top-0 offset-sm-top-0" style="padding-top: 0px;">
                                <!-- Product price-->
                                <div class="product-price text-bold h5 offset-xs-top-0 offset-top-0 margin-xs-bottom-0" style="margin-bottom: 0px;">
                                    <span class="text-dark"><i class="mdi mdi-cart"></i>&nbsp;<?php echo $prepedido->pre; ?> $&nbsp;<span class="text-light" style="font-size: 16px;">(Precio)</span></span>
                                    <span class="product-price-new"><i class="mdi mdi-cash-multiple"></i>&nbsp;<?php echo $prepedido->com; ?> $&nbsp;<span class="text-light" style="font-size: 16px;">(Comisión)</span></span>
                                </div>
                                <div class="product-price h6 offset-xs-top-0 margin-xs-bottom-0" style="margin-bottom: 0px;">
                                    <span class="text-dark text-light"><i class="mdi mdi-timer"></i>&nbsp;<?php if ($prepedido->est == 3) { echo 'Tiene oferta. Mejórala!'; } else { echo 'Sé el primero en hacerle una oferta!'; } ?></span>
                                </div>
                                <div class="offset-top-4">
                                <!-- Product Add To cart-->
                                    <?php if ($prepedido->est==2 || $prepedido->est==3 || $prepedido->est==7) {?>

	                                <form id="formulariopre" class="guvery-form-regular">
	                                    <div class="form-horizontal offset-top-10 col-lg-12 col-md-12 col-sm-12">
		                                    <div class="contenerdordeform">

		                                  <div class="form-group"">
				                          <label for="form-pre" class="form-label">Precio ($) *:</label>
				                          <input value="<?php echo $prepedido->pre;?>" id="form-pre" type="text" name="pre" data-constraints="@Required @IsNumeric" class="form-control col-md-6 col-lg-6 col-sm-12">
		                                    </div>

		                                  <div class="form-group">
				                          <label for="form-com" class="form-label">Comisión ($) *:</label>
				                          <input value="<?php echo $prepedido->com; ?>" id="form-com" type="text" name="com" data-constraints="@Required @IsNumeric" class="form-control col-md-6 col-lg-6 col-sm-12">
		                                    </div>

		                                <div class="form-group" style="margin-top: 10px">
			                                <label for="form-men" class="form-label-outside">Mensaje Opcional : </label>
			                                <input id="form-men" type="text" name="men" class="form-control col-md-9 col-sm-12 col-lg-9 bg-white"/>
		                                </div>
		                                    <div class="form-group">
			                                    <label><?php $re = substr($defaultFecent,-2 ) ; $re2 = substr($defaultFecent, -5,2) ;
                                                    echo  "Para el ".$re."/".$re2." en ".$defaultObs . " "?>
				                                    <a class="" href="<?php echo URL . 'viajero/oferta/' . $prepedido->idpp . "?redirectTo=" . $redirectTo  ?>"  >
					                                    ¿Cambiar fecha o lugar?</a></label>
		                                    </div>
		                                     <div class="form-group">
                                                <a class="mandar btn btn-sm btn-guvery btn-icon btn-icon-left offset-xs-top-0 mandarDatos" target="_blank" x-idpp="<?php echo $prepedido->idpp; ?>" ><span class="icon mdi mdi-check-all"></span><span>Hacer Oferta</span></a>	                                </div>
	                                    </div>
		                                <div    class="form-group newbutton">
			                              <a    onclick="mostrar(this)" class="mostarformu btn btn-sm btn-guvery btn-icon btn-icon-left offset-xs-top-0 btnmostrar">
		                                  <span class="icon mdi mdi-airplane"></span>Hacer Oferta</a><?php }?>
			                                </div>
	                                </form>
	                                <div class="mensajes">
		                                <p class="mensaje" style="color: #1CB474"></p>
	                                </div>

                                <!-- <a href="mailto:
                                  <?php echo $prepedido->mai; ?>?Subject=Guvery%20Delivery!" class="btn btn-sm btn-default btn-icon btn-icon-left offset-top-10 offset-xs-top-0"><span class="icon mdi mdi-email-outline"></span>Enviar mensaje</a> -->
                                    <?php if (array_search($prepedido->idpp,$ofertas)!==false) {?><br /><span class="text-ubold text-mantis" style="font-size: 12px;">* Ya le hiciste una oferta a este pedido.</span><?php }?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
	            <hr class="hr hr-gradient visible-xs visible-sm bg-mantis" style="margin-top: 15px !important; margin-bottom: 5px !important">
            <?php } ?>
        </div>
            <?php if ($e_pages > 1) $this->funciones->paginador('viajero/listado/' . $filtro, $e_pages, $pag); ?>
    </div>

  </main>
    <!-- Page Footers-->
