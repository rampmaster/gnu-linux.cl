<script type="text/javascript" src="<?php echo $_base; ?>/js/mantenedor.js"></script>
<h1>Listado de Noticias</h1>
<p></p>

<?php

// columnas que se utilizarán en la tabla que se desplegará
$columns = array(
    'id' => 'Id',
    'nombre' => 'Nombre',
    'contenido' => 'Contenido'
);

// preparar títulos de columnas (con link para ordenar por dicho campo)
$titles = array();
foreach ($columns as $column => &$name) {
    // si es un arreglo se extrae el nombre
    if (is_array($name)) {
        $titles[] = $name['name'];
    }
    // si es un campo normal
    else {
        $titles[] = $name.'<br />'.
            '<a href="'.$_base.$module_url.$controller.'/listar/'.$page.'/'.$column.'/D'.$searchUrl.'" title="Ordenar descendentemente por '.$name.'"><img src="'.$_base.'/img/icons/16x16/actions/down.png" alt="" /></a>'.
            '<a href="'.$_base.$module_url.$controller.'/listar/'.$page.'/'.$column.'/A'.$searchUrl.'" title="Ordenar ascendentemente por '.$name.'"><img src="'.$_base.'/img/icons/16x16/actions/up.png" alt="" /></a>'
        ;
    }
}
$titles[] = 'Acciones';

// crear arreglo para la tabla y agregar títulos de columnas
$data = array($titles);

// agregar fila para búsqueda mediante formulario
$row = array();
$form = new \sowerphp\general\View_Helper_Form ('normal');
$optionsBoolean = array(array('', 'Seleccione una opción'), array('t', 'Si'), array('f', 'No'));
foreach ($columns as $column => &$name) {
    // si es un archivo
    if (is_array($name) && $name['type']=='file') {
        $row[] = '';
    }
    // si es de tipo boolean se muestra lista desplegable
    else if ($columnsInfo[$column]['type']=='boolean') {
        $row[] = $form->input(array('type'=>'select', 'name'=>$column, 'options' => $optionsBoolean, 'selected' => (isset($search[$column])?$search[$column]:'')));
    }
    // si es llave foránea
    else if ($columnsInfo[$column]['fk']) {
        $class = 'Model_'.\sowerphp\core\Utility_Inflector::camelize(
            $columnsInfo[$column]['fk']['table']
        );
        $classs = $fkNamespace[$class].'\Model_'.\sowerphp\core\Utility_Inflector::camelize(
            \sowerphp\core\Utility_Inflector::pluralize($columnsInfo[$column]['fk']['table'])
        );
        $objs = new $classs();
        $options = $objs->getList();
        array_unshift($options, array('', 'Seleccione una opción'));
        $row[] = $form->input(array('type'=>'select', 'name'=>$column, 'options' => $options, 'selected' => (isset($search[$column])?$search[$column]:'')));
    }
    // si es cualquier otro tipo de datos
    else {
        $row[] = $form->input(array('name'=>$column, 'value'=>(isset($search[$column])?$search[$column]:'')));
    }
}
$row[] = '<input type="image" src="'.$_base.'/img/icons/16x16/actions/search.png" alt="Buscar" title="Buscar" />';
$data[] = $row;

// crear filas de la tabla
foreach ($Noticias as &$obj) {
    $row = array();
    foreach ($columns as $column => &$name) {
        // si es un archivo
        if (is_array($name) && $name['type']=='file') {
            if ($obj->{$column.'_size'})
                $row[] = '<a href="'.$_base.$module_url.$controller.'/d/'.$column.'/'.urlencode($obj->id).'"><img src="'.$_base.'/img/icons/16x16/actions/download.png" alt="" /></a>';
            else
                $row[] = '';
        }
        // si es boolean se usa Si o No según corresponda
        else if ($columnsInfo[$column]['type']=='boolean') {
            $row[] = $obj->{$column}=='t' ? 'Si' : 'No';
        }
        // si es llave foránea
        else if ($columnsInfo[$column]['fk']) {
            // si no es vacía la columna
            if (!empty($obj->{$column})) {
                $method = 'get'.\sowerphp\core\Utility_Inflector::camelize($column);
                $row[] = $obj->$method()->{$columnsInfo[$column]['fk']['table']};
            } else {
                $row[] = '';
            }
        }
        // si es cualquier otro tipo de datos
        else {
            $row[] = $obj->{$column};
        }
    }
    $row[] =
        '<a href="'.$_base.$module_url.$controller.'/editar/'.urlencode($obj->id).'" title="Editar"><img src="'.$_base.'/img/icons/16x16/actions/edit.png" alt="" /></a> '.
        '<a href="'.$_base.$module_url.$controller.'/eliminar/'.urlencode($obj->id).'" title="Eliminar" onclick="return eliminar(\'Noticia\', \''.$obj->id.'\')"><img src="'.$_base.'/img/icons/16x16/actions/delete.png" alt="" /></a>';
    $data[] = $row;
}

// renderizar el mantenedor
$maintainer = new \sowerphp\app\View_Helper_Maintainer (array(
    'link' => $_base.$module_url.$controller,
    'linkEnd' => $linkEnd,
));
$maintainer->setId('Noticias');
echo $maintainer->listar ($data, $pages, $page);
