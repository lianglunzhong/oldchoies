<aside id="aside" class="fll">
    <div class="category_box aside_box">
        <h3 class="bg">Цетра Помощи</h3>
        <ul class="scroll_list">
        <?php
        $url = URL::current(0);
        $links = array(
array('name' => 'О нас', 'link' => '/about-us'),
array('name' => 'Свяжитесь С Нами', 'link' => '/contact-us'),
array('name' => 'Отправка и доставка', 'link' => '/shipping-delivery'),
array('name' => 'Возврат и oбмен', 'link' => '/returns-exchange'),
array('name' => 'Конфиденциальность И Безопасность', 'link' => '/privacy-security'),
array('name' => 'Гид размера', 'link' => '/size-guide'),
array('name' => 'Платеж', 'link' => '/payment'),
array('name' => 'Уровень VIP& Привилегия', 'link' => '/vip-policy'),
array('name' => 'ЧЗВ', 'link' => '/faqs'),
array('name' => 'Оптовая торговля', 'link' => '/wholesale'),
array('name' => 'Партнерская Программа', 'link' => '/affiliate-program'),
        );
        foreach($links as $link):
            $link['link'] = LANGPATH . $link['link'];
            ?>
            <li><a rel="nofollow" href="<?php echo $link['link']; ?>" <?php if($url == $link['link']) echo 'class="on"'; ?>><?php echo $link['name']; ?></a></li>
        <?php
        endforeach;
        ?>
        </ul>
    </div>
</aside>