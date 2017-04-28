<section id="main">
    <!-- crumbs -->
    <div class="container">
        <div class="crumbs">
            <div>
                <a href="<?php echo LANGPATH; ?>/">home</a>
                <a href="<?php echo LANGPATH; ?>/mobile-left" class="visible-xs-inline hidden-sm hidden-md hidden-lg"> > Mon Compte</a> > Гид размера
            </div>
        </div>
    </div>  
    <!-- main begin -->
    <div class="container">
        <div class="row">
            <?php echo View::factory(LANGPATH . '/doc/left'); ?>
            <article class="user col-sm-9 col-xs-12">
				<div class="tit">
					<h2>Руководство Размеров</h2>
				</div>
				<div class="doc-box help">
					<p>Мы не хотим, чтобы вам отправить то, что не подходит. Пожалуйста, используйте таблицу размеров, чтобы определить свой размер. При выборе размера, пожалуйста, обратитесь к деталям каждого элемента. Если у вас любые проблемы о размере, пожалуйста, свяжитесь с нашим отделом обслуживания клиентов.</p>
					
					<h5 class="mb10">Как измерить:</h5>
					<div style="margin-left:2%;float:left;">
						<p>
							<strong>a) Обхват груди</strong>
							<br> *Это не ваш размер бюстгальтера!
							<br> *Носите бюстгальтер без ведущего (ваше платье будет иметь встроенный в бюстгальтер)
							<br> *Опустите расслабленные руки вдоль туловища
							<br> *Потяните ленту по полной части бюста
						</p>
						<p>
							<strong>b) Обхват талии</strong>
							<br> *Найти естественную талию
							<br> *Это самая маленькая часть талии
							<br> *Обычно около 1 дюйм выше пупка
							<br> *Держать ленту слегка свободно, чтобы обеспечить передышку
						</p>
						<p>
							<strong>c) Обхват бедер</strong>
							<br> *Найдите самую широкую часть бедер
							<br> *Обычно около 8 дюймов. ниже талии
							<br> *Лента должна охватывать обе тазовые кости
						</p>
					</div>
					<p style="float:left;margin-left:6%;">
						<img alt="" src="<?php echo STATICURL; ?>/assets/images/<?php echo LANGPATH; ?>/docs/size-guide1.jpg">
					</p>
					<ul class="col-xs-12 mb20">
						<li class="col-sm-4 col-xs-12"><img alt="" src="<?php echo STATICURL; ?>/assets/images/<?php echo LANGPATH; ?>/docs/size-guide2.jpg"></li>
						<li class="col-sm-4 col-xs-12"><img alt="" src="<?php echo STATICURL; ?>/assets/images/<?php echo LANGPATH; ?>/docs/size-guide3.jpg"></li>
						<li class="col-sm-4 col-xs-12"><img alt="" src="<?php echo STATICURL; ?>/assets/images/<?php echo LANGPATH; ?>/docs/size-guide4.jpg"></li>
						<li class="col-sm-4 col-xs-12"><img alt="" src="<?php echo STATICURL; ?>/assets/images/<?php echo LANGPATH; ?>/docs/size-guide5.jpg"></li>
						<li class="col-sm-5 col-xs-12"><img alt="" src="<?php echo STATICURL; ?>/assets/images/<?php echo LANGPATH; ?>/docs/size-guide6.jpg"></li>
					</ul>
                    <div class="size-guide-wrapper col-xs-12">
                        <div class="clothing-single-size-conversion-wrapper table-responsive">
                            <table id="size-guide" class="user-table user-table1" border="0" title="This is a table to display CHOIES size guide data">
                                <tbody>
                                    <tr class="caption">
                                        <th colspan="13">Одежда – Преобразование Размера</th>
                                    </tr>
                                    <tr>
                                        <td class="highlight">Англия</td>
                                        <td>4</td>
                                        <td>6</td>
                                        <td>8</td>
                                        <td>10</td>
                                        <td>12</td>
                                        <td>14</td>
                                        <td>16</td>
                                        <td>18</td>
                                        <td>20</td>
                                        <td>22</td>
                                        <td>24</td>
                                        <td>26</td>
                                    </tr>
                                    <tr>
                                        <td class="highlight">Европа</td>
                                        <td>32</td>
                                        <td>34</td>
                                        <td>36</td>
                                        <td>38</td>
                                        <td>40</td>
                                        <td>42</td>
                                        <td>44</td>
                                        <td>46</td>
                                        <td>48</td>
                                        <td>50</td>
                                        <td>52</td>
                                        <td>54</td>
                                    </tr>
                                    <tr>
                                        <td class="highlight">США</td>
                                        <td>1</td>
                                        <td>2</td>
                                        <td>4</td>
                                        <td>6</td>
                                        <td>8</td>
                                        <td>10</td>
                                        <td>12</td>
                                        <td>14</td>
                                        <td>16</td>
                                        <td>18</td>
                                        <td>20</td>
                                        <td>22</td>
                                    </tr>
                                    <tr>
                                        <td class="highlight">Австралия</td>
                                        <td>4</td>
                                        <td>6</td>
                                        <td>8</td>
                                        <td>10</td>
                                        <td>12</td>
                                        <td>14</td>
                                        <td>16</td>
                                        <td>18</td>
                                        <td>20</td>
                                        <td>22</td>
                                        <td>24</td>
                                        <td>26</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                         <div class="clothing-single-size-wrapper  table-responsive">
                            <table class="user-table user-table1" border="0" title="This is a table to display CHOIES size guide data">
                                <tbody>
                                    <tr class="caption">
                                        <th colspan="25">Одежда - Single Size</th>
                                    </tr>
                                    <tr>
                                        <th class="highlight">Single Size</th> <th colspan="2">Англия 4</th> <th colspan="2">Англия 6</th> <th colspan="2">Англия 8</th> <th colspan="2">Англия 10</th> <th colspan="2">Англия 12</th> <th colspan="2">Англия 14</th> <th colspan="2">Англия 16</th> <th colspan="2">Англия 18</th> <th colspan="2">Англия 20</th> <th colspan="2">Англия 22</th> <th colspan="2">Англия 24</th> <th colspan="2">Англия 26</th>
                                    </tr>
                                    <tr class="highlight">
                                        <td>&nbsp;</td>
                                        <td>CM</td>
                                        <td>In</td>
                                        <td>CM</td>
                                        <td>In</td>
                                        <td>CM</td>
                                        <td>In</td>
                                        <td>CM</td>
                                        <td>In</td>
                                        <td>CM</td>
                                        <td>In</td>
                                        <td>CM</td>
                                        <td>In</td>
                                        <td>CM</td>
                                        <td>In</td>
                                        <td>CM</td>
                                        <td>In</td>
                                        <td>CM</td>
                                        <td>In</td>
                                        <td>CM</td>
                                        <td>In</td>
                                        <td>CM</td>
                                        <td>In</td>
                                        <td>CM</td>
                                        <td>In</td>
                                    </tr>
                                    <tr>
                                        <td class="highlight">Обхват груди</td>
                                        <td><span>76</span></td>
                                        <td><span>30</span></td>
                                        <td><span>78&frac12;</span></td>
                                        <td><span>31</span></td>
                                        <td><span>81</span></td>
                                        <td><span>32</span></td>
                                        <td><span>86</span></td>
                                        <td><span>34</span></td>
                                        <td><span>91</span></td>
                                        <td><span>36</span></td>
                                        <td><span>96</span></td>
                                        <td><span>38</span></td>
                                        <td><span>101</span></td>
                                        <td><span>40</span></td>
                                        <td><span>108&frac12;</span></td>
                                        <td><span>43</span></td>
                                        <td><span>116</span></td>
                                        <td><span>45&frac12;</span></td>
                                        <td><span>122</span></td>
                                        <td><span>48</span></td>
                                        <td><span>128</span></td>
                                        <td><span>50&frac12;</span></td>
                                        <td><span>134</span></td>
                                        <td><span>53</span></td>
                                    </tr>
                                    <tr>
                                        <td class="highlight">Обхват талии</td>
                                        <td><span>58</span></td>
                                        <td><span>22&frac34;</span></td>
                                        <td><span>60&frac12;</span></td>
                                        <td><span>23&frac34;</span></td>
                                        <td><span>63</span></td>
                                        <td><span>24&frac34;</span></td>
                                        <td><span>68</span></td>
                                        <td><span>26&frac34;</span></td>
                                        <td><span>73</span></td>
                                        <td><span>28&frac34;</span></td>
                                        <td><span>78</span></td>
                                        <td><span>30&frac34;</span></td>
                                        <td><span>83</span></td>
                                        <td><span>32&frac34;</span></td>
                                        <td><span>90&frac12;</span></td>
                                        <td><span>35&frac34;</span></td>
                                        <td><span>98</span></td>
                                        <td><span>38&frac12;</span></td>
                                        <td><span>104</span></td>
                                        <td><span>41</span></td>
                                        <td><span>110</span></td>
                                        <td><span>43&frac12;</span></td>
                                        <td><span>116</span></td>
                                        <td><span>46</span></td>
                                    </tr>
                                    <tr>
                                        <td class="highlight">Обхват бедер</td>
                                        <td><span>83&frac12;</span></td>
                                        <td><span>32&frac34;</span></td>
                                        <td><span>86</span></td>
                                        <td><span>33&frac34;</span></td>
                                        <td><span>88&frac12;</span></td>
                                        <td><span>34&frac34;</span></td>
                                        <td><span>93&frac12;</span></td>
                                        <td><span>36&frac34;</span></td>
                                        <td><span>98&frac12;</span></td>
                                        <td><span>38&frac34;</span></td>
                                        <td><span>103&frac12;</span></td>
                                        <td><span>40&frac34;</span></td>
                                        <td><span>108&frac12;</span></td>
                                        <td><span>42&frac34;</span></td>
                                        <td><span>116</span></td>
                                        <td><span>45&frac34;</span></td>
                                        <td><span>123&frac12;</span></td>
                                        <td><span>48&frac12;</span></td>
                                        <td><span>129&frac12;</span></td>
                                        <td><span>51</span></td>
                                        <td><span>135&frac12;</span></td>
                                        <td><span>53&frac12;</span></td>
                                        <td><span>141&frac12;</span></td>
                                        <td><span>56</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="clothing-dual-size-p1-wrapper table-responsive">
                            <table class="user-table user-table1" border="0" title="This is a table to display CHOIES size guide data">
                                <tbody>
                                    <tr>
                                        <th class="highlight">Dual Size</th> <th colspan="2">Англия XS<br />6</th> <th colspan="2">Англия S<br />8-10</th> <th colspan="2">Англия M<br />12-14</th> <th colspan="2">Англия L<br />16-18</th> <th colspan="2">Англия XL<br />20</th>
                                    </tr>
                                    <tr class="highlight">
                                        <td>&nbsp;</td>
                                        <td>сантиметр</td>
                                        <td>дюйм</td>
                                        <td>сантиметр</td>
                                        <td>дюйм</td>
                                        <td>сантиметр</td>
                                        <td>дюйм</td>
                                        <td>сантиметр</td>
                                        <td>дюйм</td>
                                        <td>сантиметр</td>
                                        <td>дюйм</td>
                                    </tr>
                                    <tr>
                                        <td>Обхват груди</td>
                                        <td>78&frac12;</td>
                                        <td>31</td>
                                        <td>81-86</td>
                                        <td>32-34</td>
                                        <td>91-78</td>
                                        <td>36-38</td>
                                        <td>101-108&frac12;</td>
                                        <td>40-43</td>
                                        <td>116</td>
                                        <td>45&frac12;</td>
                                    </tr>
                                    <tr>
                                        <td>Обхват талии</td>
                                        <td>60&frac12;</td>
                                        <td>23&frac34;</td>
                                        <td>63-68</td>
                                        <td>24&frac34;-26&frac34;</td>
                                        <td>73-78</td>
                                        <td>28&frac34;-30&frac34;</td>
                                        <td>83-90&frac12;</td>
                                        <td>32&frac34;-35&frac34;</td>
                                        <td>98</td>
                                        <td>38&frac12;</td>
                                    </tr>
                                    <tr>
                                        <td>Обхват бедер</td>
                                        <td>86</td>
                                        <td>33&frac34;</td>
                                        <td>88&frac12;-93&frac12;</td>
                                        <td>34&frac34;-36&frac34;</td>
                                        <td>98&frac12;-103&frac12;</td>
                                        <td>38&frac34;-40&frac34;</td>
                                        <td>108&frac12;-116</td>
                                        <td>42&frac34;-45&frac34;</td>
                                        <td>123&frac12;</td>
                                        <td>48&frac12;</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="clothing-dual-size-p2-wrapper table-responsive">
                            <table class="user-table user-table1" border="0" title="This is a table to display CHOIES size guide data">
                                <tbody>
                                    <tr class="caption">
                                        <th colspan="6">Одежда - Dual Size</th>
                                    </tr>
                                    <tr>
                                        <td class="highlight">Англия</td>
                                        <td>XS</td>
                                        <td>S</td>
                                        <td>M</td>
                                        <td>L</td>
                                        <td>XL</td>
                                    </tr>
                                    <tr>
                                        <td class="highlight">Европа</td>
                                        <td>XS</td>
                                        <td>S</td>
                                        <td>M</td>
                                        <td>L</td>
                                        <td>XL</td>
                                    </tr>
                                    <tr>
                                        <td class="highlight">США</td>
                                        <td>XXS</td>
                                        <td>XS</td>
                                        <td>S</td>
                                        <td>M</td>
                                        <td>L</td>
                                    </tr>
                                    <tr>
                                        <td class="highlight">Австралия</td>
                                        <td>XS</td>
                                        <td>S</td>
                                        <td>M</td>
                                        <td>L</td>
                                        <td>XL</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="maternity-clothing-wrapper table-responsive">
                            <table class="user-table user-table1" border="0" title="This is a table to display CHOIES size guide data">
                                <tbody>
                                    <tr class="caption">
                                        <th colspan="15">Одежда Для Беременных</th>
                                    </tr>
                                    <tr>
                                        <th class="highlight">Single Size</th> <th colspan="2">8</th> <th colspan="2">10</th> <th colspan="2">12</th> <th colspan="2">14</th> <th colspan="2">16</th> <th colspan="2">18</th> <th colspan="2">20</th>
                                    </tr>
                                    <tr class="highlight">
                                        <td>&nbsp;</td>
                                        <td>сантиметр</td>
                                        <td>дюйм</td>
                                        <td>сантиметр</td>
                                        <td>дюйм</td>
                                        <td>сантиметр</td>
                                        <td>дюйм</td>
                                        <td>сантиметр</td>
                                        <td>дюйм</td>
                                        <td>сантиметр</td>
                                        <td>дюйм</td>
                                        <td>сантиметр</td>
                                        <td>дюйм</td>
                                        <td>сантиметр</td>
                                        <td>дюйм</td>
                                    </tr>
                                    <tr>
                                        <td>Обхват груди</td>
                                        <td>86</td>
                                        <td>34</td>
                                        <td>91</td>
                                        <td>36</td>
                                        <td>96</td>
                                        <td>38</td>
                                        <td>101</td>
                                        <td>40</td>
                                        <td>106</td>
                                        <td>42</td>
                                        <td>113</td>
                                        <td>44&frac34;</td>
                                        <td>120</td>
                                        <td>47&frac12;</td>
                                    </tr>
                                    <tr>
                                        <td>Обхват талии</td>
                                        <td>95</td>
                                        <td>37&frac34;</td>
                                        <td>100</td>
                                        <td>39&frac12;</td>
                                        <td>105</td>
                                        <td>41&frac12;</td>
                                        <td>110</td>
                                        <td>43&frac12;</td>
                                        <td>115</td>
                                        <td>45&frac12;</td>
                                        <td>122</td>
                                        <td>48&frac14;</td>
                                        <td>129</td>
                                        <td>51</td>
                                    </tr>
                                    <tr>
                                        <td>Обхват бедер</td>
                                        <td>93</td>
                                        <td>36&frac34;</td>
                                        <td>98</td>
                                        <td>38&frac34;</td>
                                        <td>103</td>
                                        <td>40&frac34;</td>
                                        <td>108</td>
                                        <td>42&frac34;</td>
                                        <td>113</td>
                                        <td>44&frac34;</td>
                                        <td>120</td>
                                        <td>45&frac34;</td>
                                        <td>127</td>
                                        <td>48&frac12;</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="main-range-lengths-wrapper table-responsive">
                            <table class="user-table user-table1" border="0" title="This is a table to display CHOIES size guide data">
                                <tbody>
                                    <tr class="caption">
                                        <th colspan="11">Основной диапазон длины (на основе среднего размера 10)</th>
                                    </tr>
                                    <tr class="highlight">
                                        <th colspan="3">Брюки</th> <th class="table-split" rowspan="11">&nbsp;</th> <th colspan="3">Юбки</th> <th class="table-split" rowspan="11">&nbsp;</th> <th colspan="3">Платья</th>
                                    </tr>
                                    <tr>
                                        <td rowspan="2">Короткие</td>
                                        <td class="highlight">дюйм</td>
                                        <td>30</td>
                                        <td rowspan="2">Мини</td>
                                        <td class="highlight">дюйм</td>
                                        <td>14</td>
                                        <td rowspan="2">Мини</td>
                                        <td class="highlight">дюйм</td>
                                        <td>33&frac12;</td>
                                    </tr>
                                    <tr>
                                        <td class="highlight">сантиметр</td>
                                        <td>76</td>
                                        <td class="highlight">сантиметр</td>
                                        <td>35</td>
                                        <td class="highlight">сантиметр</td>
                                        <td>85</td>
                                    </tr>
                                    <tr>
                                        <td rowspan="2">Регулярные</td>
                                        <td class="highlight">дюйм</td>
                                        <td>32</td>
                                        <td rowspan="2">Средние</td>
                                        <td class="highlight">дюйм</td>
                                        <td>17&frac12;</td>
                                        <td rowspan="2">Средние</td>
                                        <td class="highlight">дюйм</td>
                                        <td>35&frac12;</td>
                                    </tr>
                                    <tr>
                                        <td class="highlight">сантиметр</td>
                                        <td>81</td>
                                        <td class="highlight">сантиметр</td>
                                        <td>45</td>
                                        <td class="highlight">сантиметр</td>
                                        <td>90</td>
                                    </tr>
                                    <tr>
                                        <td rowspan="2">Длинные</td>
                                        <td class="highlight">дюйм</td>
                                        <td>34</td>
                                        <td rowspan="2">До колен</td>
                                        <td class="highlight">дюйм</td>
                                        <td>21&frac12;</td>
                                        <td rowspan="2">До колен</td>
                                        <td class="highlight">дюйм</td>
                                        <td>37&frac12;</td>
                                    </tr>
                                    <tr>
                                        <td class="highlight">сантиметр</td>
                                        <td>86</td>
                                        <td class="highlight">сантиметр</td>
                                        <td>55</td>
                                        <td class="highlight">сантиметр</td>
                                        <td>95</td>
                                    </tr>
                                    <tr>
                                        <td class="table-null" colspan="3">&nbsp;</td>
                                        <td rowspan="2">До голени</td>
                                        <td class="highlight">дюйм</td>
                                        <td>29&frac12;</td>
                                        <td rowspan="2">До голени</td>
                                        <td class="highlight">дюйм</td>
                                        <td>39&frac12;</td>
                                    </tr>
                                    <tr>
                                        <td class="table-null" colspan="3">&nbsp;</td>
                                        <td class="highlight">сантиметр</td>
                                        <td>75</td>
                                        <td class="highlight">сантиметр</td>
                                        <td>100</td>
                                    </tr>
                                    <tr>
                                        <td class="table-null" colspan="3">&nbsp;</td>
                                        <td rowspan="2">Макси</td>
                                        <td class="highlight">дюйм</td>
                                        <td>37&frac12;</td>
                                        <td rowspan="2">Макси</td>
                                        <td class="highlight">дюйм</td>
                                        <td>56</td>
                                    </tr>
                                    <tr>
                                        <td class="table-null" colspan="3">&nbsp;</td>
                                        <td class="highlight">сантиметр</td>
                                        <td>95</td>
                                        <td class="highlight">сантиметр</td>
                                        <td>142</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                       <div class="petite-lengths-wrapper table-responsive">
                                        <table class="user-table user-table1" border="0" title="This is a table to display CHOIES size guide data">
                                <tbody>
                                    <tr class="caption">
                                        <th colspan="11">Миниатюрный Длины(на основе среднего размера 10)</th>
                                    </tr>
                                    <tr class="highlight">
                                        <th colspan="3">Брюки</th> <th class="table-split" rowspan="11">&nbsp;</th> <th colspan="3">Юбки</th> <th class="table-split" rowspan="11">&nbsp;</th> <th colspan="3">Платья</th>
                                    </tr>
                                    <tr>
                                        <td rowspan="2">Регулярные</td>
                                        <td class="highlight">дюйм</td>
                                        <td>29</td>
                                        <td rowspan="2">Мини</td>
                                        <td class="highlight">дюйм</td>
                                        <td>13</td>
                                        <td rowspan="2">Мини</td>
                                        <td class="highlight">дюйм</td>
                                        <td>31&frac12;</td>
                                    </tr>
                                    <tr>
                                        <td class="highlight">сантиметр</td>
                                        <td>74</td>
                                        <td class="highlight">сантиметр</td>
                                        <td>33</td>
                                        <td class="highlight">сантиметр</td>
                                        <td>80</td>
                                    </tr>
                                    <tr>
                                        <td class="table-null" colspan="3">&nbsp;</td>
                                        <td rowspan="2">Средние</td>
                                        <td class="highlight">дюйм</td>
                                        <td>17</td>
                                        <td rowspan="2">Средние</td>
                                        <td class="highlight">дюйм</td>
                                        <td>33&frac12;</td>
                                    </tr>
                                    <tr>
                                        <td class="table-null" colspan="3">&nbsp;</td>
                                        <td class="highlight">сантиметр</td>
                                        <td>43</td>
                                        <td class="highlight">сантиметр</td>
                                        <td>85</td>
                                    </tr>
                                    <tr>
                                        <td class="table-null" colspan="3">&nbsp;</td>
                                        <td rowspan="2">До колен</td>
                                        <td class="highlight">дюйм</td>
                                        <td>20&frac12;</td>
                                        <td rowspan="2">До колен</td>
                                        <td class="highlight">дюйм</td>
                                        <td>35&frac12;</td>
                                    </tr>
                                    <tr>
                                        <td class="table-null" colspan="3">&nbsp;</td>
                                        <td class="highlight">сантиметр</td>
                                        <td>52</td>
                                        <td class="highlight">сантиметр</td>
                                        <td>90</td>
                                    </tr>
                                    <tr>
                                        <td class="table-null" colspan="3">&nbsp;</td>
                                        <td rowspan="2">До голени</td>
                                        <td class="highlight">дюйм</td>
                                        <td>25&frac34;</td>
                                        <td rowspan="2">До голени</td>
                                        <td class="highlight">дюйм</td>
                                        <td>37&frac12;</td>
                                    </tr>
                                    <tr>
                                        <td class="table-null" colspan="3">&nbsp;</td>
                                        <td class="highlight">сантиметр</td>
                                        <td>65&frac12;</td>
                                        <td class="highlight">сантиметр</td>
                                        <td>95</td>
                                    </tr>
                                    <tr>
                                        <td class="table-null" colspan="3">&nbsp;</td>
                                        <td rowspan="2">Макси</td>
                                        <td class="highlight">дюйм</td>
                                        <td>35&frac34;</td>
                                        <td rowspan="2">Макси</td>
                                        <td class="highlight">дюйм</td>
                                        <td>54</td>
                                    </tr>
                                    <tr>
                                        <td class="table-null" colspan="3">&nbsp;</td>
                                        <td class="highlight">сантиметр</td>
                                        <td>90&frac12;</td>
                                        <td class="highlight">сантиметр</td>
                                        <td>137</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="daul-sized-swimwear-wrapper table-responsive">
                                        <table class="user-table user-table1" border="0" title="This is a table to display CHOIES size guide data">
                                <tbody>
                                    <tr class="caption">
                                        <th colspan="7">Dual Sized Купальников</th>
                                    </tr>
                                    <tr>
                                        <td class="highlight">Англия</td>
                                        <td>8 B/C</td>
                                        <td>10 B/C</td>
                                        <td>12 B/C</td>
                                        <td>14 B/C</td>
                                        <td>16 B/C</td>
                                        <td>18 B/C</td>
                                    </tr>
                                    <tr>
                                        <td class="highlight">Европа</td>
                                        <td>36 B/C</td>
                                        <td>38 B/C</td>
                                        <td>40 B/C</td>
                                        <td>42 B/C</td>
                                        <td>44 B/C</td>
                                        <td>46 B/C</td>
                                    </tr>
                                    <tr>
                                        <td class="highlight">США</td>
                                        <td>4 B/C</td>
                                        <td>6 B/C</td>
                                        <td>8 B/C</td>
                                        <td>10 B/C</td>
                                        <td>12 B/C</td>
                                        <td>14 B/C</td>
                                    </tr>
                                    <tr>
                                        <td class="highlight">Австралия</td>
                                        <td>8 B/C</td>
                                        <td>10 B/C</td>
                                        <td>12 B/C</td>
                                        <td>14 B/C</td>
                                        <td>16 B/C</td>
                                        <td>18 B/C</td>
                                    </tr>
                                    <tr>
                                        <td colspan="7">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td class="highlight">Англия</td>
                                        <td>8 D/DD</td>
                                        <td>10 D/DD</td>
                                        <td>12 D/DD</td>
                                        <td>14 D/DD</td>
                                        <td>16 D/DD</td>
                                        <td>18 D/DD</td>
                                    </tr>
                                    <tr>
                                        <td class="highlight">Европа</td>
                                        <td>36 D/E</td>
                                        <td>38 D/E</td>
                                        <td>40 D/E</td>
                                        <td>42 D/E</td>
                                        <td>44 D/E</td>
                                        <td>46 D/E</td>
                                    </tr>
                                    <tr>
                                        <td class="highlight">США</td>
                                        <td>4 D/DD-E</td>
                                        <td>6 D/DD-E</td>
                                        <td>8 D/DD-E</td>
                                        <td>10 D/DD-E</td>
                                        <td>12 D/DD-E</td>
                                        <td>14 D/DD-E</td>
                                    </tr>
                                    <tr>
                                        <td class="highlight">Австралия</td>
                                        <td>8 D/DD</td>
                                        <td>10 D/DD</td>
                                        <td>12 D/DD</td>
                                        <td>14 D/DD</td>
                                        <td>16 D/DD</td>
                                        <td>18 D/DD</td>
                                    </tr>
                                    <tr>
                                        <td colspan="7">&nbsp;</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="underwear-wrapper table-responsive">
                                    <div class="bra-sizing-wrapper">
                                        <table class="user-table user-table1" border="0" title="This is a table to display CHOIES size guide data">
                                <tbody>
                                    <tr class="caption">
                                        <th colspan="4">Размер Бюстгальтера</th>
                                    </tr>
                                    <tr class="highlight">
                                        <th>Англия</th> <th>Европа</th> <th>США</th> <th>Австралия</th>
                                    </tr>
                                    <tr>
                                        <td>32A</td>
                                        <td>70A</td>
                                        <td>32A</td>
                                        <td>32A</td>
                                    </tr>
                                    <tr>
                                        <td>32B</td>
                                        <td>70B</td>
                                        <td>32B</td>
                                        <td>32B</td>
                                    </tr>
                                    <tr>
                                        <td>32C</td>
                                        <td>70C</td>
                                        <td>32C</td>
                                        <td>32C</td>
                                    </tr>
                                    <tr>
                                        <td>32D</td>
                                        <td>70D</td>
                                        <td>32D</td>
                                        <td>32D</td>
                                    </tr>
                                    <tr>
                                        <td>32DD</td>
                                        <td>70E</td>
                                        <td>32DD/E</td>
                                        <td>32DD</td>
                                    </tr>
                                    <tr>
                                        <td>32E</td>
                                        <td>70F</td>
                                        <td>32DDD/F</td>
                                        <td>32E</td>
                                    </tr>
                                    <tr>
                                        <td>32F</td>
                                        <td>70G</td>
                                        <td>32G</td>
                                        <td>32F</td>
                                    </tr>
                                    <tr>
                                        <td colspan="3">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td>34A</td>
                                        <td>75A</td>
                                        <td>34A</td>
                                        <td>34A</td>
                                    </tr>
                                    <tr>
                                        <td>34B</td>
                                        <td>75B</td>
                                        <td>34B</td>
                                        <td>34B</td>
                                    </tr>
                                    <tr>
                                        <td>34C</td>
                                        <td>75C</td>
                                        <td>34C</td>
                                        <td>34C</td>
                                    </tr>
                                    <tr>
                                        <td>34D</td>
                                        <td>75D</td>
                                        <td>34D</td>
                                        <td>34D</td>
                                    </tr>
                                    <tr>
                                        <td>34DD</td>
                                        <td>75E</td>
                                        <td>34DD/E</td>
                                        <td>34DD</td>
                                    </tr>
                                    <tr>
                                        <td>34E</td>
                                        <td>75F</td>
                                        <td>34DDD/F</td>
                                        <td>34E</td>
                                    </tr>
                                    <tr>
                                        <td>34F</td>
                                        <td>75G</td>
                                        <td>34G</td>
                                        <td>34F</td>
                                    </tr>
                                    <tr>
                                        <td colspan="3">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td>36A</td>
                                        <td>80A</td>
                                        <td>36A</td>
                                        <td>36A</td>
                                    </tr>
                                    <tr>
                                        <td>36B</td>
                                        <td>80B</td>
                                        <td>36B</td>
                                        <td>36B</td>
                                    </tr>
                                    <tr>
                                        <td>36C</td>
                                        <td>80C</td>
                                        <td>36C</td>
                                        <td>36C</td>
                                    </tr>
                                    <tr>
                                        <td>36D</td>
                                        <td>80D</td>
                                        <td>36D</td>
                                        <td>36D</td>
                                    </tr>
                                    <tr>
                                        <td>36DD</td>
                                        <td>80E</td>
                                        <td>36DD/E</td>
                                        <td>36DD</td>
                                    </tr>
                                    <tr>
                                        <td>36E</td>
                                        <td>80F</td>
                                        <td>36DDD/F</td>
                                        <td>36E</td>
                                    </tr>
                                    <tr>
                                        <td>36F</td>
                                        <td>80G</td>
                                        <td>36G</td>
                                        <td>36F</td>
                                    </tr>
                                    <tr>
                                        <td colspan="3">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td>38A</td>
                                        <td>85A</td>
                                        <td>38A</td>
                                        <td>38A</td>
                                    </tr>
                                    <tr>
                                        <td>38B</td>
                                        <td>85B</td>
                                        <td>38B</td>
                                        <td>38B</td>
                                    </tr>
                                    <tr>
                                        <td>38C</td>
                                        <td>85C</td>
                                        <td>38C</td>
                                        <td>38C</td>
                                    </tr>
                                    <tr>
                                        <td>38D</td>
                                        <td>85D</td>
                                        <td>38D</td>
                                        <td>38D</td>
                                    </tr>
                                    <tr>
                                        <td>38DD</td>
                                        <td>85DD</td>
                                        <td>38DD/E</td>
                                        <td>38DD</td>
                                    </tr>
                                    <tr>
                                        <td>38E</td>
                                        <td>85E</td>
                                        <td>38DDD/F</td>
                                        <td>38E</td>
                                    </tr>
                                    <tr>
                                        <td>38F</td>
                                        <td>85G</td>
                                        <td>38G</td>
                                        <td>38F</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="hosiery-small-large-wrapper table-responsive">
                                        <table class="user-table user-table1" border="0" title="This is a table to display CHOIES size guide data">
                                <tbody>
                                    <tr class="caption">
                                        <th colspan="4">Чулочно-носочные изделия(S-L)</th>
                                    </tr>
                                    <tr class="highlight">
                                        <td>&nbsp;</td>
                                        <td colspan="3">Размер</td>
                                    </tr>
                                    <tr class="increase-height">
                                        <td class="highlight">Высота</td>
                                        <td>Англия 8-10<br />35-37"</td>
                                        <td>Англия 12-14<br />39-41"</td>
                                        <td>Англия 16-18<br />43-46"</td>
                                    </tr>
                                    <tr>
                                        <td class="highlight">До 5 футов 3"</td>
                                        <td>S</td>
                                        <td>M</td>
                                        <td>L</td>
                                    </tr>
                                    <tr>
                                        <td class="highlight">До 5 футов 6"</td>
                                        <td>S</td>
                                        <td>M</td>
                                        <td>L</td>
                                    </tr>
                                    <tr>
                                        <td class="highlight">До 5 футов 10"</td>
                                        <td>M</td>
                                        <td>L</td>
                                        <td>L</td>
                                    </tr>
                                    <tr>
                                        <td class="highlight" colspan="4">
                                            <p>*** Если обхват бедер и высота находятся на границе размеров,<br />вы можете найти следующий размер вверх комфортнее ***</p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                      <div class="hosiery-one-size-wrapper table-responsive">
                                        <table class="user-table user-table1" border="0" title="This is a table to display CHOIES size guide data">
                                <tbody>
                                    <tr class="caption">
                                        <th colspan="3">Чулочно-носочные изделия (Один размер)</th>
                                    </tr>
                                    <tr class="highlight">
                                        <td>&nbsp;</td>
                                        <td colspan="2">размер</td>
                                    </tr>
                                    <tr class="increase-height">
                                        <td class="highlight">Высота</td>
                                        <td>Англия 8-10<br />35-37"</td>
                                        <td>Англия 12-14<br />39-41"</td>
                                    </tr>
                                    <tr>
                                        <td class="highlight">До 5 футов 3"</td>
                                        <td>Один размер</td>
                                        <td>Один размер</td>
                                    </tr>
                                    <tr>
                                        <td class="highlight">Up to 5ft 4"</td>
                                        <td>Один размер</td>
                                        <td>Один размер</td>
                                    </tr>
                                    <tr>
                                        <td class="highlight" colspan="3">
                                            <p>*** Один размер чулочно-носочных изделий-это удобный, пригодный размер для Англия 8 - 14<br />и высотой до 5 футов 4" ***</p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="footwear-wrapper table-responsive">
                                    <table class="user-table user-table1" border="0" title="This is a table to display CHOIES size guide data">
                            <tbody>
                                <tr class="caption">
                                    <th colspan="8">Женская Обувь </th>
                                </tr>
                                <tr>
                                    <th class="highlight">Англия</th>
                                    <td>2</td>
                                    <td>3</td>
                                    <td>4</td>
                                    <td>5</td>
                                    <td>6</td>
                                    <td>7</td>
                                    <td>8</td>
                                </tr>
                                <tr>
                                    <th class="highlight">Австралия</th>
                                    <td>4</td>
                                    <td>5</td>
                                    <td>6</td>
                                    <td>7</td>
                                    <td>8</td>
                                    <td>9</td>
                                    <td>10</td>
                                </tr>
                                <tr>
                                    <th class="highlight">США</th>
                                    <td>4</td>
                                    <td>5</td>
                                    <td>6</td>
                                    <td>7</td>
                                    <td>8</td>
                                    <td>9</td>
                                    <td>10</td>
                                </tr>
                                <tr>
                                    <th class="highlight">Европа</th>
                                    <td>35</td>
                                    <td>36</td>
                                    <td>37</td>
                                    <td>38</td>
                                    <td>39</td>
                                    <td>40</td>
                                    <td>41</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </article>
    </div>
</section>
