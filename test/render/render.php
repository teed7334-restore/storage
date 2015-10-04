<?php
include_once('../../config/config_setting.php');
$config    = config_setting::get_config();
$base_path = $config['base_path'];
include_once("{$base_path}/render.php");
$render = new render();
$html = '
<input type="text" name="keyword" value="" />
<table name="search_list">
    <tr>
        <td name="id">1</td>
        <td name="name">Banana</td>
        <td name="password">987654321</td>
        <td name="group">wheel</td>
        <td name="is_disabled">Y</td>
    </tr>
    <tr>
        <td name="id">2</td>
        <td name="name">Tom</td>
        <td name="password">987654321</td>
        <td name="group">wheel</td>
        <td name="is_disabled">Y</td>
    </tr>
    <tr>
        <td name="id">3</td>
        <td name="name">Ann</td>
        <td name="password">987654321</td>
        <td name="group">wheel</td>
        <td name="is_disabled">Y</td>
    </tr>
    <tr>
        <td name="id">4</td>
        <td name="name">Shiry</td>
        <td name="password">987654321</td>
        <td name="group">wheel</td>
        <td name="is_disabled">Y</td>
    </tr>
    <tr>
        <td name="id">5</td>
        <td name="name">Gleen</td>
        <td name="password">987654321</td>
        <td name="group">wheel</td>
        <td name="is_disabled">Y</td>
    </tr>
</table>';
$params = array(
    'bug1' => 'aaa',
    'bug2' => array('id' => 1),
    'keyword' => 'Peter',
    'search_list' => array(
        array('id' => 1, 'name' => 'Joe', 'password' => '12345678', 'group' => 'users', 'is_disabled' => 'N'),
        array('id' => 2, 'name' => 'John', 'password' => '12345678', 'group' => 'users', 'is_disabled' => 'N'),
        array('id' => 3, 'name' => 'Apple', 'password' => '12345678', 'group' => 'users', 'is_disabled' => 'N'),
        array('id' => 4, 'name' => 'Bill', 'password' => '12345678', 'group' => 'users', 'is_disabled' => 'N'),
        array('id' => 5, 'name' => 'Cice', 'password' => '12345678', 'group' => 'users', 'is_disabled' => 'N')
    )
);
$render->html($html);
$render->params($params);
$render->render('name');
