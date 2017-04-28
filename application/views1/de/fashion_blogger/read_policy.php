<?php if (!Customer::logged_in()): ?>
    <script type="text/javascript">
		function getScrollTop() {
				var scrollPos;
				if (window.pageYOffset) {
					scrollPos = window.pageYOffset;
				} else if (document.compatMode && document.compatMode != 'BackCompat') {
					scrollPos = document.documentElement.scrollTop;
				} else if (document.body) {
					scrollPos = document.body.scrollTop;
				}
				return scrollPos;
			}
    </script>
<?php endif; ?>
<?php
$url1 = parse_url(Request::$referrer);
?>
<section id="main">
	<!-- crumbs -->
	<div class="container">
		<div class="crumbs">
			<div>
				<a href="<?php echo LANGPATH; ?>/">Homepage</a> > Blogger Werden Wollen
			</div>
			<div class="back visible-xs-inline hidden-sm hidden-md hidden-lg">&lt;&lt;&nbsp;<a class="back" href="<?php echo LANGPATH.$url1['path']; ?>">Zurück</a>
			</div>
		</div>
	</div>
	<!-- main begin -->
	<section class="container blogger-wanted">
		<div class="blogger-img hidden-xs">
			<div class="step-nav step-nav1">
                <ul class="clearfix">
                    <li>Fashion Programm<em></em><i></i></li>
                    <li class="current">Lesen Sie die Politik<em></em><i></i></li>
                    <li>Informationen Bestätigen<em></em><i></i></li>
                    <li>Holen Sie sich einen Banner<em></em><i></i></li>
                </ul>
            </div>
		</div>
		<article class="row">
			<div class="col-sm-1 hidden-xs"></div>
			<div class="col-sm-10 col-xs-12">
				<div class="fashion-policy">
					<h3>FASHION BLOGGER:</h3>
					<p>Egal, ob Sie ein cooles Mädchen, das Mode liebt, oder ein Mode-Blogger sind, zeigen Sie immer Ihren Modegeschmack als ein freidenkendes Mädchen.</p>
	                <p>Mit der Bewerbung auf dem Choies.com Fashion Blogger-Programm. Unsere Blogger profitieren von Sonderrabatten und kostenlose Produkte direkt aus unserer neuen Produktlinien.</p>
	                <p>Zögern Sie bitte nicht, uns eine E-Mail(an <a href="mailto:business@choies.com" title="business@choies.com">business@choies.com</a>) über sich selbst senden.</p>
	            </div>
				<div class="fashion-policy">
					<p>Wie trete ich CHOIES Fashion Blogger bei?</p>
	                <h3>1. Sind Sie ein Blogger mit der Vorliebe der aktuellen Mode und Stil?</h3>
	                <p>CHOIES hat jetzt mit vielen bekannten Bloggern zusammengearbeitet und es ist uns eine Ehre, dass Sie an unserem Fashion-Programm teilnehmen. </p>
	                <h3>Qualifikation:</h3>
	                <p>  1. Sie glauben, dass Sie modischen Geschmack haben und sind einflussreich in Ihren persönlichen Blog, Facebook Seite, YouTube, <span class="red1">Chicisimo</span> und so weiter,</p>
	                <p>  2. Sie bloggen über Mode häufig, mindestens einmal pro Woche.</p>
	                <p>&nbsp;</p>
	                <h3>2. Was sollte ich tun, um zu starten?</h3>
	                <p>Sie müssen sich zuerst auf www.choies.com registrieren und unser Banner auf Ihrem Blog setzen. Sie können Banner-Code erhalten, indem Sie auf "Ich bin einverstanden" klicken. Informieren Sie uns über Ihre registrierte E-Mail, und dann werden wir Punkte auf Ihr Konto hinzufügen.</p>
	                <p>&nbsp;</p>
	                <h3>3. Welche Regel sollte ich folgen, um meine Punkte zu erneuern?</h3>
	                <p>In der Regel müssen Sie unsere Produkte innerhalb von 7 Tagen präsentieren und uns den Link Ihres Blogeintrags senden. Statt der Haupt-Seite sollte es eine entsprechende Produkt-Link unter dem Produkt, das Sie auf Ihrem Blog tragen, außer wenn das Produkt, das Sie zeigen, nicht mehr auf Lager ist. <span class="red1">Sie können Extra-Punkte erhalten, wenn Sie Ihren Fotos auf Chicisimo.com genießen und einen Link zu choies.com hinzufügen.</span></p>
	                <p>&nbsp;</p>
	                <h3>4. Wie oft geben Sie verschiedenen Blogger Belohnung mit?</h3>
	                <p>Normalerweise geben wir Punkte für Blogger als Belohnung, die Sie in unserem Shop verwenden können. Wir werden ihre Punkte erneuern, wenn sie Outfits auf ihrem Blog und so viele soziale Plattformen wie möglich machen, und uns die Post Link senden.</p>
	                <p>&nbsp;</p>
	                <h3>5. Muss ich Zollgebühren bezahlen?</h3>
	                <p>Zollpolitik unterscheidet sich von verschiedenen Ländern. Zum Beispiel, Blogger aus Brasilien müssen uns ihre Steuernummer, um die Steuern zu zahlen. Es hängt von der Politik Ihres Landes.</p>
	                <p>&nbsp;</p>
	                <h3>6. Gibt es andere Möglichkeiten, um mehr Punkte zu bekommen?</h3>
	                <p>Ja, Sie können bestimmt mehr Punkte bekommen, z.B. Sie können Blog-Post für CHOIES schreiben oder Werbegeschenke für CHOIES halten, und dann schicken Sie uns den Link.</p>
	                <p>&nbsp;</p>
	                <h3>7. Bitte registrieren Sie auf choies.com zuerst, bevor Sie irgendetwas anderes tun.</h3>
	                <p>Sie können die Punkte nicht verwenden, nur wenn Sie registriert sein.</p>
	            </div>
				<div>
					<h3>Über das Copyright Ihrer Fotos</h3>
	                <p>Wir haben das Recht, Fotos aus Ihrem Blog auf unsere Facebook, Instagram-Seite und unsere anderen offiziellen Seiten zu setzen.</p>
	                <p>Falls Sie noch Fragen zum Fashion-Blogger-Programm haben, können Sie uns per E-Mail kontaktieren: <a href="mailto:business@choies.com" title="business@choies.com">business@choies.com</a>.</p>
	                <p>&nbsp;</p>
	                <p>Wir werden es in einer Woche prüfen und Ihnen antworten, wenn Sie zugelassen sind.</p>
	                <p>Wenn Sie mit allen obenen Bedingungen einverstanden sind, klicken Sie bitte „Ich bin einverstanden", um weiterzuführen.</p>
	                <div class="form_btn mt20 mb10" id="agree">
	                    <p><a href="<?php echo LANGPATH; ?>/blogger/submit_information"><strong class="btn btn-primary btn-lg JS-popwinbtn1">Ich bin einverstanden</strong></a></p>
	                </div>
				</div>
			</div>
			<div class="col-sm-1 hidden-xs"></div>
		</article>
	</section>
    <div class="JS-popwincon1 hide">
	    <div class="order">
	        <div class="fashion-thank">
	            <h4>Erhalten Sie Ihr eigenes Konto vor nächsten Schritt.<br/>
        Bitte anmelden oder registrieren.</h4>
	            <div class="2btns">
	                <span style="padding-right:10px;"><a class="btn btn-primary btn-sm" title="Log In" href="<?php echo LANGPATH; ?>/customer/login?redirect=<?php echo LANGPATH; ?>/blogger/submit_information"><strong style="width: 100px;" class="view_btn btn26 btn40">ANMELDEN</strong></a></span>
	                <span><a class="btn btn-primary btn-sm" title="REGISTER" href="<?php echo LANGPATH; ?>/customer/register?redirect=<?php echo LANGPATH; ?>/blogger/submit_information"><strong style="width: 100px;" class="view_btn btn26 btn40">REGISTRIEREN</strong></a></span>
	            </div>
	        </div>
	    </div>
	    <div class="JS-close4 close-btn3"></div>
	</div>
</section>	
