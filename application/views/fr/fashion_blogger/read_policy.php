<?php if (!Customer::logged_in()): ?>
    <script type="text/javascript">
        $(function(){
            $("#agree").live("click", function(){
                $('body').append('<div id="wingray" style="height:100%; width:100%; position:fixed; left:0; top:0; background-color:#333; filter:alpha(opacity=50); opacity:0.5; z-index:99;"></div>');
                $('#catalog_link').appendTo('body').fadeIn(320);
                $('#catalog_link').show();
                return false;
            })
                        
            $("#catalog_link .clsbtn,#wingray").live("click",function(){
                $("#wingray").remove();
                $('#catalog_link').fadeOut(160).appendTo('#tab2');
                return false;
            })
        })
    </script>
<?php endif; ?>
<section id="main">
    <!-- crumbs -->
    <div class="layout">
        <div class="crumbs fix">
            <div class="fll"><a href="<?php echo LANGPATH; ?>/">Homepage</a>  >  BLOGGER WANTED</div>
        </div>
    </div>
    <section class="layout fix">
        <div class="tit blogger_wanted mb25">
      <span>Programme de Fashion</span><span class="on">Lire les politiques</span><span>Soumettre les informations</span><span>Obtenir un banner</span>
      <img src="/images/<?php echo LANGUAGE; ?>/blogger_wanted2.png" />
    </div>  
        <article id="container" style="margin-top:30px;background: #fff;">
            <div class="fashion_policy" style="border-bottom:#CCC 1px dashed;">
                <h3>BLOGGER de FASHION:</h3>
                <p>Vous êtes une fille qui poursuit la fashion, ou un blogger de fashion qui montre toujours votre goût de la fashion comme une fille de libre-pensée.</p>
                <p>Par l'application au programme de blogger de fashion sur choies.com, nos bloggers bénéficient des discounts spéciaux et des produits gratuits en direct de nos nouvelles lignes de produits.</p>
                <p>N'hésitez pas à nous envoyer un é-mail( <a href="mailto:business@choies.com" title="business@choies.com">business@choies.com</a>) sur vous-même.</p>
            </div>
            <div class="fashion_policy mt20" style="border-bottom:#CCC 1px dashed;">
                <p>Comment participer au blogger de fashion de Choies?</p>
                <h3>1. Êtes-vous un blogger qui s'intéresse au style et la fashion actuelle?</h3>
                <p>CHOIES collabore maintenant avec de nombreux bloggers célèbres. C'est notre honneur que vous participez à notre programme de blogger. </p>
                <h3>Qualifications:</h3>
                <p>  1. Vous êtes sûr que vous vous avez le goût pour la fashion et que vous êtes influent dans votre blog personnel, page de Facebook, YouTube, <span class="red1">Chicisimo</span> etc,</p>
                <p>  2. Votre blog de la fashion est mis à jour fréquemment, au moins une fois par semaine.</p>
                <p>&nbsp;</p>
                <h3>2. Que dois-je faire pour commencer?</h3>
                <p>Vous devez vous enregistrer d'abord dans www.choies.com et mettre notre bannière sur votre blog. Vous pouvez obtenir le code de la bannière en cliquant sur "J'accepte". Informez-nous de votre é-mail d'enregistrement, nous allons ajouter des points à votre compte.</p>
                <p>&nbsp;</p>
                <h3>3. Quelle règle dois-je suivre pour obtenir mes points renouvelés?</h3>
                <p>En général, vous devrez montrer nos produits dans les 7 jours et de nous envoyer le lien de votre blog. Il devrait y avoir un lien de produit correspondant au dessous du produit que vous portez sur votre blog au lieu seulement de la page d'accueil, sauf le produit que vous montrez a couru en rupture de stock. Vous pouvez obtenir les points supplémentaires, si vous partagez votre photo sur Chicisimo.com avec un lien vers choies.com</p>
                <p>&nbsp;</p>
                <h3>4. Combien de fois donnez-vous la récompense aux différents bloggers?</h3>
                <p>Habituellement, nous donner des points aux bloggers comme récompense que vous pouvez utiliser dans notre magasin. Nous renouvelerons leurs points quand ils montrent nos produits sur leur blog et autant de plates-formes que possible et qu'ils nous envoient le lien.</p>
                <p>&nbsp;</p>
                <h3>5. Dois-je payer des droits de douane?</h3>
                <p>Les politiques de douane se différencient dans de différents pays. Par exemple, les bloggers de Brésil sont obligatoire de nous donner leur numéro d'identification fiscale et payer des impôts.  Cela dépend de la politique de votre pays.</p>
                <p>&nbsp;</p>
                <h3>6. Y a-t-il d'autres façons pour obtenir plus de points?</h3>
                <p>Oui, vous pouvez obtenir plus de points par écrire le blog affichant le contenu de Choies ou tenir les cadeaux pour Choies et nous envoyer le lien.</p>
            </div>
            <div class="fashion_policy mt20">
                <h3>En ce qui concerne le copyright de votre photos</h3>
                <p>Nous avons le droit de mettre des photos de votre blog sur notre page de Facebook et d'Instagram et nos autres pages officielles.</p>
                <p>Si vous avez des questions sur le programme de blogger de fashion, vous pouvez envoyer un é-mail à: <a href="mailto:business@choies.com" title="business@choies.com">business@choies.com</a>.</p>
                <p>&nbsp;</p>
                <p>Nous allons le vérifier dans une semaine et y répondre si vous êtes approuvé.</p>
                <p>Si vous êtes d'accord avec tous les conditions ci-dessus, cliquer «J'accepte» pour continuer.</p>
                <div class="form_btn mt20 mb10" id="agree">
                    <p><a href="<?php echo LANGPATH; ?>/blogger/submit_information"><strong class="view_btn btn26 btn40" style="width: 100px;">J'ACCEPTE</strong></a></p>
                </div>
            </div>
        </article>
    </section>
</section>
<div class="hide" id="catalog_link" style="position: fixed;padding: 10px 10px 20px; top: 0px;left: 400px;width: 640px;height: 230px; z-index:100px;z-index: 1000; background: #FFFFFF; border-color: #F6F6F7; border:#CCC 1px solid;">
    <div class="order order_addtobag">
        <div class="fashion_thank">
            <h4>Obtenir d'abord votre propre compte avant l'étape suivante.</h4>
            <div class="2btns">
                <span class="form_btn mr10"><a href="<?php echo LANGPATH; ?>/customer/login?redirect=<?php echo LANGPATH; ?>/blogger/submit_information" title="Log In"><strong class="view_btn btn26 btn40" style="width: 100px;">SE CONNECTER</strong></a></span>
                <span class="form_btn"><a href="<?php echo LANGPATH; ?>/customer/register?redirect=<?php echo LANGPATH; ?>/blogger/submit_information" title="REGISTER"><strong class="view_btn btn26 btn40" style="width: 100px;">ENREGISTRER</strong></a></span>
            </div>
        </div>
    </div>
    <div class="clsbtn" style="right: -0px;top: 3px;"></div>
</div>