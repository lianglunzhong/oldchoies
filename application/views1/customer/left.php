<?php
$url = URL::current(0);
if(empty(LANGUAGE))
{
    $lists = Kohana::config('/customer/left.en');
}
else
{
    $lists = Kohana::config('/customer/left.'.LANGUAGE);
}

$customer_id = Customer::logged_in();
$vip_level = Customer::instance($customer_id)->get('vip_level');

if(intval($vip_level)>0){
    if(LANGPATH == '/en' or LANGUAGE == '')
    {
        $lists['MY PREVILEGES'][]=array(
            'name' => 'VIP Entrance',
            'link' => '/activity/vip_exclusive'
        );
    }
}
$email = Customer::instance($customer_id)->get('email');
$celebrity = DB::select('id')->from('celebrities_celebrits')->where('email', '=', $email)->execute()->get('id');
if ($celebrity)
{
    if(LANGPATH == '/en' or LANGUAGE == '')
    {
        $lists['My Profile'][] = array(
            'name' => 'My Blog Show',
            'link' => '/customer/blog_show'
        );
    }elseif(LANGPATH == '/es')
    {
        $lists['MI PERFIL'][] = array(
            'name' => 'Mi show del blog',
            'link' => '/es/customer/blog_show'
        );
    }elseif(LANGPATH == '/de')
    {
        $lists['MEIN PROFIL'][] = array(
            'name' => 'Mein Blog anzeigen',
            'link' => LANGPATH . '/customer/blog_show'
        );
    }elseif(LANGPATH == '/fr')
    {
        $lists['My Profile'][] = array(
            'name' => 'Mon blog show',
            'link' => LANGPATH . '/customer/blog_show'
        );
    }
}
$lang = '';
if(LANGUAGE)
{
    $lang = trim(LANGPATH,'/').'/';
}
if(Request::instance()->uri== $lang.'customer/summary'){
    ?>
<aside id="aside" class="col-sm-3 col-xs-10 col-xs-offset-2 col-sm-offset-0">
<?php }else{ ?>
<aside id="aside" class="col-sm-3 col-xs-12 hidden-xs">
    <?php }?>
    <a href="<?php echo LANGPATH; ?>/customer/summary" class="user-home hidden-xs">My Account</a>
    <?php
    foreach ($lists as $title => $link):
        ?>
        <div class="category-box aside-box">
            <h3 class="bg"><?php echo $title; ?></h3>
            <ul class="scroll-list">
                <?php
                foreach ($link as $l):
                    if (!$l['link'] OR $l['link'] == '#')
                        continue;
                    ?>
                    <li><a  href="<?php echo $l['link']; ?>"<?php if ($url == $l['link']) echo ' class="on"'; ?>><?php echo $l['name']; ?></a></li>
                    <?php
                endforeach;
                ?>
            </ul>
        </div>
        <?php
    endforeach;
    ?>
    <a href="<?php echo LANGPATH; ?>/customer/logout" class="user-home">Sign Out</a>
</aside>