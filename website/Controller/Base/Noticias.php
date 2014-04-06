<?php

/**
 * SowerPHP: Minimalist Framework for PHP
 * Copyright (C) SowerPHP (http://sowerphp.org)
 * 
 * Este programa es software libre: usted puede redistribuirlo y/o
 * modificarlo bajo los términos de la Licencia Pública General GNU
 * publicada por la Fundación para el Software Libre, ya sea la versión
 * 3 de la Licencia, o (a su elección) cualquier versión posterior de la
 * misma.
 * 
 * Este programa se distribuye con la esperanza de que sea útil, pero
 * SIN GARANTÍA ALGUNA; ni siquiera la garantía implícita
 * MERCANTIL o de APTITUD PARA UN PROPÓSITO DETERMINADO.
 * Consulte los detalles de la Licencia Pública General GNU para obtener
 * una información más detallada.
 * 
 * Debería haber recibido una copia de la Licencia Pública General GNU
 * junto a este programa.
 * En caso contrario, consulte <http://www.gnu.org/licenses/gpl.html>.
 */

// namespace del controlador
namespace website;

/**
 * Clase abstracta para el controlador asociado a la tabla noticia de la base
 * de datos
 * Comentario de la tabla: 
 * Esta clase permite controlar las acciones básicas entre el modelo y vista
 * para la tabla noticia, o sea implementa métodos CRUD
 * @author SowerPHP Code Generator
 * @version 2014-04-05 22:18:13
 */
abstract class Controller_Base_Noticias extends \Controller_App
{

    /**
     * Controlador para listar los registros de tipo Noticia
     * @author SowerPHP Code Generator
     * @version 2014-04-05 22:18:13
     */
    public function listar ($page = 1, $orderby = null, $order = 'A')
    {
        // crear objeto
        $Noticias = new Model_Noticias();
        // si se debe buscar se agrega filtro
        $searchUrl = null;
        $search = array();
        if (!empty($_GET['search'])) {
            $searchUrl = '?search='.$_GET['search'];
            $filters = explode(',', $_GET['search']);
            $where = array();
            foreach ($filters as &$filter) {
                list($var, $val) = explode(':', $filter);
                $search[$var] = $val;
                // dependiendo del tipo de datos se ve como filtrar
                if (in_array(Model_Noticia::$columnsInfo[$var]['type'], array('char', 'character varying')))
                    $where[] = $Noticias->like($var, $val);
                else
                    $where[] = $Noticias->sanitize($var)." = '".$Noticias->sanitize($val)."'";
            }
            // agregar condicion a la busqueda
            $Noticias->setWhereStatement(implode(' AND ', $where));
        }
        // si se debe ordenar se agrega
        if ($orderby) {
            $Noticias->setOrderByStatement($orderby.' '.($order=='D'?'DESC':'ASC'));
        }
        // total de registros
        $registers_total = $Noticias->count();
        // paginar si es necesario
        if ((integer)$page>0) {
            $registers_per_page = \sowerphp\core\Configure::read('app.registers_per_page');
            $pages = ceil($registers_total/$registers_per_page);
            $Noticias->setLimitStatement($registers_per_page, ($page-1)*$registers_per_page);
            if ($page != 1 && $page > $pages) {
                $this->redirect(
                    $this->module_url.'noticias/listar/1'.($orderby ? '/'.$orderby.'/'.$order : '').$searchUrl
                );
            }
        }
        // setear variables
        $this->set(array(
            'module_url' => $this->module_url,
            'controller' => $this->request->params['controller'],
            'page' => $page,
            'orderby' => $orderby,
            'order' => $order,
            'searchUrl' => $searchUrl,
            'search' => $search,
            'Noticias' => $Noticias->getObjects(),
            'columnsInfo' => Model_Noticia::$columnsInfo,
            'registers_total' => $registers_total,
            'pages' => isset($pages) ? $pages : 0,
            'linkEnd' => ($orderby ? '/'.$orderby.'/'.$order : '').$searchUrl,
            'fkNamespace' => Model_Noticia::$fkNamespace,
        ));
    }
    
    /**
     * Controlador para crear un registro de tipo Noticia
     * @author SowerPHP Code Generator
     * @version 2014-04-05 22:18:13
     */
    public function crear ()
    {
        // si se envió el formulario se procesa
        if (isset($_POST['submit'])) {
            $Noticia = new Model_Noticia();
            $Noticia->set($_POST);
            $Noticia->save();
            \sowerphp\core\Model_Datasource_Session::message(
                'Registro Noticia creado'
            );
            $this->redirect(
                $this->module_url.'noticias/listar'
            );
        }
        // setear variables
        $this->set(array(
            'columnsInfo' => Model_Noticia::$columnsInfo,
            'fkNamespace' => Model_Noticia::$fkNamespace,
            'accion' => 'Crear',
        ));
        // renderizar
        $this->autoRender = false;
        $this->render('Noticias/crear_editar');
    }
    
    /**
     * Controlador para editar un registro de tipo Noticia
     * @author SowerPHP Code Generator
     * @version 2014-04-05 22:18:13
     */
    public function editar ($id)
    {
        $Noticia = new Model_Noticia($id);
        // si el registro que se quiere editar no existe error
        if(!$Noticia->exists()) {
            \sowerphp\core\Model_Datasource_Session::message(
                'Registro Noticia('.implode(', ', func_get_args()).') no existe, no se puede editar'
            );
            $this->redirect(
                $this->module_url.'noticias/listar'
            );
        }
        // si no se ha enviado el formulario se mostrará
        if(!isset($_POST['submit'])) {
            $this->set(array(
                'Noticia' => $Noticia,
                'columnsInfo' => Model_Noticia::$columnsInfo,
                'fkNamespace' => Model_Noticia::$fkNamespace,
                'accion' => 'Editar',
            ));
            // renderizar
            $this->autoRender = false;
            $this->render('Noticias/crear_editar');
        }
        // si se envió el formulario se procesa
        else {
            $Noticia->set($_POST);
            $Noticia->save();
            if(method_exists($this, 'u')) {
                $this->u($id);
            }
            \sowerphp\core\Model_Datasource_Session::message(
                'Registro Noticia('.implode(', ', func_get_args()).') editado'
            );
            $this->redirect(
                $this->module_url.'noticias/listar'
            );
        }
    }

    /**
     * Controlador para eliminar un registro de tipo Noticia
     * @author SowerPHP Code Generator
     * @version 2014-04-05 22:18:13
     */
    public function eliminar ($id)
    {
        $Noticia = new Model_Noticia($id);
        // si el registro que se quiere eliminar no existe error
        if(!$Noticia->exists()) {
            \sowerphp\core\Model_Datasource_Session::message(
                'Registro Noticia('.implode(', ', func_get_args()).') no existe, no se puede eliminar'
            );
            $this->redirect(
                $this->module_url.'noticias/listar'
            );
        }
        $Noticia->delete();
        \sowerphp\core\Model_Datasource_Session::message(
            'Registro Noticia('.implode(', ', func_get_args()).') eliminado'
        );
        $this->redirect($this->module_url.'noticias/listar');
    }



}
