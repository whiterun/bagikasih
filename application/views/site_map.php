	<?php
		$cu = get_logged_in_user();
		$mdo = (!$cu) ? "disabled" : "" ;
	?>
	<body>
		<?=$this->load->view('head')?>
		
		<div class="content-wrap">
			<div class="container content detail">
			<?=print_error($this->session->flashdata("warning"))?>
			<?=print_success($this->session->flashdata("success"))?>
				<div class="row-fluid">
					<div class="span2 left-side">
						<div class="thumbnail detail-boxes-left">
							<h4 class="subtitle"><?=langtext('others')?></h4>
							<p><?=anchor('about_us', langtext('about_us'))?></p>
							<p><?=anchor('contact_us', langtext('contact_us'))?></p>
							<p><?=anchor('site_map', langtext('site_map'))?></p>
							<p><?=anchor('faq', 'F.A.Q')?></p>
							<p><?=anchor('links', 'Links')?></p>
						</div>
					</div>
					<div class="span10 thumbnail detail-boxes">
						<h4 class="subtitle"><?=langtext('site_map')?></h4>
						<?=auto_tidy('Lorem ipsum dolor sit amet, amet oportere ne vim. Eum at altera delectus. At quo alia duis intellegam, novum debet corpora an mei. Has constituto definiebas ea. Ea mea dicunt timeam adipisci. Laudem suscipiantur vis in, sed munere ceteros philosophia ne, nec ferri movet ex. Usu elit omnes id. His elitr scripta fastidii no. Te usu aeque eligendi. Cu assum simul fabellas usu.

Cu animal detracto mel, mea id dicta dolorum. Nec eu utinam concludaturque. Ei dico appareat has, sea verear officiis te, ubique ridens et pro. Nec no fugit constituto temporibus. Modo purto cu quo. Eum id tibique gloriatur sadipscing, ei nec iusto appellantur, in eum labitur ancillae dignissim. No admodum inimicus vel, autem populo petentium pri ei. Dolorem mediocrem iracundia eos ad. Et propriae copiosae vim. Ei unum prompta usu.

Reque noster laboramus sed id, voluptaria cotidieque sea id. Ferri luptatum dissentias eam in, tota quodsi lucilius et ius. Ex corrumpit disputando sit. In nostrud ornatus neglegentur vim. Nam lorem omnium sensibus at, ex vel molestiae vituperatoribus, vel omittam delectus dissentias an.

An unum natum pro, id mei tation timeam volumus, mea id rebum detraxit appellantur. Ut eum lobortis petentium, no essent iisque lobortis per. Eam an tamquam mentitum. Per admodum eleifend aliquando ea, odio definiebas ullamcorper ea sea, vim mucius legimus vituperatoribus id. Id quo sint reque eruditi.

No mundi altera consulatu eos, per ei habeo homero. Id nam amet vidisse aliquando, minim complectitur mea in. Ex qui diam vero, at sea justo tempor reprimique. Vis fastidii suscipit at. Usu case fabellas no. Et nam pertinax eleifend facilisis, nec mentitum detraxit ut, ut ius nibh ponderum. Et eam diam habeo dicam, mei inermis accusamus in.

Ex cum mazim nullam eligendi, vim ea suas omittantur. Verear efficiantur eu sed, usu et labore dicunt timeam, ex probatus consectetuer mel. Ex per eligendi inciderint. Case quaestio an vel. Et vim dico summo abhorreant, nonumes vivendo referrentur vel et. Sint ceteros tractatos sit ad.

Vim choro neglegentur te. Eum elit saepe volumus eu, cu mel docendi delectus pertinax. Ex tollit deleniti nam, cu vis nibh nihil referrentur, stet nobis tincidunt ea sit. Facer facilisi convenire mea no, sit consulatu deterruisset at. Atqui numquam reprimique nam at.

Ridens verear sea ex. Per ne mundi aliquip. Pri no mentitum disputando philosophia, agam voluptatum sed ex. Mei cu maiorum voluptatum. Malis albucius et sit, nam dicunt labitur posidonium ex.

An qui ubique ocurreret, ius purto salutatus in. Ceteros corrumpit mnesarchum mei no, in quo veri nemore. Te primis assentior nam, eam enim vero electram cu, aperiam philosophia eum et. Illud apeirian referrentur ut nec, in velit dicit denique ius.

Usu eu hinc aliquid. Mei prima everti instructior ut, veri neglegentur in sed. Eu pri putant denique, atqui suavitate qui ei. Duo soluta constituto complectitur ne, qui no harum simul dissentiet. Ea amet clita qui. Deserunt oportere pri cu. Ut duo oratio impetus assueverit, appetere legendos his et. Nec ea dicta blandit. Adhuc decore temporibus vis ex, elit vocibus corpora pro ei. Vel ex suas intellegat concludaturque, mel in tation verterem, summo option vis ea. Sit agam omnesque scribentur ut.')?>
					</div>
				</div>
			</div>
		</div>
	</body>